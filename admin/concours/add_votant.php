<?php
session_start();
include '../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../concours/concours_detail.php");
    exit;
}

try {

    $id_concours = $_POST['id_concours'];

    $nom  = trim($_POST['nom_user']);
    $email = trim($_POST['email']);
    $tel  = trim($_POST['numTel']);
    $pwd  = password_hash($_POST['pwd'], PASSWORD_DEFAULT);

    /* =========================
       1. USER EXISTE ?
    ========================= */
    $stmt = $pdo->prepare("SELECT id_user FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $id_votant = $user['id_user'];
    } else {

        $stmt = $pdo->prepare("
            INSERT INTO users(nom_user, email, numTel, pwd, role_user)
            VALUES(?,?,?,?,?)
        ");

        $stmt->execute([
            $nom,
            $email,
            $tel,
            $pwd,
            'votant'
        ]);

        $id_votant = $pdo->lastInsertId();
    }

    /* =========================
       2. INSERT LIEN CONCOURS
       (PAS DE CHECK MANUEL ❌)
       ON LAISSE SQL GÉRER
    ========================= */
    $stmt = $pdo->prepare("
        INSERT INTO concours_votants(id_concours, id_votant)
        VALUES(?,?)
    ");

    $stmt->execute([$id_concours, $id_votant]);

    $_SESSION['message'] = "Votant ajouté avec succès";

} catch (PDOException $e) {

    /* =========================
       DUPLICATE ENTRY HANDLING
    ========================= */
    if ($e->getCode() == 23000) {
        $_SESSION['message'] = "Ce votant est déjà dans ce concours";
    } else {
        $_SESSION['message'] = "Erreur : " . $e->getMessage();
    }
}

header("Location: ../concours/concours_detail.php?id_concours=" . $id_concours);
exit;
?>