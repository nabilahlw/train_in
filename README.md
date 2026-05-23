# 🚂 KeretaIN — Sistem Pemesanan Tiket Kereta Online

![PHP](https://img.shields.io/badge/PHP-8.x-blue?logo=php)
![MySQL](https://img.shields.io/badge/MySQL-8.x-orange?logo=mysql)
![XAMPP](https://img.shields.io/badge/XAMPP-Required-red?logo=apache)
![License](https://img.shields.io/badge/License-MIT-green)

KeretaIN adalah aplikasi web pemesanan tiket kereta api berbasis PHP dan MySQL. Pengguna dapat memilih jadwal kereta, mengisi data penumpang, melakukan pembayaran via transfer bank, dan mengunduh invoice tiket.

## ✨ Fitur
- Lihat jadwal kereta yang tersedia
- Pesan tiket untuk satu atau lebih penumpang
- Input data pemesan & penumpang lengkap
- Pembayaran via transfer bank (BCA, BRI, BSI, Mandiri)
- Upload bukti transfer
- Invoice tiket yang bisa diunduh sebagai gambar

## 🛠️ Teknologi yang Digunakan

| Teknologi | Keterangan |
|-----------|------------|
| PHP 8.x | Backend / server-side |
| MySQL | Database |
| XAMPP | Local server (Apache + MySQL) |
| HTML/CSS | Frontend tampilan |
| JavaScript | Interaksi UI & download invoice |
| html2canvas | Export invoice ke gambar |

## ⚙️ Cara Menjalankan Project (Step by Step)

### 📋 Prasyarat

Pastikan sudah menginstall:
- [XAMPP](https://www.apachefriends.org/download.html) (versi terbaru)
- Browser modern (Chrome, Firefox, Edge)
- [Git](https://git-scm.com/) (opsional, untuk clone repo)

### Langkah 1 — Clone / Download Project

**Opsi A: Via Git**
```bash
git clone https://github.com/username/keretain.git
```

**Opsi B: Download ZIP**
Klik tombol **Code → Download ZIP** di halaman repository ini


### Langkah 2 — Pindahkan ke Folder XAMPP

Extract all file ZIP yg sudah didownload, dan wajib pindahkan ke folder project :
```
C:\xampp\htdocs\train_in\
```

Struktur folder seharusnya:
```
htdocs/
└── train_in/
    ├── img/
    │   ├── logo.png
    │   ├── stasiun.jpg
    │   ├── train1.jpg
    │   └── ...
    ├── js/
    │   └── main.js
    ├── uploads/          ← buat folder ini jika belum ada
    ├── index.php
    ├── koneksi.php
    ├── pesan.php
    ├── proses_pesan.php
    ├── payment.php
    ├── simpan_pembayaran.php
    ├── invoice.php
    ├── style.css
    └── ...
```

### Langkah 3 — Jalankan XAMPP

1. Buka **XAMPP Control Panel**
2. Klik **Start** pada **Apache**
3. Klik **Start** pada **MySQL**
4. Pastikan keduanya berstatus **hijau / Running**

### Langkah 4 — Import Database

1. Buka browser, akses: `http://localhost/phpmyadmin`
2. Klik **New** di panel kiri untuk membuat database baru
3. Isi nama database: `keretain` → klik **Create**
4. Setelah masuk ke database `keretain`, klik tab **SQL**
5. Copy-paste SQL berikut, lalu klik **Go**:

```sql
CREATE TABLE schedules (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_kereta VARCHAR(100) NOT NULL,
    asal VARCHAR(100) NOT NULL,
    tujuan VARCHAR(100) NOT NULL,
    jam_berangkat TIME NOT NULL,
    jam_tiba TIME NOT NULL,
    tanggal_berangkat DATE NOT NULL,
    harga INT NOT NULL
);

CREATE TABLE pemesanan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kereta_id INT NOT NULL,
    jumlah_penumpang INT NOT NULL,
    harga_satuan INT NOT NULL,
    total_harga INT NOT NULL,
    created_at DATETIME NOT NULL,
    FOREIGN KEY (kereta_id) REFERENCES schedules(id)
);

CREATE TABLE pemesan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pemesanan_id INT NOT NULL,
    nama_lengkap VARCHAR(100),
    no_hp VARCHAR(20),
    email VARCHAR(100),
    alamat TEXT,
    umur DATE,
    FOREIGN KEY (pemesanan_id) REFERENCES pemesanan(id)
);

CREATE TABLE penumpang (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pemesanan_id INT NOT NULL,
    nama VARCHAR(100),
    umur INT,
    jenis_kelamin CHAR(1),
    FOREIGN KEY (pemesanan_id) REFERENCES pemesanan(id)
);

CREATE TABLE pembayaran (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pemesanan_id INT NOT NULL,
    nama_pengirim VARCHAR(100),
    metode_pembayaran VARCHAR(50),
    no_rekening_pengirim VARCHAR(50),
    bukti_transfer VARCHAR(255),
    status VARCHAR(50) DEFAULT 'Menunggu Verifikasi',
    FOREIGN KEY (pemesanan_id) REFERENCES pemesanan(id)
);

-- Data contoh jadwal kereta
INSERT INTO schedules (nama_kereta, asal, tujuan, jam_berangkat, jam_tiba, tanggal_berangkat, harga) VALUES
('Argo Bromo Anggrek', 'Jakarta', 'Surabaya', '08:00:00', '16:00:00', '2026-06-01', 350000),
('Gajayana', 'Jakarta', 'Malang', '17:00:00', '06:00:00', '2026-06-01', 420000),
('Taksaka', 'Jakarta', 'Yogyakarta', '09:00:00', '15:30:00', '2026-06-01', 280000),
('Lodaya', 'Bandung', 'Solo', '07:00:00', '13:00:00', '2026-06-01', 200000),
('Harina', 'Bandung', 'Surabaya', '20:00:00', '09:00:00', '2026-06-01', 310000),
('Argo Wilis', 'Bandung', 'Surabaya', '07:30:00', '16:45:00', '2026-06-01', 370000);
```

### Langkah 5 — Cek Konfigurasi Koneksi

Buka file `koneksi.php` dan pastikan isinya:

```php
<?php
$koneksi = new mysqli("localhost", "root", "", "keretain");
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}
?>
```

> Jika password MySQL kamu bukan kosong, isi bagian `""` dengan password kamu.

### Langkah 6 — Buka Aplikasi

Akses di browser:
```
http://localhost/train_in/
```

🎉 Aplikasi siap digunakan!
---

## 🗺️ Alur Penggunaan Aplikasi

```
Halaman Utama (index.php)
        ↓
Pilih Kereta & Jumlah Penumpang
        ↓
Form Data Penumpang (pesan.php)
        ↓
Proses Simpan (proses_pesan.php)
        ↓
Form Pembayaran (payment.php)
        ↓
Upload Bukti Transfer (simpan_pembayaran.php)
        ↓
Invoice & Download Tiket (invoice.php)
```

## 📁 Struktur File

| File | Fungsi |
|------|--------|
| `index.php` | Halaman utama, tampilkan jadwal kereta |
| `pesan.php` | Form data penumpang & pemesan |
| `proses_pesan.php` | Proses & simpan data pemesanan ke DB |
| `payment.php` | Form pembayaran & info rekening |
| `simpan_pembayaran.php` | Simpan data pembayaran & bukti transfer |
| `invoice.php` | Tampilkan & download invoice tiket |
| `koneksi.php` | Konfigurasi koneksi database |
| `style.css` | Styling halaman |
| `uploads/` | Folder penyimpanan bukti transfer |

## 📄 License

MIT License — bebas digunakan untuk keperluan belajar.
