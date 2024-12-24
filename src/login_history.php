<?php
session_start();

// Redirect to login page if the user is not logged in
if (!isset($_SESSION['role'])) {
    header('Location: login.php');
}

// Include database connection file
include_once("connection.php");

// Fetch data from the "lhistory" table
$result = mysqli_query($mysqli, "SELECT * FROM history ORDER BY id DESC");
?>

<html>

<head>
    <title>Login History</title>
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
        <p class='text-20 font-semibold'>Data Login by ID</p>
    </div>

    <?php
    echo "<div style='display: grid; grid-template-columns: repeat(auto-fit, 200px); grid-gap: 25px; place-content: start center'>";
    
    while ($res = mysqli_fetch_array($result)) {
        echo "<div class='rounded-md shadow-bottom' style='width: 200px; height: 150px;'>";

        // Assuming you have a date field in your "lhistory" table
        echo "<div style='padding: 10px;'>";
        echo "<p class='font-semibold text-12'>ID: " . $res['id'] . "</p>";
        echo "<p class='font-semibold text-12'>Name ID: " . $res['id_name'] . "</p>";
        echo "<p class='font-semibold text-12'>Name: " . $res['name'] . "</p>";
        echo "<p class='font-semibold text-12'>Date: " . $res['date'] . "</p>";

        // You can add more fields if needed

        // Add your form or any additional elements here

        echo "</div>";
        echo "</div>";
    }

    echo "</div>";
    ?>
</body>

</html>
