<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit;
}

$id_user = $_SESSION['user_id'];

$sql = "SELECT * FROM concours WHERE id_concours = ? AND status_concours='ouvert'";
$stmt = $db->prepare($sql);
$stmt->execute([$id_concours]);

$concours = $stmt->fetch();

if ($concours['type_vote'] == 'gratuit') {
    $verif = $db->prepare("
        SELECT COUNT(*) FROM votes 
        WHERE id_votant=? AND id_concours=? AND source='gratuit'
    ");
    $verif->execute([$id_user, $id_concours]);

    if ($verif->fetchColumn() > 0) {
        echo "Vous avez déjà voté gratuitement.";
        exit;
    }

    $insert = $db->prepare("
        INSERT INTO votes (id_candidat, id_concours, id_votant, source, adr_ip, user_agent)
        VALUES (?, ?, ?, 'gratuit', ?, ?)
    ");
    $insert->execute([
      $id_candidat, $id_concours, $id_user,
      $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT']
    ]);

    echo "Vote gratuit enregistré avec succès.";
}
?>