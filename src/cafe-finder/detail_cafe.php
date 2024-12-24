<?php
// Mengambil ID kafe dari URL
$cafeId = $_GET['id'] ?? null;

// Memasukkan koneksi ke database
include_once("../connection.php");

// Memastikan ID kafe ada dan valid
if (isset($cafeId) && is_numeric($cafeId)) {
    // Query untuk mengambil detail kafe berdasarkan ID
    $query = "SELECT * FROM cafes WHERE id = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("i", $cafeId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Mengecek apakah data ditemukan
    if ($result->num_rows > 0) {
        // Mengambil data kafe
        $cafe = $result->fetch_assoc();
    } else {
        // Pesan jika kafe tidak ditemukan
        echo "<div class='alert alert-danger text-center mt-5'>Kafe tidak ditemukan.</div>";
        exit;
    }
} else {
    // Pesan jika ID tidak valid
    echo "<div class='alert alert-danger text-center mt-5'>ID kafe tidak valid.</div>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Kafe - <?php echo htmlspecialchars($cafe['name']); ?></title>
    <!-- Menambahkan Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 50px;
        }
        .card {
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        img {
            border-radius: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h1 class="card-title text-center"><?php echo htmlspecialchars($cafe['name']); ?></h1>
                        <p class="card-text"><strong>Deskripsi:</strong> <?php echo htmlspecialchars($cafe['description']); ?></p>
                        <p class="card-text"><strong>Lokasi:</strong> <?php echo htmlspecialchars($cafe['latitude']); ?>, <?php echo htmlspecialchars($cafe['longitude']); ?></p>
                        <div class="text-center">
                            <img src="../<?php echo htmlspecialchars($cafe['image_url']); ?>" alt="<?php echo htmlspecialchars($cafe['name']); ?>" class="img-fluid" style="width: 300px;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center mt-4">
            <a href="../index.php" class="btn btn-primary">Kembali ke Beranda</a>
        </div>
    </div>

    <!-- Menambahkan Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
