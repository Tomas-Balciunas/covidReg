<?php 

$router->define([
    '/' => 'controllers/home.php',
    '404' => 'controllers/404.php',
    '/search' => 'controllers/search.php',
    '/delete' => 'controllers/delete.php',
    '/appointment' => 'controllers/edit.php',
    '/data' => 'controllers/data.php',
    '/list' => 'controllers/list.php'
]);