<?php

$databaseHost = 'localhost'; // Ganti dengan nama service Docker Compose atau IP database
$databaseName = 'komputasi_awan';
$databaseUsername = 'root';
$databasePassword = '123456';

$mysqli = mysqli_connect($databaseHost, $databaseUsername, $databasePassword, $databaseName);

if (!$mysqli) {
    die("Connection failed: " . mysqli_connect_error());
}

?>
