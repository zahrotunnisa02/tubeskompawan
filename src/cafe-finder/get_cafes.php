<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

// Koneksi ke database
include_once("../connection.php");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Query untuk mengambil data kafe (termasuk ID, deskripsi, latitude, longitude, dan image_url)
$sql = "SELECT id, name, latitude, longitude, description, image_url FROM cafes";
$result = $mysqli->query($sql);

// Jika ada data
if ($result->num_rows > 0) {
    $cafes = [];
    while($row = $result->fetch_assoc()) {
        $cafes[] = [
            'id' => $row['id'], // Menambahkan ID kafe
            'name' => $row['name'],
            'latitude' => $row['latitude'],
            'longitude' => $row['longitude'],
            'description' => $row['description'], // Menambahkan deskripsi kafe
            'image_url' => $row['image_url'] // Menambahkan URL gambar
        ];
    }
    // Mengembalikan data kafe dalam format JSON
    echo json_encode($cafes);
} else {
    echo json_encode([]); // Mengembalikan array kosong jika tidak ada data
}

$mysqli->close();
?>
