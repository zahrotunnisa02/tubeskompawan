<html>

<head>
	<title>Register</title>
	<link rel="stylesheet" href="login.css">
</head>

<body>
	<?php
	include("connection.php");

	if (isset($_POST['submit'])) {
		$name = $_POST['name'];
		$email = $_POST['email'];
		$user = $_POST['username'];
		$pass = $_POST['password'];

		if ($user == "" || $pass == "" || $name == "" || $email == "") {
			echo "<p style='color: white'>All fields should be filled. Either one or many fields are empty.</p>";
			echo "<br/>";
			echo "<a href='register.php' style='color: white'>Go back</a>";
		} else {
			mysqli_query($mysqli, "INSERT INTO login(name, email, username, password) VALUES('$name', '$email', '$user', md5('$pass'))")
				or die("Could not execute the insert query.");

			header('Location: login.php');
		}
	} else {
		?>

		<body>
			<div class="login-page">
				<div class="form">
					<div class="login">
						<div class="login-header">
							<h3>REGISTRASI</h3>
							<p>Silahkan isi data diri anda</p>
						</div>
					</div>
					<form class="login-form" name="form1" method="post" action="">
						<input type="text" name="name" placeholder="name" />
						<input type="text" name="email" placeholder="email" />
						<input type="text" name="username" placeholder="username" />
						<input type="password" name="password" placeholder="password" />
						<button name="submit">BUAT</button>
						<p class="message">Sudah punya akun? <a href="login.php">Masuk</a></p>
					</form>
				</div>
			</div>
		</body>
		<?php
	}
	?>
</body>

</html>