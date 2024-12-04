<?php session_start(); ?>

<?php
if (!isset($_SESSION['role'])) {
	header('Location: login.php');
}
?>

<html>

<head>
	<title>Add Data</title>
	<link href="../public/style.css" rel="stylesheet">
	<link rel="stylesheet" href="component.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body style="background-color:#f5fbff;">
	<?php
	//including the database connection file
	include_once("connection.php");

	if (isset($_POST['Submit'])) {
		$namaFile = $_FILES["gambar"]["name"];
		$ukuranFile = $_FILES["gambar"]["size"];
		$tmpName = $_FILES["gambar"]["tmp_name"];
		$error = $_FILES["gambar"]["error"];

		$name = $_POST['name'];
		$price = $_POST['price'];
		$stock = $_POST['stock'];
		$description = $_POST['description'];
		$loginId = $_SESSION['id'];

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

			//link to the previous page
			echo "<br/><a href='javascript:self.history.back();'>Go Back</a>";
		} else {
			// if all the fields are filled (not empty) 
			$folderTujuan = "../images/";
			move_uploaded_file($tmpName, $folderTujuan . $namaFile);
			$linkGambar = $folderTujuan . $namaFile;

			//insert data to database	
			$result = mysqli_query($mysqli, "INSERT INTO products(url ,name, stock, price, description, id) VALUES('$linkGambar','$name','$stock','$price', '$description', '$loginId')");

			//display success message
			header('Location: product.php');
		}
	} else {
		?>
		<a href="product.php"><p style="padding: 30px 0 0 30px;"><span><i class="fa-solid fa-angle-left"></i></span> Back</p></a>
		<div style="height: 90%;" class="flex justify-center align-center">
			<div class="shadow-bottom rounded-sm" style="padding: 70px; width: 30%; background-color: white;">
				<form action="add.php" method="post" name="form1" enctype="multipart/form-data">
					<div class="flex justify-between">
						<p>Gambar</p>
						<input type="file" name="gambar" />
					</div>
					<br>
					<div class="flex justify-between align-center">
						<p>Nama</p>
						<input type="text" name="name" class="custom-input">
					</div>
					<br>
					<div class="flex justify-between align-center">
						<p>Stock</p>
						<input type="text" name="stock" class="custom-input">
					</div>
					<br>
					<div class="flex justify-between align-center">
						<p>Price</p>
						<input type="text" name="price" class="custom-input">
					</div>
					<br>
					<div class="flex justify-between">
						<p>Deskripsi</p>
						<textarea name="description" class="custom-textarea" placeholder="Tulis pesan di sini"></textarea>
					</div>
					<br>
					<div class="flex justify-end" style="">
						<button class="custom-button" name="Submit" value="Add">Add Barang</button>
					</div>

				</form>
			</div>
		</div>
		<?php
	}
	?>
</body>

</html>