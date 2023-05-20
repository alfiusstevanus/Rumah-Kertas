<?php
session_start();
if ($_SESSION['user_status'] == 'Admin') {
    header('location: dataprofil.php');
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
    <link rel="icon" href="Assets/logo.png" type="image/png" />
    <title>Edit User</title>
</head>

<body>
    <div class="wrapper">
        <header>
            <a class="logo" href="./user.php"><img src="icon/22.png" alt=""></a>
            <a class="atr" href="./user.php?logout=1" onclick="return confirm('Anda yakin ingin Logout?')"><img src="icon/logoff.png" alt=""></a>
        </header>
        <main>
            <form id="up" method="post" enctype="multipart/form-data" action="actionUpdate.php?id=<?= $_SESSION['user_id'] ?>">
                <h1>Edit <span>User</span></h1>
                <div class="update">
                    <label for="fname"><span>Name:</span><input type="text" id="fname" name="user_name" value="<?= $_SESSION['user_name'] ?> " required></label>
                    <label for="Email"><span>Email:</span> <input type="email" id="email" name="user_email" value="<?= $_SESSION['user_email'] ?>" required></label>
                    <label for="Telephone"><span>No Telp:</span> <input type="text" id="telp" name="user_telp" value="<?= $_SESSION['user_telp'] ?>" required></label>
                    <label id="img" for="photo"><span>Photo:</span> <input type="file" id="photo" name="photo"></label>
                </div>
                <input type="submit" value="UPDATE">
                <a href="./profil.php">Kembali ke Laman Profil?</a>
            </form>
            <div class="picture">
                <img class="picture" src="img/profil/<?= $_SESSION['user_photo'] ?>" alt="">
            </div>
        </main>
    </div>
</body>

</html>