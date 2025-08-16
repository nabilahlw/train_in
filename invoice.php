<?php
include 'koneksi.php';

if (!isset($_GET['order_id'])) {
    die("Order ID tidak ditemukan.");
}

$order_id = $_GET['order_id'];

// Ambil data order
$order = $koneksi->query("
    SELECT 
        p.*, 
        s.nama_kereta, s.asal, s.tujuan, s.jam_berangkat AS jam, s.jam_tiba, s.tanggal_berangkat
    FROM pemesanan p
    JOIN schedules s ON p.kereta_id = s.id
    WHERE p.id = '$order_id'
")->fetch_assoc();

if (!$order) {
    die("❌ Data kereta tidak lengkap atau ID tidak cocok antara pemesanan dan schedules.");
}

// Ambil data pemesan berdasarkan pemesanan_id
$pemesan = $koneksi->query("SELECT * FROM pemesan WHERE pemesanan_id = '$order_id'")->fetch_assoc();

// Ambil data penumpang berdasarkan pemesanan_id
$penumpang = $koneksi->query("SELECT * FROM penumpang WHERE pemesanan_id = '$order_id'");

// Ambil data pembayaran
$pembayaran = $koneksi->query("SELECT * FROM pembayaran WHERE pemesanan_id = '$order_id'")->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Invoice Tiket - KeretaIN</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <style>
    body {
        margin: 0;
        padding: 0;
        background: #f2f2f2;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        font-family: 'Courier New', monospace;
    }

    .struk-wrapper {
        background: white;
        padding: 10px;
        border: 1px dashed #999;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    .invoice-wrapper {
        width: 260px;
        font-size: 11px;
        color: #000;
    }

    h1, h2 {
        font-size: 13px;
        text-align: center;
        margin: 4px 0;
        text-transform: uppercase;
    }

    p {
        margin: 2px 0;
        line-height: 1.3;
    }

    .mini-table {
        width: 100%;
        border-collapse: collapse;
        margin: 4px 0 8px;
    }

    .mini-table th,
    .mini-table td {
        border-bottom: 1px dashed #ccc;
        padding: 2px 4px;
        font-size: 11px;
        text-align: left;
    }

    img {
        width: 100%;
        margin-top: 5px;
        border: 1px solid #000;
    }

    #download-btn {
        width: 100%;
        padding: 6px;
        margin-top: 10px;
        background-color: #000;
        color: white;
        font-size: 11px;
        border: none;
        cursor: pointer;
        border-radius: 3px;
    }

    @media print {
        #download-btn {
            display: none;
        }
        body {
            background: white;
        }
    }
</style>


</head>
<body>
    <div class="struk-wrapper">
        <div class="invoice-wrapper" id="invoice-content">
            <h1>Invoice Pemesanan Tiket</h1>
            <p><strong>ID Pemesanan:</strong> <?= $order_id ?></p>
            <p><strong>Tanggal:</strong> <?= date('d M Y', strtotime($order['created_at'])) ?></p>

            <h2>Info Pemesan</h2>
            <?php if ($pemesan): ?>
                <p><strong>Nama:</strong> <?= $pemesan['nama_lengkap'] ?></p>
                <p><strong>Email:</strong> <?= $pemesan['email'] ?></p>
                <p><strong>HP:</strong> <?= $pemesan['no_hp'] ?></p>
                <p><strong>Alamat:</strong> <?= $pemesan['alamat'] ?></p>
            <?php else: ?>
                <p><em>Data pemesan tidak ditemukan.</em></p>
            <?php endif; ?>

            <h2>Detail Tiket</h2>
            <table class="mini-table">
                <tr><td>Kereta</td><td><?= $order['nama_kereta'] ?></td></tr>
                <tr><td>Rute</td><td><?= $order['asal'] ?> - <?= $order['tujuan'] ?></td></tr>
                <tr><td>Waktu</td><td><?= $order['tanggal_berangkat'] ?> <?= $order['jam'] ?></td></tr>
                <tr><td>Penumpang</td><td><?= $order['jumlah_penumpang'] ?></td></tr>
                <tr><td>Harga</td><td>Rp <?= number_format($order['harga_satuan'], 0, ',', '.') ?></td></tr>
                <tr><td>Total</td><td><strong>Rp <?= number_format($order['total_harga'], 0, ',', '.') ?></strong></td></tr>
            </table>

            <h2>Penumpang</h2>
            <table class="mini-table">
                <tr><th>No</th><th>Nama</th><th>Umur</th></tr>
                <?php $no = 1; while ($row = $penumpang->fetch_assoc()): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $row['nama'] ?></td>
                    <td><?= $row['umur'] ?></td>
					</tr>
                <?php endwhile; ?>
            </table>

            <h2>Pembayaran</h2>
            <?php if ($pembayaran): ?>
                <p><strong>Status:</strong> Telah Dibayar</p>
                <p><strong>Pengirim:</strong> <?= $pembayaran['nama_pengirim'] ?></p>
                <p><strong>Metode:</strong> <?= $pembayaran['metode_pembayaran'] ?></p>
                <img src="uploads/<?= $pembayaran['bukti_transfer'] ?>" alt="Bukti" />
            <?php else: ?>
                <p><em>Belum ada data pembayaran.</em></p>
            <?php endif; ?>

            <button id="download-btn">Simpan Bukti Pembayaran</button>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script>
        document.getElementById("download-btn").addEventListener("click", function () {
            html2canvas(document.querySelector("#invoice-content")).then(canvas => {
                let link = document.createElement('a');
                link.download = 'invoice-<?= $order_id ?>.png';
                link.href = canvas.toDataURL("image/png");
                link.click();
            });
        });
    </script>
</body>

</html>
