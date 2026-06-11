
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
                                <div class=""><?= htmlspecialchars($con['titre']); ?></div>
                                <!--<span class="contest-name"><?= htmlspecialchars($con['titre']); ?></span>-->
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

    <button
        class="action-btn edit"
        onclick="editConcours(
            <?= $con['id_concours']; ?>,
            '<?= htmlspecialchars(addslashes($con['titre'])); ?>',
            '<?= htmlspecialchars(addslashes($con['description_concours'])); ?>',
            '<?= $con['type_vote']; ?>',
            '<?= $con['prix_vote']; ?>',
            '<?= date('Y-m-d\TH:i', strtotime($con['date_debut'])); ?>',
            '<?= date('Y-m-d\TH:i', strtotime($con['date_fin'])); ?>'
        )">

        <i class="fa-solid fa-pen"></i>

    </button>

    <button
        class="action-btn delete"
        onclick="deleteConcours(<?= $con['id_concours']; ?>)">

        <i class="fa-solid fa-trash"></i>

    </button>

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
            <h2 id="modalTitle">Nouveau concours</h2>
            <p id="modalSubTitle">Créer une nouvelle compétition</p>
        </div>

       <form
    id="concoursForm"
    class="modal-body"
    action="concours/gestionConcours.php"
    method="POST"
    enctype="multipart/form-data">

    <!-- IMPORTANT -->
    <input type="hidden" name="action" id="formAction" value="add">

    <input type="hidden" name="id_concours" id="id_concours">

    <input
        type="text"
        name="titre"
        id="titre"
        placeholder="Titre du concours"
        required>

    <textarea
        name="description_concours"
        id="description_concours"
        placeholder="Description"></textarea>

    <div class="form-row">

        <select name="type_vote" id="type_vote">
            <option value="gratuit">Gratuit</option>
            <option value="payant">Payant</option>
        </select>

        <input
            type="number"
            name="prix_vote"
            id="prix_vote"
            placeholder="Prix du vote">

    </div>

    <div class="form-row">

        <div>
            <label>Date début</label>
            <input
                type="datetime-local"
                name="date_debut"
                id="date_debut"
                required>
        </div>

        <div>
            <label>Date fin</label>
            <input
                type="datetime-local"
                name="date_fin"
                id="date_fin"
                required>
        </div>

    </div>

    <input
        type="file"
        name="photo_concours"
        accept=".jpg,.jpeg,.png">

    <div class="modal-footer">

        <button
            type="button"
            class="btn-cancel"
            onclick="closeModalConcours()">

            Annuler

        </button>

        <button
            type="submit"
            id="submitBtn"
            class="btn-submit">

            Créer

        </button>

    </div>

</form>

    </div>

</div>
</div>

<script>

function openModalConcours() {

    document.getElementById("modalTitle").innerHTML =
        "Nouveau concours";

    document.getElementById("modalSubTitle").innerHTML =
        "Créer une nouvelle compétition";

    document.getElementById("submitBtn").innerHTML =
        "Créer";

    document.getElementById("formAction").value =
        "add";

    document.getElementById("id_concours").value =
        "";

    document.getElementById("concoursForm").reset();

    document.getElementById("addConcoursModal").style.display =
        "flex";
}

function editConcours(
    id,
    titre,
    description,
    type_vote,
    prix_vote,
    date_debut,
    date_fin
) {

    document.getElementById("modalTitle").innerHTML =
        "Modifier concours";

    document.getElementById("modalSubTitle").innerHTML =
        "Mettre à jour les informations";

    document.getElementById("submitBtn").innerHTML =
        "Mettre à jour";

    document.getElementById("formAction").value =
        "edit";

    document.getElementById("id_concours").value =
        id;

    document.getElementById("titre").value =
        titre;

    document.getElementById("description_concours").value =
        description;

    document.getElementById("type_vote").value =
        type_vote;

    document.getElementById("prix_vote").value =
        prix_vote;

    document.getElementById("date_debut").value =
        date_debut;

    document.getElementById("date_fin").value =
        date_fin;

    document.getElementById("addConcoursModal").style.display =
        "flex";
}

function deleteConcours(id) {

    if (confirm("Supprimer ce concours ?")) {

        window.location.href =
            "concours/gestionConcours.php?action=delete&id=" + id;
    }
}

function closeModalConcours() {

    document.getElementById("addConcoursModal").style.display =
        "none";
}

window.onclick = function(event) {

    const modal =
        document.getElementById("addConcoursModal");

    if (event.target === modal) {
        closeModalConcours();
    }
}
</script>