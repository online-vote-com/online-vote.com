<div id="section-concours" class="content-section" style="display: none; ">
    <header class="top-header">
        <h1>Gestion des Concours</h1>
    </header>

    <div class="table-controls">
        <button class="btn-new" id="openModalBtnConcours"><i class="fa-solid fa-file-circle-plus"></i> Nouveau
</button>
        <div class="filter-group">
            <span class="filter-label">Filtre</span>
            <div class="select-wrapper">
                <select class="filter-select">
                    <option>Tous les concours</option>
                    <option>Ouverts</option>
                    <option>Fermés</option>
                    <option>En attente</option>
                </select>
            </div>
        </div>
    </div>

    <div class="table-wrapper">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Titre</th>
                    <th>Description</th>
                    <th>Photo</th>
                    <th>Type de vote</th>
                    <th>Prix du vote</th>
                    <th>Status</th>
                    <th>Date début</th>
                     <th>Date fin</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <?php foreach ($concours as $con){ ?>
            <tbody>
                <tr>
                    <td><?= $con['titre'] ?></td>
                    <td><?= $con['description_concours'] ?></td>
                    <td>
                        <div class="img-placeholder mini-circle">
                            <img src="../assets/images/concours/art2026.jpg" alt="Concours Art 2026">
                        </div>
                    </td>
                    <td><?= $con['type_vote'] ?></td>
                    <td><?= $con['prix_vote'] ?></td>
                    <td class=""><?= $con['status_concours'] ?></td>
                    <td><?= $con['date_debut'] ?></td>
                    <td><?= $con['date_fin'] ?></td>
                    <td class="actions">
                        <span class="badge black"> <i class="fa-solid fa-chart-line"></i> </span>
                        <span class="badge yellow"><i class="fa-solid fa-trash"></i> </span>
                        <span class="badge purple"> <i class="fa-solid fa-pen-to-square"></i> </span>
                    </td>
                </tr>
            </tbody>
            <?php }?>
        </table>

        <div class="table-footer">
            <button class="btn-outline">Voir plus +</button>
            <div class="pagination"> < 1 10 > </div>
        </div>
    </div>
</div>


<?php 
    include 'ajout_concours.php'; 
?>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const modal = document.getElementById("modalConcours");
    const btn = document.getElementById("openModalBtnConcours");

    if (!modal || !btn) {
        console.error("Modal ou bouton introuvable");
        return;
    }

    btn.addEventListener("click", () => {
        modal.style.display = "block";
    });

    window.addEventListener("click", (e) => {
        if (e.target === modal) {
            modal.style.display = "none";
        }
    });
});
</script>

