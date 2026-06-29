<?php
session_start();

if (!isset($_SESSION['id_user'])) {
    header("Location: ../login.php");
    exit;
}

include '../includes/link.php'; 
include '../config/database.php';


$id_user = $_SESSION['id_user'];
$role = $_SESSION['role'];

if($role === 'votant'){
    header("Location: ../profil_user.php");
    exit;
}

$isAdmin = ($role === 'admin');
$isOrg   = ($role === 'organisateur');


/* =========================
   FILTRE GLOBAL CONCOURS
========================= */
$whereConcours = "";
$wherePaiements = "";
$params = [];

if ($isOrg) {
    $whereConcours = "WHERE con.id_organisateur = :id_org";
    $wherePaiements = "WHERE c.id_organisateur = :id_org";
    $params[':id_org'] = $id_user;
}

/* =========================
   1. TOTAL CONCOURS
========================= */
$sqlCon = "SELECT COUNT(*) FROM concours con $whereConcours";
$pdo_sta = $pdo->prepare($sqlCon);
$pdo_sta->execute($params);
$nbrConcours = $pdo_sta->fetchColumn();


/* =========================
   2. LISTE CONCOURS
========================= */
$sql_concours = "
SELECT 
    con.*,
    org.nom_user,

    COUNT(DISTINCT v.id_vote) AS votes_count,

    COALESCE(SUM(CASE WHEN p.status_paiement = 'succes' THEN p.montant ELSE 0 END),0) AS revenus_bruts,

    COALESCE(SUM(CASE WHEN p.status_paiement = 'succes' THEN p.montant ELSE 0 END) * 0.95,0) AS revenus_generes

FROM concours con
JOIN users org ON con.id_organisateur = org.id_user
LEFT JOIN votes v ON v.id_concours = con.id_concours
LEFT JOIN paiements p ON p.id_concours = con.id_concours

$whereConcours
GROUP BY con.id_concours
";

$stmt_concours = $pdo->prepare($sql_concours);
$stmt_concours->execute($params);
$concours = $stmt_concours->fetchAll(PDO::FETCH_ASSOC);


/* =========================
   3. KPI STATUT CONCOURS
========================= */
$sql = "
SELECT 
    SUM(status_concours = 'ouvert') AS ouverts,
    SUM(status_concours = 'attente') AS attente,
    SUM(status_concours = 'ferme') AS fermes
FROM concours con
$whereConcours
";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);

$kpi_status = $stmt->fetch(PDO::FETCH_ASSOC) ?: [
    'ouverts' => 0,
    'attente' => 0,
    'fermes'  => 0
];


/* =========================
   4. TOTAL VOTES
========================= */
$sqlVotes = "
SELECT COUNT(v.id_vote)
FROM votes v
JOIN concours c ON v.id_concours = c.id_concours
";

if ($isOrg) {
    $sqlVotes .= " WHERE c.id_organisateur = :id_org";
    $stmtVotes = $pdo->prepare($sqlVotes);
    $stmtVotes->execute([':id_org' => $id_user]);
} else {
    $stmtVotes = $pdo->prepare($sqlVotes);
    $stmtVotes->execute();
}

$totalVotes = $stmtVotes->fetchColumn();


/* =========================
   5. NOMBRE CANDIDATS
========================= */
$sql = "SELECT COUNT(*) FROM candidats";

if ($isOrg) {
    $sql .= " WHERE id_organisateur = :id_org";
    $stmtC = $pdo->prepare($sql);
    $stmtC->execute([':id_org' => $id_user]);
} else {
    $stmtC = $pdo->prepare($sql);
    $stmtC->execute();
}

$nbrC = $stmtC->fetchColumn();


/* =========================
   6. TOTAL PAIEMENTS
========================= */
$sqlP = "
SELECT COALESCE(SUM(p.montant),0)
FROM paiements p
JOIN concours c ON p.id_concours = c.id_concours
WHERE p.status_paiement = 'succes'
";

if ($isOrg) {
    $sqlP .= " AND c.id_organisateur = :id_org";
    $stmtP = $pdo->prepare($sqlP);
    $stmtP->execute([':id_org' => $id_user]);
} else {
    $stmtP = $pdo->prepare($sqlP);
    $stmtP->execute();
}

$total_P = $stmtP->fetchColumn();


/* =========================
   7. STATS GLOBAL
========================= */
$query = "
SELECT 
    COALESCE(SUM(c.prix_vote) * 0.95,0) AS revenus_nets,
    COUNT(DISTINCT v.id_vote) AS votants_actifs,
    SUM(CASE WHEN DATE(v.date_vote) = CURDATE() THEN 1 ELSE 0 END) AS votes_aujourdhui
FROM votes v
JOIN concours c ON v.id_concours = c.id_concours
";

if ($isOrg) {
    $query .= " WHERE c.id_organisateur = :id_org";
    $stmtStats = $pdo->prepare($query);
    $stmtStats->execute([':id_org' => $id_user]);
} else {
    $stmtStats = $pdo->prepare($query);
    $stmtStats->execute();
}

$stats = $stmtStats->fetch(PDO::FETCH_ASSOC) ?: [
    'revenus_nets' => 0,
    'votants_actifs' => 0,
    'votes_aujourdhui' => 0
];


/* =========================
   8. TOP CONCOURS (CORRIGÉ MYSQL STRICT)
========================= */
$queryTC = "
SELECT 
    c.id_concours,
    c.titre,
    COUNT(v.id_vote) AS total_votes
FROM concours c
LEFT JOIN votes v ON v.id_concours = c.id_concours
";

if ($isOrg) {
    $queryTC .= " WHERE c.id_organisateur = ? ";
}

$queryTC .= "
GROUP BY c.id_concours, c.titre
ORDER BY total_votes DESC
LIMIT 5
";

$stmt = $pdo->prepare($queryTC);
$stmt->execute($isOrg ? [$id_user] : []);
$topConcours = $stmt->fetchAll(PDO::FETCH_ASSOC);


/* =========================
   KPI TRANSACTIONS
========================= */
$sqlKpi = "
SELECT 
    COUNT(p.id_paiement) AS total_transactions,
    COALESCE(SUM(p.montant),0) AS total_montant,
    SUM(p.status_paiement = 'succes') AS succes,
    SUM(p.status_paiement = 'echec') AS echoue
FROM paiements p
JOIN concours c ON p.id_concours = c.id_concours
$wherePaiements
";

$stmt = $pdo->prepare($sqlKpi);
$stmt->execute($params);
$kpi = $stmt->fetch(PDO::FETCH_ASSOC);

/* =========================
   LISTE TRANSACTIONS
========================= */
$sql = "
SELECT 
    p.*,
    c.titre AS concours_titre
FROM paiements p
JOIN concours c ON p.id_concours = c.id_concours
$wherePaiements
ORDER BY p.id_paiement DESC
";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$transactions = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>