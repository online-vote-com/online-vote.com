<?php
include __DIR__ . '/../../config/database.php';
include __DIR__ . '/../../includes/link.php';

$id = $_GET['id_concours'] ?? null;

if (!$id) {
    die("Concours introuvable");
}

/* =========================
   CONCOURS INFO
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
   STATS CORRIGÉES
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
            c.*,
            COUNT(v.id_vote) AS votes
        FROM candidats c
        LEFT JOIN votes v ON v.id_candidat = c.id_candidat
        WHERE c.id_concours = ?
        GROUP BY c.id_candidat";

$stmt = $pdo->prepare($sqlC);
$stmt->execute([$id]);
$candidats = $stmt->fetchAll();

/* =========================
   VOTANTS (via users + votes)
========================= */
$sqlV = "SELECT 
            u.nom_user,
            u.email,
            COUNT(v.id_vote) AS nb_votes
        FROM votes v
        JOIN users u ON u.id_user = v.id_votant
        WHERE v.id_concours = ?
        GROUP BY v.id_votant";

$stmt = $pdo->prepare($sqlV);
$stmt->execute([$id]);
$votants = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Détail Concours</title>
<link rel="stylesheet" href="../../assets/css/admin-detailconcours.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>

<main class="main-content">

<!-- ================= HERO ================= -->
<div class="concours-hero">
    <h1><?= htmlspecialchars($concours['titre']) ?></h1>
    <p>Organisé par <?= htmlspecialchars($concours['nom_user']) ?> • <?= $concours['status_concours'] ?></p>

    <div class="concours-actions">
        <a href="export_txt.php?id_concours=<?= $concours['id_concours'] ?>" class="btn-export">
             <i class="fa fa-file-export"></i> Export TXT
        </a>
        <button class="btn-export"><i class="fa fa-chart-line"></i> Statistiques</button>
    </div>
</div>

<!-- ================= STATS ================= -->
<div class="stats-grid">

    <div class="stat-card">
        <div class="stat-title">Votes total</div>
        <div class="stat-value"><?= $stats['total_votes'] ?? 0 ?></div>
        <div class="stat-sub">Votes enregistrés</div>
    </div>

    <div class="stat-card">
        <div class="stat-title">Candidats</div>
        <div class="stat-value"><?= $stats['total_candidats'] ?? 0 ?></div>
        <div class="stat-sub">Participants</div>
    </div>

    <div class="stat-card">
        <div class="stat-title">Votants</div>
        <div class="stat-value"><?= $stats['total_votants'] ?? 0 ?></div>
        <div class="stat-sub">Utilisateurs actifs</div>
    </div>

    <div class="stat-card">
        <div class="stat-title">Revenus</div>
        <div class="stat-value">
            <?= number_format($stats['revenus'] ?? 0, 0, ',', ' ') ?> FCFA
        </div>
        <div class="stat-sub">Total généré</div>
    </div>

</div>

<!-- ================= CANDIDATS ================= -->
<div class="section-box">

    <div class="section-header">
        <h3>Candidats</h3>
    </div>

    <table>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Votes</th>
                <th>Rank</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>
        <?php foreach($candidats as $c): ?>
            <tr>
                <td><?= htmlspecialchars($c['nom_candidat']) ?></td>
                <td><?= $c['votes'] ?? 0 ?></td>
                <td>#<?= $c['rank'] ?? '-' ?></td>
                <td>
                    <a href="../candidats/candidat_detail.php?id_candidat=<?= $con['id_candidat']; ?>" class="action-btn view">
                        <i class="fa-solid fa-eye"></i>
                    </a>
                    <a href="../candidats/candidat_edit.php?id_candidat=<?= $c['id_candidat']; ?>" class="action-btn edit">
                        <i class="fa-solid fa-pen"></i>
                    </a>
                    <a class="action-btn delete"><i class="fa-solid fa-trash"></i></a>                    
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

</div>

<!-- ================= VOTANTS ================= -->
 <!--
<div class="section-box">

    <div class="section-header">
        <h3>Votants</h3>
    </div>

    <table>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Email</th>
                <th>Votes donnés</th>
            </tr>
        </thead>

        <tbody>
        <?php foreach($votants as $v): ?>
            <tr>
                <td><?= htmlspecialchars($v['nom']) ?></td>
                <td><?= htmlspecialchars($v['email']) ?></td>
                <td><?= $v['nb_votes'] ?? 0 ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

</div>
        -->
</main>

</body>
</html>