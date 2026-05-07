<?php
include __DIR__ . '/../../config/database.php';

$id = $_GET['id_concours'] ?? null;

if (!$id) {
    die("Concours introuvable");
}

/* =========================
   INFOS CONCOURS
========================= */
$sql = "SELECT c.*, u.nom_user
        FROM concours c
        JOIN users u ON c.id_organisateur = u.id_user
        WHERE c.id_concours = ?";

$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);

$concours = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$concours) {
    die("Concours non trouvé");
}

/* =========================
   STATS
========================= */
$sqlStats = "SELECT 
    COUNT(DISTINCT v.id_vote) AS total_votes,
    COUNT(DISTINCT ca.id_candidat) AS total_candidats,
    COUNT(DISTINCT p.id_votant) AS total_votants,
    SUM(p.montant) AS revenus
FROM concours c
LEFT JOIN votes v ON v.id_concours = c.id_concours
LEFT JOIN candidats ca ON ca.id_concours = c.id_concours
LEFT JOIN paiements p ON p.id_concours = c.id_concours
WHERE c.id_concours = ?";

$stmt = $pdo->prepare($sqlStats);
$stmt->execute([$id]);

$stats = $stmt->fetch(PDO::FETCH_ASSOC);

/* =========================
   CANDIDATS + VOTES
========================= */
$sqlC = "SELECT 
            c.nom_candidat,
            c.prenom_candidat,
            COUNT(v.id_vote) AS total_votes
        FROM candidats c
        LEFT JOIN votes v ON v.id_candidat = c.id_candidat
        WHERE c.id_concours = ?
        GROUP BY c.id_candidat
        ORDER BY total_votes DESC";

$stmt = $pdo->prepare($sqlC);
$stmt->execute([$id]);

$candidats = $stmt->fetchAll(PDO::FETCH_ASSOC);

/* =========================
   GENERATION TXT
========================= */

$contenu = "";
$contenu .= "=====================================\n";
$contenu .= "      RAPPORT DU CONCOURS\n";
$contenu .= "=====================================\n\n";

$contenu .= "Titre : " . $concours['titre'] . "\n";
$contenu .= "Description : " . $concours['description_concours'] . "\n";
$contenu .= "Organisateur : " . $concours['nom_user'] . "\n";
$contenu .= "Type de vote : " . $concours['type_vote'] . "\n";
$contenu .= "Prix vote : " . $concours['prix_vote'] . " FCFA\n";
$contenu .= "Statut : " . $concours['status_concours'] . "\n";
$contenu .= "Date début : " . $concours['date_debut'] . "\n";
$contenu .= "Date fin : " . $concours['date_fin'] . "\n\n";

$contenu .= "=====================================\n";
$contenu .= "STATISTIQUES\n";
$contenu .= "=====================================\n";

$contenu .= "Total votes : " . ($stats['total_votes'] ?? 0) . "\n";
$contenu .= "Total candidats : " . ($stats['total_candidats'] ?? 0) . "\n";
$contenu .= "Total votants : " . ($stats['total_votants'] ?? 0) . "\n";
$contenu .= "Revenus : " . number_format($stats['revenus'] ?? 0, 0, ',', ' ') . " FCFA\n\n";

$contenu .= "=====================================\n";
$contenu .= "CLASSEMENT DES CANDIDATS\n";
$contenu .= "=====================================\n\n";

$rang = 1;

foreach ($candidats as $c) {

    $contenu .= $rang . ". ";
    $contenu .= $c['nom_candidat'] . " ";
    $contenu .= $c['prenom_candidat'];
    $contenu .= " => ";
    $contenu .= $c['total_votes'] . " vote(s)\n";

    $rang++;
}

/* =========================
   TELECHARGEMENT TXT
========================= */

$filename = "rapport_concours_" . $id . " : " .$concours['titre']. ".txt";

header('Content-Type: text/plain');
header('Content-Disposition: attachment; filename="' . $filename . '"');

echo $contenu;
exit;
?>