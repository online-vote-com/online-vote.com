<?php
 session_start();

if (!isset($_SESSION['id_user'])) {
    header("Location: ../../login.php");
    exit;
}

include __DIR__ . '/../../config/database.php';
include __DIR__ . '/../../includes/link.php';

$id = $_GET['id_concours'] ?? null;

if (!$id) {
    die("Concours introuvable");
}

$id_user = $_SESSION['id_user'];
$role = $_SESSION['role'];

if($role === 'votant'){
    header("Location: ../../profil_user.php");
    exit;
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
    COUNT(v.id_vote) AS votes,

    -- pourcentage
    ROUND(
        (COUNT(v.id_vote) / NULLIF(t.total_votes, 0)) * 100, 
        2
    ) AS pourcentage

FROM candidats c

LEFT JOIN votes v 
    ON v.id_candidat = c.id_candidat

LEFT JOIN (
    SELECT id_concours, COUNT(*) AS total_votes
    FROM votes
    WHERE id_concours = ?
    GROUP BY id_concours
) t ON t.id_concours = c.id_concours

WHERE c.id_concours = ?

GROUP BY c.id_candidat

ORDER BY votes DESC";

$stmt = $pdo->prepare($sqlC);
$stmt->execute([$id, $id]);
$candidats = $stmt->fetchAll(PDO::FETCH_ASSOC);

/* =========================
   VOTANTS
========================= */
$sqlV = "
SELECT 
    u.id_user,
    u.nom_user,
    u.email,

    -- nombre de votes donnés
    COUNT(v.id_vote) AS nb_votes,

    -- statut vote
    CASE 
        WHEN COUNT(v.id_vote) > 0 THEN 'Déjà voté'
        ELSE 'Pas encore voté'
    END AS statut_vote

FROM concours_votants cv
JOIN users u ON u.id_user = cv.id_votant
LEFT JOIN votes v 
    ON v.id_votant = u.id_user 
    AND v.id_concours = cv.id_concours

WHERE cv.id_concours = ?

GROUP BY u.id_user
";

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
<link rel="stylesheet" href="../../assets/css/color.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

</head>

<body>

<main class="main-content">

<!-- ================= HERO ================= -->
<div class="concours-hero" style="background-image:
        linear-gradient(135deg,
            rgba(83,2,116,.92),
            rgba(156,4,218,.78)),
        url('uploads/concours/<?= htmlspecialchars($concours['photo_concours']) ?>');">
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

      

        <button class="btn-export" onclick="openModal('modalCandidat')">
            <i class="fa fa-user-plus"></i> Ajouter candidat
        </button>
            <?php if ($concours['type_vote'] === 'gratuit'): ?>
                <button class="btn-export" onclick="openModal('modalVotant')">
                    <i class="fa fa-user"></i> Ajouter votant
                </button>
            <?php endif; ?>
            <?php if (isset($_SESSION['message'])): ?>
    <div class="alert-success">
        <?= $_SESSION['message']; ?>
    </div>
    <?php unset($_SESSION['message']); ?>
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
<?php if ($concours['type_vote'] !== 'gratuit'): ?>
    <div class="stat-card">
        <div class="stat-title">Revenus</div>
        <div class="stat-value">
            <?= number_format($stats['revenus'] ?? 0, 0, ',', ' ') ?> FCFA
        </div>
        <div class="stat-sub">Total généré</div>
    </div>
    <?php endif; ?>

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
                <th>%</th>
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
                <td><?= $c['pourcentage'] ?? 0 ?> %</td>

                <!-- ACTION -->
                <td>
<a href="javascript:void(0)"
   onclick='editCandidat(<?= htmlspecialchars(json_encode($c), ENT_QUOTES, "UTF-8") ?>)'
   class="action-btn view">
   <i class="fa fa-eye"></i>
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
                <td>
    <?php if ($v['statut_vote'] === 'Déjà voté'): ?>
        <span style="color:green;font-weight:bold;">Déjà voté</span>
    <?php else: ?>
        <span style="color:red;font-weight:bold;">0</span>
    <?php endif; ?>
</td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

</div>
<!-- ================= MODAL CANDIDAT ================= -->
<div id="modalCandidat" class="modal">
    <div class="modal-content">

        <div class="modal-header">
            <h2 id="candidat_title">Ajouter un candidat</h2>
        </div>

        <form id="formCandidat" action="add_candidat.php" method="POST" enctype="multipart/form-data">

            <input type="hidden" name="id_candidat" id="id_candidat">
            <input type="hidden" name="id_concours" value="<?= $concours['id_concours'] ?>">

            <div class="modal-body">

                <input type="text" name="nom_candidat" id="nom_candidat" placeholder="Nom" required>
                <input type="text" name="prenom_candidat" id="prenom_candidat" placeholder="Prénom" required>
                <input type="email" name="email_candidat" id="email_candidat" placeholder="Email">
                
                <textarea name="biography" id="biography" placeholder="Biographie"></textarea>

                <label class="file-input">
                    Photo
                    <input type="file" name="photo_candidat" id="photo_candidat">
                </label>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeModal('modalCandidat')">
                    Annuler
                </button>
                <button type="submit" id="submit_btn" class="btn-submit">
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

        <form id="formVotant" action="add_votant.php" method="POST">

            <input type="hidden" name="id_concours" value="<?= $concours['id_concours'] ?>">

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
document.addEventListener("DOMContentLoaded", () => {

    window.openModal = function(id) {
        const modal = document.getElementById(id);
        if (modal) modal.classList.add("show");
    };

    window.closeModal = function(id) {
        const modal = document.getElementById(id);
        if (modal) modal.classList.remove("show");
    };

    // fermer clic extérieur
    document.querySelectorAll(".modal").forEach(modal => {
        modal.addEventListener("click", (e) => {
            if (e.target === modal) modal.classList.remove("show");
        });
    });

    // RESET / OPEN ADD
    window.openCandidat = function() {

        openModal("modalCandidat");

        document.getElementById("candidat_title").innerText = "Ajouter un candidat";

        document.getElementById("formCandidat").action = "add_candidat.php";

        document.getElementById("id_candidat").value = "";
        document.getElementById("nom_candidat").value = "";
        document.getElementById("prenom_candidat").value = "";
        document.getElementById("email_candidat").value = "";
        document.getElementById("biography").value = "";
    };

    // EDIT + PREFILL
    window.editCandidat = function(data) {

        openModal("modalCandidat");

        document.getElementById("candidat_title").innerText = "Modifier candidat";

        document.getElementById("formCandidat").action = "update_candidat.php";

        document.getElementById("id_candidat").value = data.id_candidat;
        document.getElementById("nom_candidat").value = data.nom_candidat;
        document.getElementById("prenom_candidat").value = data.prenom_candidat;
        document.getElementById("email_candidat").value = data.email_candidat;
        document.getElementById("biography").value = data.biography;
    };

});
</script>
</main>

</body>
</html>