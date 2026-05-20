<!-- Sécurisation de l'inclusion de la feuille de style du pied de page -->
<link rel="stylesheet" href="<?= BASE_URL ?>assets/css/footer.css">

<footer class="footer">

    <!-- MAIN FOOTER ZONE -->
    <div class="footer-main">
        <div class="footer-grid">

            <!-- BRAND COLUMN (Harmonisé avec la Navbar et sécurisé) -->
            <div class="footer-brand">
                <a href="<?= BASE_URL ?>index.php" class="footer-logo">
                    <div class="footer-logo-wrapper">
                        <!-- Sécurisation absolue de l'image du logo -->
                        <img src="<?= BASE_URL ?>assets/images/logo.png" alt="Online Vote" class="footer-logo-img">
                        <span class="footer-brand-name">Online Vote</span>
                    </div>
                </a>
                <p class="footer-description">
                    Simplifiez l’organisation de vos votes, élections et concours grâce à une plateforme pensée pour la transparence, la sécurité et l’engagement.
                </p>
            </div>

            <!-- COLUMN 1 : NAVIGATION SECURISEE -->
            <div class="footer-column">
                <h4>Navigation</h4>
                <a href="<?= BASE_URL ?>index.php" class="footer-link">Accueil</a>
                <a href="<?= BASE_URL ?>concours.php" class="footer-link">Concours</a>
                <a href="#" class="footer-link">À propos</a>
                <a href="#" class="footer-link">Contact</a>
            </div>

            <!-- COLUMN 2 : CONTACT INFOS -->
            <div class="footer-column">
                <h4>Contact & Support</h4>
                <span class="footer-info-text"><i class="fas fa-map-marker-alt"></i> Yaoundé, Cameroun</span>
                <span class="footer-info-text"><i class="fas fa-phone-alt"></i> +237 650 082 325</span>
                <span class="footer-info-text"><i class="fas fa-envelope"></i> contact@online-vote.com</span>
            </div>

            <!-- COLUMN 3 : NEWSLETTER -->
            <div class="footer-column">
                <h4>Rester informé</h4>
                <p class="footer-news-text">Inscrivez-vous pour suivre l'actualité des scrutins et l'ouverture des prochains concours.</p>
                
                <form action="#" method="POST" class="newsletter-form">
                    <input type="email" name="email_newsletter" placeholder="Votre adresse email" required aria-label="Adresse email">
                    <button type="submit" class="btn-newsletter-submit">S'abonner</button>
                </form>
            </div>

        </div>

        <!-- BOTTOM LEGAL ZONE -->
        <div class="footer-bottom">
            <p class="copyright-text">&copy; <?= date('Y') ?> Online Vote. Tous droits réservés.</p>
            <div class="footer-bottom-links">
                <a href="#">Mentions légales</a>
                <a href="#">Politique de confidentialité</a>
                <a href="#">CGU</a>
            </div>
        </div>
    </div>

</footer>
