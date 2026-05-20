<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
 <?php include 'includes/link.php'; ?>
    <?php include 'includes/header.php'; ?>
    <link rel="stylesheet" href="assets/css/footer.css">
<link rel="stylesheet" href="assets/css/navbar.css">
</head>

<body>

   <link rel="stylesheet" href="assets/css/navbar.css">
<header class="navbar">
    <div class="navbar-container">

        <!-- BRAND LOGO (ICÔNE + TEXTE ALIGNÉS) -->
        <a href="index.php" class="logo">
            <div class="logo-wrapper">
                <img src="assets/images/logo.png" alt="Online Vote" class="logo-img"> 
                
                <span class="logo-brand-name">Online Vote</span>
            </div>
        </a>

        <!-- LINKS MENU -->
        <nav class="nav-menu">
            <a href="index.php" class="nav-link">Accueil</a>
            <a href="concours.php" class="nav-link">Concours</a>
            <a href="#" class="nav-link">À propos</a>
            <a href="#" class="nav-link">Contact</a>
        </nav>

        <!-- AUTH ACTIONS -->
        <div class="nav-actions">
            <?php if(isset($_SESSION['id_user'])): ?>
                <a href="profil_user" class="btn-nav-primary">Mon Profil</a>
            <?php else: ?>
                <!--<a href="login.php" class="btn-nav-secondary">Connexion</a>-->
                <a href="login" class="btn-nav-primary">Commencer</a>
            <?php endif; ?>
        </div>

        <!-- MOBILE BURGER TOGGLE -->
        <button class="mobile-toggle" aria-label="Menu principal">
            <i class="fas fa-bars"></i>
        </button>

    </div>
    <!-- Panneau Mobile Unique -->
<div class="mobile-menu">
    <div class="mobile-menu-content">
        <a href="index.php" class="mobile-link">Accueil</a>
        <a href="concours.php" class="mobile-link">Concours</a>
        <a href="#" class="mobile-link">À propos</a>
        <a href="#" class="mobile-link">Contact</a>
        
        <div class="mobile-divider"></div>
        
        <?php if(isset($_SESSION['id_user'])): ?>
            <a href="profil_user.php" class="mobile-btn primary">Mon Profil</a>
        <?php else: ?>
            <a href="login" class="mobile-btn secondary">Connexion</a>
           <!-- <a href="signup.php" class="mobile-btn primary">Commencer</a>-->
        <?php endif; ?>
    </div>
</div>

</header>
<script src="assets/js/navbar.js"></script>


    <?php include 'includes/hero.php'; ?>

    

    

<footer class="footer">

    <!-- MAIN FOOTER ZONE -->
    <div class="footer-main">
        <div class="footer-grid">

            <!-- BRAND COLUMN (Harmonisé avec la Navbar) -->
            <div class="footer-brand">
                <a href="index.php" class="footer-logo">
                    <div class="footer-logo-wrapper">
                        <img src="assets/images/logo.png" alt="Online Vote" class="footer-logo-img">
                        <span class="footer-brand-name">Online Vote</span>
                    </div>
                </a>
                <p class="footer-description">
                    Simplifiez l’organisation de vos votes, élections et concours grâce à une plateforme pensée pour la transparence, la sécurité et l’engagement.
                </p>
            </div>

            <!-- COLUMN 1 : NAVIGATION -->
            <div class="footer-column">
                <h4>Navigation</h4>
                <a href="index.php" class="footer-link">Accueil</a>
                <a href="concours.php" class="footer-link">Concours</a>
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

            <!-- COLUMN 3 : NEWSLETTER (Correction des balises coupées) -->
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


</body>
</html>