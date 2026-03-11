<?php

/**
 * WEBHOOK AANGARAA PAY
 */

require_once("../config/database.php");

header("Content-Type: application/json");

/*
SECURITE OPTIONNELLE
IP whitelist
*/
/*
$ip = $_SERVER['REMOTE_ADDR'];

if($ip !== "IP_SERVEUR_AANGARAA"){
    http_response_code(403);
    exit;
}
*/


// Lire le JSON envoyé par Aangaraa
$content = file_get_contents("php://input");
$data = json_decode($content, true);


// Vérifier JSON valide
if (!$data) {
    http_response_code(400);
    echo json_encode(["error" => "JSON invalide"]);
    exit;
}


// récupérer données
$transaction_id = $data['transaction_id'] ?? null;
$status = strtoupper($data['status'] ?? '');


// log debug
$pdo->prepare("
    INSERT INTO logs_paiement(transaction_id, payload)
    VALUES (?, ?)
")->execute([
    $transaction_id,
    $content
]);


// vérifier données
if (!$transaction_id || !$status) {
    http_response_code(400);
    echo json_encode(["error" => "Données manquantes"]);
    exit;
}


// récupérer paiement
$stmt = $pdo->prepare("
    SELECT * FROM paiements 
    WHERE transaction_id = ?
");

$stmt->execute([$transaction_id]);

$paiement = $stmt->fetch(PDO::FETCH_ASSOC);


if (!$paiement) {

    http_response_code(404);

    echo json_encode([
        "error" => "Transaction introuvable"
    ]);

    exit;
}


// paiement réussi
if ($status === "SUCCESSFUL") {

    if ($paiement['status_paiement'] === "succes") {

        echo json_encode([
            "message" => "Paiement déjà validé"
        ]);

        exit;
    }

    // update paiement
    $pdo->prepare("
        UPDATE paiements
        SET status_paiement='succes'
        WHERE transaction_id=?
    ")->execute([$transaction_id]);


    // ajouter votes
    for ($i = 0; $i < $paiement['quantite_vote']; $i++) {

        $pdo->prepare("
            INSERT INTO votes
            (id_candidat,id_concours,id_paiement,source)
            VALUES (?,?,?,'payant')
        ")->execute([
            $paiement['id_candidat'],
            $paiement['id_concours'],
            $paiement['id_paiement']
        ]);
    }
}


// paiement échoué
if ($status === "FAILED") {

    $pdo->prepare("
        UPDATE paiements
        SET status_paiement='echec'
        WHERE transaction_id=?
    ")->execute([$transaction_id]);
}


http_response_code(200);

echo json_encode([
    "message" => "Webhook reçu"
]);

exit;

?>