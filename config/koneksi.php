<?php
$servername = "localhost";
$username   = "root";
$password   = "";
$database   = "uni_bookstore";

$koneksi = new mysqli($servername, $username, $password, $database);

if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}
?>