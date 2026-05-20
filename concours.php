<?php
    session_start();
    include 'includes/link.php';
    include 'includes/navbar.php';
    include 'config/database.php';

    $sql_concours = "SELECT con.*, org.nom_user 
    FROM concours con, users org
    WHERE con.id_organisateur = org.id_user";
    $pdo_concours = $pdo->query($sql_concours);
    $concours = $pdo_concours->fetchAll();
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

        <?php foreach ($concours as $c) { ?>
            <div id="contest-<?= $c['id_concours']; ?>" class="contest-card">
                
                <div class="card-hero">
                    <img src="<?= 'uploads/concours/' . htmlspecialchars($c['photo_concours']); ?>" alt="Bannière">
                    <div class="card-overlay"></div>
                </div>
                
                <div class="card-content">
                    <div class="badge-type <?= $c['type_vote'] ?>">
                        <?= $c['type_vote'] === 'payant' ? 'Vote Payant' : 'Vote Gratuit' ?>
                    </div>
                    
                    <h3 class="card-title">
                        <?= htmlspecialchars($c['titre']); ?>
                    </h3>
                    
                    <a href="concours_detail.php?id_concours=<?= $c['id_concours']; ?>" class="btn-action">
                        Participer & Voter
                    </a>
                </div>

            </div>
        <?php } ?>
    </div>

</main>

<script src="assets/js/grid-card-concours.js"></script>
<?php include 'includes/footer.php'; ?>
