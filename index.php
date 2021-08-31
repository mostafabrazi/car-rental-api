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
    $password   = $LOCAL ? 'root' : 'Mostafa2020@'; // S78muWO@dFSOZ
    $user       = $LOCAL ? 'root' : 'id17298720_demoyouschool'; // youschool
    $database   = 'id17298720_youschooldemo';

    // DB setup
    R::setup('mysql:host=' . $host . ';dbname=' . $database, $user, $password);
?>