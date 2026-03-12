
<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
include 'includes/link.php'; 
//include 'auth/login.php'; 

?>
<link rel="stylesheet" href="assets/css/register.css">
<link rel="stylesheet" href="assets/css/color.css">
<div class="main-container">
    <div class="sidebar">
        <h1>Donne une nouvelle tournure à ton concours, compétition</h1>
    </div>
        <div class="alert">
            <?php
                    if (isset($_SESSION['status'])){
                        echo "<h2>". $_SESSION['status']. "</h2>";
                        unset($_SESSION['status']);
                    }
                ?>
            </div>
           <div class="form-wrapper">
    <h2>Connexion</h2>
    <hr class="divider">
    <form class="form-section" method="post" action="loginProcess.php">
        <div class="input-group">
            <label>Email :</label>
            <input type="email" name="email" required>
        </div>
        <div class="input-group">
            <label>Mot de passe :</label>
            <input type="password" name="mdp" required>
        </div>
        <button type="submit" class="btn-submit">Se connecter</button>
    </form>
</div>
                

            <p class="footer-text">Pas de compte ? <a href="register">inscription</a></p>
            <p class="footer-text">Retour à <a href="index">l'acceuil</a></p>
        </div>
    </div>
</div>

