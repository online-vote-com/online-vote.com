<link rel="stylesheet" href="assets/css/concours_detail.css">

<?php
include 'includes/link.php';
include 'includes/navbar.php';
include 'config/database.php';

if (!isset($_GET['id_concours']) || empty($_GET['id_concours'])) {
    die("Concours introuvable");
}

$idConcours = (int) $_GET['id_concours'];

// Récupération des candidats avc le titre du concours
$sqlCandidats = "
    SELECT can.*, co.titre
    FROM candidats can
    JOIN concours co ON can.id_concours = co.id_concours
    WHERE can.id_concours = :id_concours
";
  /* $sqlCandidats = "
    SELECT can.*, co.titre
    FROM candidats can, concours co
    WHERE can.id_concours = :id_concours
    ";
    */
$stmt = $pdo->prepare($sqlCandidats);
$stmt->execute(['id_concours' => $idConcours]);
$candidats = $stmt->fetchAll();

if (empty($candidats)) {
    die("Aucun candidat trouvé pour ce concours.");
}

$titreConcours = $candidats[0]['titre'];


$sqlRanks = "
    SELECT id_candidat, COUNT(*) AS nb_votes, 
           RANK() OVER (ORDER BY COUNT(*) DESC) AS rang
    FROM vote
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

<main class="container">
    <h1 class="main-title">Candidats du concours : <?php echo htmlspecialchars($titreConcours); ?></h1>

    <div class="search-container">
        <div class="filter-group-alt">
            <span>Filtre</span>
            <select class="filter-select-alt">
                <option>Rang</option>
            </select>
        </div>
        <input type="text" placeholder="Recherche ..." class="search-input">
        <button class="btn-search">Rechercher</button>
    </div>

    <div class="competitions-grid">
        <?php foreach ($candidats as $can) { ?>
            <div class="candidate-card">
                <div class="card-image-container">
                    <img src="<?php echo htmlspecialchars($can['image'] ?: 'assets/images/organisateur/art.jpg'); ?>" 
                         alt="<?php echo htmlspecialchars($can['nom_candidat']); ?>" 
                         class="card-img">
                </div>

                <div class="candidate-info">
                    <h3><?php echo htmlspecialchars($can['nom_candidat']); ?></h3>
                    <div class="rank-badge">Numéro : <strong><?php echo $rangsAssoc[$can['id_candidat']] ?? '-'; ?></strong></div>

                    <div class="card-actions">
                        <a href="#" class="btn-action-outline">Voir Plus +</a>
                        <a href="profil_candidats.php?id_candidat=<?php echo $can['id_candidat']; ?>" 
                           class="btn-action-solid openModalBtnProfilCandidat">Voter</a>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</main>

<?php include 'includes/footer.php'; ?>
