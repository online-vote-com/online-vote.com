<?php include '../includes/link.php'; ?>

    <div class="dashboard-container">
        <aside class="sidebar">
            <div class="brand">
                <span class="logo-text">ONLINE <small>vote</small></span>
            </div>
            
            <div class="profile-box">
              <div class="img-placeholder circle">
                <img src="../assets/images/organisateur/art.jpg" alt="Arthur Chakoualeu">
              </div>
                 <h3>Arthur CHAKOUALEU</h3>
                <a href="#" class="profil-link">Voir mon profil ></a>
            </div>

            <nav class="sidebar-nav">
                <a href="#" class="nav-item" data-section="section-dashboard">Dashboard</a>
                <a href="#" class="nav-item" data-section="section-candidats">Candidats</a>
                <a href="#" class="nav-item" data-section="section-concours">Concours</a>
            </nav>

            <button class="logout-btn">Déconnexion X</button>
        </aside>

        <main class="main-content">
            
            <div id="section-dashboard" class="content-section">
                <header class="top-header">
                    <h1>Mon Tableau de Bord</h1>
                    <button class="btn-home">Retour à l'accueil</button>
                </header>

                <section class="welcome-text">
                    <h2>Salut, <strong>Arthur chakoualeu !</strong></h2>
                    <p>Bienvenue sur Online-vote, votre plateforme de vote</p>
                </section>

                <div class="stats-grid">
                    <div class="stat-card"><strong>20</strong><p>Concours</p></div>
                    <div class="stat-card purple"><strong>300</strong><p>Candidats</p></div>
                    <div class="stat-card"><strong>20, 000</strong><p>Fcfa</p></div>
                    <div class="stat-card purple"><strong>300</strong><p>Candidats</p></div>
                </div>

                <h3 class="section-title">Concours récents ....</h3>
                <div class="contests-row">
                    <div class="contest-card-banner">
                        <div class="img-placeholder banner"></div> <div class="card-footer">
                            <span>Concours de Miss et Masters</span>
                            <button class="btn-more">Voir plus +</button>
                        </div>
                    </div>
                    <div class="contest-card-banner">
                        <div class="banner">  <img src="../assets/images/organisateur/art.jpg" alt="Arthur Chakoualeu"></div>
                        <div class="card-footer">
                            <span>Concours de Miss et Masters</span>
                            <button class="btn-more">Voir plus +</button>
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