
    <div class="view-header">
        <div>
            <h1>Gestion des Votants</h1>
            <p>Pilotez vos compétitions et suivez les votes en temps réel</p>
        </div>
        <button class="btn-primary" onclick="openModalVotants()"><i class="fa-solid fa-plus"></i> Nouveau Votant</button>
    </div>
    
    <div class="kpi-grid">
        <div class="kpi-card gradient-orange">
            <div class="kpi-header">
                <span class="label white">Total Votants</span>
                <div class="kpi-icon-bg"><i class="fa-solid fa-users"></i></div>
            </div>
            <div class="kpi-body">
                <h2 class="white">24</h2>
                <p class="sub-label white-opacity">Toutes catégories confondues</p>
            </div>
        </div>

        <div class="kpi-card gradient-green">
            <div class="kpi-header">
                <span class="label white">En cours</span>
                <div class="kpi-icon-bg"><i class="fa-solid fa-bolt"></i></div>
            </div>
            <div class="kpi-body">
                <h2 class="white">08</h2>
                <p class="sub-label white-opacity">Votes ouverts actuellement</p>
            </div>
        </div>

        <div class="kpi-card white-card border-glow">
            <div class="kpi-header">
                <span class="label">En attente</span>
                <div class="kpi-icon-bg gray"><i class="fa-regular fa-clock"></i></div>
            </div>
            <div class="kpi-body">
                <h2>03</h2>
                <p class="sub-label">Planifiés pour bientôt</p>
            </div>
        </div>

        <div class="kpi-card white-card">
            <div class="kpi-header">
                <span class="label">Terminés</span>
                <div class="kpi-icon-bg green-soft"><i class="fa-solid fa-check"></i></div>
            </div>
            <div class="kpi-body">
                <h2>13</h2>
                <p class="sub-label">Résultats archivés</p>
            </div>
        </div>
    </div>

    <div class="table-container">
        <div class="table-header">
            <h3>Liste détaillée des concours</h3>
            <div class="table-actions">
                <button class="btn-ghost">Filtrer</button>
                <button class="btn-ghost">Exporter</button>
            </div>
        </div>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Concours</th>
                        <th>Statut</th>
                        <th>Participants</th>
                        <th>Fin du vote</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <div class="contest-cell">
                                <div class="img-placeholder"><i class="fa-solid fa-crown"></i></div>
                                <span class="contest-name">Miss Cameroun 2026</span>
                            </div>
                        </td>
                        <td><span class="status-badge active">En cours</span></td>
                        <td class="fw-600">12,450 votes</td>
                        <td>15 Mai 2026</td>
                        <td class="actions">
                            <button class="action-btn view"><i class="fa-solid fa-eye"></i></button>
                            <button class="action-btn edit"><i class="fa-solid fa-pen"></i></button>
                            <button class="action-btn delete"><i class="fa-solid fa-trash"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal" id="openModalVotants">
    <div class="modal-content">

        <div class="modal-header">
            <h2>Nouvel organisateur</h2>
            <p>Créer un compte organisateur</p>
        </div>

        <form class="modal-body" method="POST">

            <div class="form-row">
                <input type="text" name="nom_user" placeholder="Nom" required>
                <input type="text" name="prenom_user" placeholder="Prénom">
            </div>

            <input type="email" name="email" placeholder="Email" required>

            <input type="tel" name="numTel" placeholder="Téléphone">

            <input type="password" name="pwd" placeholder="Mot de passe" required>

             <label class="file-input">
                <input type="file" accept = ".jpg, .jpeg, .png" name="photo_candidat" hidden>
                📷 Ajouter une photo
            </label>

            <select name="role_user">
                <option value="organisateur">Organisateur</option>
                <option value="admin">Admin</option>
                <option value="admin">Votant</option>
            </select>

            <select name="status_user">
                <option value="actif">Actif</option>
                <option value="suspendu">Suspendu</option>
            </select>

            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeModalVotants()">Annuler</button>
                <button type="submit" class="btn-submit">Créer</button>
            </div>

        </form>
    </div>
</div>

<script>
    
    function openModalVotants() {
        document.getElementById('openModalVotants').style.display = 'flex';
    }
    function closeModalVotants() {
        document.getElementById('openModalVotants').style.display = 'none';
    }

    window.onclick = function(event) {
        const modal = document.getElementById('openModalVotants');
        if (event.target === modal) {
            closeModalVotants();
        }
    }
</script>