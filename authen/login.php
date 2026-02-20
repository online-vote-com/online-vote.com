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

            header("Location: index.php");
            exit();

        } else {
            $msg= "Mot de passe incorrect";
        }

    } else {
        $msg="Email incorrect";
    }
}
?>