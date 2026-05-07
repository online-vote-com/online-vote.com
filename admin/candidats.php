
    <div class="view-header">
        <div>
            <h1>Gestion des candidats</h1>
            <p>Pilotez vos compétitions et suivez les votes en temps réel</p>
        </div>
        <button class="btn-primary" onclick="openModal()"><i class="fa-solid fa-plus"></i> Nouveau Candidat</button>
    </div>

    <div class="kpi-grid">
        <div class="kpi-card gradient-orange">
            <div class="kpi-header">
                <span class="label white">Total Candidats</span>
                <div class="kpi-icon-bg"><i class="fa-solid fa-user"></i></div>
            </div>
            <div class="kpi-body">
                <h2 class="white">24</h2>
                <p class="sub-label white-opacity">Toutes catégories confondues</p>
            </div>
        </div>

        <div class="kpi-card gradient-green">
            <div class="kpi-header">
                <span class="label white">Moyenne candidats par concours</span>
                <div class="kpi-icon-bg"><i class="fa-solid fa-bolt"></i></div>
            </div>
            <div class="kpi-body">
                <h2 class="white">08</h2>
                <p class="sub-label white-opacity">candidats</p>
            </div>
        </div>


        <div class="kpi-card white-card">
            <div class="kpi-header">
                <span class="label">Top candidat (votes)</span>
                <div class="kpi-icon-bg green-soft"><i class="fa-solid fa-check"></i></div>
            </div>
            <div class="kpi-body">
                <h2>Peter</h2>
                <p class="sub-label">Peter</p>
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
                        <th>Candidat</th>
                        <th>Concours</th>
                        <th>Rank</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($candidats as $c){ ?>
                    <tr>
                        <td>
                            <div class="contest-cell">
                                <div class="img-placeholder"><i class="fa-solid fa-crown"></i></div>
                                <span class="contest-name"><?= htmlspecialchars($c['nom_candidat']) ?> <?= htmlspecialchars($c['prenom_candidat']) ?></span>
                            </div>
                        </td>
                        <td><span class="status-badge active"><?= htmlspecialchars($c['titre']) ?></span></td>
                        <td class="fw-600"> </td>
                        <td class="actions">
                            <button class="action-btn view"><i class="fa-solid fa-eye"></i></button>
                            <button class="action-btn edit"><i class="fa-solid fa-pen"></i></button>
                            <button class="action-btn delete"><i class="fa-solid fa-trash"></i></button>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>


<!-- ===================== MODAL ===================== -->
<div class="modal" id="addCandidatModal">

    <div class="modal-content">

        <!-- HEADER -->
        <div class="modal-header">
            <h2>Ajouter un candidat</h2>
            <p>Créer un nouveau profil pour un concours</p>
        </div>

        <!-- BODY -->
        <form class="modal-body" method="POST" enctype="multipart/form-data">

            <!-- NOM + PRENOM -->
            <div class="form-row">
                <input type="text" name="nom_candidat" placeholder="Nom du candidat" required>
                <input type="text" name="prenom_candidat" placeholder="Prénom du candidat" required>
            </div>

            <!-- EMAIL -->
            <input type="email" name="email_candidat" placeholder="Email (optionnel)">

            <!-- CONCOURS -->
            <select name="id_concours" required>
                <option value="">Sélectionner un concours</option>
                <!-- PHP LOOP -->
                <!--
                <?php foreach($concours as $c): ?>
                    <option value="<?= $c['id_concours'] ?>">
                        <?= $c['titre'] ?>
                    </option>
                <?php endforeach; ?>
                -->
            </select>

            <!-- BIO -->
            <textarea name="biography" placeholder="Biographie du candidat"></textarea>

            <!-- PHOTO -->
            <label class="file-input">
                <input type="file" accept = ".jpg, .jpeg, .png" name="photo_candidat" hidden>
                📷 Ajouter une photo du candidat
            </label>

            <!-- FOOTER -->
            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeModal()">Annuler</button>
                <button type="submit" class="btn-submit">Enregistrer</button>
            </div>

        </form>

    </div>
</div>



<script>

    function openModal() {
        document.getElementById('addCandidatModal').style.display = 'flex';
    }
    function closeModal() {
        document.getElementById('addCandidatModal').style.display = 'none';
    }

    window.onclick = function(event) {
        const modal = document.getElementById('addCandidatModal');
        if (event.target === modal) {
            closeModal();
        }
    }

</script>

