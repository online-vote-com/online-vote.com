<?php

require_once("../config/database.php");

$content = file_get_contents("php://input");
$data = json_decode($content, true);

/* Log brut */
$pdo->prepare("
    INSERT INTO logs_paiement(transaction_id, payload)
    VALUES(?,?)
")->execute([
    $data['externalReference'] ?? null,
    $content
]);

if (!isset($data['externalReference'], $data['status'])) {
    http_response_code(400);
    exit;
}

$transaction_id = $data['externalReference'];
$status = strtoupper($data['status']);

if ($status === "SUCCESS") {

    $stmt = $pdo->prepare("
        SELECT * FROM paiements 
        WHERE transaction_id=?
    ");
    $stmt->execute([$transaction_id]);
    $paiement = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$paiement || $paiement['status_paiement'] === 'succes') {
        exit;
    }

    /* Mettre en succès */
    $pdo->prepare("
        UPDATE paiements
        SET status_paiement='succes'
        WHERE transaction_id=?
    ")->execute([$transaction_id]);

    /* Ajouter les votes */
    for ($i=0; $i < $paiement['quantite_vote']; $i++) {

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

http_response_code(200);

?>