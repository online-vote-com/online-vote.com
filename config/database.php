<?php 
   $dsn = "mysql:host=127.0.0.1;port=3306;dbname=online-vote";

   try{
      $pdo = new PDO($dsn, "root", "");
   // echo "<h1>Succès lors de la connexion</h1>";
   }catch(PDOException $e){
      echo "Erreur lors de la connexion : " . $e->getMessage();
      $pdo =Null;
   }

   /*
   $dsn = "mysql:host=localhost;port=3306;dbname=u636319906_online_vote";

   try{
      $pdo = new PDO($dsn, "u636319906_admin", "So_lo@.12");
   // echo "<h1>Succès lors de la connexion</h1>";
   }catch(PDOException $e){
      echo "Erreur lors de la connexion : " . $e->getMessage();
      $pdo =Null;
   }
   */
?>