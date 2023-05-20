<?php
include('server/connection.php');

$username = $_POST['user_name'];
$email = $_POST['user_email'];
$password = md5(($_POST['user_password']));
$telp = ($_POST['telephone']);

if (!empty($_FILES['photo']['tmp_name'])) {
    $photo = $_FILES['photo']['tmp_name'];
    $photo_name = rand(0, 9999) . str_replace(' ', '', $username) . ".jpg";
    move_uploaded_file($photo, "img/profil/" . $photo_name);
} else {
    $photo_name =  'member.jpg';
}
$query = "INSERT INTO akun VALUES('','$email','$username','$password','$telp','User','$photo_name')";

mysqli_query($conn, $query);

header("location:login.php");
die();
