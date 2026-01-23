<link rel="stylesheet" href="../assets/css/liste_concours.css">
<?php
    include '../includes/link.php';
    include '../includes/navbar.php';
?>
<main class="container">
    <h1 class="main-title">Liste De Tous Les Concours</h1>
    <p class="subtitle">Tous les champs marqués avec * sont obligatoires</p>

    <form class="search-container">
        <input type="text" required placeholder="Recherche ..." class="search-input">
        <button class="btn-search">Rechercher</button>
</form>

    <div class="competitions-grid">
        <div class="comp-card">
            <img src="../assets/images/organisateur/art.jpg" alt="Affiche Concours" class="card-img">
            <div class="card-overlay">
                <div class="card-content">
                    <h3>Miss et Masters</h3>
                    <a href="concours_detail.php" class="btn-more">En savoir plus</a>
                </div>
            </div>
        </div>
        </div>
</main>
 
    <?php  include '../includes/footer.php' ; ?>