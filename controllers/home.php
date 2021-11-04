<?php session_start();

use Visma\DB;
use Visma\Tasks;
use Visma\Validation;

unset($_SESSION['search']);

if (isset($_POST['register'])) {
    $connection = DB::connect();
    $validation = Validation::appointment($_POST);

    if (empty(implode('', $validation))) {
        $task = new Tasks($connection);
        $task->create($_POST);
    } else {
        foreach ($validation as $error) {
            echo '<p>' . $error . '</p>';
        }
    }
}

require "view/pages/home.view.php";
