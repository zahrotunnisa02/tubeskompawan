<?php
// Including the database connection file
include("connection.php");

// Getting ID of the data from the form submission
$transactionId = $_POST['transaction_id'];

// Deleting the row from the "transaction" table
$result = mysqli_query($mysqli, "DELETE FROM transactions WHERE id=$transactionId");

// Redirecting to the display page (transaction.php in our case)
header("Location: transaction.php");
?>
