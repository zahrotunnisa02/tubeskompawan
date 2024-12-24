<?php
session_start();

// Redirect to login page if the user is not logged in
if (!isset($_SESSION['role'])) {
    header('Location: login.php');
}

// Include database connection file
include_once("connection.php");

// Fetch data from the "transaction" table
$result = mysqli_query($mysqli, "SELECT * FROM transactions ORDER BY id DESC");
?>

<html>

<head>
    <title>Transaction</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<?php
// Include header file
include_once("header.php");
?>

<body>
    <br>
    <br>
    <div style='margin-left: 50px;'>
        <p class='text-20 font-semibold'>List of Transactions</p>
    </div>

    <?php
    echo "<div style='display: grid; grid-template-columns: repeat(auto-fit, 200px); grid-gap: 25px; place-content: start center'>";
    
    while ($res = mysqli_fetch_array($result)) {
        echo "<div class='rounded-md shadow-bottom' style='width: 200px; height: 225px;'>";

        // Assuming you have a date field in your "transaction" table
        echo "<div style='padding: 10px;'>";
        echo "<p class='font-semibold text-12'>ID: " . $res['id'] . "</p>";
        echo "<p class='font-semibold text-12'>Product ID: " . $res['id_product'] . "</p>";
        echo "<p class='font-semibold text-12'>Product ID: " . $res['p_name'] . "</p>";
        echo "<p class='font-semibold text-12'>Product ID: " . $res['p_price'] . "</p>";
        echo "<p class='font-semibold text-12'>Name ID: " . $res['id_name'] . "</p>";
        echo "<p class='font-semibold text-12'>Name User: " . $res['name'] . "</p>";
        echo "<p class='font-semibold text-12'>Date: " . $res['date'] . "</p>";

        echo "<form method='post' action='delete_transaction.php' style='margin-top: 10px;'>";
        echo "<input type='hidden' name='transaction_id' value='" . $res['id'] . "' />";
        echo "<button type='submit' style='padding: 4px 3px; color: white;' class='bg-blue rounded-sm width-min' onclick=\"return confirm('Yakin User Sudah Membayar?')\">Selesai</button>";
        echo "</form>";


        // Add additional fields as needed

        echo "</div>";
        echo "</div>";
    }

    echo "</div>";
    ?>
</body>

</html>
