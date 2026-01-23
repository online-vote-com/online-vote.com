<?php include '../includes/link.php'; ?>
<link rel="stylesheet" href="../assets/css/grid-card.css">
<style>
    
</style>
 <div class="dashboard-container">
    <aside class="sidebar">
        <div class="brand">
            <span class="logo-text"><i class="fas fa-vote-yea"></i> ONLINE <small>vote</small></span>
        </div>
        
        <div class="profile-box">
            <div class="img-placeholder circle">
                <img src="../assets/images/organisateur/art.jpg" alt="Arthur Chakoualeu">
            </div>
            <h3>Arthur CHAKOUALEU</h3>
            <a href="#" class="profil-link">Voir mon profil <i class="fas fa-chevron-right"></i></a>
        </div>

        <nav class="sidebar-nav">
            <a href="#" class="nav-item active" data-section="section-dashboard">
                <i class="fas fa-chart-pie"></i> Dashboard
            </a>
            <a href="#" class="nav-item" data-section="section-candidats">
                <i class="fas fa-users"></i> Candidats
            </a>
            <a href="#" class="nav-item" data-section="section-concours">
                <i class="fas fa-trophy"></i> Concours
            </a>
        </nav>

        <button class="logout-btn">
            <i class="fas fa-sign-out-alt"></i>
             <!--<i class="fas fa-sign-out-alt"></i> Déconnexion-->
        </button>
    </aside>

    <main class="main-content">
        
        <div id="section-dashboard" class="content-section">
    <header class="top-header">
        <div class="header-text">
            <h1>Tableau de Bord</h1>
            <p class="date-now">Content de vous revoir !</p>
        </div>
        <a href="../public/index.php" class="btn-home-circle" title="Retour à l'accueil">
            <i class="fas fa-home"></i>
        </a>
    </header>

    <section class="welcome-banner">
        <div class="welcome-content">
            <h2>Salut, <span>Arthur Chakoualeu !</span> </h2>
            <p>Prêt à gérer vos votes aujourd'hui ? Voici un résumé de votre activité.</p>
        </div>
    </section>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon-bg purple-light"><i class="fas fa-flag"></i></div>
            <div class="stat-info">
                <strong>20</strong>
                <p>Concours</p>
            </div>
        </div>
        <div class="stat-card purple-solid">
            <div class="stat-icon-bg white-alpha"><i class="fas fa-user-friends"></i></div>
            <div class="stat-info">
                <strong>300</strong>
                <p>Candidats</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon-bg yellow-light"><i class="fas fa-wallet"></i></div>
            <div class="stat-info">
                <strong>20,000</strong>
                <p>FCFA récoltés</p>
            </div>
        </div>
        <div class="stat-card purple-solid">
            <div class="stat-icon-bg white-alpha"><i class="fas fa-chart-line"></i></div>
            <div class="stat-info">
                <strong>Boost</strong>
                <p>D'impact</p>
            </div>
        </div>
    </div>

    <div class="section-header">
        <h3 class="section-title">Concours récents</h3>
        <button class="btn-text-only">Tout voir <i class="fas fa-arrow-right"></i></button>
    </div>

    <div class="contests-row">
        <div class="contest-card">
            <div class="contest-banner gradient-bg">
                <span class="status-badge">Actif</span>
            </div>
            <div class="contest-details">
                <h4>Concours de Miss et Masters</h4>
                <button class="btn-more-minimal">Gérer le concours</button>
            </div>
        </div>

        <div class="contest-card">
            <div class="contest-banner">
                <img src="../assets/images/organisateur/art.jpg" alt="Concours Banner">
                <span class="status-badge">En attente</span>
            </div>
            <div class="contest-details">
                <h4>Élection Bureau Étudiant</h4>
                <button class="btn-more-minimal">Gérer le concours</button>
            </div>
        </div>
    </div>
</div>
          <?php

                include 'candidat/liste_candidats.php';

                include 'concours/liste_concours.php';

                 include 'concours/stats_concours.php';

           ?>
    </main>
</div>
    <script>
      // Sélectionne tous les éléments ayant la classe 'nav-item' (les liens de la sidebar)
document.querySelectorAll('.nav-item').forEach(link => {

    // Pour chaque lien, on ajoute un écouteur d'événement au clic
    link.addEventListener('click', () => {

        // Récupère l'ID de la section à afficher depuis l'attribut data-section du lien
        const sectionId = link.dataset.section;

        // Masque toutes les sections ayant la classe 'content-section'
        document.querySelectorAll('.content-section').forEach(sec => sec.style.display = 'none');

        // Affiche uniquement la section correspondant au lien cliqué
        document.getElementById(sectionId).style.display = 'block';

        // Supprime la classe 'active' de tous les liens pour désactiver l'état actif
        document.querySelectorAll('.nav-item').forEach(item => item.classList.remove('active'));

        // Ajoute la classe 'active' au lien cliqué pour indiquer qu'il est sélectionné
        link.classList.add('active');
    });

});


    </script>
</body>
</html>