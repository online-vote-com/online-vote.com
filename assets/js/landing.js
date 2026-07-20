        // Lancement des icônes Lucide
        lucide.createIcons();

        // Gestion ergonomique du lecteur vidéo interactif
        const overlay = document.getElementById('video-play-overlay');
        const video = document.getElementById('main-demo-video');

        overlay.addEventListener('click', () => {
            overlay.style.opacity = '0';
            overlay.style.pointerEvents = 'none';
            video.play();
        });

        // Feedback au clic du formulaire
        document.getElementById('landing-contact').addEventListener('submit', (e) => {
            e.preventDefault();
            alert('Votre message a été bien pris en compte ! Notre équipe vous recontacte sous 24h.');
            e.target.reset();
        });