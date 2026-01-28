<?php 
   $dsn = "mysql:host=127.0.0.1;port=3306;dbname=online-vote";

   try{
      $pdo = new PDO($dsn, "root", "");
   // echo "<h1>Succès lors de la connexion</h1>";
   }catch(PDOException $e){
      echo "Erreur lors de la connexion : " . $e->getMessage();
      $pdo =Null;
   }

?>