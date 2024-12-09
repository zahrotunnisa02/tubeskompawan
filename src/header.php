<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../public/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<header class="shadow-bottom" style="padding: 15px 50px">
    <div class="flex justify-between">
        <div class="flex align-center" style="gap: 20px;">
            <div class="rounded-sm width-min bg-blue" style="padding: 12px 12px">
                <i class="fa-solid fa-cart-shopping" style="color: white; font-size: 18px"></i>
            </div>
            <p class="text-20 font-semibold">StarBoy Shop</p>
        </div>
        <ul class="flex font-regular align-center" style="gap: 30px">
            <li>
                <a href="homepage.php">
                    <p class="text-16 dark-gray">Home</p>
                </a>
            </li>
            <li>
                <a href="tambahcafe.php">
                    <p class="text-16 dark-gray">Tambah cafe</p>
                </a>
            </li>
            <?php
                if ($_SESSION['role'] == 1) {
                    echo '<li>
                            <a href="transaction.php">
                                <p class="text-16 dark-gray">Transactions</p>
                            </a>
                          </li>';
                    echo '<li>
                            <a href="login_history.php">
                                <p class="text-16 dark-gray">Logs</p>
                            </a>
                          </li>';
                }
            ?>
            <li>
                <a href="logout.php" onclick="return confirm('Yakin logout?')">
                    <p class="text-16 dark-gray">Logout</p>
                </a>
            </li>
        </ul>
    </div>
</header>