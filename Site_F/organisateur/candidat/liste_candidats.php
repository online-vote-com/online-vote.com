<div id="section-candidats" class="content-section">
    <header class="top-header">
        <h1>Gestion des Candidats</h1>
    </header>

    <div class="table-controls">
        <button class="btn-new" id="openModalBtn">Nouveau</button>
        
        <div class="filter-group">
            <span class="filter-label">Filtre</span>
            <div class="select-wrapper">
                <select class="filter-select">
                    <option>Noms</option>
                </select>
            </div>
            <button class="btn-category">Concours</button>
        </div>
    </div>

    <div class="table-wrapper">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Noms</th>
                    <th>Prenom</th>
                    <th>Email</th>
                    <th>Photos</th>
                    <th>Bios</th>
                    <th>Concours</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Chakoualeu</td>
                    <td>Arthur</td>
                    <td>arthur@gmail.com</td>
                    <td>
                        <div class="img-container-table">
                            <img src="../assets/images/organisateur/art.jpg" alt="Arthur Chakoualeu" class="mini-circle">
                        </div>
                    </td>
                    <td>@gmail.com</td>
                    <td>Miss/Master</td>
                    <td class="actions">
                        <span class="badge yellow">Supprimer</span>
                        <span class="badge purple">Ajouter</span>
                        <span class="badge black">Modifier</span>
                    </td>
                </tr>
            </tbody>
        </table>
        
        <div class="table-footer">
            <button class="btn-outline">Voir plus +</button>
            <div class="pagination"> &lt; 1 10 &gt; </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById("modalCandidat");
    const btn = document.getElementById("openModalBtn");

    // Ouvrir la modale
    btn.onclick = function() {
        modal.style.display = "block";
    }

    // Fermer si clic à l'extérieur
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
});
</script>
<?php 
    include 'ajout_candidat.php'; 
?>
