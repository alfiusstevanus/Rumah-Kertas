<?php
session_start();
include('server/connection.php');

$sql = "Select * from akun WHERE status = 'User'";
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
  if (strlen($keyword) > 0) {
    $q = "Select * from akun WHERE name LIKE '%$keyword%' && status = 'User' ";
  } else {
    $q = "Select * from akun WHERE status = 'User'";
  }
} else {
  $q = "Select * from akun WHERE status = 'User'";
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
  <title>Kelola User</title>
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
    <h1>KELOLA <font color="#5907EF"> USER</font>
    </h1>
    <div class="form-search">
      <form class="search" method="post">
        <input class="search-box" type="text" name="keyword" placeholder="Cari Nama User" />
        <button class="cari" name="cari">
          <img src="Assets/icon/3917132.png" width="25px" alt="" />
        </button>
      </form>
    </div>

    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Nama</th>
          <th>Email</th>
          <th>Telephone</th>
          <th class="th-hapus">HAPUS</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
          <tr class="col-2">
            <td><?= $row['id'] ?></td>
            <td><?= $row['name'] ?></td>
            <td><?= $row['email'] ?></td>
            <td><?= $row['telephone'] ?></td>
            <td>
              <div class="act-delete">
                <a href="DeleteUser.php?id=<?= $row['id']; ?>" role="button" onclick="return confirm('Data dari <?= $row['name'] ?> akan dihapus?')"><img src="Assets/icon/hapus.png" class="hapus" width="40px" alt="" /></a>
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