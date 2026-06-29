<?php
    session_start();
    include 'includes/link.php';
    include 'includes/navbar.php';
    include 'config/database.php';


    $sql = "SELECT con.*, org.nom_user 
    FROM concours con
    JOIN users org ON con.id_organisateur = org.id_user
    WHERE con.suprime = 0 ";

    $now = date('Y-m-d H:i:s');

    $concours = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

    $idUser = $_SESSION['id_user'] ?? null;
    $role = $_SESSION['role_user'] ?? null;
    if (!isset($_SESSION['role_user'])) {
    $_SESSION['role_user'] = 'votant';
}

   $filtered = [];

foreach ($concours as $c) {


    $c['etat'] = $c['status_concours'];

    /*/  ne pas afficher les concours fermés
    if ($c['etat'] === 'ferme') {
        continue;
    }*/

    if ($role === 'admin') {
        $filtered[] = $c;
        continue;
    }

    if ($role === 'organisateur') {

        if ($c['id_organisateur'] == $idUser) {
            $filtered[] = $c;
        }
        continue;
    }

    if ($role === 'votant') {

        if ($c['type_vote'] === 'payant') {
            $filtered[] = $c;
            continue;
        }

        $stmt = $pdo->prepare("
            SELECT COUNT(*) 
            FROM votant_concours
            WHERE id_votant = ? 
            AND id_concours = ?
        ");

        $stmt->execute([$idUser, $c['id_concours']]);
        $isAllowed = $stmt->fetchColumn();

        if ($isAllowed > 0) {
            $filtered[] = $c;
        }
    }
}
?>

<!-- Liaisons des styles et scripts externes -->
<link rel="stylesheet" href="assets/css/color.css">
<link rel="stylesheet" href="assets/css/grid-card-concours.css">

<main class="chic-wrapper">
    
    <!-- HEADER -->
    <div class="header-zone">
        <h1 class="main-title">Espace <span>Scrutin</span></h1>
        <p class="subtitle">Recherchez instantanément ou sélectionnez un concours ci-dessous</p>
    </div>

    <!-- SÉLECTEUR & BARRE DE RECHERCHE DYNAMIQUE FUSIONNÉS -->
    <div class="select-container" id="customDropdown">
        <div class="select-trigger-wrapper">
            <!-- L'icône loupe minimaliste -->
            <span class="search-icon-left"></span>
            
            <input type="text" 
                   id="dropdownSearchInput" 
                   class="select-trigger" 
                   placeholder="Tapez le nom d'un concours ou cliquez pour choisir..." 
                   autocomplete="off">
                   
            <!-- Bouton de réinitialisation rapide -->
            <button type="button" id="clearSearchBtn" class="clear-btn" aria-label="Effacer la recherche" style="display: none;">&times;</button>
        </div>
        
        <!-- Liste déroulante des propositions -->
        <div class="select-options-menu" id="optionsMenu">
            <?php foreach ($concours as $c) { ?>
                <div class="option-item" data-value="contest-<?= $c['id_concours']; ?>">
                    <?= htmlspecialchars($c['titre']); ?>
                </div>
            <?php } ?>
            <div class="no-result-item" style="display: none;">Aucun concours ne correspond à votre recherche</div>
        </div>
    </div>

    <!-- ZONE D'AFFICHAGE DYNAMIQUE DE LA CARTE -->
    <div class="display-zone">
        <div id="defaultPlaceholder" class="empty-placeholder">
            En attente de votre sélection pour afficher les détails du scrutin.
        </div>

        <?php foreach ($filtered as $c) { ?>
            <div id="contest-<?= $c['id_concours']; ?>" class="contest-card">
                
                <div class="card-hero">
                    <img src="<?= 'uploads/concours/' . htmlspecialchars($c['photo_concours']); ?>" alt="Bannière">
                    <div class="card-overlay"></div>
                </div>
                
<div class="card-content">

    <!-- Badge type vote -->
    <div class="badge-type <?= $c['type_vote'] ?>">
        <?= $c['type_vote'] === 'payant' ? 'Vote Payant' : 'Vote Gratuit' ?>
    </div>

    <!-- Titre -->
    <h3 class="card-title">
        <?= htmlspecialchars($c['titre']); ?>
    </h3>

    <!-- Description -->
    <p class="card-description">
        <?= htmlspecialchars($c['description_concours']); ?>
    </p>

    <!-- État du concours -->
    <div class="card-status">
<?php if ($c['etat'] === 'ouvert'): ?>

    <a href="concours_detail.php?id_concours=<?= $c['id_concours']; ?>" class="btn-action">
        Participer & Voter
    </a>

<?php elseif ($c['etat'] === 'attente'): ?>

    <span class="btn-action disabled">
        Bientôt disponible
    </span>

<?php else: ?>

    <span class="btn-action disabled">
        Concours terminé
    </span>

<?php endif; ?>
    </div>

    <!-- Action 
    <a href="concours_detail.php?id_concours=<?= $c['id_concours']; ?>" class="btn-action">
        Participer & Voter
    </a>-->

</div>

            </div>
        <?php } ?>
    </div>

</main>

<script src="assets/js/grid-card-concours.js"></script>
<?php include 'includes/footer.php'; ?>
