<?php 
 //$host = "localhost"; 
 //$user = "root"; 
 //$pwd =""; 
 

 try {
 $dsn = "mysql:host=localhost;port;3306;dbname=online_vote";
 // $con = new PDO( $dsn, "root", '');   
  $con = new PDO("mysql:host=localhost;dbname=online_vote", "root", "");
 //$con = new PDO("mysql:host=localhost;dbname=art", "root", '');    
//$con ->exec("CREATE DATABASE IF NOT EXISTS online_vote"); 
//echo "ok yes";
 $con->exec("CREATE TABLE users(
        id_user INT PRIMARY KEY AUTO_INCREMENT, 
    photo_user VARCHAR (255),
    nom_user VARCHAR (100) NOT NULL, 
    prenom_user VARCHAR (100) NOT NULL, 
    email VARCHAR (100) UNIQUE NOT NULL, 
    pwd VARCHAR (255) NOT NULL, 
    role_user ENUM('admin', 'organisateur', 
    'votant') NOT NULL DEFAULT 'Votant',
    status_user BOOLEAN DEFAULT FALSE, 
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP, 
    date_modification TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )
 ");
    echo "Ok";

 } catch(PDOException $pdo_err){
    $con = null;
    echo "Erreur lors de la connexion " . $pdo_err ->getMessage();
 }


 ?>