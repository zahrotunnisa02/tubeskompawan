<?php session_start();

if (!isset($_SESSION['role'])) {
	header('Location: login.php');
}

include_once("connection.php");
$result = mysqli_query($mysqli, "SELECT * FROM products ORDER BY id DESC");
?>

<html>

<head>
	<title>Product</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<?php
include_once("header.php");
?>

<body>
	<br>
	<br>
	<?php
	echo "<div style='display: grid; grid-template-columns: repeat(auto-fit, 200px); grid-gap: 25px; place-content: start center'>";
	while ($res = mysqli_fetch_array($result)) {
		echo "<div class='rounded-md shadow-bottom' style='width: 200px; height: 350px;' onClick=pindahHalaman(\"detail_product.php?id=$res[id]\")>";

		$url = $res['url'];
		echo "<div style='width: 100%; height: 200px'><img class='object-cover rounded-t-md' src='$url'></div>";
		echo "<div style='padding: 10px;'>";
		echo "<p class='clamp-text'>" . $res['name'] . "</p>";
		echo "<div class='rounded-sm' style='padding: 2px 5px; margin: 3px 0; background-color: #c9fde0; width: min-content'><p class='font-semibold text-12' style='color: #00b394'>Tersisa-" . $res['stock'] . "</p></div>";
		echo "<p class=' font-semibold'>Rp " . $res['price'] . "</p>";

		if ($_SESSION['role'] == 1) {
			echo "<div><a href=\"edit.php?id=$res[id]\">Edit</a> | <a href=\"delete.php?id=$res[id]\" onClick=\"return confirm('Yakin menghapus item?')\">Delete</a></div>";
		}
		echo "</div>";
		echo "</div>";
	}
	echo "</div>";
	?>
	</table>

	<?php
	if ($_SESSION['role'] == 1) {
		echo "<div class='fab'><a href='add.php' class='fab-icon'>+</a></div>";
	}

	?>

</body>
<script>
	function pindahHalaman(halamanTujuan) {
		window.location.href = halamanTujuan;
	}
</script>
<style>
	.clamp-text {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }
</style>
</html>