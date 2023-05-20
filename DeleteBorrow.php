<?php

include "server/connection.php";
$id = $_GET['id'];

$query = "DELETE FROM meminjam WHERE id_pinjam = '$id'";
mysqli_query($conn, $query);
header("location: dataPeminjam.php");
//a