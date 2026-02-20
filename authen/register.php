<?php
require '../config/database.php'; // connexion PDO

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $nom = htmlspecialchars($_POST['nom']);
    $prenom = htmlspecialchars($_POST['prenom']);
    $email = htmlspecialchars($_POST['email']);
    $password = $_POST['mdp'];

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);


    $photo_name = null; // valeur par défaut

    if(isset($_FILES['photo']) && $_FILES['photo']['error'] === 0){

        $allowed_types = ['image/jpeg', 'image/png', 'image/webp'];
       // $max_size = 2 * 1024 * 1024; // 2MB
$max_size = 30* 1024 * 1024; // 2MB
        if(in_array($_FILES['photo']['type'], $allowed_types)){

            if($_FILES['photo']['size'] <= $max_size){

                $upload_dir = "../uploads/";

                if(!is_dir($upload_dir)){
                    mkdir($upload_dir, 0755, true);
                }

                $extension = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
                $photo_name = uniqid("user_", true) . "." . $extension;

                move_uploaded_file(
                    $_FILES['photo']['tmp_name'],
                    $upload_dir . $photo_name
                );

            } else {
                die("Image trop volumineuse (max 2MB)");
            }

        } else {
            die("Format d'image non autorisé");
        }
    }

    $stmt = $pdo->prepare("
        INSERT INTO users 
        (nom_user, prenom_user, email, pwd, photo_user) 
        VALUES (?, ?, ?, ?, ?)
    ");

    $stmt->execute([
        $nom,
        $prenom,
        $email,
        $hashed_password,
        $photo_name
    ]);

    header("Location: ../login.php");
    exit();
}
?>