<?php

use Visma\DB;
use Visma\Tasks;

$connection = DB::connect();
$task = new Tasks($connection);
$list = $task->fetchData();

require "view/pages/list.view.php";