<link rel="stylesheet" href="assets/css/concours_detail.css">

<?php
    include 'includes/link.php';
    include 'includes/navbar.php';
    include 'config/database.php';

    if (!isset($_GET['id_concours']) || empty($_GET['id_concours'])) {
        die("Concours introuvable");
    }

    $idConcours = (int) $_GET['id_concours'];

    /*
    $sqlConcours = "SELECT * FROM concours WHERE id_concours = :id_concours";
    $stmtConcours = $pdo->prepare($sqlConcours);
    $stmtConcours->execute(['id_concours' => $idConcours]);
    $concours = $stmtConcours->fetch();
    */
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

    $sql = "SELECT id_candidat, COUNT(*) AS nb_votes, RANK() OVER (ORDER BY COUNT(*) DESC) AS rang
        FROM Vote
        WHERE id_concours = ?
        GROUP BY id_candidat";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$idConcours]);
    $ranks = $stmt->fetchAll();

    foreach($ranks as $r){
        if($r['id_candidat'] == $candidats[0]['id_candidat']){
            $rangCandidat = $r['rang'];
            break;
        }
    }

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
            <?php foreach( $candidats as $can) { ?>
            <div class="card-image-container">
            <!--      <img src="<?php echo $can['image']; ?>" alt="Arthur CHAKOUALEU" class="card-img">  -->
                <img src="assets/images/organisateur/art.jpg" alt="Arthur CHAKOUALEU" class="card-img">
            </div>
            
            <div class="candidate-info">
                <h3><?php echo $can['nom_candidat']; ?></h3>
                <div class="rank-badge"> Numéro : <strong><?php echo $r['rang']; ?></div>
                
                <div class="card-actions">
                    <a href="#" class="btn-action-outline">Voir Plus +</a>
                    <a href="profil_candidats.php?id_candidat=<?php echo $can['id_candidat']; ?>" class="btn-action-solid openModalBtnProfilCandidat">Voter</a>
                </div>
            </div>
             <?php  } ?>
        </div>
        </div>
</main>


  <?php  include 'includes/footer.php' ; ?>