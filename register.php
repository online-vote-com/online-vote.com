<?php 
session_start();
include 'includes/link.php'; 

?>
<link rel="stylesheet" href="assets/css/register.css">
<link rel="stylesheet" href="assets/css/color.css">
<div class="main-container">
    
    <!-- SECTION GAUCHE -->
    <div class="sidebar">
        <h1>Donne une nouvelle tournure à ton concours, compétition</h1>
    </div>

    <!-- SECTION DROITE -->
    <div class="form-section">
        <div class="form-wrapper">

            <h2>Rejoins l'aventure</h2>
            <hr class="divider">

             <div class="alert">
            <?php
                    if (isset($_SESSION['status'])){
                        echo "<h2>". $_SESSION['status']. "</h2>";
                        unset($_SESSION['status']);
                    }
                ?>
            </div>
            <form action="auth/register.php" 
                  method="post" 
                  enctype="multipart/form-data" 
                  id="registerForm">


                <!-- NOM -->
                <div class="input-group">
                    <label>Nom :</label>
                    <input type="text" 
                           placeholder="Entrez votre nom" 
                           name="nom" 
                           required>
                </div>

                <!-- EMAIL -->
                <div class="input-group">
                    <label>Email :</label>
                    <input type="email" 
                           placeholder="Entrez votre email" 
                           name="email" 
                           required>
                </div>
                                <!-- PHOTO 
                <div class="input-group">
                    <label>Photo de profil :</label>
                    <input type="file" name="photo" accept="image/*">
                </div> -->


                <!-- PASSWORD -->
                <div class="input-group">
                    <label>Mot de passe :</label>
                    <input type="password" 
                           id="mdp" 
                           placeholder="Mot de passe" 
                           name="mdp" 
                           required>
                </div>

                <!-- CONFIRM PASSWORD -->
                <div class="input-group">
                    <label>Confirmation :</label>
                    <input type="password" 
                           id="cmdp" 
                           placeholder="Confirmez le mot de passe" 
                           name="cmdp" 
                           required>
                </div>
            <input type="radio" required>Vous acceptez nos <a href="#">Politique de confidentialités</a>

                <button type="submit" class="btn-submit">
                    Créer mon compte
                </button>

            </form>

            <!-- SOCIAL -->
            <div class="social-login">
                <div class="social-icon">
                    <img src="https://cdn-icons-png.flaticon.com/512/2991/2991148.png" alt="Google">
                </div>
                <div class="social-icon">
                    <img src="https://cdn-icons-png.flaticon.com/512/733/733547.png" alt="Facebook">
                </div>
                <div class="social-icon">
                    <img src="https://cdn-icons-png.flaticon.com/512/3046/3046121.png" alt="TikTok">
                </div>
            </div>

            <p class="footer-text">
                J'ai déjà un compte : 
                <a href="login">Connexion</a>
            </p>
            <p class="footer-text">Retour à <a href="index">l'acceuil</a></p>
        </div>
    </div>
</div>

<!-- SCRIPT VERIFICATION PASSWORD -->
<script>
document.getElementById("registerForm").addEventListener("submit", function(e){

    let mdp = document.getElementById("mdp").value;
    let cmdp = document.getElementById("cmdp").value;

    if(mdp !== cmdp){
        e.preventDefault();
        alert("Les mots de passe ne correspondent pas !");
    }
});
</script>