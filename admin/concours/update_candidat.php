<?php
session_start();
include '../../config/database.php';

$id = $_POST['id_candidat'];
$id_concours = $_POST['id_concours'];

$nom = $_POST['nom_candidat'];
$prenom = $_POST['prenom_candidat'];
$email = $_POST['email_candidat'];
$bio = $_POST['biography'];

/* =========================
   1. RECUP PHOTO ACTUELLE
========================= */
$stmt = $pdo->prepare("SELECT photo_candidat FROM candidats WHERE id_candidat = ?");
$stmt->execute([$id]);
$old = $stmt->fetch(PDO::FETCH_ASSOC);
$photoName = $old['photo_candidat'];

/* =========================
   2. SI NOUVELLE PHOTO
========================= */
if (!empty($_FILES['photo_candidat']['name'])) {

    $tmp = $_FILES['photo_candidat']['tmp_name'];
    $ext = strtolower(pathinfo($_FILES['photo_candidat']['name'], PATHINFO_EXTENSION));

    $allowed = ['jpg','jpeg','png','webp'];

    if (in_array($ext, $allowed)) {

        $photoName = uniqid('cand_') . '.' . $ext;
        $path = "../../uploads/candidats/" . $photoName;

        move_uploaded_file($tmp, $path);

        if (!empty($old['photo_candidat']) && file_exists("../../uploads/candidats/" . $old['photo_candidat'])) {
            unlink("../../uploads/candidats/" . $old['photo_candidat']);
        }
    }
}

/* =========================
   3. UPDATE DB
========================= */
$sql = "UPDATE candidats 
        SET nom_candidat = ?,
            prenom_candidat = ?,
            email_candidat = ?,
            biography = ?,
            photo_candidat = ?
        WHERE id_candidat = ?";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    $nom,
    $prenom,
    $email,
    $bio,
    $photoName,
    $id
]);

/* =========================
   MESSAGE SUCCESS
========================= */
$_SESSION['message'] = "Candidat modifié avec succès";

header("Location: ../concours/concours_detail.php?id_concours=" . $id_concours);
exit;
?>