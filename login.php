
<?php 
session_start();
include 'includes/link.php'; 

?>
<link rel="stylesheet" href="assets/css/register.css">
<link rel="stylesheet" href="assets/css/color.css">
<div class="main-container">
    <div class="sidebar">
        <h1>Donne une nouvelle tournure à ton concours, compétition</h1>
    </div>
        <div class="alert">
            <?php
                    if (isset($_SESSION['user'])){
                        echo "<h2>". $_SESSION['user']. "</h2>";
                        unset($_SESSION['user']);
                    }
                ?>
            </div>
    <form class="form-section" method="post" action = "auth/login.php">
        <div class="form-wrapper">
            <h2>Connexion</h2>
            <hr class="divider">

                <div class="input-group">
                    <label>Email :</label>
                    <input type="email" placeholder="" name="email" required>
                </div>

                <div class="input-group">
                    <label>Mot de passe :</label>
                    <input type="password" placeholder="" name="mdp" required>
                </div>
                <button type="submit" class="btn-submit">Se connecter</button>
                
            </form> 

            <p class="footer-text">Pas de compte ? <a href="register">inscription</a></p>
            <p class="footer-text">Retour à <a href="index">l'acceuil</a></p>
        </div>
    </div>
</div>

