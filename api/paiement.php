<?php
require_once("../config/database.php");
require_once("../config/payment_config.php");

header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["status"=>"error","message"=>"Méthode invalide"]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['id_candidat'], $data['id_concours'], $data['montant'], $data['phone'], $data['operator'])) {
    echo json_encode(["status"=>"error","message"=>"Données manquantes"]);
    exit;
}

$idCandidat = intval($data['id_candidat']);
$idConcours = intval($data['id_concours']);
$montant = floatval($data['montant']);
$phone = trim($data['phone']);
$operator = strtoupper($data['operator']);

/**
 * Vérifier concours ouvert
 */
$stmt = $pdo->prepare("SELECT prix_vote FROM concours WHERE id_concours=? AND status_concours='ouvert'");
$stmt->execute([$idConcours]);
$concours = $stmt->fetch();

if (!$concours) {
    echo json_encode(["status"=>"error","message"=>"Concours fermé ou invalide"]);
    exit;
}

$prixVote = floatval($concours['prix_vote']);
$nbVotes = floor($montant / $prixVote);

if ($nbVotes <= 0) {
    echo json_encode(["status"=>"error","message"=>"Montant insuffisant"]);
    exit;
}

$transaction_id = uniqid("VOTE_");

/**
 * Enregistrer paiement en attente
 */
$stmtInsert = $pdo->prepare("
    INSERT INTO paiements
    (transaction_id, montant, quantite_vote, operator, phone_number,
     status_paiement, id_candidat, id_concours)
    VALUES (?, ?, ?, ?, ?, 'attente', ?, ?)
");

$stmtInsert->execute([
    $transaction_id,
    $montant,
    $nbVotes,
    $operator,
    $phone,
    $idCandidat,
    $idConcours
]);

/**
 * Appel API Mesomb
 */
$response = callMesomb($phone, $montant, $transaction_id, $operator);

if (!$response || isset($response['status']) && $response['status'] === 'error') {

echo "<pre>";
print_r($response);
exit;
}

echo json_encode([
    "status" => "success",
    "transaction_id" => $transaction_id
]);

?>