<?php 
session_start(); 
include("connection.php");

if (isset($_POST['submit'])) {
    $user = mysqli_real_escape_string($mysqli, $_POST['username']);
    $pass = mysqli_real_escape_string($mysqli, $_POST['password']);

    if ($user == "" || $pass == "") {
        echo "<p style='color: white'>Either username or password field is empty.</p>";
        echo "<br/>";
        echo "<a href='login.php' style='color: white;'>Go back</a>";
    } else {
        $result = mysqli_query($mysqli, "SELECT * FROM login WHERE username='$user' AND password=md5('$pass')") 
            or die("Could not execute the select query.");

        $row = mysqli_fetch_assoc($result);

        if (is_array($row) && !empty($row)) {
            $_SESSION['role'] = $row['role'];
            $_SESSION['name'] = $row['name'];
            $_SESSION['id'] = $row['id'];
            $timestamp = time();
            mysqli_query($mysqli, "INSERT INTO history (id_name, name, date) VALUES ('$_SESSION[id]', '$_SESSION[name]', NOW())");

            header('Location: index.php'); // Redirect setelah login sukses
            exit(); // Pastikan untuk menghentikan eksekusi setelah header
        } else {
            echo "<p style='color: white'>Invalid username or password.</p>";
            echo "<br/>";
            echo "<a href='login.php' style='color: white;'>Go back</a>";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="login-page">
        
        <div class="form">
            <div class="login">
                <div class="login-header">
                    <h3>-- LOGIN ADMIN --</h3>
                    <p>Silahkan masukan username dan password</p>
                </div>
            </div>
            <form class="login-form" name="form1" method="post" action="">
                <input type="text" name="username" placeholder="username" />
                <input type="password" name="password" placeholder="password" />
                <button name="submit">login</button>
                <p class="message">Belum punya akun? <a href="register.php">Daftar</a></p>
            </form>
        </div>
    </div>
</body>
</html>
