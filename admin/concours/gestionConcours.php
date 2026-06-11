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

        $allowed = ['jpg','jpeg','png'];

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

    $_SESSION['message'] = "<div style='
padding:14px 18px;
border-radius:var(--radius);
background:var(--soft-purple);
border-left:5px solid var(--main-purple);
color:var(--text-dark);
font-weight:600;
box-shadow:var(--shadow-sm);
'>
Concours créé avec succès
</div>";

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
    $prix_vote = $_POST['prix_vote'];
    $date_debut = $_POST['date_debut'];
    $date_fin = $_POST['date_fin'];

    $sqlPhoto = "";
    $paramsPhoto = [];

    if (!empty($_FILES['photo_concours']['name'])) {

        $fileName = time().'_'.basename($_FILES['photo_concours']['name']);

        $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        $allowed = ['jpg','jpeg','png'];

        if (in_array($extension, $allowed)) {

            $targetDir = __DIR__ . '/../../uploads/concours/';

            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0777, true);
            }

            move_uploaded_file(
                $_FILES['photo_concours']['tmp_name'],
                $targetDir . $fileName
            );

            $sqlPhoto = ", photo_concours = :photo";
            $paramsPhoto[':photo'] = $fileName;
        }
    }

    $sql = "UPDATE concours SET

            titre = :titre,
            description_concours = :description,
            type_vote = :type_vote,
            prix_vote = :prix_vote,
            date_debut = :date_debut,
            date_fin = :date_fin

            $sqlPhoto

            WHERE id_concours = :id";

    $params = [

        ':titre' => $titre,
        ':description' => $description,
        ':type_vote' => $type_vote,
        ':prix_vote' => $prix_vote,
        ':date_debut' => $date_debut,
        ':date_fin' => $date_fin,
        ':id' => $id

    ];

    $params = array_merge($params, $paramsPhoto);

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    $_SESSION['message'] = "<div style='
padding:14px 18px;
border-radius:var(--radius);
background:rgba(156, 4, 218, 0.08);
border-left:5px solid var(--main-purple);
color:var(--text-dark);
font-weight:600;
box-shadow:var(--shadow-sm);
'>
Concours modifié avec succès
</div>";
    
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

    $stmt = $pdo->prepare(
        "DELETE FROM concours WHERE id_concours = :id"
    );

    $stmt->execute([
        ':id' => $id
    ]);

   $_SESSION['message'] = "<div style='
padding:14px 18px;
border-radius:var(--radius);
background:#fff1f2;
border-left:5px solid #ef4444;
color:var(--text-dark);
font-weight:600;
box-shadow:var(--shadow-sm);
'>
Concours supprimé avec succès
</div>";

header("Location: ../dash");
exit;
}
?>