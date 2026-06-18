<?php

include __DIR__ . '/../../config/database.php';
session_start();

/*
|--------------------------------------------------------------------------
| AJOUT
|--------------------------------------------------------------------------
*/

if (isset($_POST['action']) && $_POST['action'] == 'add') {

    $id_org = $_SESSION['id_user'];

    $titre = $_POST['titre'];
    $description = $_POST['description_concours'];
    $type_vote = $_POST['type_vote'];
    $prix_vote = !empty($_POST['prix_vote']) ? $_POST['prix_vote'] : 0;
    $date_debut = $_POST['date_debut'];
    $date_fin = $_POST['date_fin'];

    $photo = null;

    if (!empty($_FILES['photo_concours']['name'])) {

        $fileName = time().'_'.basename($_FILES['photo_concours']['name']);
        $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        $allowed = ['jpg','jpeg','png','webp'];

        if (in_array($extension, $allowed)) {

            $targetDir = __DIR__ . '/../../uploads/concours/';

            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0777, true);
            }

            move_uploaded_file(
                $_FILES['photo_concours']['tmp_name'],
                $targetDir . $fileName
            );

            $photo = $fileName;
        }
    }

    $sql = "INSERT INTO concours
        (
            titre,
            description_concours,
            photo_concours,
            type_vote,
            prix_vote,
            status_concours,
            id_organisateur,
            date_debut,
            date_fin
        )
        VALUES
        (
            :titre,
            :description,
            :photo,
            :type_vote,
            :prix_vote,
            'attente',
            :id_org,
            :date_debut,
            :date_fin
        )";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ':titre' => $titre,
        ':description' => $description,
        ':photo' => $photo,
        ':type_vote' => $type_vote,
        ':prix_vote' => $prix_vote,
        ':id_org' => $id_org,
        ':date_debut' => $date_debut,
        ':date_fin' => $date_fin
    ]);

    $_SESSION['message'] = "Concours créé avec succès";

    header("Location: ../dash");
    exit;
}

/*
|--------------------------------------------------------------------------
| MODIFICATION
|--------------------------------------------------------------------------
*/

if (isset($_POST['action']) && $_POST['action'] == 'edit') {

    $id = $_POST['id_concours'];

    $titre = $_POST['titre'];
    $description = $_POST['description_concours'];
    $type_vote = $_POST['type_vote'];
    $prix_vote = !empty($_POST['prix_vote']) ? $_POST['prix_vote'] : 0;
    $status_concours = $_POST['status_concours']; //  AJOUT ICI
    $date_debut = $_POST['date_debut'];
    $date_fin = $_POST['date_fin'];

    $photoSql = "";
    $photoParam = [];

    if (!empty($_FILES['photo_concours']['name'])) {

        $fileName = time().'_'.basename($_FILES['photo_concours']['name']);
        $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        $allowed = ['jpg','jpeg','png','webp'];

        if (in_array($extension, $allowed)) {

            $targetDir = __DIR__ . '/../../uploads/concours/';

            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0777, true);
            }

            move_uploaded_file(
                $_FILES['photo_concours']['tmp_name'],
                $targetDir . $fileName
            );

            $photoSql = ", photo_concours = :photo";
            $photoParam[':photo'] = $fileName;
        }
    }

    $sql = "UPDATE concours SET
        titre = :titre,
        description_concours = :description,
        type_vote = :type_vote,
        prix_vote = :prix_vote,
        status_concours = :status_concours,  --  AJOUT ICI
        date_debut = :date_debut,
        date_fin = :date_fin
        $photoSql
        WHERE id_concours = :id";

    $params = [
        ':titre' => $titre,
        ':description' => $description,
        ':type_vote' => $type_vote,
        ':prix_vote' => $prix_vote,
        ':status_concours' => $status_concours, //  AJOUT ICI
        ':date_debut' => $date_debut,
        ':date_fin' => $date_fin,
        ':id' => $id
    ];

    $params = array_merge($params, $photoParam);

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    $_SESSION['message'] = "Concours modifié avec succès";

    header("Location: ../dash");
    exit;
}

/*
|--------------------------------------------------------------------------
| SUPPRESSION
|--------------------------------------------------------------------------
*/

if (isset($_GET['action']) && $_GET['action'] == 'delete') {

    $id = $_GET['id'];

    $stmt = $pdo->prepare("DELETE FROM concours WHERE id_concours = :id");

    $stmt->execute([
        ':id' => $id
    ]);

    $_SESSION['message'] = "Concours supprimé avec succès";

    header("Location: ../dash");
    exit;
}
?>