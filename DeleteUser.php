<?php

include "server/connection.php";
$id = $_GET['id'];

$q = "DELETE FROM akun WHERE id = '$id'";
mysqli_query($conn, $q);
header("location: dataProfil.php");
