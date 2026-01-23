    <?php 
    include '../includes/header.php'; 
    include '../includes/navbar.php';
    ?>

<main class="main-content">
    <section class="tableau-section">
        <h1 class="page-title-center">Liste des concours</h1>
        
        <nav class="filter-nav">
            <button class="filter-btn active">Tout</button>
            <button class="filter-btn">Awards</button>
            <button class="filter-btn">Miss/Master</button>
            <button class="filter-btn">Coopérative</button>
        </nav>

        <div class="concours-grid">
            <div class="concours-card">
                <div class="card-image">
                  <img src="../assets/images/organisateur/art.jpg" alt="Concours" >
                   
                </div>
                <div class="card-label">
                    Miss/Master
                </div>
            </div>
                      <div class="concours-card">
                <div class="card-image">
                  <img src="../assets/images/organisateur/art.jpg" alt="Concours" >
                   
                </div>
                <div class="card-label">
                    Miss/Master
                </div>
            </div>
                      <div class="concours-card">
                <div class="card-image">
                  <img src="../assets/images/organisateur/art.jpg" alt="Concours" >
                   
                </div>
                <div class="card-label">
                    Miss/Master
                </div>
            </div>
            
            </div>
    </section>
</main>
<script>
    document.querySelectorAll('.filter-btn').forEach(button => {
    button.addEventListener('click', function() {
        // Retirer la classe active de tous les boutons
        document.querySelectorAll('.filter-btn').forEach(btn => btn.classList.remove('active'));
        // Ajouter la classe au bouton cliqué
        this.classList.add('active');
        
        // Logique de filtrage ici (ex: comparer le texte du bouton avec les labels des cartes)
    });
});
</script>

<?php include '../includes/footer.php'; ?>