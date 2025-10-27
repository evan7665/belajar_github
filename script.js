document.addEventListener("DOMContentLoaded", function() {

    const bukaButton = document.querySelector('.cta-button[href="#intro"]');
    const audio = document.getElementById('background-music');
    const playPauseButton = document.getElementById('play-pause-button');
    
    bukaButton.addEventListener('click', function(e) {
        e.preventDefault();
        
        document.querySelector('#intro').scrollIntoView({
            behavior: 'smooth'
        });
        
        if (audio.paused) {
            audio.play();
        }
        playPauseButton.style.display = 'block'; 
    });

    playPauseButton.addEventListener('click', function() {
        if (audio.paused) {
            audio.play();
            playPauseButton.innerHTML = '❚❚'; 
        } else {
            audio.pause();
            playPauseButton.innerHTML = '►'; 
        }
    });

    window.copyToClipboard = function(text) {
        navigator.clipboard.writeText(text).then(function() {
            alert('Nomor rekening telah disalin!');
        }, function(err) {
            alert('Gagal menyalin nomor rekening.');
        });
    }
});
