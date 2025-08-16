<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $pemesanan_id = $_POST['pemesanan_id'];
    $nama_pengirim = $_POST['nama_pengirim'];
    $rekening_pengirim = $_POST['no_rekening_pengirim'];
    $metode_pembayaran = $_POST['metode_pembayaran'];
    $bukti = $_FILES['bukti_transfer']['name'];

    // Simpan file bukti transfer
    $target = "uploads/" . basename($bukti);
    move_uploaded_file($_FILES['bukti_transfer']['tmp_name'], $target);

    // Query INSERT (pastikan kolom di DB sesuai)
    $sql = "INSERT INTO pembayaran 
(pemesanan_id, nama_pengirim, metode_pembayaran, no_rekening_pengirim, bukti_transfer, status)
VALUES 
('$pemesanan_id', '$nama_pengirim', '$metode_pembayaran', '$no_rekening_pengirim', '$bukti', 'Menunggu Verifikasi')";

    if ($koneksi->query($sql) === TRUE) {
        header("Location: invoice.php?order_id=$pemesanan_id");
        exit();
    } else {
        echo "Gagal menyimpan pembayaran: " . $koneksi->error;
    }
}
?>
