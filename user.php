<?php
session_start();
include('server/connection.php');

$sql = "Select * from buku";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
  $row = mysqli_fetch_assoc($result);
}

if (isset($_POST['cari'])) {
  $keyword = $_POST['keyword'];
  $q = "Select * from buku where judul_buku LIKE '%$keyword%'";
} else {
  $q = 'Select * from buku';
}

$result = mysqli_query($conn, $q);

if (!isset($_SESSION['logged_in'])) {
  header('location: landingpage.php');
  exit;
}

if (isset($_GET['logout'])) {
  if (isset($_SESSION['logged_in'])) {
    unset($_SESSION['logged_in']);
    unset($_SESSION['user_email']);
    header('location: login.php');
    exit;
  }
}
if ($_SESSION['user_status'] == 'Admin') {
  header('location: index.php');
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Rumah Kertas</title>
  <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" />
  <link rel="stylesheet" href="css/bootstrap.css" />
  <link rel="stylesheet" href="css/style.css" />
  <link rel="icon" href="Assets/logo.png" type="image/png" />
</head>

<body>
  <div class="Header">
    <nav class="wrapper">
      <div class="home">
        <ul style="list-style: none">
          <li>
            <a href="./user.php"><img src="Assets/icon/22.png" width="90px" alt="" /></a>
          </li>
        </ul>
      </div>

      <div class="action">
        <ul style="display: flex; list-style: none">
          <li>
            <a href="./profil.php"><img src="Assets/icon/user.png" class="user" width="70px" alt="" /></a>
          </li>
          <li>
            <a href="./user.php?logout=1" onclick="return confirm('Anda yakin ingin Logout?')"><img src="Assets/icon/off.png" width="70px" alt="" /></a>
          </li>
        </ul>
      </div>
    </nav>
  </div>

  <div class="hero-section">
    <section class="right-content">
      <h1>
        <font color="#5907ef">Nikmati</font> Peminjaman buku secara
        online & mudah
      </h1>
      <p class="desc-hero">
        Rumah Kertas adalah sebuah situs web perpustakaan yang menyediakan layanan peminjaman buku secara online.
        Situs ini menyediakan berbagai macam buku dari berbagai kategori seperti fiksi, non-fiksi, sains, sejarah,
        biografi, dan masih banyak lagi.
      </p>
      <br>
      <form class="search" method="post">
        <input class="search-box" type="text" name="keyword" placeholder="Cari Buku" />
        <button class="btn-cari" name="cari">
          <img src="Assets/icon/3917132.png" width="25px" class="search-icon" alt="" />
        </button>
      </form>
    </section>

    <section class="left-content">
      <img src="Assets/My project.png" width="90%" alt="hero image" />
      <div class="hero-book-title">
        <h4>Gone Dead</h4>
        <p>By George Martin</p>
      </div>
    </section>
  </div>

  <!-- CARD BUKU -->
  <main>
    <h1 class="main-title">Peminjaman <font color="#5907ef">BUKU</font>
    </h1>

    <div class="Book-content row">
      <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <div class="card col-lg-4">
          <img src="img/book/<?= $row['cover_buku'] ?>" alt="Cover buku" style="width:75% ;" />
          <div class="container">
            <h5><?= $row['judul_buku'] ?></h5>
            <p>By
              <?= $row['penulis_buku'] ?>
            </p>
          </div>
          <div class="tombol-pinjam">
            <!-- <form method="post" action="borrowBook.php"> -->
            <!-- <input type="button" name="submit" class="btn-pinjam" value="Pinjam" role="button" onclick="return confirm('Ingin meminjam buku <?= $row['judul_buku'] ?> ?')"> -->
            <!-- </form> -->
            <a href="borrowBook.php?book_id=<?= $row['id_buku'] ?>" role="button" onclick="return confirm('Ingin meminjam buku <?= $row['judul_buku'] ?> ?')" class="btn-pinjam">Pinjam</a>
          </div>
        </div>
      <?php } ?>
    </div>
  </main>
  <!-- END -->

</body>

</html>