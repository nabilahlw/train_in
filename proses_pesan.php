<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $p = $_POST['p'];

    $pemesan_nama   = $_POST['pemesan_nama'];
    $pemesan_email  = $_POST['pemesan_email'];
    $pemesan_hp     = $_POST['pemesan_hp'];
    $pemesan_alamat = $_POST['pemesan_alamat'];
    $pemesan_usia   = $_POST['pemesan_usia'];
    $penumpang_data = $_POST['penumpang'];

    // Ambil data kereta
    $query = "SELECT * FROM schedules WHERE id = $id LIMIT 1";
    $result = $koneksi->query($query);
    if (!$result || $result->num_rows == 0) {
        die("Kereta tidak ditemukan.");
    }
    $data = $result->fetch_assoc();
    $harga = $data['harga'];
    $total = $harga * $p;

    // Simpan ke tabel pemesanan
    $created_at = date('Y-m-d H:i:s');
    $stmt = $koneksi->prepare("INSERT INTO pemesanan (kereta_id, jumlah_penumpang, harga_satuan, total_harga, created_at) 
                               VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("iiids", $id, $p, $harga, $total, $created_at);
    if (!$stmt->execute()) {
        die("Gagal simpan pemesanan: " . $stmt->error);
    }
    $pemesanan_id = $stmt->insert_id;

    // Simpan ke tabel pemesan
    $stmt_pemesan = $koneksi->prepare("INSERT INTO pemesan (pemesanan_id, nama_lengkap, no_hp, email, alamat, umur) 
                                       VALUES (?, ?, ?, ?, ?, ?)");
    $stmt_pemesan->bind_param("issssi", $pemesanan_id, $pemesan_nama, $pemesan_hp, $pemesan_email, $pemesan_alamat, $pemesan_usia);
    $stmt_pemesan->execute();
// Simpan ke tabel penumpang (tanpa ktp)
// Simpan ke tabel penumpang
foreach ($penumpang_data as $pnp) {
    $nama          = $pnp['nama'];
    $usia          = $pnp['usia'];
    $jenis_kelamin = $pnp['jenis_kelamin'];

    $stmt_penumpang = $koneksi->prepare("INSERT INTO penumpang 
        (pemesanan_id, nama, umur, jenis_kelamin) 
        VALUES (?, ?, ?, ?)");
    $stmt_penumpang->bind_param("isis", $pemesanan_id, $nama, $usia, $jenis_kelamin);
    $stmt_penumpang->execute();
}

// Redirect ke halaman pembayaran
header("Location: payment.php?id=$pemesanan_id");
exit;
}