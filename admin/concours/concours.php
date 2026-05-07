
    <div class="view-header">
        <div>
            <h1>Gestion des Concours</h1>
            <p>Pilotez vos compétitions et suivez les votes en temps réel</p>
        </div>
        <button class="btn-primary" onclick="openModalConcours()"><i class="fa-solid fa-plus"></i> Nouveau Concours</button>
    </div>

 <div class="kpi-grid">
        <div class="kpi-card gradient-orange">
            <div class="kpi-header">
                <span class="label white">Total Concours</span>
                <div class="kpi-icon-bg"><i class="fa-solid fa-trophy"></i></div>
            </div>
            <div class="kpi-body">
                <h2 class="white"><?php echo $nbrConcours; ?></h2>
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

         <div class="kpi-card gradient-green">
            <div class="kpi-header">
                <span class="label white">Moyenne votes par concours</span>
                <div class="kpi-icon-bg"><i class="fa-solid fa-bolt"></i></div>
            </div>
            <div class="kpi-body">
                <h2 class="white">08</h2>
                <p class="sub-label white-opacity">participations</p>
            </div>
        </div>

        <div class="kpi-card white-card border-glow">
            <div class="kpi-header">
                <span class="label">Concours le plus voté</span>
                <div class="kpi-icon-bg gray"><i class="fa-regular fa-clock"></i></div>
            </div>
            <div class="kpi-body">
                <h2>conours 1</h2>
                <p class="sub-label">cameroun</p>
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
                        <th class="text-center">Votes</th>
                        <th>Revenus (Net)</th>
                        <th>Fin</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($concours as $con): ?>
                    <tr>
                        <td>
                            <div class="contest-cell">
                                <div class="img-placeholder"><i class="fa-solid fa-trophy"></i></div>
                                <span class="contest-name"><?= htmlspecialchars($con['titre']); ?></span>
                            </div>
                        </td>
                        <!-- Statut dynamique -->
                        <td>
                            <span class="status-badge <?= $con['status_concours']; ?>">
                                <?= ucfirst($con['status_concours']); ?>
                            </span>
                        </td>
                        <!-- Score total des votes -->
                        <td class="text-center fw-600">
                            <?= number_format($con['votes_count'] ?? 0); ?>
                        </td>
                        <!-- Revenus calculés -->
                        <td class="fw-600 color-purple">
                            <?= number_format($con['revenus_generes'] ?? 0, 0, ',', ' '); ?> <small>FCFA</small>
                        </td>
                        <!-- Date de fin simplifiée -->
                        <td><?= date('d/m/y', strtotime($con['date_fin'])); ?></td>
                        <td class="actions">
                            <a href="concours/concours_detail.php?id_concours=<?= $con['id_concours']; ?>" class="action-btn view">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                            <a href="concours/concours_edit.php?id_concours=<?= $con['id_concours']; ?>" class="action-btn edit">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                            <a class="action-btn delete"><i class="fa-solid fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    </div>


    <div class="modal" id="addConcoursModal">
    <div class="modal-content">

        <div class="modal-header">
            <h2>Nouveau concours</h2>
            <p>Créer une nouvelle compétition</p>
        </div>

        <form class="modal-body" action="concours/addConcours.php" enctype="multipart/form-data" method="POST">

            <input type="text" name="titre" placeholder="Titre du concours" required>

            <textarea name="description_concours" placeholder="Description"></textarea>

            <div class="form-row">
                <select name="type_vote" required placeholder="Type de vote">
                  
                    <option value="gratuit">Gratuit</option>
                    <option value="payant">Payant</option>
                </select>

                <input type="number" name="prix_vote" placeholder="Prix du vote (FCFA)">
            </div>

            <div class="form-row">
                <label for="date_debut"> Date de début</label>
                <input type="datetime-local" name="date_debut"  required>
                <label for="date_fin"> Date de fin</label>
                <input type="datetime-local" name="date_fin" required>
            </div>

            <input type="file"accept = ".jpg, .jpeg, .png" name="photo_concours">

            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeModalConcours()">Annuler</button>
                <button type="submit" class="btn-submit" name="submit_concours">Créer</button>
            </div>

        </form>
    </div>
</div>

<script>
    
    function openModalConcours() {
        document.getElementById('addConcoursModal').style.display = 'flex';
    }
    function closeModalConcours() {
        document.getElementById('addConcoursModal').style.display = 'none';
    }

    window.onclick = function(event) {
        const modal = document.getElementById('addConcoursModal');
        if (event.target === modal) {
            closeModalConcours();
        }
    }
</script>