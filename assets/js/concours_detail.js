document.addEventListener('DOMContentLoaded', () => {
    const dropdownContainer = document.getElementById('customDropdown');
    const searchInput = document.getElementById('dropdownSearchInput');
    const clearBtn = document.getElementById('clearSearchBtn');
    const optionItems = document.querySelectorAll('.option-item');
    const noResultItem = document.querySelector('.no-result-item');
    const placeholder = document.getElementById('defaultPlaceholder');
    const grid = document.getElementById('competitionsGrid');
    const candidateCards = document.querySelectorAll('.candidate-card');

    searchInput.addEventListener('focus', () => dropdownContainer.classList.add('is-open'));
    searchInput.addEventListener('click', () => dropdownContainer.classList.add('is-open'));

    document.addEventListener('click', (e) => {
        if (!dropdownContainer.contains(e.target)) {
            dropdownContainer.classList.remove('is-open');
        }
    });

    searchInput.addEventListener('input', function() {
        const value = this.value;
        dropdownContainer.classList.add('is-open');
        clearBtn.style.display = value.length > 0 ? 'block' : 'none';
        filterDropdownOptions(value);
    });

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

    optionItems.forEach(option => {
        option.addEventListener('click', function(e) {
            e.stopPropagation();
            
            const targetValue = this.getAttribute('data-value');
            searchInput.value = this.textContent.trim();
            clearBtn.style.display = 'block';
            dropdownContainer.classList.remove('is-open');
            
            if (placeholder) placeholder.style.display = 'none';

            // Nettoyage initial des classes d'affichage
            grid.classList.remove('multi-mode');
            candidateCards.forEach(card => {
                card.classList.remove('active');
                card.style.display = 'none';
            });

            // LOGIQUE DE SÉLECTION
            if (targetValue === "all") {
                // Passage en mode Grille multi-colonnes responsive
                grid.classList.add('multi-mode');
                setTimeout(() => {
                    candidateCards.forEach(card => {
                        card.style.display = 'flex';
                        setTimeout(() => card.classList.add('active'), 50);
                    });
                }, 100);
            } else {
                // Mode focus centré sur un seul candidat agrandi
                const targetCard = document.getElementById(targetValue);
                if (targetCard) {
                    setTimeout(() => {
                        targetCard.style.display = 'flex';
                        setTimeout(() => targetCard.classList.add('active'), 50);
                    }, 100);
                }
            }
        });
    });

    clearBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        searchInput.value = "";
        clearBtn.style.display = 'none';
        filterDropdownOptions("");
        searchInput.focus();
    });
});
