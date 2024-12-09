<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

// Koneksi ke database
include_once("../connection.php");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Query untuk mengambil data kafe
$sql = "SELECT name, latitude, longitude FROM cafes";
$result = $mysqli->query($sql);

// Jika ada data
if ($result->num_rows > 0) {
    $cafes = [];
    while($row = $result->fetch_assoc()) {
        $cafes[] = [
            'name' => $row['name'],
            'latitude' => $row['latitude'],
            'longitude' => $row['longitude']
        ];
    }
    // Mengembalikan data kafe dalam format JSON
    echo json_encode($cafes);
} else {
    echo json_encode([]); // Mengembalikan array kosong jika tidak ada data
}

$mysqli->close();
?>
