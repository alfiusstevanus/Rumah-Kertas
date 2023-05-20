<?php
session_start();
include('server/connection.php');
$id = $_GET["id_buku"];
$sql = "Select * from buku WHERE id_buku = $id";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $_SESSION['id_buku'] = $row['id_buku'];
    $_SESSION['judul_buku'] = $row['judul_buku'];
    $_SESSION['penulis_buku'] = $row['penulis_buku'];
    $_SESSION['penerbit_buku'] = $row['penerbit_buku'];
    $_SESSION['tahun_terbit'] = $row['tahun_terbit'];
    $_SESSION['cover_buku'] = $row['cover_buku'];
}
if (!isset($_SESSION['logged_in'])) {
    header('location: login.php');
    exit;
}
if ($_SESSION['user_status'] == 'User') {
    header('location: user.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/editdata.css">
    <title>Edit Buku</title>
    <link rel="icon" href="Assets/logo.png" type="image/png" />
</head>

<body>
    <div class="wrapper">
        <header>
            <a class="logo" href="./index.php"><img src="icon/22.png" alt=""></a>
            <a class="atr" href="./index.php?logout=1"><img src="icon/logoff.png" alt=""></a>
        </header>
        <main>
            <form id="up" method="post" action="actionUpdateBuku.php?id_buku=<?= $id ?>" enctype="multipart/form-data">
                <h1>UPDATE <span>BUKU</span></h1>
                <h4 class="updateId">ID BUKU: <?= $_SESSION['id_buku']; ?> </h4>
                <div class="update">
                    <label for="judul"><span>Judul buku:</span> <input type="text" id="judul" name="judul_buku" value="<?= $_SESSION['judul_buku'] ?>"></label>
                    <label for="penulis"><span>Penulis:</span> <input type="text" id="penulis" name="penulis_buku" value="<?= $_SESSION['penulis_buku'] ?>"></label>
                    <label for="penerbit"><span>Penerbit:</span> <input type="text" id="penerbit" name="penerbit_buku" value="<?= $_SESSION['penerbit_buku'] ?>"></label>
                    <label for="tahun"><span>Tahun Terbit:</span> <input type="text" id="tahun" name="tahun_terbit" value="<?= $_SESSION['tahun_terbit'] ?>"></label>
                    <label for="cover"><span>Cover Buku:</span> <input type="file" id="cover" name="cover_buku"></label>
                </div>
                <input type="submit" value="UPDATE">
                <a href="./index.php">Kembali ke laman tabel?</a>
            </form>
            <div class="picture">
                <img class="picture" src="img/book/<?= $_SESSION['cover_buku'] ?>" alt="">
            </div>
        </main>
    </div>
</body>

</html>