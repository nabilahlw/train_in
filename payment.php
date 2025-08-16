<?php
$pemesanan_id = $_GET['id'] ?? null;
if (!$pemesanan_id) {
    echo "ID Pemesanan tidak ditemukan!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pembayaran - KeretaIN</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .container {
            max-width: 700px;
            margin: 40px auto;
            padding: 30px;
            background: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        h2 { text-align: center; color: #0b1d46; }
        .bank-section {
            margin-bottom: 30px;
            background: #fff;
            padding: 20px;
            border-radius: 6px;
            box-shadow: 0 0 5px rgba(0,0,0,0.1);
        }
        .bank-buttons button {
            padding: 10px 20px;
            margin: 5px;
            font-weight: bold;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            background-color: #e0e0e0;
        }
        table { width: 100%; margin-top: 20px; }
        td { padding: 10px; }
        input, select {
            width: 100%; padding: 10px;
            border: 1px solid #ccc; border-radius: 4px;
        }
        button[type="submit"] {
            padding: 12px 20px;
            background: #0b1d46;
            color: white;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 20px;
            width: 100%;
        }
    </style>
    <script>
        function pilihBank(namaBank) {
            document.getElementById("metode_pembayaran").value = namaBank;
        }
    </script>
</head>
<body>
    <div class="container">
        <h2>Form Pembayaran</h2>

        <!-- Bagian info rekening TrainIN -->
        <div class="bank-section">
            <h3>Rekening Bank TrainIN</h3>
            <ul>
                <li><strong>BCA:</strong> 1234567890 a.n. TrainIN Indonesia</li>
                <li><strong>BRI:</strong> 9876543210 a.n. TrainIN Indonesia</li>
                <li><strong>BSI:</strong> 5678901234 a.n. TrainIN Indonesia</li>
                <li><strong>MANDIRI:</strong> 1122334455 a.n. TrainIN Indonesia</li>
            </ul>

            <div class="bank-buttons">
                <p><strong>Klik untuk memilih metode pembayaran:</strong></p>
                <button type="button" onclick="pilihBank('BCA')">BCA</button>
                <button type="button" onclick="pilihBank('BRI')">BRI</button>
                <button type="button" onclick="pilihBank('BSI')">BSI</button>
                <button type="button" onclick="pilihBank('MANDIRI')">Mandiri</button>
            </div>
        </div>

        <!-- Form input pembayaran -->
        <form action="simpan_pembayaran.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="pemesanan_id" value="<?= htmlspecialchars($pemesanan_id) ?>">

            <table>
                <tr>
                    <td>Metode Pembayaran</td>
                    <td>
                        <select name="metode_pembayaran" id="metode_pembayaran" required>
                            <option value="">Pilih</option>
                            <option value="BCA">Transfer BCA</option>
                            <option value="BRI">Transfer BRI</option>
                            <option value="BSI">Transfer BSI</option>
                            <option value="MANDIRI">Transfer Mandiri</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Nama Pengirim</td>
                    <td><input type="text" name="nama_pengirim" required></td>
                </tr>
                <tr>
                    <td>No Rekening Pengirim</td>
                    <td><input type="text" name="no_rekening_pengirim" required></td>
                </tr>
                <tr>
                    <td>Bukti Transfer</td>
                    <td><input type="file" name="bukti_transfer" accept="image/*" required></td>
                </tr>
            </table>

            <button type="submit">Simpan & Selesaikan</button>
        </form>
    </div>
</body>
</html>
