<?php
    include __DIR__ . '/../../config/database.php';
    session_start();
    if (isset($_POST['submit_concours'])) {

  $id_org = $_SESSION['id_user'];
    $titre = $_POST['titre'];
    $description = $_POST['description_concours'];
    $type_vote = $_POST['type_vote'];
    $prix_vote = !empty($_POST['prix_vote']) ? $_POST['prix_vote'] : 0;
    $date_debut = $_POST['date_debut'];
    $date_fin = $_POST['date_fin'];

    // ===== Upload image =====
        $photo = null;

        if (!empty($_FILES['photo_concours']['name'])) {

            $fileName = time() . "_" . basename($_FILES['photo_concours']['name']);
            $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

            $allowed = ['jpg', 'jpeg', 'png'];

            if (in_array($fileType, $allowed)) {

                $targetDir = __DIR__ . "/../../uploads/concours/";

                if (!is_dir($targetDir)) {
                    mkdir($targetDir, 0777, true);
                }

                $targetFile = $targetDir . $fileName;

                move_uploaded_file($_FILES['photo_concours']['tmp_name'], $targetFile);

                $photo = $fileName;
            }
        }

    // ===== INSERT SQL =====
    $sql = "INSERT INTO concours 
    (titre, description_concours, photo_concours, type_vote, prix_vote, status_concours, id_organisateur, date_debut, date_fin)
    VALUES 
    (:titre, :description, :photo, :type_vote, :prix_vote, 'attente', :id_org, :date_debut, :date_fin)";

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

    $_SESSION['message'] = '
                        <div style="padding: 16px; background: #ECFDF5; color: #059669; border: 1px solid #A7F3D0; border-radius: 12px; margin-bottom: 24px; font-family: \'Inter\', sans-serif; font-weight: 500; font-size: 0.95rem; text-align: center;">
                        Concours créé avec succès !
                    </div>';
    header("Location: ../dash");
    exit();
  
    }
?>
