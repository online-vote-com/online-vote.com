<?php 
session_start();
include 'includes/link.php'; 
//include 'auth/register.php'; 
?>

<link rel="stylesheet" href="assets/css/register.css">
<link rel="stylesheet" href="assets/css/color.css">

<main class="login-page">
    <div class="login-card">

        <!-- PANNEAU PHOTO AFRIQUE MOBILE VOTE (PC & Mobile) -->
        <section class="login-visual">
            <div class="login-overlay"></div>
            <img src="https://i1-e.pinimg.com/1200x/8b/18/9c/8b189cdf5b472d4b6c70c75ec57fb6db.jpg" 
                 alt="Vote citoyen en Afrique" 
                 class="login-img">
            <div class="login-visual-text">
                <h2>Votez simplement.<br><span>Participez en toute confiance.</span></h2>
                <p>Une plateforme sécurisée, rapide et transparente.</p>
            </div>
        </section>

        <!-- PANNEAU FORMULAIRE ÉPURÉ -->
        <section class="login-form-side">
            <div class="login-box">
                
                <header class="login-header">
                    <h1>Rejoins l'aventure</h1>
                    <p>Créez votre compte en quelques secondes.</p>
                </header>

                <!-- Message d'erreur PHP -->
                <?php if (isset($_SESSION['status'])): ?>
                    <div class="login-alert">
                        <i class="fas fa-exclamation-circle"></i>
                        <span><?= htmlspecialchars($_SESSION['status']); ?></span>
                    </div>
                    <?php unset($_SESSION['status']); ?>
                <?php endif; ?>

                <!-- Formulaire d'inscription -->
                <form action="registerProcess.php" method="POST" enctype="multipart/form-data" id="registerForm" class="login-core-form">
                    
                    <!-- NOM -->
                    <div class="login-field">
                        <label for="nom">Nom</label>
                        <input type="text" id="nom" name="nom" placeholder="Entrez votre nom complet" required>
                    </div>

                    <!-- EMAIL -->
                    <div class="login-field">
                        <label for="email">Adresse email</label>
                        <input type="email" id="email" name="email" placeholder="exemple@domaine.com" required autocomplete="email">
                    </div>

                    <!-- PHOTO DE PROFIL REPRÉCISE -->
                  <!--   <div class="login-field login-file-field">
                        <label for="photo">Photo de profil</label>
                        <input type="file" id="photo" name="photo" accept="image/*">
                    </div>
-->
                    <!-- PASSWORD -->
                    <div class="login-field">
                        <label for="mdp">Mot de passe</label>
                        <input type="password" id="mdp" name="mdp" placeholder="Créer un mot de passe" required>
                    </div>

                    <!-- CONFIRM PASSWORD -->
                    <div class="login-field">
                        <label for="cmdp">Confirmation</label>
                        <input type="password" id="cmdp" name="cmdp" placeholder="Confirmez votre mot de passe" required>
                    </div>

                    <!-- REGLÈS ET CONFIDENTIALITÉ -->
                    <div class="login-checkbox-field">
                        <input type="radio" id="agree" required>
                        <label for="agree">J'accepte la <a href="#">Politique de confidentialité</a></label>
                    </div>

                    <button type="submit" class="btn-login-action">
                        Créer mon compte
                    </button>
                    
                </form>

                <!-- BOUTONS DE CONNEXION SOCIALE -->
             <!--     <div class="login-social-hub">
                    <div class="login-social-icon" title="S'inscrire avec Google">
                        <img src="https://cdn-icons-png.flaticon.com/512/2991/2991148.png" alt="Google">
                    </div>
                    <div class="login-social-icon" title="S'inscrire avec Facebook">
                        <img src="https://cdn-icons-png.flaticon.com/512/733/733547.png" alt="Facebook">
                    </div>
                    <div class="login-social-icon" title="S'inscrire avec TikTok">
                        <img src="https://cdn-icons-png.flaticon.com/512/3046/3046121.png" alt="TikTok" alt="TikTok">
                    </div>
                </div>
-->
                <footer class="login-footer">
                    <p>J'ai déjà un compte : <a href="login.php">Connexion</a></p>
                    <a href="index.php" class="login-back">➔ Retour à l'accueil</a>
                </footer>

            </div>
        </section>

    </div>
</main>

<!-- SCRIPT VERIFICATION PASSWORD STABLE -->
<script>
document.getElementById("registerForm").addEventListener("submit", function(e){
    const mdp = document.getElementById("mdp").value;
    const cmdp = document.getElementById("cmdp").value;

    if (mdp !== cmdp) {
        e.preventDefault();
        alert("Les mots de passe ne correspondent pas !");
    }
});
</script>
