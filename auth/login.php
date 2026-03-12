<?php

session_start();
require '../config/database.php';

if($_SERVER['REQUEST_METHOD'] === 'POST'){ 

    $mail = $_POST['email'];
    $mdp  = $_POST['mdp'];

     if(!$mail){
        $_SESSION['status'] = "Email invalide";
        header("Location: login.php");
        exit();
    }

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :mail");
    $stmt->execute([':mail' => $mail]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if($user){

        if(password_verify($mdp, $user['pwd'])){
 
            $_SESSION['id_user'] = $user['id_user'];
            $_SESSION['nom'] =$user['nom_user'];
            $_SESSION['role'] = $user['role_user'];
           $_SESSION['prenom'] = $user['prenom_user'];
           $_SESSION['mail'] = $user['email'] ;
           $_SESSION['photo'] = $user['photo_user'] ;
             $_SESSION['status'] = $user['status_user'] ;
            
            header("Location: index.php");
            exit();

        } else {
            $_SESSION['status'] = "Authentification échouée, mot de passe ou email incorrect";
            header("Location: login.php");
            exit();
        }

    } else {
           $_SESSION['status'] = "Email incorrect";
    header("Location: login.php");
    exit();
    }
}
?>