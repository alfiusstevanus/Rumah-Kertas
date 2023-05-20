<?php
session_start();
include "server/connection.php";
$id = $_GET['id'];
$email = $_POST['user_email'];
$telp = $_POST['user_telp'];
$password = $_POST['user_password'];
$name = $_POST['user_name'];

$photo_name = rand(0, 9999) . str_replace(' ', '', $name) . ".jpg";
$path = 'img/profil/' . $_SESSION['user_photo'];


if (!empty($_FILES['photo']['tmp_name'])) {
    if (file_exists($path) && $_SESSION['user_photo'] != 'member.jpg') {
        unlink($path);
    }
    $photo = $_FILES['photo']['tmp_name'];
    move_uploaded_file($photo, "img/profil/" . $photo_name);
} else {
    $photo_name =  $_SESSION['user_photo'];
}

$query = "UPDATE akun SET email = '$email', name = '$name', telephone = '$telp' , photo = '$photo_name' WHERE id = '$id'";
mysqli_query($conn, $query);
header("location:profil.php");
die();
