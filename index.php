<?php
session_start();
include('server/connection.php');

$sql = "Select * from buku";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
  $row = mysqli_fetch_assoc($result);
}
if ($_SESSION['user_status'] == 'User') {
  header('location: user.php');
  exit;
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
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/ManageAdmin.css">
  <!-- <link rel="stylesheet" href="css/bootstrap.css"> -->
  <link rel="icon" href="Assets/logo.png" type="image/png" />
  <title>Kelola Buku</title>
</head>

<body>
  <!--  HEADER    -->
  <nav>
    <img src="Assets/logo.png" id="icon-header" width="150" alt="headerlogo" />
  </nav>
  <!-- END HEADER -->

  <!--   SIDE BAR   -->
  <div class="side-bar">
    <a href="./dataprofil.php"><img class="side" id="profile" width="50" src="Assets/profile.png" alt="Profil" /></a>
    <a href="./index.php"><img class="side" width="50" src="Assets/book.png" alt="Book" /></a>
    <a href="./index.php?logout=1" onclick="return confirm('Anda yakin ingin Logout?')"><img class="side" id="logout" width="50" src="Assets/exit.png" alt="Exit" /></a>
  </div>

  <!--  END SIDE BAR -->

  <!--  CONTENT-BUKU    -->
  <div class="Container">
    <h1>KELOLA <font color="#5907EF"> BUKU</font>
    </h1>
    <div class="form-search">
      <form class="search" method="post">
        <input class="search-box" type="text" name="keyword" placeholder="Cari Judul Buku" />
        <button class="cari" name="cari">
          <img src="Assets/icon/3917132.png" width="25px" alt="" />
        </button>
      </form>
    </div>

    <div class="act-buku">
      <a href="./PageTambahBuku.php"><button class="tambah">
          + Tambah Buku
        </button></a>
      <a href="dataPeminjam.php"><button class="lihat">
          Daftar Peminjam
        </button></a>
    </div>

    <table>
      <thead>
        <tr>
          <th>ID Buku</th>
          <th>Judul Buku</th>
          <th>Penulis</th>
          <th>Penerbit</th>
          <th class="th-tahun">Tahun Terbit</th>
          <th class="th-action" colspan="2">ACTION</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
          <tr class="col-2">
            <td><?= $row['id_buku'] ?></td>
            <td><?= $row['judul_buku'] ?></td>
            <td><?= $row['penulis_buku'] ?></td>
            <td><?= $row['penerbit_buku'] ?></td>
            <td><?= $row['tahun_terbit'] ?></td>
            <td>
              <div class="act-delete">
                <a href="DeleteBuku.php?id_buku=<?= $row['id_buku']; ?>" role="button" onclick="return confirm('Buku <?= $row['judul_buku'] ?> akan dihapus?')"><img src="Assets/icon/hapus.png" class="hapus" width="40px" alt="" /></a>
              </div>
            </td>
            <td>
              <div class="act-update">
                <a href="UpdateBuku.php?id_buku=<?= $row['id_buku']; ?>"><img src="Assets/icon/edit-246.png" class="update" width="40px" alt="" /></a>
              </div>
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
  <!--  END CONTENT-USER   -->
</body>

</html>