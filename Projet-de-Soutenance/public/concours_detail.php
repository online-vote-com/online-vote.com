<link rel="stylesheet" href="../assets/css/liste_concours.css">
<?php
    include '../includes/link.php';
    include '../includes/navbar.php';
    include '../config/database.php';

    if (!isset($_GET['id_concours']) || empty($_GET['id_concours'])) {
        die("Concours introuvable");
    }

    $idConcours = (int) $_GET['id_concours'];

    
    $sqlConcours = "SELECT * FROM concours WHERE id_concours = :id_concours";
    $stmtConcours = $pdo->prepare($sqlConcours);
    $stmtConcours->execute(['id_concours' => $idConcours]);
    $concours = $stmtConcours->fetch();

    $sqlCandidats = "
    SELECT can.*, co.titre
    FROM candidats can, concours co
    WHERE can.id_concours = :id_concours
    ";
    $stmt = $pdo->prepare($sqlCandidats);
    $stmt->execute(['id_concours' => $idConcours]);
    $candidats = $stmt->fetchAll();

?>
<main class="container">
    <h1 class="main-title">Liste De Tous Les Candidats <?php echo $candidats[0]['titre']; ?></h1>
   <!-- <p class="subtitle">du concours de <?php echo $candidats[0]['titre']; ?></p> -->

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
        
        <div class="candidate-card">
            <div class="card-image-container">
            <!--      <img src="<?php echo $candidats[0]['image']; ?>" alt="Arthur CHAKOUALEU" class="card-img">  -->
                <img src="../assets/images/organisateur/art.jpg" alt="Arthur CHAKOUALEU" class="card-img">
            </div>
            
            <div class="candidate-info">
                <h3><?php echo $candidats[0]['nom_candidat']; ?></h3>
                <div class="rank-badge">1 ère Place</div>
                
                <div class="card-actions">
                    <a href="#" class="btn-action-outline">Voir Plus +</a>
                    <a href="profil_candidats.php?id_candidat=<?php echo $candidats[0]['id_candidat']; ?>" class="btn-action-solid openModalBtnProfilCandidat">Voter</a>
                </div>
            </div>
        </div>
        </div>
</main>


  <?php  include '../includes/footer.php' ; ?>