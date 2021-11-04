<?php

use Visma\DB;
use Visma\Tasks;
use Visma\Request;

$id = intval(basename(Request::uri()));
$connection = DB::connect();
$task = new Tasks($connection);
$task->delete($id);

header('Location:/visma/search');
