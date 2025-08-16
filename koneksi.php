<?php
$koneksi = new mysqli("localhost", "root", "", "keretain");

if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}
?>
