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

            <h2>Connexion</h2>
            <hr class="divider">

            <!-- Affichage des alertes -->
            <div class="alert">
                <?php
                if (isset($_SESSION['status'])){
                    echo "<h2>". $_SESSION['status']. "</h2>";
                    unset($_SESSION['status']);
                }
                ?>
            </div>

            <!-- Formulaire -->
            <form method="post" action="loginProcess.php">

                <div class="input-group">
                    <label>Email :</label>
                    <input type="email" name="email" placeholder="Entrez votre email" required>
                </div>

                <div class="input-group">
                    <label>Mot de passe :</label>
                    <input type="password" name="mdp" placeholder="Entrez votre mot de passe" required>
                </div>

                <button type="submit" class="btn-submit">Se connecter</button>
            </form>

            <!-- Footer -->
            <p class="footer-text">Pas de compte ? <a href="register">Inscription</a></p>
            <p class="footer-text">Retour à <a href="index">l'accueil</a></p>

        </div>
    </div>

</div>