<?php
session_start();
require '../config/database.php';

if($_SERVER['REQUEST_METHOD'] === 'POST'){ 

    $mail = htmlspecialchars($_POST['email']);
    $mdp  = $_POST['mdp'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :mail");
    $stmt->execute([':mail' => $mail]);

    $user = $stmt->fetch();

    if($user){

        if(password_verify($mdp, $user['pwd'])){
 
            $_SESSION['id_user'] = $user['id_user'];
            $_SESSION['nom'] =$user['nom_user'];
            $_SESSION['role'] = $user['role_user'];
           $_SESSION['prenom'] = $user['prenom_user'];
           $_SESSION['mail'] = $user['email'] ;
           $_SESSION['photo'] = $user['photo_user'] ;
             $_SESSION['status'] = $user['status_user'] ;
            
            header("Location: ../index");
            exit();

        } else {
            $msg= "<p style='color:red'>Mot de passe incorrect</p>";
        }

    } else {
        $msg="<p style='color:red'>Email incorrect</p>";
    }
}
?>