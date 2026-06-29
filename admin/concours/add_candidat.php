<?php
session_start();
require '../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../concours/concours_detail.php");
    exit;
}

$id_concours = (int)($_POST['id_concours'] ?? 0);
$nom         = trim($_POST['nom_candidat'] ?? '');
$prenom      = trim($_POST['prenom_candidat'] ?? '');
$email       = trim($_POST['email_candidat'] ?? '');
$bio         = trim($_POST['biography'] ?? '');

if ($id_concours <= 0 || empty($nom) || empty($prenom)) {
    $_SESSION['message'] = "Veuillez remplir les champs obligatoires.";
    header("Location: ../concours/concours_detail.php?id_concours=".$id_concours);
    exit;
}

/* Nettoyage des espaces */
$nom = preg_replace('/\s+/', ' ', $nom);
$prenom = preg_replace('/\s+/', ' ', $prenom);

try {

    /* Vérifie uniquement les doublons dans le même concours */
    $check = $pdo->prepare("
        SELECT id_candidat
        FROM candidats
        WHERE id_concours = ?
        AND LOWER(TRIM(nom_candidat)) = LOWER(TRIM(?))
        AND LOWER(TRIM(prenom_candidat)) = LOWER(TRIM(?))
        LIMIT 1
    ");

    $check->execute([
        $id_concours,
        $nom,
        $prenom
    ]);

    if ($check->fetch()) {
        $_SESSION['message'] = "Ce candidat existe déjà dans ce concours.";
        header("Location: ../concours/concours_detail.php?id_concours=".$id_concours);
        exit;
    }

    /* Gestion de la photo */
    $photoName = null;

    if (
        isset($_FILES['photo_candidat']) &&
        $_FILES['photo_candidat']['error'] === UPLOAD_ERR_OK
    ) {

        $extensions = ['jpg','jpeg','png','gif','webp'];

        $ext = strtolower(pathinfo($_FILES['photo_candidat']['name'], PATHINFO_EXTENSION));

        if (!in_array($ext, $extensions)) {
            $_SESSION['message'] = "Format d'image non autorisé.";
            header("Location: ../concours/concours_detail.php?id_concours=".$id_concours);
            exit;
        }

        $photoName = uniqid('cand_', true).".".$ext;

        move_uploaded_file(
            $_FILES['photo_candidat']['tmp_name'],
            "../../uploads/candidats/".$photoName
        );
    }

    /* Insertion */
    $insert = $pdo->prepare("
        INSERT INTO candidats(
            id_concours,
            nom_candidat,
            prenom_candidat,
            email_candidat,
            biography,
            photo_candidat
        )
        VALUES (?, ?, ?, ?, ?, ?)
    ");

    $insert->execute([
        $id_concours,
        $nom,
        $prenom,
        !empty($email) ? $email : null,
        !empty($bio) ? $bio : null,
        $photoName
    ]);

    $_SESSION['message'] = "Candidat ajouté avec succès.";

} catch (PDOException $e) {

    $_SESSION['message'] = "Erreur SQL : ".$e->getMessage();
}

header("Location: ../concours/concours_detail.php?id_concours=".$id_concours);
exit;
?>