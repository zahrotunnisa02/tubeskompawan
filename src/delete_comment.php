<?php
//including the database connection file
include("connection.php");

//getting id of the data from url
$idItem = $_GET['idItem'];
$idComment = $_GET['idComment'];

echo $idItem. "";
echo $idComment;

//deleting the row from table
$result=mysqli_query($mysqli, "DELETE FROM comments WHERE id=$idComment");

//redirecting to the display page (view.php in our case)
header("Location:detail_product.php?id=$idItem");
?>

