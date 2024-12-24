<?php
session_start();

// Redirect to login page if the user is not logged in
if (!isset($_SESSION['role'])) {
    header('Location: login.php');
    exit;
}

// Include database connection file
include_once("connection.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Mengambil data dari form
    // Pastikan data yang dimasukkan aman untuk query SQL
    $name = mysqli_real_escape_string($mysqli, $_POST['name']);
    $location = mysqli_real_escape_string($mysqli, $_POST['location']);
    $longitude = mysqli_real_escape_string($mysqli, $_POST['longitude']);
    $latitude = mysqli_real_escape_string($mysqli, $_POST['latitude']);
    $description = mysqli_real_escape_string($mysqli, $_POST['description']);
    
    // Penanganan file gambar
    if (isset($_FILES['image'])) {
        $imageName = $_FILES['image']['name'];
        $imageTmpName = $_FILES['image']['tmp_name'];
        $imageSize = $_FILES['image']['size'];
        $imageError = $_FILES['image']['error'];

        if ($imageError === 0) {
            // Validasi ukuran gambar (maksimal 5MB)
            if ($imageSize <= 5000000) {
                // Ekstensi file yang diperbolehkan
                $imageExt = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));
                $allowedExts = ['jpg', 'jpeg', 'png', 'gif'];

                if (in_array($imageExt, $allowedExts)) {
                    // Membuat nama file unik
                    $newImageName = uniqid('', true) . "." . $imageExt;
                    $imageDestination = 'images/' . $newImageName;

                    // Memindahkan file gambar ke folder 'images'
                    move_uploaded_file($imageTmpName, $imageDestination);

                    // Menyimpan data kafe ke database dengan URL gambar
                    $sql = "INSERT INTO cafes (name, location, longitude, latitude, description, image_url) 
                            VALUES ('$name', '$location', '$longitude', '$latitude', '$description', '$imageDestination')";

                    if ($mysqli->query($sql) === TRUE) {
                        echo "Kafe berhasil ditambahkan!";
                        header("Location: tambahcafe.php");
                        exit();
                    } else {
                        echo "Error: " . $sql . "<br>" . $mysqli->error;
                    }
                } else {
                    echo "Ekstensi file tidak diperbolehkan!";
                }
            } else {
                echo "Ukuran gambar terlalu besar! Maksimal 5MB.";
            }
        } else {
            echo "Terjadi kesalahan saat mengunggah gambar.";
        }
    } else {
        echo "File gambar tidak di-upload.";
    }
}

?>

<!DOCTYPE html>
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
        <form action="tambahcafe.php" method="POST" enctype="multipart/form-data">
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
            <div class="mb-3">
                <label for="image" class="form-label">Gambar Kafe</label>
                <input type="file" id="image" name="image" class="form-control" accept="image/*" required>
            </div>
            <button type="submit" class="btn btn-primary">Tambah Kafe</button>
        </form>
    </div>
</body>
</html>
