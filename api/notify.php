<?php

/**
 * WEBHOOK MESOMB - PRODUCTION READY
 */

require_once("../config/database.php");

header("Content-Type: application/json");

// Lire contenu brut
$content = file_get_contents("php://input");
$data = json_decode($content, true);

// Sécurité : vérifier JSON valide
if (!$data) {
    http_response_code(400);
    echo json_encode(["error" => "JSON invalide"]);
    exit;
}

// Log complet pour debug
$pdo->prepare("
    INSERT INTO logs_paiement(transaction_id, payload)
    VALUES(?, ?)
")->execute([
    $data['externalReference'] ?? null,
    $content
]);

// Vérifier champs obligatoires
if (!isset($data['externalReference'], $data['status'])) {
    http_response_code(400);
    echo json_encode(["error" => "Données manquantes"]);
    exit;
}

$transaction_id = $data['externalReference'];
$status         = strtoupper($data['status']);

// Récupérer paiement
$stmt = $pdo->prepare("
    SELECT * FROM paiements WHERE transaction_id = ?
");
$stmt->execute([$transaction_id]);
$paiement = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$paiement) {
    http_response_code(404);
    echo json_encode(["error" => "Transaction introuvable"]);
    exit;
}

// 🔥 SUCCESS
if ($status === "SUCCESS") {

    // Protection anti double validation
    if ($paiement['status_paiement'] === 'succes') {
        echo json_encode(["message" => "Déjà validé"]);
        exit;
    }

    // Mettre paiement en succès
    $pdo->prepare("
        UPDATE paiements 
        SET status_paiement = 'succes'
        WHERE transaction_id = ?
    ")->execute([$transaction_id]);

    // Ajouter les votes
    for ($i = 0; $i < $paiement['quantite_vote']; $i++) {

        $pdo->prepare("
            INSERT INTO votes 
            (id_candidat, id_concours, id_paiement, source) 
            VALUES (?, ?, ?, 'payant')
        ")->execute([
            $paiement['id_candidat'],
            $paiement['id_concours'],
            $paiement['id_paiement']
        ]);
    }
}

// ❌ FAILED
if ($status === "FAILED") {

    $pdo->prepare("
        UPDATE paiements 
        SET status_paiement = 'echec'
        WHERE transaction_id = ?
    ")->execute([$transaction_id]);
}

http_response_code(200);
echo json_encode(["message" => "Webhook reçu"]);
exit;
?>