<?php
session_start();
include 'config/database.php';
if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit;
}

$role = $_SESSION['role_user'] ?? 'votant';
$success = $_SESSION['success'] ?? null;
$error = $_SESSION['error'] ?? null;

unset($_SESSION['success'], $_SESSION['error']);
/*
    ROUTAGE DES DASHBOARDS
*/
if ($role !== 'votant') {
    header("Location: admin/dash");
    exit;
}

include 'includes/link.php';
include 'includes/navbar.php';


// sécurisation session
$idUser = $_SESSION['id_user'] ?? null;

$mesConcours = [];
$totalVotes = 0;
$totalPaiements = 0;

if ($idUser) {

    // Votes
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM votes WHERE id_votant = ?");
    $stmt->execute([$idUser]);
    $totalVotes = $stmt->fetchColumn();

    // Paiements
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM paiements WHERE id_votant = ?");
    $stmt->execute([$idUser]);
    $totalPaiements = $stmt->fetchColumn();

    // Concours rejoints
$stmt = $pdo->prepare("
    SELECT c.*
    FROM concours c
    INNER JOIN concours_votants vc 
        ON vc.id_concours = c.id_concours
    WHERE vc.id_votant = :id
");

$stmt->execute([
    ':id' => $idUser
]);
    $mesConcours = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<link rel="stylesheet" href="assets/css/profil_user.css">
<link rel="stylesheet" href="assets/css/color.css">

<?php if ($success): ?>
    <div class="alert success">
        <?= htmlspecialchars($success) ?>
    </div>
<?php endif; ?>

<?php if ($error): ?>
    <div class="alert error">
        <?= htmlspecialchars($error) ?>
    </div>
<?php endif; ?>

<link rel="stylesheet" href="assets/css/profil_user.css">
<link rel="stylesheet" href="assets/css/color.css">

<div class="dashboard">

    <!-- ================= LEFT ================= -->
    <div class="dash-left">

        <!-- KPI -->
        <div class="kpi-grid">

            <div class="kpi-card">
                <h3><?= $totalVotes ?></h3>
                <span class="kpi-label">Votes</span>
            </div>

            <div class="kpi-card">
                <h3><?= $totalPaiements ?></h3>
                <span class="kpi-label">Transactions</span>
            </div>

        </div>

        <!-- CONCOURS -->
        <div class="section-title">
            <h2>Mes concours</h2>
            <p>Accès rapide à vos participations</p>
        </div>

        <div class="contest-list">

            <?php if (empty($mesConcours)): ?>
                <div class="empty-state">
                    Aucun concours rejoint
                </div>
            <?php else: ?>

                <?php foreach ($mesConcours as $c): ?>
                    <div class="contest-card-mini">

                        <div class="contest-info">
                            <h4><?= htmlspecialchars($c['titre']) ?></h4>

                        </div>

                        <a href="concours_detail.php?id_concours=<?= (int)$c['id_concours'] ?>"
                           class="btn-mini">
                            Accéder
                        </a>

                    </div>
                <?php endforeach; ?>

            <?php endif; ?>

        </div>

    </div>

    <!-- ================= RIGHT ================= -->
    <div class="dash-right">

        <div class="section-title">
            <h2>Mon profil</h2>
            <p>Gestion de vos informations personnelles</p>
        </div>

        <div class="form-card">

            <form action="update_profile.php" method="POST" enctype="multipart/form-data">

                <!-- PHOTO -->
                <div class="profile-upload">

                    <img src="uploads/<?= htmlspecialchars($_SESSION['photo'] ?? 'default.png') ?>"
                         class="profile-preview">

                    <input type="file" name="photo">
                </div>

                <!-- INFOS -->
                <div class="form-grid">

                    <input type="text" name="nom"
                           value="<?= htmlspecialchars($_SESSION['nom'] ?? '') ?>"
                           placeholder="Nom">

                    <input type="text" name="prenom"
                           value="<?= htmlspecialchars($_SESSION['prenom'] ?? '') ?>"
                           placeholder="Prénom">

                    <input type="email" name="email"
                           value="<?= htmlspecialchars($_SESSION['mail'] ?? '') ?>"
                           placeholder="Email">

                    <input type="password" name="old_password"
                           placeholder="Ancien mot de passe">

                    <input type="password" name="new_password"
                           placeholder="Nouveau mot de passe">

                </div>

                <button class="btn-primary" type="submit">
                    Mettre à jour
                </button>

            </form>

        </div>

        <a href="become_organisateur.php" class="btn-soft">
            Devenir organisateur
        </a>

        <a href="logout.php" class="btn-soft danger">
            Déconnexion
        </a>

    </div>

</div>



<?php 

include 'includes/footer.php'; 
?> 