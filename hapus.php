<?php
include 'db.php';
$id = $_GET['id'];

mysqli_query($conn, "DELETE FROM daftar_kontak WHERE id=$id");

header("Location: index.php");
?>
