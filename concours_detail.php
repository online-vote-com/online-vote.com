<?php
include 'includes/link.php';
include 'includes/navbar.php';
include 'config/database.php';

if (!isset($_GET['id_concours']) || empty($_GET['id_concours'])) {
    echo "<div class='empty-state'><h2>Concours introuvable</h2></div>";
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

$titreConcours =  $candidats[1]['titre'] ?? "Concours";

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

<link rel="stylesheet" href="assets/css/concours_detail.css">

<main class="container">

    <h1 class="main-title">
        Candidats du concours : 
        <?php echo htmlspecialchars($titreConcours); ?>
    </h1>

    <?php if (empty($candidats)) : ?>

        <div class="empty-state">
            <div class="empty-icon"></div>
            <h2>Aucun candidat pour le moment</h2>
            <p>
                Les inscriptions sont peut-être encore en cours.<br>
                Revenez bientôt pour découvrir les participants.
            </p>

            <a href="concours" class="btn-return">
                Voir les autres concours
            </a>
        </div>

    <?php else : ?>

        <!--   BARRE DE RECHERCHE -->

        <div class="search-container">
            <input type="text" placeholder="Recherche ..." class="search-input">
            <button class="btn-search">Rechercher</button>
        </div>

        <!--  GRILLE CANDIDATS -->

        <div class="competitions-grid">
            <?php foreach ($candidats as $can) { ?>
                <div class="candidate-card">

                    <div class="card-image-container">
                        <img src="<?php echo htmlspecialchars($can['photo_candidat'] ?: 'assets/images/default.jpg'); ?>" 
                             alt="<?php echo htmlspecialchars($can['nom_candidat']); ?>" 
                             class="card-img">
                    </div>

                    <div class="candidate-info">
                        <h3>
                            <?php echo htmlspecialchars($can['nom_candidat']); ?>
                        </h3>

                        <div class="rank-badge">
                            Rang : 
                            <strong>
                                <?php echo $rangsAssoc[$can['id_candidat']] ?? '-'; ?>
                            </strong>
                        </div>

                        <div class="card-actions">
                            <a href="profil_candidats.php?id_candidat=<?php echo $can['id_candidat']; ?>" 
                               class="btn-action-solid">
                                Voir profil
                            </a>
                        </div>
                    </div>

                </div>
            <?php } ?>
        </div>

    <?php endif; ?>

</main>

<?php include 'includes/footer.php'; ?>