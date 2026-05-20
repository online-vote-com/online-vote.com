
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
