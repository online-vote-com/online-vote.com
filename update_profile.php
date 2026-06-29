<?php
session_start();
include 'config/database.php';

if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit;
}

$id = $_SESSION['id_user'];

$nom = $_POST['nom'] ?? '';
$prenom = $_POST['prenom'] ?? '';
$email = $_POST['email'] ?? '';

$old_password = $_POST['old_password'] ?? '';
$new_password = $_POST['new_password'] ?? '';

try {


    $stmt = $pdo->prepare("SELECT pwd, photo_user FROM users WHERE id_user = ?");
    $stmt->execute([$id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        $_SESSION['error'] = "Utilisateur introuvable";
        header("Location: profil_user.php");
        exit;
    }

    // 📸 gestion photo (optionnel)
    $photoName = $user['photo_user'];

    if (!empty($_FILES['photo']['name'])) {
        $uploadDir = "uploads/";

        $photoName = time() . "_" . basename($_FILES['photo']['name']);
        move_uploaded_file($_FILES['photo']['tmp_name'], $uploadDir . $photoName);
    }


    if (!empty($new_password)) {

        if (!password_verify($old_password, $user['pwd'])) {
            $_SESSION['error'] = "Ancien mot de passe incorrect";
            header("Location: profil_user.php");
            exit;
        }

        $hashedPassword = password_hash($new_password, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare("
            UPDATE users 
            SET nom_user = ?, 
                prenom_user = ?, 
                email = ?, 
                pwd = ?, 
                photo_user = ?
            WHERE id_user = ?
        ");

        $stmt->execute([
            $nom,
            $prenom,
            $email,
            $hashedPassword,
            $photoName,
            $id
        ]);

    } else {

        // sans changement password
        $stmt = $pdo->prepare("
            UPDATE users 
            SET nom_user = ?, 
                prenom_user = ?, 
                email = ?, 
                photo_user = ?
            WHERE id_user = ?
        ");

        $stmt->execute([
            $nom,
            $prenom,
            $email,
            $photoName,
            $id
        ]);
    }

  
    $_SESSION['nom'] = $nom;
    $_SESSION['prenom'] = $prenom;
    $_SESSION['mail'] = $email;
    $_SESSION['photo'] = $photoName;

    $_SESSION['success'] = "Profil mis à jour avec succès";

    header("Location: profil_user.php");
    exit;

} catch (Exception $e) {
    $_SESSION['error'] = "Erreur : " . $e->getMessage();
    header("Location: profil_user.php");
    exit;
}

?>