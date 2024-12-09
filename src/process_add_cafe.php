<?php
session_start();

// Redirect to login page if the user is not logged in
if (!isset($_SESSION['role'])) {
    header('Location: login.php');
    exit(); // Pastikan berhenti setelah redirect
}

// Include database connection file
include_once("connection.php");

// Ambil data dari form
$name = $_POST['name'];
$location = $_POST['location'];
$longitude = $_POST['longitude'];
$latitude = $_POST['latitude'];
$description = $_POST['description'];

// Query untuk menyimpan data
$sql = "INSERT INTO cafes (name, location, longitude, latitude, description) 
        VALUES ('$name', '$location', '$longitude', '$latitude', '$description')";

if ($mysqli->query($sql) === TRUE) {
    echo "Kafe berhasil ditambahkan! <a href='add_cafe.php'>Kembali</a>";
} else {
    echo "Error: " . $sql . "<br>" . $mysqli->error;
}

// Tutup koneksi
$mysqli->close();
?>
