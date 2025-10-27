<?php

// --- DATA ACARA (Silakan ganti dengan data Anda) ---
$data_undangan = [
    'nama_pria' => "Adam Putra",
    'nama_wanita' => "Bunga Citra",
    'ortu_pria' => "Bpk. Hendra Wijaya & Ibu. Sari Dewi",
    'ortu_wanita' => "Bpk. Rahmat Hidayat & Ibu. Fatimah",
    
    'akad' => [
        'nama' => "Akad Nikah",
        'tanggal' => "Sabtu, 14 November 2026",
        'waktu' => "09:00 - 10:00 WIB",
        'tempat' => "Masjid Istiqlal, Jakarta",
        'alamat' => "Jl. Taman Wijaya Kusuma, Ps. Baru, Sawah Besar",
        'maps_url' => "https://maps.app.goo.gl/abcdef123456"
    ],
    
    'resepsi' => [
        'nama' => "Resepsi Pernikahan",
        'tanggal' => "Sabtu, 14 November 2026",
        'waktu' => "11:00 - 13:00 WIB",
        'tempat' => "Gedung A, Hotel Borobudur",
        'alamat' => "Jl. Lapangan Banteng Selatan, Ps. Baru",
        'maps_url' => "https://maps.app.goo.gl/ghijk789012"
    ],
    
    'quote' => "Dan di antara tanda-tanda (kebesaran)-Nya ialah Dia menciptakan pasangan-pasangan untukmu dari jenismu sendiri, agar kamu cenderung dan merasa tenteram kepadanya, dan Dia menjadikan di antaramu rasa kasih dan sayang. (QS. Ar-Rum: 21)",
];

// --- FUNGSI BUKU TAMU (Guestbook) ---

$file_ucapan = 'ucapan.json';
$ucapan_list = [];

// 1. Membaca data ucapan yang sudah ada
if (file_exists($file_ucapan)) {
    $ucapan_json = file_get_contents($file_ucapan);
    $ucapan_list = json_decode($ucapan_json, true);
}

// 2. Memproses jika ada ucapan baru yang dikirim (via POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_ucapan'])) {
    $nama_tamu = htmlspecialchars($_POST['nama_tamu']);
    $isi_ucapan = htmlspecialchars($_POST['isi_ucapan']);
    
    if (!empty($nama_tamu) && !empty($isi_ucapan)) {
        $ucapan_baru = [
            'nama' => $nama_tamu,
            'ucapan' => $isi_ucapan,
            'waktu' => date('d M Y, H:i')
        ];
        
        // Tambahkan ucapan baru ke awal array
        array_unshift($ucapan_list, $ucapan_baru);
        
        // Simpan kembali ke file JSON
        file_put_contents($file_ucapan, json_encode($ucapan_list, JSON_PRETTY_PRINT));
        
        // Refresh halaman untuk menghindari re-submit form
        header("Location: " . $_SERVER['PHP_SELF'] . "?to=" . urlencode($_GET['to'] ?? 'Tamu Undangan') . "#guestbook");
        exit;
    }
}

// 3. Mengambil nama tamu dari URL (Query Parameter ?to=...)
// Menggunakan htmlspecialchars untuk keamanan (mencegah XSS)
$nama_tamu_undangan = isset($_GET['to']) ? htmlspecialchars($_GET['to']) : 'Tamu Undangan';

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Wedding of <?php echo $data_undangan['nama_pria']; ?> & <?php echo $data_undangan['nama_wanita']; ?></title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Montserrat:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body>

    <header class="hero">
        <div class="hero-content">
            <h4>Kepada Yth.</h4>
            <h1><?php echo $nama_tamu_undangan; ?></h1>
            <p>Kami mengundang Anda untuk hadir di pernikahan kami.</p>
            
            <h2><?php echo $data_undangan['nama_pria']; ?> & <?php echo $data_undangan['nama_wanita']; ?></h2>
            <p class="tanggal-hero"><?php echo $data_undangan['resepsi']['tanggal']; ?></p>
            
            <a href="#intro" class="cta-button">Buka Undangan</a>
        </div>
    </header>

    <section id="intro" class="section">
        <h2>Om Swastiastu,</h2>
        <p class="quote">"<?php echo $data_undangan['quote']; ?>"</p>
        <p>Maha suci Tuhan, yang telah menciptakan makhluk-Nya berpasang-pasangan. Kami bermaksud menyelenggarakan pernikahan putra-putri kami:</p>
        
        <div class="mempelai">
            <div class="mempelai-card">
                <h3><?php echo $data_undangan['nama_pria']; ?></h3>
                <p>Putra dari:</p>
                <p><?php echo $data_undangan['ortu_pria']; ?></p>
            </div>
            
            <span class="mempelai-ampersand">&</span>
            
            <div class="mempelai-card">
                <h3><?php echo $data_undangan['nama_wanita']; ?></h3>
                <p>Putri dari:</p>
                <p><?php echo $data_undangan['ortu_wanita']; ?></p>
            </div>
        </div>
    </section>

    <section id="acara" class="section dark-bg">
        <h2>Detail Acara</h2>
        <div class="acara-container">
            <div class="acara-card">
                <h3><?php echo $data_undangan['akad']['nama']; ?></h3>
                <p><?php echo $data_undangan['akad']['tanggal']; ?></p>
                <p><?php echo $data_undangan['akad']['waktu']; ?></p>
                <hr>
                <p><strong><?php echo $data_undangan['akad']['tempat']; ?></strong></p>
                <p><?php echo $data_undangan['akad']['alamat']; ?></p>
                <a href="<?php echo $data_undangan['akad']['maps_url']; ?>" target="_blank" class="cta-button-outline">Lihat Peta</a>
            </div>
            
            <div class="acara-card">
                <h3><?php echo $data_undangan['resepsi']['nama']; ?></h3>
                <p><?php echo $data_undangan['resepsi']['tanggal']; ?></p>
                <p><?php echo $data_undangan['resepsi']['waktu']; ?></p>
                <hr>
                <p><strong><?php echo $data_undangan['resepsi']['tempat']; ?></strong></p>
                <p><?php echo $data_undangan['resepsi']['alamat']; ?></p>
                <a href="<?php echo $data_undangan['resepsi']['maps_url']; ?>" target="_blank" class="cta-button-outline">Lihat Peta</a>
            </div>
        </div>
    </section>

    <section id="gallery" class="section">
        <h2>Galeri Kenangan</h2>
        <div class="gallery-grid">
            <img src="images/gallery1.jpg" alt="Gallery 1">
            <img src="images/hero.jpg" alt="Gallery 2">
            <img src="images/gallery2.jpg" alt="Gallery 3">
        </div>
    </section>
    
    <section id="amplop" class="section dark-bg">
        <h2>Amplop Digital</h2>
        <p>Bagi Anda yang ingin memberikan tanda kasih, dapat melalui:</p>
        <div class="amplop-card">
            <strong>Bank BCA</strong>
            <p>1234567890</p>
            <p>a.n. Adam Putra</p>
            <button class="cta-button-outline" onclick="copyToClipboard('1234567890')">Salin Rekening</button>
        </div>
    </section>

    <section id="guestbook" class="section">
        <h2>Buku Tamu & Ucapan</h2>
        
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>?to=<?php echo urlencode($nama_tamu_undangan); ?>#guestbook" method="POST" class="guestbook-form">
            <div class="form-group">
                <label for="nama_tamu">Nama Anda:</label>
                <input type="text" id="nama_tamu" name="nama_tamu" required>
            </div>
            <div class="form-group">
                <label for="isi_ucapan">Ucapan Anda:</label>
                <textarea id="isi_ucapan" name="isi_ucapan" rows="4" required></textarea>
            </div>
            <button type="submit" name="submit_ucapan" class="cta-button">Kirim Ucapan</button>
        </form>
        
        <div class="guestbook-list">
            <?php if (empty($ucapan_list)): ?>
                <p>Jadilah yang pertama memberikan ucapan!</p>
            <?php else: ?>
                <?php foreach ($ucapan_list as $ucapan): ?>
                    <div class="ucapan-item">
                        <strong><?php echo htmlspecialchars($ucapan['nama']); ?></strong>
                        <small><?php echo htmlspecialchars($ucapan['waktu']); ?></small>
                        <p><?php echo htmlspecialchars($ucapan['ucapan']); ?></p>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </section>
    
    <audio id="background-music" src="music/theme.mp3" loop></audio>
    <button id="play-pause-button">Play/Pause</button>

    <script src="script.js"></script>
</body>
</html>
