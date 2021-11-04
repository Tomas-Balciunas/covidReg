<?php

namespace Visma;

use PDO;
use PDOException;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Tasks
{
    protected $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    public function create($e)
    {
        $this->name = $e['name'];
        $this->email = $e['email'];
        $this->phone = $e['phoneNumber'];
        $this->id = $e['personalId'];
        $this->date = $e['date'] . ' ' . $e['time'];
        $exists = $this->validate($e['personalId']);
        if (!$exists) {
            $this->add();
        } else {
            echo '<p>Appointment with this personal ID already exists</p>';
        }
    }

    public function add()
    {
        try {
            $query = "INSERT INTO visma.appointments (name, email, phone_number, personal_id, date_time) VALUES (:name, :email, :phone, :id, :date)";
            $prepare = $this->pdo->prepare($query);
            $prepare->bindParam(':name', $this->name, PDO::PARAM_STR);
            $prepare->bindParam(':email', $this->email, PDO::PARAM_STR);
            $prepare->bindParam(':phone', $this->phone, PDO::PARAM_STR);
            $prepare->bindParam(':id', $this->id, PDO::PARAM_INT);
            $prepare->bindParam(':date', $this->date, PDO::PARAM_STR);
            $prepare->execute();
        } catch (PDOException $msg) {
            throw $msg;
        }
    }

    //--------------------------- get appointment for editing, update appointment ----------------------------

    public function fetchApp($e)
    {
        try {
            $query = "SELECT * FROM visma.appointments WHERE id = $e";
            $prepare = $this->pdo->prepare($query);
            $prepare->execute();
            return $prepare->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $msg) {
            throw $msg;
        }
    }

    public function createEdit($e, $id)
    {
        $this->userId = $id;
        $this->editName = $e['name'];
        $this->editEmail = $e['email'];
        $this->editPhone = $e['phoneNumber'];
        $this->editId = $e['personalId'];
        $this->editDate = $e['date'] . ' ' . $e['time'];
        $exists = $this->validate($e['personalId']);
        if (!$exists) {
            $this->edit();
            header('Location:/visma/search');
        } else {
            echo '<p>Appointment with this personal ID already exists</p>';
        }
    }

    public function edit()
    {
        try {
            $query = "UPDATE visma.appointments SET 
            name = :editName, 
            email = :editEmail, 
            phone_number = :editPhone, 
            personal_id = :editId, 
            date_time = :editDate 
            WHERE id = :userId";
            $prepare = $this->pdo->prepare($query);
            $prepare->bindParam(':userId', $this->userId, PDO::PARAM_INT);
            $prepare->bindParam(':editName', $this->editName, PDO::PARAM_STR);
            $prepare->bindParam(':editEmail', $this->editEmail, PDO::PARAM_STR);
            $prepare->bindParam(':editPhone', $this->editPhone, PDO::PARAM_STR);
            $prepare->bindParam(':editId', $this->editId, PDO::PARAM_INT);
            $prepare->bindParam(':editDate', $this->editDate, PDO::PARAM_STR);
            $prepare->execute();
        } catch (PDOException $msg) {
            throw $msg;
        }
    }

    //--------------------------------------- delete appointment -----------------------------------------------

    public function delete($e)
    {
        $this->del = $e;

        try {
            $query = "DELETE FROM visma.appointments WHERE id = :del";
            $prepare = $this->pdo->prepare($query);
            $prepare->bindParam(':del', $this->del, PDO::PARAM_INT);
            $prepare->execute();
        } catch (PDOException $msg) {
            throw $msg;
        }
    }

    //-------------------------------------- search for appointments by date --------------------------------------

    public function search($e)
    {
        try {
            $query = "SELECT * FROM visma.appointments WHERE date_time LIKE '%" . $e . "%' ORDER BY date_time ASC";
            $prepare = $this->pdo->prepare($query);
            $prepare->execute();
            return $prepare->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $msg) {
            throw $msg;
        }
    }

    //----------------------------------- download appointment list for specified day --------------------------------

    public static function download($e, $results)
    {
        $spreadsheet = new Spreadsheet();
        $writer = new Xlsx($spreadsheet);
        $sheet = $spreadsheet->getActiveSheet();
        $styleArray = [
            'font' => [
                'bold' => true,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
        ];

        $sheet->getStyle('A1:E1')->applyFromArray($styleArray);
        $sheet->setCellValue('A1', 'Name');
        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->setCellValue('B1', 'Email');
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->setCellValue('C1', 'Phone Nr.');
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->setCellValue('D1', 'Personal ID');
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->setCellValue('E1', 'Date');
        $sheet->getColumnDimension('E')->setAutoSize(true);

        foreach ($results as $key => $app) {
            $sheet->setCellValue('A' . $key + 2, $app['name']);
            $sheet->setCellValue('B' . $key + 2, $app['email']);
            $sheet->setCellValue('C' . $key + 2, $app['phone_number']);
            $sheet->setCellValue('D' . $key + 2, $app['personal_id']);
            $sheet->setCellValue('E' . $key + 2, $app['date_time']);
            $sheet->getStyle('A' . $key + 2 . ':' . 'E' . $key + 2)
                ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        }

        $filename = $e . "_appointment_list";
        $writer->save($filename);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Length: ' . filesize($filename));
        header('Content-Disposition: attachment;filename=' . $filename);
        readfile($filename);
        unlink($filename);
        exit;
    }

    public static function csv($e, $results)
    {
        $delimiter = ",";
        $filename = $e . "_appointment_list.csv";
        $f = fopen('php://memory', 'w');

        foreach ($results as $row) {
            $lineData = array($row['name'], $row['email'], $row['phone_number'], $row['personal_id'], $row['date_time']);
            fputcsv($f, $lineData, $delimiter);
        }

        fseek($f, 0);
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        fpassthru($f);
        exit;
    }

//------------------------------------------------ export a csv list of all appointments ----------------------------------------------

    public function export()
    {
        try {
            $query = "SELECT * FROM visma.appointments";
            $prepare = $this->pdo->prepare($query);
            $prepare->execute();
            $data = $prepare->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $msg) {
            throw $msg;
        }

        $delimiter = ",";
        $f = fopen('php://memory', 'w');

        foreach ($data as $row) {
            $lineData = array($row['name'], $row['email'], $row['phone_number'], $row['personal_id'], $row['date_time']);
            fputcsv($f, $lineData, $delimiter);
        }

        fseek($f, 0);
        header('Content-Type: text/csv');
        header("Content-Disposition: attachment; filename=appointment_data.csv");
        fpassthru($f);
        exit;
    }

//-------------------------------------- import a csv list ----------------------------------------------------------

    public function import()
    {
        $fileName = $_FILES['csv']['tmp_name'];
        $ext = pathinfo($_FILES['csv']['name'], PATHINFO_EXTENSION);
        if ($ext == 'csv') {
            if ($_FILES['csv']['size'] > 0) {
                $file = fopen($fileName, 'r');

                while (($line = fgetcsv($file)) !== false) {
                    $exists = $this->validate($line[3]);
                    if (!$exists) {
                        $query = "INSERT INTO visma.appointments (name, email, phone_number, personal_id, date_time) VALUES (:name, :email, :phone, :id, :date)";
                        $prepare = $this->pdo->prepare($query);
                        $prepare->bindParam(':name', $line[0], PDO::PARAM_STR);
                        $prepare->bindParam(':email', $line[1], PDO::PARAM_STR);
                        $prepare->bindParam(':phone', $line[2], PDO::PARAM_STR);
                        $prepare->bindParam(':id', $line[3], PDO::PARAM_INT);
                        $prepare->bindParam(':date', $line[4], PDO::PARAM_STR);
                        $prepare->execute();
                    } else {
                        $query = "UPDATE visma.appointments SET 
                        name = :name, 
                        email = :email, 
                        phone_number = :phone, 
                        personal_id = :id, 
                        date_time = :date 
                        WHERE id = :userId";
                        $prepare = $this->pdo->prepare($query);
                        $prepare->bindParam(':userId', $exists['id'], PDO::PARAM_STR);
                        $prepare->bindParam(':name', $line[0], PDO::PARAM_STR);
                        $prepare->bindParam(':email', $line[1], PDO::PARAM_STR);
                        $prepare->bindParam(':phone', $line[2], PDO::PARAM_STR);
                        $prepare->bindParam(':id', $line[3], PDO::PARAM_INT);
                        $prepare->bindParam(':date', $line[4], PDO::PARAM_STR);
                        $prepare->execute();
                    }
                }

                fclose($file);
                echo '<p>Data import successful!</p>';
            } else {
                echo '<p>File is empty!</p>';
            }
        } else {
            echo '<p>Only .csv file type is accepted</p>';
        }
    }

//-------------------------- lists all appointments ----------------------------------------------

    public function fetchData()
    {
        try {
            $query = "SELECT * FROM visma.appointments ORDER BY date_time ASC";
            $prepare = $this->pdo->prepare($query);
            $prepare->execute();
            return $prepare->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $msg) {
            throw $msg;
        }
    }

//-------------------------- checks whether same personal id exists ------------------------------------------

    public function validate($e)
    {
        try {
            $query = "SELECT * FROM visma.appointments WHERE personal_id = :personalId";
            $prepare = $this->pdo->prepare($query);
            $prepare->bindParam(':personalId', $e, PDO::PARAM_INT);
            $prepare->execute();
            return $prepare->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $msg) {
            throw $msg;
        }
    }
}
