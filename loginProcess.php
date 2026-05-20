<?php
ob_start();
session_start();
require 'config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Nettoyage basique des entrées
    $mail = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $mdp  = $_POST['mdp'];

    if (!$mail || !filter_var($mail, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['status'] = '<div class="alert-box error">Format d\'email invalide</div>';
        header("Location: login");
        exit();
    }

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :mail");
    $stmt->execute([':mail' => $mail]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        if (password_verify($mdp, $user['pwd'])) {
            
            // Stockage des infos en session
            $_SESSION['id_user']       = $user['id_user'];
            $_SESSION['nom']          = $user['nom_user'];
            $_SESSION['role']         = $user['role_user'];
            $_SESSION['prenom']       = $user['prenom_user'];
            $_SESSION['mail']         = $user['email'];
            $_SESSION['photo']        = $user['photo_user'];
            $_SESSION['email_verifie'] = $user['email_verifie'];

            if ($_SESSION['email_verifie'] !== "0") {
                // 1. On prépare d'abord le message
             /*   $_SESSION['status'] = '
                    <div style="padding: 16px; background: #ECFDF5; color: #059669; border: 1px solid #A7F3D0; border-radius: 12px; margin-bottom: 24px; font-family: \'Inter\', sans-serif; font-weight: 500; font-size: 0.95rem; text-align: center;">
                        Connexion réussie, bienvenue ' . htmlspecialchars($_SESSION['nom']) . ' !
                    </div>';
               */
                    $_SESSION['status'] = ' Connexion réussie, bienvenue ' . htmlspecialchars($_SESSION['nom']) . ' ! ';
                 
                // 2. On redirige
                header("Location: admin/dash");
                
                // 3. On arrête TOUT de suite l'exécution
                exit();
            } 

          
                $_SESSION['status'] = ' Presque fini ! Veuillez activer votre compte via l\'email envoyé. ';
                header("Location: login");
                exit();
        } else {
            // Mot de passe incorrect
            $_SESSION['status'] = ' Identifiants incorrects. Veuillez réessayer.';
            header("Location: login");
            exit();
        }
    } else {
        // Email inexistant
        $_SESSION['status'] = 'Aucun compte trouvé avec cet email.';
        header("Location: login");
        exit();
    }
}
?>
