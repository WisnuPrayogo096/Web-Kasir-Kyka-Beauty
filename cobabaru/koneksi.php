<?php
$host = 'localhost'; // Ganti dengan nama host database Anda
$username = 'root'; // Ganti dengan username database Anda
$password = ''; // Ganti dengan password database Anda
$database = 'kasir_zibran'; // Ganti dengan nama database Anda

// Buat koneksi ke database
$connection = mysqli_connect($host, $username, $password, $database);

// Periksa apakah koneksi berhasil
if (!$connection) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>
