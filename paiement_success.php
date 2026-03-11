<?php
require_once("config/database.php");

$transaction_id = $_GET['transaction_id'] ?? null;

$stmt = $pdo->prepare("SELECT status_paiement FROM paiements WHERE transaction_id=?");
$stmt->execute([$transaction_id]);
$paiement = $stmt->fetch();

if (!$paiement) {
    die("Transaction invalide");
}

if ($paiement['status_paiement'] === 'succes') {
    echo "<h2>Paiement confirmé </h2>";
} else {
    echo "<h2>Paiement en attente </h2>";
}
?>