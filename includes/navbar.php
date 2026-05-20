<style>
    @import url('https://googleapis.com');

/* ==========================================================================
   1. SYSTEM VARIABLES INTEGRATION
   ========================================================================== */
:root {
    --main-purple: #9C04DA;
    --dark-purple-gradient: #530274;
    --text-dark: #111111;
    --text-muted: #6E6E73;
    --white: #FFFFFF;
    --bg-light-gray: #F5F5F7;
    --gray-border: rgba(0, 0, 0, 0.04);
}

/* ==========================================================================
   2. STRUCTURE GLOBALE ET FLOU DE VERRE (BARRE SUPÉRIEURE)
   ========================================================================== */
.navbar {
    width: 100%;
    height: 80px;
    position: sticky;
    top: 0;
    z-index: 1000;
    background: rgba(255, 255, 255, 0.75);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    border-bottom: 1px solid var(--gray-border);
    display: flex;
    align-items: center;
}

.navbar-container {
    width: 100%;
    max-width: 1200px;
    height: 100%;
    margin: 0 auto;
    padding: 0 24px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 24px;
}

body.no-scroll {
    overflow: hidden; /* Bloque le défilement de la page arrière sur mobile */
}

/* ==========================================================================
   3. BRAND LOGO
   ========================================================================== */
.logo {
    display: flex;
    align-items: center;
    text-decoration: none;
    height: 100%;
    z-index: 1100; /* Priorité d'affichage au-dessus du panneau mobile */
}

.logo-wrapper {
    display: flex;
    align-items: center;
    gap: 10px;
    max-height: 40px;
    transition: transform 0.25s cubic-bezier(0.16, 1, 0.3, 1);
}

.logo-img {
    height: 38px;
    width: auto;
    object-fit: contain;
    display: block;
}

.logo-brand-name {
    font-size: 1.15rem;
    font-weight: 800;
    color: var(--text-dark);
    letter-spacing: -0.02em;
}

.logo:hover .logo-wrapper {
    transform: scale(1.02);
}

/* ==========================================================================
   4. LIENS DE NAVIGATION (AFFICHAGE PC)
   ========================================================================== */
.nav-menu {
    display: flex;
    align-items: center;
    gap: 36px;
}

.nav-link {
    text-decoration: none;
    color: var(--text-muted);
    font-size: 0.92rem;
    font-weight: 600;
    position: relative;
    padding: 6px 0;
    transition: color 0.25s ease;
}

.nav-link:hover {
    color: var(--text-dark);
}

.nav-link::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 2px;
    background-color: var(--main-purple);
    transform: scaleX(0);
    transform-origin: right;
    transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1);
}

.nav-link:hover::after {
    transform: scaleX(1);
    transform-origin: left;
}

/* ==========================================================================
   5. BOUTONS D'ACTIONS (AFFICHAGE PC)
   ========================================================================== */
.nav-actions {
    display: flex;
    align-items: center;
    gap: 12px;
}

.btn-nav-primary,
.btn-nav-secondary {
    height: 44px;
    padding: 0 20px;
    border-radius: 12px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    font-size: 0.88rem;
    font-weight: 700;
    transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
}

.btn-nav-primary {
    background: var(--text-dark);
    color: var(--white);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.04);
}

.btn-nav-primary:hover {
    background: var(--main-purple);
    box-shadow: 0 10px 24px rgba(156, 4, 218, 0.2);
    transform: translateY(-1px);
}

.btn-nav-primary:active,
.btn-nav-secondary:active {
    transform: scale(0.97);
}

.btn-nav-secondary {
    background: var(--bg-light-gray);
    color: var(--text-dark);
}

.btn-nav-secondary:hover {
    background: #E8E8ED;
}

/* ==========================================================================
   6. ACTIONNEUR MOBIL BURGER
   ========================================================================== */
.mobile-toggle {
    width: 44px;
    height: 44px;
    border: none;
    background: var(--bg-light-gray);
    border-radius: 12px;
    display: none; /* Masqué sur PC d'origine */
    cursor: pointer;
    color: var(--text-dark);
    font-size: 1.1rem;
    transition: all 0.2s ease;
    z-index: 1100; /* Fixé au-dessus du panneau de navigation mobile */
}

.mobile-toggle:hover {
    background: #E8E8ED;
}

/* ==========================================================================
   7. LE PANNEAU TIROIR MOBILE ET COMPACT (L'INNOVATION SMARTPHONE)
   ========================================================================== */
.mobile-menu {
    position: fixed;
    inset: 0;
    width: 100%;
    height: 100vh;
    background: rgba(255, 255, 255, 0.97);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    z-index: 1050;
    
    /* États de masquage stables */
    opacity: 0;
    visibility: hidden;
    pointer-events: none;
    transition: opacity 0.3s cubic-bezier(0.16, 1, 0.3, 1), visibility 0.3s ease;
}

/* Déclenchement JS global de visibilité */
.mobile-menu.active {
    opacity: 1;
    visibility: visible;
    pointer-events: auto;
}

.mobile-menu-content {
    width: 100%;
    height: 100%;
    padding: 100px 24px 30px 24px; /* Zone tampon pour dégager le logo d'en-tête */
    display: flex;
    flex-direction: column;
    gap: 12px; 
    overflow-y: auto; /* Autorise le défilement fluide interne si l'écran est petit */
}

/* Les boîtes blanches minimalistes du menu */
.mobile-link {
    min-height: 56px;
    height: 56px;
    padding: 0 20px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    background: var(--white);
    text-decoration: none;
    color: var(--text-dark);
    font-size: 1rem;
    font-weight: 700;
    border: 1px solid rgba(0, 0, 0, 0.04);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.01);
    transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
}

.mobile-link:hover {
    background: var(--bg-light-gray);
    color: var(--main-purple);
    transform: translateX(4px);
}

/* Ligne séparatrice neutre */
.mobile-divider {
    width: 100%;
    height: 1px;
    background: rgba(0, 0, 0, 0.05);
    margin: 6px 0;
}

/* Boutons de profil et connexion adaptés */
.mobile-btn {
    width: 100%;
    height: 54px;
    border-radius: 16px;
    font-size: 0.95rem;
    font-weight: 700;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    transition: all 0.2s ease;
}

.mobile-btn.primary {
    background: var(--text-dark);
    color: var(--white);
}

.mobile-btn.primary:hover {
    background: var(--main-purple);
}

.mobile-btn.secondary {
    background: var(--bg-light-gray);
    color: var(--text-dark);
}

.mobile-btn.secondary:hover {
    background: #E8E8ED;
}

/* ==========================================================================
   8. MEDIA QUERIES RESPONSIVE (NETTOYAGE ET INTERPOLATIONS)
   ========================================================================== */
@media(min-width: 901px) {
    .mobile-menu {
        display: none !important;
    }
}

@media(max-width: 900px) {
    /* Cache les éléments PC pour éviter le parasitage structurel */
    .nav-menu,
    .nav-actions {
        display: none !important;
    }

    /* Déploiement propre de l'actionneur burger */
    .mobile-toggle {
        display: flex;
        align-items: center;
        justify-content: center;
    }
}

</style>
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
