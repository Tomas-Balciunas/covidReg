<?php

use Visma\DB;
use Visma\Tasks;

if (isset($_POST['exportAll'])) {
    $connection = DB::connect();
    $task = new Tasks($connection);
    $task->export();
}

if (isset($_POST['importData'])) {
    $connection = DB::connect();
    $task = new Tasks($connection);
    $task->import($_POST);
}

require "view/pages/data.view.php";