<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

    $dbHost = "localhost";
    $dbName = "moretti_603552";
    $dbUsername = "root";
    $dbPassword  = "";

    $connection = mysqli_connect($dbHost, $dbUsername, $dbPassword, $dbName);

    if (mysqli_connect_errno()) {
        die(mysqli_connect_error());
    }
    ?>