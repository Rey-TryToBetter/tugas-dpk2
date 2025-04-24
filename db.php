<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "db_kontak";

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error() . " (" . mysqli_connect_errno() . ")");
}

// echo "Connected successfully";
?>
