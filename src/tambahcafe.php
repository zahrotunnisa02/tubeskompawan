<?php
session_start();

// Redirect to login page if the user is not logged in
if (!isset($_SESSION['role'])) {
    header('Location: login.php');
}

// Include database connection file
include_once("connection.php");
?>

<html>

<head>
    <title>Tambah Cafe</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<?php
// Include header file
include_once("header.php");
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Kafe</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Tambah Kafe</h2>
        <form action="process_add_cafe.php" method="POST">
            <div class="mb-3">
                <label for="name" class="form-label">Nama Kafe</label>
                <input type="text" id="name" name="name" class="form-control" placeholder="Masukkan nama kafe" required>
            </div>
            <div class="mb-3">
                <label for="location" class="form-label">Lokasi</label>
                <input type="text" id="location" name="location" class="form-control" placeholder="Masukkan lokasi kafe" required>
            </div>
            <div class="mb-3">
                <label for="longitude" class="form-label">Longitude</label>
                <input type="text" id="longitude" name="longitude" class="form-control" placeholder="Masukkan koordinat longitude" required>
            </div>
            <div class="mb-3">
                <label for="latitude" class="form-label">Latitude</label>
                <input type="text" id="latitude" name="latitude" class="form-control" placeholder="Masukkan koordinat latitude" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Deskripsi</label>
                <textarea id="description" name="description" class="form-control" rows="4" placeholder="Masukkan deskripsi kafe"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Tambah Kafe</button>
        </form>
    </div>
</body>