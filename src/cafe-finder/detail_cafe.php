<?php
// Mengambil ID kafe dari URL
$cafeId = $_GET['id'];
// Debug: cek nilai id yang diterima
var_dump($_GET['id']);
// Memasukkan koneksi ke database
include_once("../connection.php");

// Memastikan ID kafe ada dan valid
if (isset($cafeId) && is_numeric($cafeId)) {
    // Query untuk mengambil detail kafe berdasarkan ID
    $query = "SELECT * FROM cafes WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $cafeId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Mengecek apakah data ditemukan
    if ($result->num_rows > 0) {
        // Mengambil data kafe
        $cafe = $result->fetch_assoc();
    } else {
        echo "Kafe tidak ditemukan.";
        exit;
    }
} else {
    echo "ID kafe tidak valid.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Kafe - <?php echo htmlspecialchars($cafe['name']); ?></title>
</head>
<body>
    <h1><?php echo htmlspecialchars($cafe['name']); ?></h1>
    <p><strong>Deskripsi:</strong> <?php echo htmlspecialchars($cafe['description']); ?></p>
    <p><strong>Lokasi:</strong> <?php echo htmlspecialchars($cafe['latitude']); ?>, <?php echo htmlspecialchars($cafe['longitude']); ?></p>
    <img src="<?php echo htmlspecialchars($cafe['image_url']); ?>" alt="<?php echo htmlspecialchars($cafe['name']); ?>" style="width: 300px;">
</body>
</html>
