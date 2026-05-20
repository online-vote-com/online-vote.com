<?php 
session_start();
include 'includes/link.php'; 
?>

<link rel="stylesheet" href="assets/css/register.css">
<link rel="stylesheet" href="assets/css/color.css">

<main class="login-page">
    <div class="login-card">

        <!-- PANNEAU PHOTO AFRIQUE MOBILE VOTE (PC uniquement) -->
        <section class="login-visual">
            <div class="login-overlay"></div>
            <img src="https://i.pinimg.com/736x/f2/32/02/f232022f5082fc77fcbd6aa3edc1aed4.jpg" 
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
                    <h1>Connexion</h1>
                    <p>Ravi de vous revoir. Connectez-vous à votre espace.</p>
                </header>

                <!-- Message d'erreur PHP -->
                <?php if (isset($_SESSION['status'])): ?>
                    <div class="login-alert">
                        <i class="fas fa-exclamation-circle"></i>
                        <span><?= htmlspecialchars($_SESSION['status']); ?></span>
                    </div>
                    <?php unset($_SESSION['status']); ?>
                <?php endif; ?>

                <!-- Formulaire traditionnel propre -->
                <form method="POST" action="loginProcess.php" class="login-core-form">
                    
                    <div class="login-field">
                        <label for="email">Adresse email</label>
                        <input type="email" id="email" name="email" placeholder="exemple@domaine.com" required autocomplete="email">
                    </div>

                    <div class="login-field">
                        <label for="mdp">Mot de passe</label>
                        <input type="password" id="mdp" name="mdp" placeholder="••••••••" required>
                    </div>

                    <button type="submit" class="btn-login-action">
                        Se connecter
                    </button>
                    
                </form>

                <footer class="login-footer">
                    <p>Pas encore de compte ? <a href="register.php">Créer un compte</a></p>
                    <a href="index.php" class="login-back">➔ Retour à l'accueil</a>
                </footer>

            </div>
        </section>

    </div>
</main>
