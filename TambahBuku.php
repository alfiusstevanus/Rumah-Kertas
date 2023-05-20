<?php
include('server/connection.php');

$judul = $_POST['judul_buku'];
$penulis = $_POST['penulis_buku'];
$penerbit = $_POST['penerbit_buku'];
$tahunTerbit = $_POST['tahun_terbit'];

if (!empty($_FILES['cover']['tmp_name'])) {
    $cover = $_FILES['cover']['tmp_name'];
    $coverBuku = rand(0, 9999) . str_replace(' ', '', $judul) . ".jpg";
    move_uploaded_file($cover, "img/book/" . $coverBuku);
} else {
    $coverBuku =  'default.jpg';
}

$query = "INSERT INTO buku VALUES('','$judul','$penulis','$penerbit','$coverBuku','$tahunTerbit')";

mysqli_query($conn, $query);

header("location:index.php");
die();
