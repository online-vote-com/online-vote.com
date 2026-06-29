<?php
require_once __DIR__ . '/../../vendor/autoload.php';
include __DIR__ . '/../../config/database.php';

use Dompdf\Dompdf;
use Dompdf\Options;

$id = $_GET['id_concours'] ?? null;

if (!$id) {
    die("Concours introuvable");
}

/* =========================
   CONCOURS
========================= */
$stmt = $pdo->prepare("
SELECT c.*, u.nom_user
FROM concours c
JOIN users u ON u.id_user = c.id_organisateur
WHERE c.id_concours = ?
");
$stmt->execute([$id]);
$concours = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$concours) {
    die("Concours introuvable");
}

/* =========================
   STATS
========================= */
$stmt = $pdo->prepare("
SELECT 
    COUNT(DISTINCT v.id_vote) AS total_votes,
    COUNT(DISTINCT ca.id_candidat) AS total_candidats,
    COUNT(DISTINCT p.id_votant) AS total_votants,
    COALESCE(SUM(p.montant),0) AS revenus
FROM concours c
LEFT JOIN votes v ON v.id_concours = c.id_concours
LEFT JOIN candidats ca ON ca.id_concours = c.id_concours
LEFT JOIN paiements p ON p.id_concours = c.id_concours
WHERE c.id_concours = ?
");
$stmt->execute([$id]);
$stats = $stmt->fetch(PDO::FETCH_ASSOC);

/* =========================
   CANDIDATS
========================= */
$stmt = $pdo->prepare("
SELECT 
    c.nom_candidat,
    c.prenom_candidat,
    COUNT(v.id_vote) AS total_votes
FROM candidats c
LEFT JOIN votes v ON v.id_candidat = c.id_candidat
WHERE c.id_concours = ?
GROUP BY c.id_candidat
ORDER BY total_votes DESC
");
$stmt->execute([$id]);
$candidats = $stmt->fetchAll(PDO::FETCH_ASSOC);

/* =========================
   VIEW HTML
========================= */
ob_start();
include "../../pdf/rapport.php";
$html = ob_get_clean();

/* =========================
   DOMPDF
========================= */
$options = new Options();
$options->set('isRemoteEnabled', true);

$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

$dompdf->stream("rapport_concours.pdf", ["Attachment" => true]);

?>