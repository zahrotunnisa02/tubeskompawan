<?php session_start(); ?>

<?php
if (!isset($_SESSION['role'])) {
	header('Location: login.php');
}
?>

<?php
// including the database connection file
include_once("connection.php");

if (isset($_POST['update'])) {
	$namaFile = $_FILES["gambar"]["name"];
	$ukuranFile = $_FILES["gambar"]["size"];
	$tmpName = $_FILES["gambar"]["tmp_name"];
	$error = $_FILES["gambar"]["error"];

	$id = $_POST['id'];

	$name = $_POST['name'];
	$stock = $_POST['stock'];
	$price = $_POST['price'];

	// checking empty fields
	if (empty($name) || empty($stock) || empty($price)) {

		if (empty($name)) {
			echo "<font color='red'>Name field is empty.</font><br/>";
		}

		if (empty($stock)) {
			echo "<font color='red'>Quantity field is empty.</font><br/>";
		}

		if (empty($price)) {
			echo "<font color='red'>Price field is empty.</font><br/>";
		}
	} else {
		$folderTujuan = "../images/";
		move_uploaded_file($tmpName, $folderTujuan . $namaFile);
		$linkGambar = $folderTujuan . $namaFile;
		//updating the table
		$result = mysqli_query($mysqli, "UPDATE products SET url='$linkGambar', name='$name', stock='$stock', price='$price' WHERE id=$id");

		//redirectig to the display page. In our case, it is view.php
		header("Location: product.php");
	}
}
?>
<?php
//getting id from url
$id = $_GET['id'];

//selecting data associated with this particular id
$result = mysqli_query($mysqli, "SELECT * FROM products WHERE id =$id");

while ($res = mysqli_fetch_array($result)) {
	$url = $res['url'];
	$name = $res['name'];
	$stock = $res['stock'];
	$price = $res['price'];
	$description = $res['description'];
}
?>
<html>

<head>
	<title>Edit Data</title>
	<link rel="stylesheet" href="component.css">
	<link href="../public/style.css" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
		integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
		crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body style="background-color:#f5fbff;">
	<a href="product.php">
		<p style="padding: 30px 0 0 30px;"><span><i class="fa-solid fa-angle-left"></i></span> Back</p>
	</a>
	<div style="height: 90%;" class="flex justify-center align-center">
		<div class="flex shadow-bottom rounded-sm" style="padding: 70px; width: 50%; background-color: white;">
			<div style="width: 80%; height: 400px;">
				<img src="<?php echo $url ?>" alt="" class="object-cover" style="object-fit: cover;">
			</div>
			<div style="width: 10%">
			</div>
			<div style="width: 100%">
				<form action="edit.php" method="post" name="form1" enctype="multipart/form-data">
					<div class="flex justify-between">
						<p>Gambar</p>
						<input type="file" name="gambar" />
					</div>
					<br>
					<div class="flex justify-between align-center">
						<p>Nama</p>
						<input type="text" name="name" class="custom-input" value="<?php echo $name; ?>">
					</div>
					<br>
					<div class="flex justify-between align-center">
						<p>Stock</p>
						<input type="text" name="stock" class="custom-input" value="<?php echo $stock; ?>">
					</div>
					<br>
					<div class="flex justify-between align-center">
						<p>Price</p>
						<input type="text" name="price" class="custom-input" value="<?php echo $price ?>">
					</div>
					<br>
					<div class="flex justify-between">
						<p>Deskripsi</p>
						<textarea name="description" class="custom-textarea"
							placeholder="Tulis pesan di sini"><?php echo $description ?></textarea>
					</div>
					<br>
					<div class="flex" style="justify-content: end;">
						<input type="hidden" name="id" value=<?php echo $_GET['id']; ?>>
						<button class="custom-button" name="update" value="Add">Edit Barang</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</body>

</html>