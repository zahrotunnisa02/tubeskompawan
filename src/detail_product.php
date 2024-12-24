<?php session_start(); ?>

<?php
if (!isset($_SESSION['role'])) {
    header('Location: login.php');
}
?>

<?php
include_once("connection.php");

if (isset($_GET['idItem'])) {
    $id_name = $_SESSION['id'];
    $id = $_GET['idItem'];
    $name = $_SESSION['name'];
    $stock = $_GET['stock'];
    $newStok = $stock - 1;

    $result = mysqli_query($mysqli, "SELECT * FROM products WHERE id=$id");
    while ($res = mysqli_fetch_array($result)) {
        $pname = $res['name'];
        $pprice = $res['price'];
    }

    if ($newStok > -1) {

        mysqli_query($mysqli, "UPDATE products SET stock='$newStok' WHERE id='$id'");
        mysqli_query($mysqli, "INSERT INTO transactions (id_product, p_name, p_price, id_name, name, date) VALUES ('$id', '$pname', '$pprice','$id_name', '$name', NOW())");
    }
    echo "id " . $id;
    echo "stok " . $stock;
    header('Location: product.php');
} else if (isset($_POST['comment'])) {
    $id = $_POST['id'];
    $id_name = $_POST['id_name'];
    $name = $_POST['name'];
    $comment = $_POST['comment'];

    mysqli_query($mysqli, "INSERT INTO comments (id_product, id_name, name, comment) VALUES ('$id', '$id_name', '$name', '$comment')");

    $result = mysqli_query($mysqli, "SELECT * FROM products WHERE id=$id");

    while ($res = mysqli_fetch_array($result)) {
        $id = $res['id'];
        $url = $res['url'];
        $name = $res['name'];
        $stock = $res['stock'];
        $price = $res['price'];
        $description = $res['description'];
    }
} else {
    $id = $_GET['id'];
    $result = mysqli_query($mysqli, "SELECT * FROM products WHERE id=$id");

    while ($res = mysqli_fetch_array($result)) {
        $id = $res['id'];
        $url = $res['url'];
        $name = $res['name'];
        $stock = $res['stock'];
        $price = $res['price'];
        $description = $res['description'];
    }
}
$result2 = mysqli_query($mysqli, "SELECT * FROM comments WHERE id_product=$id");
?>
<html>

<head>
    <title>Detail</title>
    <link href="../public/style.css" rel="stylesheet">
    <link rel="stylesheet" href="component.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<header>
    <p class="text-14" style="padding-top: 20px;"><a href="product.php">detail produk</a> <span><i
                class="fa-solid fa-angle-right"></i></span>
        <?php echo $name ?>
    </p>
</header>
<br>

<body style="padding: 0 50px;">
    <div class="flex">
        <div style="flex: 30%;" class="flex justify-center">
            <div style="width: 100%; height: 400px">
                <img src="<?php echo $url ?>" alt="" class="image-detail">
            </div>
        </div>
        <div style="flex: 40%; padding: 0 20px;">
            <div>
                <p class="text-18 font-semibold">
                    <?php echo $name ?>
                </p>
                <p class="text-16">
                    <?php echo "Rp " . $price ?>
                </p>
            </div>
            <br>
            <hr style="border: none; border-top: 1px solid rgba(0, 0, 0, 0.10)">
            <div style="height: 400px;">
                <p class="soft-gray">Deskripsi produk</p>
                <textarea class=" custom-textarea" name="comment"
                    style="width: 100%; height: 100%; margin: 10px 10px 0 0; border: none; padding: 0; outline: none; box-shadow: none;"
                    placeholder="Deskripsi kosong" readonly><?php echo $description ?></textarea>
            </div>
            <br>
            <div style="height: 300px;">
                <br>
                <div>
                    <form action="detail_product.php" method="post" name="form1">
                        <input type="hidden" name="id" value="<?php echo $id ?>">
                        <input type="hidden" name="id_name" value="<?php echo $_SESSION['id'] ?>">
                        <input type="hidden" name="name" value="<?php echo $_SESSION['name'] ?>">
                        <textarea class="custom-textarea" name="comment"
                            style="width: 100%; height: 100px; margin-bottom: 10px;"
                            placeholder="Tulis comment"></textarea>
                        <button type="submit" name="submit" class="rounded-md custom-button">
                            <p><span><i class="fa-solid fa-paper-plane"></i></span> Kirim</p>
                        </button>
                    </form>
                </div>
                <br>
                <hr style="border: none; border-top: 1px solid rgba(0, 0, 0, 0.10)">
                <p class="soft-gray">Kata orang</p>
                <br>
                <?php
                while ($res2 = mysqli_fetch_array($result2)) {
                    ?>
                    <div>
                        <br>
                        <div class="flex justify-between align-center">
                            <div class="flex align-center" style="gap: 10px; margin-bottom: 10px;">
                                <img src="https://source.unsplash.com/640x480" alt="" class="object-cover"
                                    style="height: 50px; width: 50px; border-radius: 100%;">
                                <p class="font-semibold">
                                    <?php echo $res2['name'] ?>
                                </p>
                            </div>
                            <?php
                            if ($res2['id_name'] == $_SESSION['id'] || $_SESSION['role'] == 1)
                                echo "<a href=\" delete_comment.php?idItem=$id&idComment=$res2[id]\"><i class=\"fa-solid fa-trash\"></i class=></a>";
                            ?>
                        </div>
                        <p>
                            <?php echo $res2['comment'] ?>
                        </p>
                        <br>
                        <hr style="border: none; border-top: 1px solid rgba(0, 0, 0, 0.10)">
                    </div>
                    <?php
                }
                ?>
            </div>
            <br>
        </div>
        <?php
        	if ($_SESSION['role'] == 0) {
                echo "<div class='fab'><a href='add.php' class='fab-icon'>+</a></div>";
                    echo "<div style='flex: 30%;'>
                    <div class='border-solid rounded-md'
                        style='border: 1px solid rgba(0, 0, 0, 0.10); padding: 20px; width: max-content;'>
                        <p class='font-semibold'>Informasi pembelian</p>
                        <p>Tersisa $stock</p>
                        <br>
                        <div style='background-color: #c9fde0; padding: 5px 10px; width: max-content;' class='rounded-md text-14'>
                           <a href='detail_product.php?idItem=$id&stock=$stock' onClick=\"return confirm('Yakin membeli barang?')\">Beli sekarang</a>
                        </div>
                    </div>
                </div>";
            }
        ?>
    </div>
    <br />
</body>
<style>
    .image-detail {
        object-fit: scale-down;
    }
    
    .image-detail:hover {
        object-fit: cover;
    }
</style>
</html>