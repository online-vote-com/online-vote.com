<!-- Sécurisation de l'inclusion de la feuille de style avec l'URL absolue -->
<link rel="stylesheet" href="<?= BASE_URL ?>assets/css/navbar.css">

<header class="navbar">
    <div class="navbar-container">

        <!-- BRAND LOGO (ICÔNE + TEXTE ALIGNÉS) -->
        <a href="<?= BASE_URL ?>index.php" class="logo">
            <div class="logo-wrapper">
                <!-- Sécurisation de l'image du logo -->
                <img src="<?= BASE_URL ?>assets/images/logo.png" alt="Online Vote" class="logo-img"> 
                <span class="logo-brand-name">Online Vote</span>
            </div>
        </a>

        <!-- LINKS MENU -->
        <nav class="nav-menu">
            <a href="<?= BASE_URL ?>index.php" class="nav-link">Accueil</a>
            <a href="<?= BASE_URL ?>concours.php" class="nav-link">Concours</a>
            <a href="#" class="nav-link">À propos</a>
            <a href="#" class="nav-link">Contact</a>
        </nav>

        <!-- AUTH ACTIONS -->
        <div class="nav-actions">
            <?php if(isset($_SESSION['id_user'])): ?>
                <a href="<?= BASE_URL ?>profil_user.php" class="btn-nav-primary">Mon Profil</a>
            <?php else: ?>
                <a href="<?= BASE_URL ?>login.php" class="btn-nav-primary">Commencer</a>
            <?php endif; ?>
        </div>

        <!-- MOBILE BURGER TOGGLE -->
        <button class="mobile-toggle" aria-label="Menu principal">
            <i class="fas fa-bars"></i>
        </button>

    </div>

    <!-- PANNEAU MOBILE UNIQUE (TIROIR COMPACT UNIFIÉ) -->
    <div class="mobile-menu">
        <div class="mobile-menu-content">
            <a href="<?= BASE_URL ?>index.php" class="mobile-link">Accueil</a>
            <a href="<?= BASE_URL ?>concours.php" class="mobile-link">Concours</a>
            <a href="#" class="mobile-link">À propos</a>
            <a href="#" class="mobile-link">Contact</a>
            
            <div class="mobile-divider"></div>
            
            <?php if(isset($_SESSION['id_user'])): ?>
                <a href="<?= BASE_URL ?>profil_user.php" class="mobile-btn primary">Mon Profil</a>
            <?php else: ?>
                <a href="<?= BASE_URL ?>login.php" class="mobile-btn secondary">Connexion</a>
            <?php endif; ?>
        </div>
    </div>

</header>

<!-- Sécurisation de l'importation du script de gestion de la barre de navigation -->
<script src="<?= BASE_URL ?>assets/js/navbar.js"></script>
