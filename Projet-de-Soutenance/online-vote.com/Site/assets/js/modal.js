// On attend que le DOM soit chargé
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById("modalCandidat");
    // On cible tous les boutons avec la classe .btn-add
    const btnsAdd = document.querySelectorAll(".btn-add");

    // Ouvrir la modale au clic sur n'importe quel bouton "Ajouter"
    btnsAdd.forEach(btn => {
        btn.onclick = function() {
            modal.style.display = "block";
        }
    });

    // Fermer la modale si on clique à l'extérieur de la boîte blanche
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
});