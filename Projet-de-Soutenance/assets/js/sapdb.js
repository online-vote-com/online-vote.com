document.addEventListener('DOMContentLoaded', () => {
    const linkDashboard = document.getElementById('link-dashboard');
    const linkCandidats = document.getElementById('link-candidats');
    
    const contentDashboard = document.getElementById('content-dashboard');
    const contentCandidats = document.getElementById('content-candidats');

    // Fonction pour changer de page
    function showPage(pageName) {
        // 1. Masquer tous les contenus
        contentDashboard.style.display = 'none';
        contentCandidats.style.display = 'none';

        // 2. Retirer la classe 'active' de tous les liens
        document.querySelectorAll('.nav-item').forEach(nav => nav.classList.remove('active'));

        // 3. Afficher la page demandée et activer le lien
        if (pageName === 'dashboard') {
            contentDashboard.style.display = 'block';
            linkDashboard.classList.add('active');
        } else if (pageName === 'candidats') {
            contentCandidats.style.display = 'block';
            linkCandidats.classList.add('active');
        }
    }

    // Écouteurs de clics
    linkDashboard.addEventListener('click', () => showPage('dashboard'));
    linkCandidats.addEventListener('click', () => showPage('candidats'));
});