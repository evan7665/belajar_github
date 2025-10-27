<?php


$data_undangan = [
    'nama_pria' => "Evan Santoso",
    'nama_wanita' => "Tania Mahani Handojo",
    'ortu_pria' => "Mr. Budi Santoso & Mrs. Mila Ardiana",
    'ortu_wanita' => "Mr. Andreas Handojo & Mrs. Eva Mayasari",
    
    'akad' => [
        'nama' => "Holy Matrimony",
        'tanggal' => "Saturday, 14th November 2026",
        'waktu' => "09:00 - 10:00 WIB",
        'tempat' => "Gepembri Pekalongan Church",
        'alamat' => "Jl. Toba No.40, Keputran, Kec. Pekalongan Tim., Kota Pekalongan, Jawa Tengah 51128",
        'maps_url' => "https://maps.app.goo.gl/iyf73si7bPtMnKDX9"
    ],
    
    'resepsi' => [
        'nama' => "Wedding Reception",
        'tanggal' => "Saturday, 14th November 2026",
        'waktu' => "11:00 - 13:00 WIB",
        'tempat' => "Cinlong",
        'alamat' => "Komplek Dupan Square, Jl. Dr. Setiabudi, Baros, Kec. Pekalongan Tim., Kota Pekalongan, Jawa Tengah 51123",
        'maps_url' => "https://maps.app.goo.gl/G1fnMc2aFUee1zSo9"
    ],
    
    'quote' => "So they are no longer two, but one flesh. Therefore what God has joined together, let no one separate. (Matthew 19:6)",
];



$file_ucapan = 'ucapan.json';
$ucapan_list = [];

if (file_exists($file_ucapan)) {
    $ucapan_json = file_get_contents($file_ucapan);
    $ucapan_list = json_decode($ucapan_json, true);
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_ucapan'])) {
    $nama_tamu = htmlspecialchars($_POST['nama_tamu']);
    $isi_ucapan = htmlspecialchars($_POST['isi_ucapan']);
    
    if (!empty($nama_tamu) && !empty($isi_ucapan)) {
        $ucapan_baru = [
            'nama' => $nama_tamu,
            'ucapan' => $isi_ucapan,
            'waktu' => date('d M Y, H:i')
        ];
        
        array_unshift($ucapan_list, $ucapan_baru);
        
        file_put_contents($file_ucapan, json_encode($ucapan_list, JSON_PRETTY_PRINT));
        
        header("Location: " . $_SERVER['PHP_SELF'] . "?to=" . urlencode($_GET['to'] ?? 'Tamu Undangan') . "#guestbook");
        exit;
    }
}


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
        <h2>Shalom,</h2>
        <p class="quote">"<?php echo $data_undangan['quote']; ?>"</p>
        <p>By the grace of God, we joyfully invite you to witness and celebrate the union of our lives in the holy matrimony of:</p>
        
        <div class="mempelai">
            <div class="mempelai-card">
                <h3><?php echo $data_undangan['nama_pria']; ?></h3>
                <p>Son of</p>
                <p><?php echo $data_undangan['ortu_pria']; ?></p>
            </div>
            
            <span class="mempelai-ampersand">&</span>
            
            <div class="mempelai-card">
                <h3><?php echo $data_undangan['nama_wanita']; ?></h3>
                <p>Daughter of</p>
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
        <h2>Moments Full of Love</h2>
        <div class="gallery-grid">
            <img src="images/gallery1.jpg" alt="Gallery 1">
            <img src="images/gallery3.jpg" alt="Gallery 2">
            <img src="images/gallery2.jpg" alt="Gallery 3">
        </div>
    </section>
    
    <section id="amplop" class="section dark-bg">
        <h2>Token of Love</h2>
        <p>Your prayers and presence mean the world to us. If you wish to bless us with a gift, we would receive it with heartfelt gratitude</p>
        <div class="amplop-card">
            <strong>Bank BCA</strong>
            <p>1234567890</p>
            <p>a.n. Adam Putra</p>
            <button class="cta-button-outline" onclick="copyToClipboard('1234567890')">Salin Rekening</button>
        </div>
    </section>

    <section id="guestbook" class="section">
        <h2>Guestbook & Prayers</h2>
        
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>?to=<?php echo urlencode($nama_tamu_undangan); ?>#guestbook" method="POST" class="guestbook-form">
            <div class="form-group">
                <label for="nama_tamu">Your name:</label>
                <input type="text" id="nama_tamu" name="nama_tamu" required>
            </div>
            <div class="form-group">
                <label for="isi_ucapan">Your prayers:</label>
                <textarea id="isi_ucapan" name="isi_ucapan" rows="4" required></textarea>
            </div>
            <button type="submit" name="submit_ucapan" class="cta-button">Send</button>
        </form>

        <div class="guestbook-slider">
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
        </div>
    </section>
    
    <audio id="background-music" src="music/theme.mp3" loop></audio>
    <button id="play-pause-button">Play/Pause</button>

    <script src="script.js"></script>
</body>
</html>
