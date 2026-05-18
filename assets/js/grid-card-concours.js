document.addEventListener('DOMContentLoaded', () => {
    const dropdownContainer = document.getElementById('customDropdown');
    const searchInput = document.getElementById('dropdownSearchInput');
    const clearBtn = document.getElementById('clearSearchBtn');
    const optionItems = document.querySelectorAll('.option-item');
    const noResultItem = document.querySelector('.no-result-item');
    const placeholder = document.getElementById('defaultPlaceholder');

    let currentActiveCard = null;

    // Ouvrir le panneau de recherche dynamique
    searchInput.addEventListener('focus', () => dropdownContainer.classList.add('is-open'));
    searchInput.addEventListener('click', () => dropdownContainer.classList.add('is-open'));

    // Fermer le conteneur si clic à l'extérieur
    document.addEventListener('click', (e) => {
        if (!dropdownContainer.contains(e.target)) {
            dropdownContainer.classList.remove('is-open');
        }
    });

    // Écoute de la saisie clavier pour le filtre en temps réel
    searchInput.addEventListener('input', function() {
        const value = this.value;
        dropdownContainer.classList.add('is-open');
        
        // Afficher/Masquer le bouton X d'effacement
        clearBtn.style.display = value.length > 0 ? 'block' : 'none';
        
        filterDropdownOptions(value);
    });

    // Fonction de filtrage algorithmique des résultats du menu
    function filterDropdownOptions(query) {
        const cleanQuery = query.toLowerCase().trim();
        let matchCount = 0;

        optionItems.forEach(item => {
            const text = item.textContent.toLowerCase();
            if (text.includes(cleanQuery)) {
                item.style.display = 'block';
                matchCount++;
            } else {
                item.style.display = 'none';
            }
        });

        noResultItem.style.display = matchCount === 0 ? 'block' : 'none';
    }

    // Sélection de l'élément au clic
    optionItems.forEach(option => {
        option.addEventListener('click', function(e) {
            e.stopPropagation();
            
            const targetId = this.getAttribute('data-value');
            const selectionText = this.textContent.trim();

            searchInput.value = selectionText;
            clearBtn.style.display = 'block';
            dropdownContainer.classList.remove('is-open');
            
            // Masquer le message par défaut
            if (placeholder) placeholder.style.display = 'none';

            // Cacher la carte précédemment affichée avec animation
            document.querySelectorAll('.contest-card').forEach(card => {
                card.classList.remove('active');
                setTimeout(() => { card.style.display = 'none'; }, 150);
            });

            // Afficher la nouvelle carte correspondante
            const targetCard = document.getElementById(targetId);
            if (targetCard) {
                setTimeout(() => {
                    targetCard.style.display = 'block';
                    setTimeout(() => targetCard.classList.add('active'), 50);
                }, 160);
            }
        });
    });

    // Action du bouton Effacer (Croix)
    clearBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        searchInput.value = "";
        clearBtn.style.display = 'none';
        filterDropdownOptions("");
        searchInput.focus();
    });
});
