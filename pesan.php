<?php
include 'koneksi.php';

// Ambil ID kereta dari URL (GET)
$id = $_GET['id'] ?? 0;
$penumpang = $_GET['p'] ?? 1;

// Ambil data kereta dari tabel schedules
$query = "SELECT * FROM schedules WHERE id = $id";
$result = mysqli_query($koneksi, $query);
$kereta = mysqli_fetch_assoc($result);

// Jika tidak ada data kereta
if (!$kereta) {
    die("Data kereta tidak ditemukan.");
}

// Hitung total harga
$total = $kereta['harga'] * $penumpang;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Info Pemesanan – KeretaIN</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f9f9f9;
            padding: 40px;
        }

        h2 {
            text-align: center;
            color: #0b1d46;
            margin-top: 40px;
        }

        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background: #fff;
            box-shadow: 0 0 12px rgba(0,0,0,0.1);
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
        }

        th {
            background: #0b1d46;
            color: #fff;
            text-align: left;
        }

        input, textarea, select {
            width: 100%;
            padding: 6px;
            box-sizing: border-box;
        }

        button {
            background: #ffcc00;
            color: #0b1d46;
            font-weight: bold;
            padding: 12px 24px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            display: block;
            margin: 30px auto;
        }
    </style>
</head>
<body>

    <h2>Info Pemesanan</h2>
    <table>
        <tr><th>Nama Kereta</th><td><?= htmlspecialchars($kereta['nama_kereta']) ?></td></tr>
        <tr><th>Rute</th><td><?= htmlspecialchars($kereta['asal']) ?> – <?= htmlspecialchars($kereta['tujuan']) ?></td></tr>
        <tr><th>Waktu Berangkat</th><td><?= htmlspecialchars($kereta['jam_berangkat']) ?></td></tr>
        <tr><th>Waktu Tiba</th><td><?= htmlspecialchars($kereta['jam_tiba']) ?></td></tr>
        <tr><th>Jumlah Penumpang</th><td><?= (int)$penumpang ?></td></tr>
        <tr><th>Harga Satuan</th><td>Rp <?= number_format($kereta['harga'], 0, ',', '.') ?></td></tr>
        <tr><th>Total Harga</th><td>Rp <?= number_format($total, 0, ',', '.') ?></td></tr>
    </table>

    <h2>Detail Penumpang & Info Pemesan</h2>
    <form action="proses_pesan.php" method="POST">
        <!-- Hidden input -->
        <input type="hidden" name="id" value="<?= $kereta['id'] ?>">
        <input type="hidden" name="p" value="<?= $penumpang ?>">

        <!-- Data penumpang -->
        <table>
            <tr>
                <th>Nama</th>
                <th>Usia</th>
                <th>No KTP</th>
				<th>Gender</th>
            </tr>
            <?php for ($i = 1; $i <= $penumpang; $i++): ?>
            <tr>
    <td><input type="text" name="penumpang[<?= $i ?>][nama]" required></td>
    <td><input type="number" name="penumpang[<?= $i ?>][usia]" required></td>
    <td><input type="text" name="penumpang[<?= $i ?>][ktp]" required></td>
    <td>
        <select name="penumpang[<?= $i ?>][jenis_kelamin]" required>
            <option value="">Pilih</option>
            <option value="L">Laki-laki</option>
            <option value="P">Perempuan</option>
        </select>
    </td>
</tr>
            <?php endfor; ?>
        </table>

        <!-- Info pemesan -->
        <table>
            <tr><th>Nama Lengkap</th><td><input type="text" name="pemesan_nama" required></td></tr>
            <tr><th>Email</th><td><input type="email" name="pemesan_email" required></td></tr>
            <tr><th>No Telepon</th><td><input type="text" name="pemesan_hp" required></td></tr>
            <tr><th>Alamat</th><td><textarea name="pemesan_alamat" required></textarea></td></tr>
            <tr><th>Tanggal Lahir</th><td><input type="date" name="pemesan_usia" required></td></tr>
        </table>

        <button type="submit">Simpan & Lanjutkan</button>
    </form>

</body>
</html>