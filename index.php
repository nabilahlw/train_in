<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>KeretaIN – Pesan Tiket Kereta</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<!-- ====== HEADER + HERO WRAPPER (dengan background stasiun.jpg) ====== -->
<section class="header-hero">

    <!-- ====== NAVBAR ====== -->
    <header class="navbar">
        <div class="logo">
            <img src="img/logo.png" alt="Logo KeretaIN" class="logo-img">
            Train<span>IN</span>
        </div>
        <nav>
            <a href="#">Home</a>
            <a href="#">Promo</a>
            <a href="#">Bantuan</a>
            <a href="#" class="login">Login</a>
        </nav>
    </header>

    <!-- ====== HERO SECTION (Form Pencarian) ====== -->
    <section class="hero">
        <img src="img/hero-train.jpg" class="hero-bg" alt="Hero Train Image" />
        <div class="hero-overlay">
            <h1 class="tagline">
    Hai, Mau Ke Mana Hari Ini?<br>
    <small>Yuk pesan tiket kereta dengan mudah di TrainIN</small><br>
    <small>Pilih jadwal dan tujuanmu sekarang juga</small><br>
    <small>Dan nikmati perjalanan yang nyaman dan aman bersama kami</small>
</h1>

            <!-- FORM CARI JADWAL -->
            <form id="searchForm" class="search-card" method="POST" action="jadwal.php">
                <div class="field-group">
                    <label>Asal</label>
                    <select name="asal" required>
                        <option value="">Pilih Kota</option>
                        <option>JAKARTA</option>
                        <option>BANDUNG</option>
                        <option>SURABAYA</option>
                        <option>YOGYAKARTA</option>
                        <option>SEMARANG</option>
                    </select>
                </div>

                <div class="field-group">
                    <label>Tujuan</label>
                    <select name="tujuan" required>
                        <option value="">Pilih Kota</option>
                        <option>JAKARTA</option>
                        <option>BANDUNG</option>
                        <option>SURABAYA</option>
                        <option>YOGYAKARTA</option>
                        <option>SEMARANG</option>
                    </select>
                </div>

                <div class="field-group">
                    <label>Berangkat</label>
                    <input type="date" name="tanggal" required>
                </div>

                <div class="field-group">
                    <label>Penumpang</label>
                    <select name="penumpang" required>
                        <?php for ($i = 1; $i <= 10; $i++) echo "<option>$i</option>"; ?>
                    </select>
                </div>

                <button type="submit" class="primary-btn">Cari</button>
            </form>
        </div>
    </section>

</section>

<!-- ====== HASIL JADWAL ====== -->
<section id="resultSection" class="result-section hidden">
    <h2>Jadwal Tersedia</h2>
    <div id="cardContainer" class="card-grid">
        <!-- 6 kartu akan di‑inject lewat JS -->
    </div>
</section>

<!-- ====== SCRIPT JS ====== -->
<script src="js/main.js"></script>
</body>
</html>
