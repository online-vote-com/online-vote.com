document.addEventListener("DOMContentLoaded", () => {
    const mobileToggle = document.querySelector(".mobile-toggle");
    const mobileMenu = document.querySelector(".mobile-menu");
    const body = document.body;
    
    // Protection si l'icône FontAwesome n'est pas encore instanciée
    const toggleIcon = mobileToggle ? mobileToggle.querySelector("i") : null;

    if (mobileToggle && mobileMenu && toggleIcon) {
        
        // Centralisation de la logique de fermeture
        const closeMenu = () => {
            mobileToggle.classList.remove("active");
            mobileMenu.classList.remove("active");
            body.classList.remove("no-scroll");
            toggleIcon.className = "fas fa-bars"; // Reset de l'icône burger
        };

        // Centralisation de la logique d'ouverture
        const openMenu = () => {
            mobileToggle.classList.add("active");
            mobileMenu.classList.add("active");
            body.classList.add("no-scroll");
            toggleIcon.className = "fas fa-xmark"; // Passage à la croix
        };

        // Événement clic sur le bouton d'ouverture/fermeture
        mobileToggle.addEventListener("click", (e) => {
            e.stopPropagation(); // Évite la fermeture immédiate via l'écouteur du document
            if (mobileMenu.classList.contains("active")) {
                closeMenu();
            } else {
                openMenu();
            }
        });

        // Fermeture automatique au clic sur un lien ou bouton mobile
        const mobileElements = mobileMenu.querySelectorAll(".mobile-link, .mobile-btn");
        mobileElements.forEach(element => {
            element.addEventListener("click", () => {
                closeMenu();
            });
        });

        // Fermeture si l'utilisateur clique sur l'arrière-plan flouté (hors contenu)
        document.addEventListener("click", (e) => {
            if (mobileMenu.classList.contains("active")) {
                // Si le clic n'est ni dans le contenu du menu, ni sur le bouton toggle
                if (!mobileMenu.querySelector(".mobile-menu-content").contains(e.target) && !mobileToggle.contains(e.target)) {
                    closeMenu();
                }
            }
        });
    }
});
