<?php

use Visma\DB;
use Visma\Tasks;
use Visma\Request;
use Visma\Validation;

$id = intval(basename(Request::uri()));
$connection = DB::connect();
$fetch = new Tasks($connection);
$app = $fetch->fetchApp($id);
$date = explode(" ", $app['date_time']);


if (isset($_POST['edit'])) {
    $validation = Validation::appointment($_POST);

    if (empty(implode('', $validation))) {
        $task = new Tasks($connection);
        $task->createEdit($_POST, $id);
        header('Location:/visma/search');
    } else {
        foreach ($validation as $error) {
            echo '<p>' . $error . '</p>';
        }
    }
}

require "view/pages/edit.view.php";
