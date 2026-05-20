<?php
session_start();
include 'includes/link.php';
include 'includes/navbar.php';
include 'config/database.php';

if (!isset($_GET['id_concours']) || empty($_GET['id_concours'])) {
    echo "<div class='container'><div class='empty-state'><h2>Concours introuvable</h2></div></div>";
    include 'includes/footer.php';
    exit;
}

$idConcours = (int) $_GET['id_concours'];

/*  RÉCUPÉRATION CANDIDATS */
$sqlCandidats = "
    SELECT can.*, co.titre
    FROM candidats can
    JOIN concours co ON can.id_concours = co.id_concours
    WHERE can.id_concours = :id_concours
";
$stmt = $pdo->prepare($sqlCandidats);
$stmt->execute(['id_concours' => $idConcours]);
$candidats = $stmt->fetchAll();

$titreConcours = $candidats[0]['titre'] ?? "Concours";

/*  RÉCUPÉRATION RANGS */
$sqlRanks = "
    SELECT id_candidat, COUNT(*) AS nb_votes, 
           RANK() OVER (ORDER BY COUNT(*) DESC) AS rang
    FROM votes
    WHERE id_concours = ?
    GROUP BY id_candidat
";
$stmt = $pdo->prepare($sqlRanks);
$stmt->execute([$idConcours]);
$ranks = $stmt->fetchAll();

$rangsAssoc = [];
foreach ($ranks as $r) {
    $rangsAssoc[$r['id_candidat']] = $r['rang'];
}
?>


<link rel="stylesheet" href="assets/css/color.css">
<link rel="stylesheet" href="assets/css/concours_detail.css">

<main class="container">

    <div class="header-zone">
        <h1 class="main-title">
            Candidats du concours : 
            <span><?php echo htmlspecialchars($titreConcours); ?></span>
        </h1>
    </div>

    <?php if (empty($candidats)) : ?>

        <div class="empty-state">
            <h2>Aucun candidat pour le moment</h2>
            <p>Les inscriptions sont en cours. Revenez bientôt découvrir les participants.</p>
            <a href="concours" class="btn-return">Voir les autres concours</a>
        </div>

    <?php else : ?>

        <!-- BARRE DE RECHERCHE HYBRIDE -->
        <div class="select-container" id="customDropdown">
            <div class="select-trigger-wrapper">
                <span class="search-icon-left"></span>
                <input type="text" 
                       id="dropdownSearchInput" 
                       class="select-trigger" 
                       placeholder="Saisissez un nom ou cliquez pour choisir..." 
                       autocomplete="off">
                <button type="button" id="clearSearchBtn" class="clear-btn" style="display: none;">&times;</button>
            </div>
            
            <div class="select-options-menu" id="optionsMenu">
                <div class="option-item all-option" data-value="all">Tout afficher (Tous les candidats)</div>
                <hr class="dropdown-divider">
                <?php foreach ($candidats as $can) { ?>
                    <div class="option-item" data-value="candidate-<?= $can['id_candidat']; ?>">
                        <?= htmlspecialchars($can['nom_candidat']); ?>
                    </div>
                <?php } ?>
                <div class="no-result-item" style="display: none;">Aucun candidat trouvé</div>
            </div>
        </div>

        <!-- ZONE D'AFFICHAGE -->
        <div class="display-zone">
            
            <div id="defaultPlaceholder" class="empty-placeholder">
                Sélectionnez un candidat ou choisissez "Tout afficher" pour lancer l'affichage.
            </div>

            <div class="competitions-grid" id="competitionsGrid">
                <?php foreach ($candidats as $can) { ?>
                    
                    <div id="candidate-<?= $can['id_candidat']; ?>" class="candidate-card">
                        <div class="card-image-container">
                            <img src="<?php echo htmlspecialchars($can['photo_candidat'] ?: 'assets/images/default.jpg'); ?>" 
                                 alt="<?php echo htmlspecialchars($can['nom_candidat']); ?>" 
                                 class="card-img">
                        </div>

                        <div class="candidate-info">
                            <h3><?php echo htmlspecialchars($can['nom_candidat']); ?></h3>
                            <div class="rank-badge">Rang : <strong>#<?php echo $rangsAssoc[$can['id_candidat']] ?? '-'; ?></strong></div>
                            <div class="card-actions">
                                <a href="profil_candidats.php?id_candidat=<?php echo $can['id_candidat']; ?>" class="btn-action-solid">
                                    Voir profil & Voter
                                </a>
                            </div>
                        </div>
                    </div>

                <?php } ?>
            </div>
            
        </div>

    <?php endif; ?>

</main>

<script src="assets/js/concours_detail.js"></script>
<?php include 'includes/footer.php'; ?>
