<?php
$host = "localhost:3308";
$user = "root";
$password = "";
$dbname = "formulir";

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>