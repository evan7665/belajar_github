document.addEventListener("DOMContentLoaded", function() {

    // --- 1. Tombol Buka Undangan (Scroll & Mainkan Musik) ---
    const bukaButton = document.querySelector('.cta-button[href="#intro"]');
    const audio = document.getElementById('background-music');
    const playPauseButton = document.getElementById('play-pause-button');
    
    bukaButton.addEventListener('click', function(e) {
        e.preventDefault();
        
        // Scroll ke bagian intro
        document.querySelector('#intro').scrollIntoView({
            behavior: 'smooth'
        });
        
        // Mainkan musik
        if (audio.paused) {
            audio.play();
        }
        playPauseButton.style.display = 'block'; // Tampilkan tombol play/pause
    });

    // --- 2. Tombol Play/Pause Musik ---
    playPauseButton.addEventListener('click', function() {
        if (audio.paused) {
            audio.play();
            playPauseButton.innerHTML = '❚❚'; // Pause icon
        } else {
            audio.pause();
            playPauseButton.innerHTML = '►'; // Play icon
        }
    });

    // --- 3. Fungsi Copy to Clipboard (Untuk Amplop) ---
    // Kita buat fungsinya global agar bisa diakses dari HTML
    window.copyToClipboard = function(text) {
        navigator.clipboard.writeText(text).then(function() {
            alert('Nomor rekening telah disalin!');
        }, function(err) {
            alert('Gagal menyalin nomor rekening.');
        });
    }
});
