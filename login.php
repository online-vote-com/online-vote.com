
<?php include 'includes/link.php'; ?>
<link rel="stylesheet" href="assets/css/register.css">

<div class="main-container">
    <div class="sidebar">
        <h1>Donne une nouvelle tournure à ton concours, compétition</h1>
    </div>
  <?php 
      if(isset($msg)) {
        echo "<p class='error-msg'>$msg</p>";
       }
   ?>
    <form class="form-section" method="post" action = "authen/login.php">
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

            <p class="footer-text">Pas de compte ? <a href="register.php">inscription</a></p>
        </div>
    </div>
</div>

