<?php
$host = "localhost";
$user = "root";
$pass = "1";
$db   = "utscrud";

$koneksi = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) {
    die("Aduh, gagal nyambung ke database!");
}
?>
