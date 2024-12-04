<?php
session_start();

if (!isset($_SESSION['role'])) {
	header('Location: homepage2.php');
} else {
	header('Location: homepage.php');
}
?>