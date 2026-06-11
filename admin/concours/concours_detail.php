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
   STATS
========================= */
$sqlStats = "SELECT 
    COUNT(DISTINCT v.id_vote) AS total_votes,
    COUNT(DISTINCT ca.id_candidat) AS total_candidats,
    COUNT(DISTINCT v.id_votant) AS total_votants,
    COALESCE(SUM(p.montant),0) AS revenus
FROM concours c
LEFT JOIN votes v ON v.id_concours = c.id_concours
LEFT JOIN candidats ca ON ca.id_concours = c.id_concours
LEFT JOIN paiements p ON p.id_concours = c.id_concours
WHERE c.id_concours = ?";

$stmt = $pdo->prepare($sqlStats);
$stmt->execute([$id]);
$stats = $stmt->fetch(PDO::FETCH_ASSOC);

/* =========================
   CANDIDATS + VOTES + PHOTO
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
$candidats = $stmt->fetchAll(PDO::FETCH_ASSOC);

/* =========================
   VOTANTS
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
$votants = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <p>
        Organisé par <?= htmlspecialchars($concours['nom_user']) ?> • 
        <?= htmlspecialchars($concours['status_concours']) ?>
    </p>

    <div class="concours-actions">
        <a href="export_txt.php?id_concours=<?= $concours['id_concours'] ?>" class="btn-export">
            <i class="fa fa-file-export"></i> Export TXT
        </a>

        <button class="btn-export">
            <i class="fa fa-chart-line"></i> Statistiques
        </button>

        <?php if ($concours['type_vote'] === 'gratuit'): ?>

        <button class="btn-export" onclick="openModal('modalCandidat')">
            <i class="fa fa-user-plus"></i> Ajouter candidat
        </button>

        <button class="btn-export" onclick="openModal('modalVotant')">
            <i class="fa fa-user"></i> Ajouter votant
        </button>

        <?php endif; ?>
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
                <th>Photo</th>
                <th>Nom</th>
                <th>Votes</th>
                <th>Rank</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>
        <?php foreach($candidats as $c): ?>
            <tr>

                <!-- PHOTO -->
                <td>
                    <img src="../../uploads/candidats/<?= htmlspecialchars($c['photo_candidat'] ?? 'default.png') ?>"
                         style="width:45px;height:45px;border-radius:50%;object-fit:cover;">
                </td>

                <!-- NOM -->
                <td><?= htmlspecialchars($c['nom_candidat']) ?></td>

                <!-- VOTES -->
                <td><?= $c['votes'] ?? 0 ?></td>

                <!-- RANK -->
                <td>#<?= $c['rank'] ?? '-' ?></td>

                <!-- ACTION -->
                <td>
                    <a href="../candidats/candidat_detail.php?id_candidat=<?= $c['id_candidat']; ?>"
                       class="action-btn view">
                        <i class="fa-solid fa-eye"></i>
                    </a>

                    <a href="../candidats/candidat_edit.php?id_candidat=<?= $c['id_candidat']; ?>"
                       class="action-btn edit">
                        <i class="fa-solid fa-pen"></i>
                    </a>

                    <a class="action-btn delete">
                        <i class="fa-solid fa-trash"></i>
                    </a>
                </td>

            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

</div>

<!-- ================= VOTANTS ================= -->
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
                <td><?= htmlspecialchars($v['nom_user']) ?></td>
                <td><?= htmlspecialchars($v['email']) ?></td>
                <td><?= $v['nb_votes'] ?? 0 ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

</div>
<!-- ================= MODAL CANDIDAT ================= -->
<div id="modalCandidat" class="modal">
    <div class="modal-content">

        <div class="modal-header">
            <h2>Ajouter un candidat</h2>
            <p>Remplissez les informations du candidat</p>
        </div>

        <form id="formCandidat" enctype="multipart/form-data">

            <div class="modal-body">

                <input type="hidden" name="id_concours" value="<?= $concours['id_concours'] ?>">

                <div class="form-row">
                    <input type="text" name="nom_candidat" placeholder="Nom" required>
                    <input type="text" name="prenom_candidat" placeholder="Prénom" required>
                </div>

                <input type="email" name="email_candidat" placeholder="Email">

                <textarea name="biography" placeholder="Biographie"></textarea>

                <!-- PHOTO -->
                <label class="file-input">
                    Choisir une photo
                    <input type="file" name="photo_candidat" accept="image/*" hidden required>
                </label>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeModal('modalCandidat')">
                    Annuler
                </button>
                <button type="submit" class="btn-submit">
                    Ajouter
                </button>
            </div>

        </form>

    </div>
</div>


<!-- ================= MODAL VOTANT ================= -->
<div id="modalVotant" class="modal">
    <div class="modal-content">

        <div class="modal-header">
            <h2>Ajouter un votant</h2>
            <p>Créer un nouvel utilisateur votant</p>
        </div>

        <form id="formVotant">

            <div class="modal-body">

                <input type="hidden" name="role_user" value="votant">

                <input type="text" name="nom_user" placeholder="Nom" required>

                <input type="email" name="email" placeholder="Email" required>

                <input type="text" name="numTel" placeholder="Téléphone">

                <input type="password" name="pwd" placeholder="Mot de passe" required>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeModal('modalVotant')">
                    Annuler
                </button>
                <button type="submit" class="btn-submit">
                    Créer
                </button>
            </div>

        </form>

    </div>
</div>

<script>
function openModal(id) {
    const modal = document.getElementById(id);
    if (modal) {
        modal.classList.add("show");
    }
}

function closeModal(id) {
    const modal = document.getElementById(id);
    if (modal) {
        modal.classList.remove("show");
    }
}

/* BONUS : fermer en cliquant sur l’overlay */
document.addEventListener("click", function (e) {
    if (e.target.classList.contains("modal")) {
        e.target.classList.remove("show");
    }
});
</script>
</main>

</body>
</html>