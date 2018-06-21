<?php

$config = [
    'host' => 'localhost',
    'user' => 'root',
    'password' => '',
    'database_name' => 'uber'
];

// Connects to database
$db_connection = mysqli_connect($config['host'], $config['user'], $config['password'], $config['database_name']) or die(mysqli_connect_errno());
