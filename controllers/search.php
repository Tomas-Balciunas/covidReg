<?php session_start();

header("Cache-Control: must-revalidate");

use Visma\DB;
use Visma\Tasks;

if (!empty($_POST['search']) or isset($_SESSION['search'])) {
    if (isset($_POST['search'])) {
        $e = $_POST['search'];
        $_SESSION['search'] = $_POST['search'];
    } else {
        $e = $_SESSION['search'];
    }
    $connection = DB::connect();
    $task = new Tasks($connection);
    $results = $task->search($e);

    if (isset($_POST['download'])) {
        Tasks::download($e, $results);
    }
    if (isset($_POST['csv'])) {
        Tasks::csv($e, $results);
    }
} else {
    header('Location:/visma/');
}

require "view/pages/search.view.php";
