<link rel="stylesheet" href="../assets/css/liste_concours.css">
<?php
    include '../includes/link.php';
    include '../includes/navbar.php';
    include '../config/database.php';

    $sql_concours = "SELECT con.*, org.nom_user 
    FROM concours con, users org
    WHERE con.id_organisateur = org.id_user";
    $pdo_concours =$pdo->query($sql_concours);
    $concours = $pdo_concours->fetchAll();

   
    $sql_candidat= "SELECT can.*, concours.titre
    FROM candidats can, concours
    WHERE can.id_concours = concours.id_concours";
    $pdo_candidat = $pdo->query($sql_candidat);
    $candidats = $pdo_candidat->fetchAll();


?>
<main class="container">
    <h1 class="main-title">Liste De Tous Les Concours</h1>
    <p class="subtitle">Tous les champs marqués avec * sont obligatoires</p>

    <form class="search-container">
        <input type="text" required placeholder="Recherche ..." class="search-input">
        <button class="btn-search">Rechercher</button>
</form>
    <div class="contests-row">
        
            <?php foreach ($concours as $concours) {  
               // if($concours['etat'] !== 'ouvert') { ?>
            <div class="contest-card">
                <div class="contest-banner gradient-bg">
                     <!-- <img src="../assets/images/organisateur/art.jpg" alt="Affiche Concours" class="card-img">-->
                      <span class="card-badge"><?php echo $concours['type_vote']; ?></span>
                </div>
                <div class="contest-details">
                    <h4><?php echo $concours['titre']; ?></h4>
                    <button class="btn-more-minimal">
                         <a style="text-decoration: none;" href="concours_detail.php?id_concours=<?php echo $concours['id_concours']; ?>" >Gérer le concours</a>
                    </button>
                    
                </div>
            </div>
                <?php //} 
              } ?>
     </div> 

    <!--<div class="competitions-grid">
        <div class="comp-card">
            <img src="../assets/images/organisateur/art.jpg" alt="Affiche Concours" class="card-img">
            <div class="card-overlay">
                <div class="card-content">
                    <h3>Miss et Masters</h3>
                    <a href="concours_detail.php" class="btn-more">En savoir plus</a>
                </div>
            </div>
        </div>-->
    </div>
</main>
 
    <?php  include '../includes/footer.php' ; ?>