<?php
session_start();
include('server/connection.php');
$sql = "SELECT meminjam.id_pinjam, akun.name, buku.judul_buku, meminjam.tanggal_pinjam
FROM meminjam
INNER JOIN akun ON meminjam.id = akun.id
INNER JOIN buku ON meminjam.id_buku = buku.id_buku";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
  $row = mysqli_fetch_assoc($result);
}

if ($_SESSION['user_status'] == 'User') {
  header('location: profil.php');
  exit;
}
if (isset($_POST['cari'])) {
  $keyword = $_POST['keyword'];
  $q = "SELECT meminjam.id_pinjam, akun.name, buku.judul_buku, meminjam.tanggal_pinjam
    FROM meminjam
    INNER JOIN akun ON meminjam.id = akun.id
    INNER JOIN buku ON meminjam.id_buku = buku.id_buku
    WHERE akun.name LIKE '%$keyword%' OR buku.judul_buku LIKE '%$keyword%' ";
} else {
  $q = "SELECT meminjam.id_pinjam, akun.name, buku.judul_buku, meminjam.tanggal_pinjam
  FROM meminjam
  INNER JOIN akun ON meminjam.id = akun.id
  INNER JOIN buku ON meminjam.id_buku = buku.id_buku";
}
$result = mysqli_query($conn, $q);

if (!isset($_SESSION['logged_in'])) {
  header('location: login.php');
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
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="css/ManageAdmin.css" />
  <link rel="icon" href="Assets/logo.png" type="image/png" />
  <title>Daftar Peminjaman Buku</title>
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
  <!-- END SIDE BAR -->

  <!--  CONTENT-USER    -->
  <div class="Container">
    <h1>Daftar <font color="#5907EF"> Peminjaman</font>
    </h1>
    <div class="form-search">
      <form class="search" method="post">
        <input class="search-box" type="text" name="keyword" placeholder="Cari User atau Judul Buku" />
        <button class="cari" name="cari">
          <img src="Assets/icon/3917132.png" width="25px" alt="" />
        </button>
      </form>
    </div>

    <table>
      <thead>
        <tr>
          <th>ID Pinjam</th>
          <th>User Name</th>
          <th>Judul Buku</th>
          <th>Tanggal Pinjam</th>
          <th class="th-hapus">HAPUS</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = mysqli_fetch_assoc($result)) {
          setlocale(LC_TIME, 'id_ID');
          $date = strtotime($row['tanggal_pinjam']);
          $newDate = strftime("%A, %d %B %Y", $date);
        ?>
          <tr class="col-2">
            <td><?= $row['id_pinjam'] ?></td>
            <td><?= $row['name'] ?></td>
            <td><?= $row['judul_buku'] ?></td>
            <td><?= $newDate ?></td>
            <td>
              <div class="act-delete">
                <a href="DeleteBorrow.php?id=<?= $row['id_pinjam']; ?>" role="button" onclick="return confirm('Data <?= $row['name'] ?> meminjam buku <?= $row['judul_buku'] ?> akan dihapus?')"><img src="Assets/icon/hapus.png" class="hapus" width="40px" alt="" /></a>
              </div>
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
  <!--   END CONTENT-USER   -->
</body>

</html>