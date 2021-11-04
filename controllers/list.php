<?php

use Visma\DB;
use Visma\Tasks;
use Visma\Request;

$id = $_SERVER["REQUEST_URI"];
echo $id;

$connection = DB::connect();
$task = new Tasks($connection);
$list = $task->fetchData();

require "view/pages/list.view.php";