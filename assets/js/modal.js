document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById("modalCandidat");
    // On cible votre bouton "Nouveau"
    const btnNew = document.querySelector(".btn-new");

    // 1. Ouvrir la modale au clic sur "Nouveau"
    if (btnNew) {
        btnNew.onclick = function() {
            modal.style.display = "block";
        }
    }

    // 2. Fermer la modale si on clique à l'extérieur de la boîte
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
});