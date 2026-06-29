<?php
session_start();
include '../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../concours/concours_detail.php");
    exit;
}

try {

    $id_concours = $_POST['id_concours'] ?? null;
    $nom         = trim($_POST['nom_candidat'] ?? '');
    $prenom      = trim($_POST['prenom_candidat'] ?? '');
    $email       = trim($_POST['email_candidat'] ?? '');
    $bio         = trim($_POST['biography'] ?? '');

    if (!$id_concours || !$nom || !$prenom) {
        $_SESSION['message'] = "Données manquantes";
        header("Location: ../concours/concours_detail.php?id_concours=" . $id_concours);
        exit;
    }

    //  NORMALISATION (évite doublons invisibles)
    $nom = mb_strtoupper($nom);
    $prenom = mb_strtoupper($prenom);

  /*  //  CHECK DOUBLON
    $check = $pdo->prepare("
        SELECT 1 
        FROM candidats 
        WHERE id_concours = ? 
        AND nom_candidat = ? 
        AND prenom_candidat = ?
        LIMIT 1
    ");

    $check->execute([$id_concours, $nom, $prenom]);

    if ($check->fetch()) {
        $_SESSION['message'] = "Ce candidat existe déjà dans ce concours";
        header("Location: ../concours/concours_detail.php?id_concours=" . $id_concours);
        exit;
    }
        */

    //  PHOTO
    $photoName = null;

    if (!empty($_FILES['photo_candidat']['name'])) {

        $ext = strtolower(pathinfo($_FILES['photo_candidat']['name'], PATHINFO_EXTENSION));

        $photoName = uniqid('cand_') . '.' . $ext;

        move_uploaded_file(
            $_FILES['photo_candidat']['tmp_name'],
            '../../uploads/candidats/' . $photoName
        );
    }

    //  INSERT
    $stmt = $pdo->prepare("
        INSERT INTO candidats (
            id_concours,
            nom_candidat,
            prenom_candidat,
            email_candidat,
            biography,
            photo_candidat
        )
        VALUES (?,?,?,?,?,?)
    ");

    $stmt->execute([
        $id_concours,
        $nom,
        $prenom,
        $email,
        $bio,
        $photoName
    ]);

    $_SESSION['message'] = "Candidat ajouté avec succès";

} catch (PDOException $e) {

    // gestion propre des erreurs SQL (ex: contrainte UNIQUE)
    if ($e->getCode() == 23000) {
        $_SESSION['message'] = "Ce candidat existe déjà (contrainte base de données)";
    } else {
        $_SESSION['message'] = "Erreur technique : " . $e->getMessage();
    }
}

header("Location: ../concours/concours_detail.php?id_concours=" . ($id_concours ?? ''));
exit;
?>