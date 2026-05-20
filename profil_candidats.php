<?php
/**
 * PAGE PROFIL CANDIDAT
 * - Affiche candidat
 * - Gère vote gratuit (auth requis)
 * - Vote payant via API AJAX
 */

session_start();

require 'config/database.php';

if (!isset($_GET['id_candidat']) || !is_numeric($_GET['id_candidat'])) {
    die("Candidat invalide.");
}

$idC = (int) $_GET['id_candidat'];

/* Récupération candidat + concours*/
$sql = "
    SELECT con.*, can.* 
    FROM concours con
    JOIN candidats can ON can.id_concours = con.id_concours
    WHERE can.id_candidat = ?
";

$stmt = $pdo->prepare($sql);
$stmt->execute([$idC]);
$candidat = $stmt->fetch();

if (!$candidat) {
    die("Candidat introuvable.");
}

/* Compteur total votes*/
$stmtVote = $pdo->prepare("
    SELECT COUNT(*) FROM votes WHERE id_candidat = ?
");
$stmtVote->execute([$idC]);
$voteCount = $stmtVote->fetchColumn();

$message = "";

/**
 * ==================================================
 *  GESTION VOTE GRATUIT UNIQUEMENT
 * ==================================================
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['vote_gratuit'])) {

    if (!isset($_SESSION['id_user'])) {
        header("Location: login.php");
        exit;
    }

    $idVotant = $_SESSION['id_user'];
    $idConc = $candidat['id_concours'];
    $ip = $_SERVER['REMOTE_ADDR'];

    // Vérifier si déjà voté pour ce concours
    $check = $pdo->prepare("
        SELECT COUNT(*) 
        FROM votes 
        WHERE id_votant=? 
        AND id_concours=? 
        AND source='gratuit'
    ");
    $check->execute([$idVotant, $idConc]);

    //if ($check->fetchColumn() > 0 && $_SESSION['role'] === 'votant') 
    if ($check->fetchColumn() > 0) {
        $message = "<p style='color:red'>Vous avez déjà voté.</p>";
    } else {

        $insert = $pdo->prepare("
            INSERT INTO votes 
            (id_candidat, id_concours, id_votant, source, adr_ip)
            VALUES (?, ?, ?, 'gratuit', ?)
        ");

        $insert->execute([
            $idC,
            $idConc,
            $idVotant,
            $ip
        ]);

        $message = "<p style='color:green'>Vote enregistré !</p>";
        $voteCount++;
    }
}

$photo = !empty($candidat['photo_candidat'])
    ? "uploads/candidats/" . $candidat['photo_candidat']
    : "assets/images/default-user.jpg";
?>
    <?php include 'includes/link.php'; ?>

  <?php include 'includes/navbar.php'; ?>

<link rel="stylesheet" href="assets/css/profile_candidat.css">
<link rel="stylesheet" href="assets/css/color.css">


<main class="candidate-page">

    <section class="profile-card">

        <!-- IMAGE -->
        <div class="profile-image-area">

            <img src="<?= htmlspecialchars($photo) ?>"
                 alt="<?= htmlspecialchars($candidat['nom_candidat']) ?>"
                 class="profile-image">

            <div class="image-overlay"></div>

            <div class="floating-badge">
                <?= htmlspecialchars($candidat['titre']) ?>
            </div>

        </div>

        <!-- CONTENT -->
        <div class="profile-content">

            <!-- HEADER -->
            <div class="profile-header">

                <span class="profile-label">
                    Candidat officiel
                </span>

                <h1>
                    <?= htmlspecialchars($candidat['nom_candidat']) ?>
                    <?= htmlspecialchars($candidat['prenom_candidat']) ?>
                </h1>

                <p class="profile-bio">
                    <?= nl2br(htmlspecialchars($candidat['biography'])) ?>
                </p>

            </div>

            <!-- STATS -->
            <div class="stats-row">

     
        <span class="votes-count"><strong><?= $voteCount ?></strong> Votes</span>


                <?php if ($candidat['type_vote'] === 'payant'): ?>

                    <div class="accent">
                      <!--  <div class="stat-card accent">-->
                        <span class="stat-number small">
                            <?= number_format($candidat['prix_vote'],0,',',' ') ?>
                        </span>

                        <span class="stat-label">
                            FCFA / vote
                        </span>
                    </div>

                <?php else: ?>

                    <div class="stat-card success">
                        <span class="stat-label only">
                            Vote gratuit
                        </span>
                    </div>

                <?php endif; ?>

            </div>

            <!-- MESSAGE -->
            <?php if (!empty($message)): ?>
                <div class="message-box">
                    <?= $message ?>
                </div>
            <?php endif; ?>

            <!-- ACTIONS -->
            <div class="action-zone">

                <!-- GRATUIT -->
                <?php if ($candidat['type_vote'] === 'gratuit'): ?>

                    <?php if (isset($_SESSION['id_user'])): ?>

                        <form method="POST">
                            <button class="btn-primary" name="vote_gratuit">
                                Voter maintenant
                            </button>
                        </form>

                    <?php else: ?>

                        <a href="login" class="btn-secondary">
                            Se connecter pour voter
                        </a>

                    <?php endif; ?>

                <?php endif; ?>


                <!-- PAYANT -->
                <?php if ($candidat['type_vote'] === 'payant'): ?>

                    <form id="payForm" class="payment-form">

                        <div class="form-grid">

                            <input type="number"
                                   name="montant"
                                   placeholder="Montant"
                                   min="<?= $candidat['prix_vote'] ?>"
                                   required>

                            <input type="tel"
                                   name="telephone"
                                   placeholder="Téléphone"
                                   required>

                            <select name="operator" required>
                                <option value="">Opérateur</option>
                                <option value="Orange_Cameroon">
                                    Orange Money
                                </option>
                                <option value="MTN_Cameroon">
                                    MTN MoMo
                                </option>
                            </select>

                        </div>

                        <button type="submit" class="btn-primary full">
                            Payer & voter
                        </button>

                    </form>

                    <div id="paymentMessage"></div>

                <?php endif; ?>

            </div>

        </div>

    </section>

</main>

<?php include 'includes/footer.php'; ?>


<script>
const form = document.getElementById("payForm");

if (form) {

    form.addEventListener("submit", async function(e) {

        e.preventDefault(); //epeche recharge de la page

        const messageBox = document.getElementById("paymentMessage");
        messageBox.innerHTML = "Traitement du paiement...";

        try {

            const response = await fetch("api/paiement.php", { 
                //envoyer delande au serveur après le clique et envoie les données json au serveur
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({
                    id_candidat: <?= $idC ?>,
                    id_concours: <?= $candidat['id_concours'] ?>,
                    montant: form.montant.value,
                    phone: form.telephone.value,
                    operator: form.operator.value
                })
            });

                // format de données {"id_candidat": 10,"id_concours": 2,"montant": 500,"phone": "699112233","operator": "MTN"}

            const data = await response.json(); //attend la réponse du serveur et la converti en json

            if (data.status !== "success") { //si status est différent de success alors affiche le message d'erreur
                messageBox.innerHTML =
                    "<span style='color:red'>" + data.message + "</span>";
                return;
            }
                    // Si succès, affiche message de confirmation
            messageBox.innerHTML = 
                "<span style='color:green'>Demande envoyée. Confirmez sur votre téléphone.</span>";

        } catch (error) {

            messageBox.innerHTML =
                "<span style='color:red'>Erreur serveur.</span>";

            console.error(error);
        }
    });
}
</script>