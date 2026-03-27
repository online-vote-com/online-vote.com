<?php
/**
 * API PAIEMENT MOBILE MONEY
 */

session_start();

require_once("../config/database.php");
require_once("../config/payment_config.php");

header("Content-Type: application/json");

$idVotant = $_SESSION['id_user'] ?? null;

// Empêche l'accès direct sans POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        "status" => "error",
        "message" => "Méthode invalide"
    ]);
    exit;
}

// Lire les données JSON envoyées depuis JS
$data = json_decode(file_get_contents("php://input"), true);

// Vérifier que les données sont valides
if (!$data) {
    echo json_encode([
        "status" => "error",
        "message" => "JSON invalide"
    ]);
    exit;
}

// Vérifier que toutes les données nécessaires sont présentes
if (empty($data['id_candidat']) || empty($data['id_concours']) || empty($data['montant']) || empty($data['phone']) || empty($data['operator'])) {
    echo json_encode([
        "status" => "error",
        "message" => "Données manquantes"
    ]);
    exit;
}

// Caster et nettoyer les données
$idCandidat = (int)$data['id_candidat'];
$idConcours = (int)$data['id_concours'];
$montantInitial = (int)$data['montant'];
$montant = (string)$montantInitial; // AangaraaPay attend une string
$phone = preg_replace('/[^0-9]/', '', $data['phone']);

// Si le numéro commence par 237, garder tel quel
if (substr($phone, 0, 3) !== "237") {
    // vérifier qu’il a 9 chiffres
    if (strlen($phone) === 9) {
        $phone = "237".$phone;
    } else {
        echo json_encode([
            "status"=>"error",
            "message"=>"Numéro de téléphone invalide"
        ]);
        exit;
    }
}

// Vérifier que le numéro fait bien 12 chiffres maintenant
if (strlen($phone) !== 12) {
    echo json_encode([
        "status"=>"error",
        "message"=>"Numéro de téléphone incorrect pour AangaraaPay"
    ]);
    exit;
}
$operator = trim($data['operator']);
$allowedOperators = ["MTN_Cameroon","Orange_Cameroon"];
if (!in_array($operator, $allowedOperators)) {
    echo json_encode([
        "status" => "error",
        "message" => "Opérateur invalide"
    ]);
    exit;
}

// Vérifier que le concours est ouvert
$stmt = $pdo->prepare("SELECT prix_vote FROM concours WHERE id_concours=? AND status_concours='ouvert'");
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

$nbVotes = floor($montant / $prixVote);
if ($nbVotes <= 0) {
    echo json_encode([
        "status" => "error",
        "message" => "Montant insuffisant"
    ]);
    exit;
}

// Générer un transaction_id unique
$transaction_id = "VOTE_".bin2hex(random_bytes(8));

// Enregistrer le paiement en attente
$stmtInsert = $pdo->prepare("
    INSERT INTO paiements
    (transaction_id, montant, quantite_vote, operator, phone_number, status_paiement, id_votant, id_candidat, id_concours)
    VALUES (?,?,?,?,?,'attente',?,?,?)
");
$stmtInsert->execute([
    $transaction_id,
    $montantInitial,
    $nbVotes,
    $operator,
    $phone,
    $idVotant,
    $idCandidat,
    $idConcours
]);

// Appel à AangaraaPay
$response = callAangaraa($phone, $montant, $transaction_id, $operator);

// Vérification de la réponse
if (!$response || !isset($response['statusCode']) || $response['statusCode'] != 201) {
    echo json_encode([
        "status" => "error",
        "message" => $response['message'] ?? "Erreur paiement",
        "debug" => $response
    ]);
    exit;
}

// Récupérer le payToken pour suivi
$payToken = $response['data']['payToken'] ?? null;

// Réponse au frontend
echo json_encode([
    "status" => "success",
    "message" => "Demande envoyée. Confirmez sur votre téléphone.",
    "transaction_id" => $transaction_id,
    "payToken" => $payToken
]);
exit;
?>