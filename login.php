<?php
session_start();
include('server/connection.php');

if (isset($_SESSION['logged_in'])) {
    if ($_SESSION['user_status'] == 'Admin') {
        header('location: index.php');
        exit;
    } else if ($_SESSION['user_status'] == 'User') {
        header('location: user.php');
        exit;
    }
}

if (isset($_POST['login_btn'])) {

    $email = $_POST['user_email'];
    $password = md5(($_POST['user_password']));

    $query = "SELECT * FROM akun WHERE email = ? AND password = ? LIMIT 1";
    $stmt_login = $conn->prepare($query);
    $stmt_login->bind_param('ss', $email, $password);

    if ($stmt_login->execute()) {

        $stmt_login->bind_result(
            $user_id,
            $user_email,
            $user_name,
            $user_password,
            $user_telephone,
            $user_status,
            $user_photo
        );
        $stmt_login->store_result();

        if ($stmt_login->num_rows() == 1) {

            $stmt_login->fetch();

            $_SESSION['user_id'] = $user_id;
            $_SESSION['user_name'] = $user_name;
            $_SESSION['user_email'] = $user_email;
            $_SESSION['user_status'] = $user_status;
            $_SESSION['user_telephone'] = $user_telephone;
            $_SESSION['user_photo'] = $user_photo;
            $_SESSION['logged_in'] = true;

            if ($_SESSION['user_status'] == 'Admin') {
                $_SESSION['link'] = 'index';
            } else if ($_SESSION['user_status'] == 'User') {
                $_SESSION['link'] = 'user';
            }
            header("location: " . $_SESSION['link'] . ".php?message=Login berhasil sebagai " . $_SESSION['user_status']);
        } else {
            header('location: login.php?error=Harap isi dengan benar!');
        }
    } else {
        header('location: login.php?error=Terjadi suatu kesalahan!');
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/Log-regist.css">
    <link rel="icon" href="Assets/logo.png" type="image/png" />
    <title>Login</title>
</head>

<body>
    <section class="Left-content">
        <h1 class="h1">SELAMAT<font color="#5907EF"> DATANG</font>
        </h1>
        <p class="fw-medium">Silakan isi data anda untuk masuk</p>

        <div class="Login-form">
            <form action="login.php" method="post">
                <div class="mb-3">
                    <label class="form-label">Email address</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="user_email" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" class="form-control" id="exampleInputPassword1" name="user_password" required>
                </div>
                <?php if (isset($_GET['error'])) ?>
                <div class="error">
                    <?php
                    if (isset($_GET['error'])) {
                        echo $_GET['error'];
                    }
                    ?>
                </div>
                <button type="submit" class="btn btn-primary" id="login-btn" name="login_btn">LOGIN</button>
                <div class="regbtn">
                    <h6>Belum Punya akun? <a href="register.php"> Register Here</a></h6>
                </div>
            </form>
        </div>
    </section>

    <section class="Right-content">
        <span>
            <img src="Assets/iconbuku_login.png" id="book-icon" alt="">
        </span>
    </section>
</body>

</html>