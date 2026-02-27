<?php

/**
 * API PAIEMENT MOBILE MONEY
 * Production ready - Hostinger compatible
 */

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once("../config/database.php");
require_once("../config/payment_config.php");

header("Content-Type: application/json");

// Vérifier méthode HTTP
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        "status" => "error",
        "message" => "Méthode invalide"
    ]);
    exit;
}

// Lire JSON envoyé par fetch()
$input = file_get_contents("php://input");
$data = json_decode($input, true);

if (!$data) {
    echo json_encode([
        "status" => "error",
        "message" => "JSON invalide"
    ]);
    exit;
}

// Vérification données obligatoires
if (
    empty($data['id_candidat']) ||
    empty($data['id_concours']) ||
    empty($data['montant']) ||
    empty($data['phone']) ||
    empty($data['operator'])
) {
    echo json_encode([
        "status" => "error",
        "message" => "Données manquantes"
    ]);
    exit;
}

$idCandidat  = (int)$data['id_candidat'];
$idConcours  = (int)$data['id_concours'];
$montant     = (int)$data['montant'];
$phone       = preg_replace('/[^0-9]/', '', $data['phone']); // nettoyage numéro
$operator    = strtoupper(trim($data['operator']));

// Vérifier concours ouvert
$stmt = $pdo->prepare("
    SELECT prix_vote 
    FROM concours 
    WHERE id_concours = ? 
    AND status_concours = 'ouvert'
");
$stmt->execute([$idConcours]);
$concours = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$concours) {
    echo json_encode([
        "status" => "error",
        "message" => "Concours fermé ou invalide"
    ]);
    exit;
}

$prixVote = (int)$concours['prix_vote'];
$nbVotes  = floor($montant / $prixVote);

if ($nbVotes <= 0) {
    echo json_encode([
        "status" => "error",
        "message" => "Montant insuffisant"
    ]);
    exit;
}

// Générer transaction ID unique
$transaction_id = uniqid("VOTE_");

// Enregistrer paiement en attente
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

// 🔥 APPEL MESOMB
$response = callMesomb($phone, $montant, $transaction_id, $operator);

// Vérification réponse
if (!$response) {
    echo json_encode([
        "status" => "error",
        "message" => "Aucune réponse MeSomb"
    ]);
    exit;
}

// Si MeSomb renvoie une erreur
if (isset($response['success']) && $response['success'] === false) {

    echo json_encode([
        "status" => "error",
        "message" => $response['message'] ?? "Erreur paiement Mobile Money",
        "mesomb_debug" => $response
    ]);
    exit;
}

// Paiement lancé correctement (sera confirmé via webhook)
echo json_encode([
    "status" => "success",
    "message" => "Demande envoyée. Confirmez sur votre téléphone.",
    "transaction_id" => $transaction_id
]);

exit;
?>