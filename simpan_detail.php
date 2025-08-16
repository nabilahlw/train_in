<?php
include 'koneksi.php';

$id  = (int)$_POST['pemesanan_id'];
$jml = (int)$_POST['jumlah_penumpang'];

/* === SIMPAN PEMESAN === */
$stmt = $koneksi->prepare("INSERT INTO orderer (pemesanan_id,nama,email,telepon,alamat,ttl)
                           VALUES (?,?,?,?,?,?)");
$stmt->bind_param(
    "isssss",
    $id,
    $_POST['nama_pemesan'],
    $_POST['email_pemesan'],
    $_POST['telp_pemesan'],
    $_POST['alamat_pemesan'],
    $_POST['ttl_pemesan']
);
$stmt->execute();

/* === SIMPAN PENUMPANG === */
$names = $_POST['penumpang_nama'];
$ids   = $_POST['penumpang_id'];
$ps    = $koneksi->prepare("INSERT INTO penumpang (pemesanan_id,nama,id_number) VALUES (?,?,?)");

for($i=0;$i<$jml;$i++){
   $ps->bind_param("iss",$id,$names[$i],$ids[$i]);
   $ps->execute();
}

/* redirect ke halaman transfer atau invoice */
header("Location: transfer.php?ord=$id");
exit;
?>
