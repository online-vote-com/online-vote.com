<?php
/**
 * WEBHOOK AANGARAA PAY – version corrigée sans payToken
 */

require_once("../config/database.php");

header("Content-Type: application/json");

// --- Lecture du JSON envoyé par Aangaraa ---
$content = file_get_contents("php://input");
$data = json_decode($content, true);

// Vérifier JSON valide
if (!$data) {
    http_response_code(400);
    echo json_encode(["error" => "JSON invalide"]);
    exit;
}

// Récupérer données essentielles
$transaction_id = $data['transaction_id'] ?? null;
$status = strtoupper($data['status'] ?? '');

// --- Log debug ---
$pdo->prepare("INSERT INTO logs_paiement(transaction_id, payload) VALUES (?, ?)")
    ->execute([$transaction_id, $content]);

// Vérifier données requises
if (!$transaction_id || !$status) {
    http_response_code(400);
    echo json_encode(["error" => "Données manquantes"]);
    exit;
}

// Récupérer paiement correspondant
$stmt = $pdo->prepare("SELECT * FROM paiements WHERE transaction_id = ?");
$stmt->execute([$transaction_id]);
$paiement = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$paiement) {
    http_response_code(404);
    echo json_encode(["error" => "Transaction introuvable"]);
    exit;
}

// --- Traitement selon le status ---
switch ($status) {

    case "SUCCESSFUL":
        // Vérifier si paiement déjà validé
        if ($paiement['status_paiement'] === "succes") {
            echo json_encode(["message" => "Paiement déjà validé"]);
            exit;
        }

        // Mettre à jour paiement
        $pdo->prepare("UPDATE paiements SET status_paiement='succes' WHERE transaction_id=?")
            ->execute([$transaction_id]);

        // Ajouter votes seulement si pas déjà ajoutés
        $stmtCheckVotes = $pdo->prepare("SELECT COUNT(*) FROM votes WHERE id_paiement=?");
        $stmtCheckVotes->execute([$paiement['id_paiement']]);
        $votesExistants = (int)$stmtCheckVotes->fetchColumn();

        if ($votesExistants === 0) {
            for ($i = 0; $i < $paiement['quantite_vote']; $i++) {
                $pdo->prepare("
                    INSERT INTO votes (id_candidat, id_concours, id_paiement, source)
                    VALUES (?,?,?,'payant')
                ")->execute([
                    $paiement['id_candidat'],
                    $paiement['id_concours'],
                    $paiement['id_paiement']
                ]);
            }
        }

        break;

    case "FAILED":
        $pdo->prepare("UPDATE paiements SET status_paiement='echec' WHERE transaction_id=?")
            ->execute([$transaction_id]);
        break;

    default:
        // Status inconnu
        http_response_code(400);
        echo json_encode(["error" => "Status inconnu"]);
        exit;
}

// --- Réponse à l’API ---
http_response_code(200);
echo json_encode(["message" => "Webhook reçu et traité"]);

exit;
?>