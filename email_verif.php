<?php 
session_start(); 
require 'config/database.php';


if(isset($_GET['token'])){
    $token = $_GET['token']; 
    $verif = "SELECT * FROM users where email_token = ? LIMIT 1";
    $st = $pdo->prepare($verif);
    $st->execute([$token]);
    $user = $st->fetch(PDO::FETCH_ASSOC); 

    if($user){
        if($user['status_user']=="suspendu"){
        $update = "UPDATE users SET status_user = 'actif' WHERE email_token = ?"; 
        $stm = $pdo->prepare($update); 
        $stm->execute([$token]);

        if($stm){
            $_SESSION['status'] ="Votre email a été vérifié avec succès, vous pouvez maintenant vous connecter !"; 
            header("location: login.php");
            exit(0);
        } else {
         $_SESSION['status'] ="Oups, une erreur s'est produite lors de la vérification de votre email. Veuillez réessayer."; 
          header("location: login.php");
          exit(0);
        }

        } else {
            $_SESSION['status'] ="Cet email a déjà été vérifié, vous pouvez vous connecter !"; 
          header("location: login.php");
          exit(0);
        }
    } else {
          $_SESSION['status'] ="Cette clé de vérification est invalide ou a expiré."; 
          header("location: register.php");
    }
} else {
    $_SESSION['status'] ="Pas authorisé"; 
    header("location: register.php");
}
?>