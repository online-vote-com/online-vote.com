
<?php
    include 'includes/link.php';
    include 'includes/navbar.php';
    include 'config/database.php';

    $sql_concours = "SELECT con.*, org.nom_user 
    FROM concours con, users org
    WHERE con.id_organisateur = org.id_user";
    $pdo_concours =$pdo->query($sql_concours);
    $concours = $pdo_concours->fetchAll();

   
    /* 
    $sql_candidat= "SELECT can.*, concours.titre
    FROM candidats can, concours
    WHERE can.id_concours = concours.id_concours";
    $pdo_candidat = $pdo->query($sql_candidat);
    $candidats = $pdo_candidat->fetchAll();
    */

?>

<link rel="stylesheet" href="assets/css/color.css">
<link rel="stylesheet" href="assets/css/grid-card-concours.css">

<main class="container">
    <h1 class="main-title">Liste De Tous Les Concours</h1>
    <p class="subtitle">Tous les champs marqués avec * sont obligatoires</p>

    <form class="search-container">
        <input type="text" required placeholder="Recherche ..." class="search-input">
        <button class="btn-search">Rechercher</button>
</form>
<div class="contest-list">

    <?php foreach ($concours as $c) { ?>
<div class="contest-item <?= $c['type_vote'] ?>">

    <!-- IMAGE HERO -->
    <div class="contest-cover">

        <img src="<?= 'uploads/concours/' . htmlspecialchars($c['photo_concours']); ?>" alt="concours">

        <div class="contest-overlay">
            <span class="contest-icon"></span>
        </div>

    </div>

    <!-- BODY -->
    <div class="contest-body">

        <!-- TITRE -->
        <h3 class="contest-title">
            <?= htmlspecialchars($c['titre']); ?>
        </h3>

        <!-- ORGANISATEUR -->
      <!--  <p class="contest-organizer">
            organisé par <b><?= htmlspecialchars($c['nom_user']); ?></b>
        </p>
-->

        <!-- TYPE VOTE (IMPORTANT : SOUS TITRE) -->
        <div class="contest-type <?= $c['type_vote'] ?>">
            <?= $c['type_vote'] === 'payant' ? ' Vote payant' : ' Vote gratuit' ?>
        </div>

        <!-- CTA -->
        <a href="concours_detail.php?id_concours=<?= $c['id_concours']; ?>"
           class="contest-action">
            Participer au concours
        </a>

    </div>

</div>
    <?php } ?>

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
 
    <?php  include 'includes/footer.php' ; ?>