<?php
    // Display errors 
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    require 'RB.php';
    require 'utils/index.php';

    // Switch between Local/remote CONFIG
    $LOCAL = true;

    $host       = 'localhost';
    $password   = $LOCAL ? 'ssss' : 'test';
    $user       = $LOCAL ? 'ssss' : 'test';
    $database   = 'dbtest';

    // DB setup
    R::setup('mysql:host=' . $host . ';dbname=' . $database, $user, $password);
?>