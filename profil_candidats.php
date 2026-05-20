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

<!-- <link rel="stylesheet" href="assets/css/profile_candidat.css"> -->
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
console.log(data);
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

<style>
    

/* ÉCRIN DE PRÉSENTATION CENTRÉ */
.candidate-page, .candidate-wrapper {
    width: 100%;
    min-height: 100vh;
    padding: 3rem 1.5rem;
    display: flex;
    justify-content: center;
    align-items: center;
}

/* ==========================================================================
   3. STRUCTURE DE LA CARTE (HORIZONTAL SUR PC / VERTICAL SUR MOBILE)
   ========================================================================= */
.profile-card, .candidate-card {
    width: 100%;
    max-width: 880px;
    background: var(--white);
    border-radius: 24px;
    padding: 24px;
    box-shadow: 0 20px 50px rgba(0, 0, 0, 0.04);
    border: 1px solid var(--gray-border);
    
    display: grid;
    grid-template-columns: 340px 1fr;
    gap: 40px;
    align-items: center;
    transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1);
}

.profile-card:hover, .candidate-card:hover {
    transform: translateY(-4px);
}

/* AREA IMAGE */
.profile-image-area, .candidate-media-wrapper, .candidate-media {
    position: relative;
    width: 100%;
    aspect-ratio: 4 / 5;
    border-radius: 16px;
    overflow: hidden;
    background: var(--light-purple-bg);
}

.profile-image, .candidate-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

.profile-image-area img:not(:first-of-type),
.candidate-media img:not(:first-of-type) {
    display: none !important;
}

/* FLOATING TAG (Badge Concours) */
.floating-badge, .contest-name {
    position: absolute;
    top: 16px;
    left: 16px;
    z-index: 5;
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
    color: var(--text-dark);
    padding: 6px 14px;
    border-radius: 8px;
    font-size: 0.7rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.06em;
    border: 1px solid rgba(255, 255, 255, 0.5);
}

/* BLOC DES TEXTES */
.profile-content, .candidate-content-block, .candidate-info {
    display: flex;
    flex-direction: column;
    gap: 24px;
}

.profile-header h1, .candidate-header h1 {
    font-size: 2.2rem;
    font-weight: 800;
    line-height: 1.15;
    color: var(--text-dark);
}

.profile-header h1 span, .candidate-header h1 span {
    display: block;
    font-weight: 500;
    font-size: 1.5rem;
    color: var(--text-muted);
}

.profile-bio, .candidate-bio {
    font-size: 0.95rem;
    line-height: 1.6;
    color: var(--text-muted);
}

/* ==========================================================================
   4. REFONTE DES COMPTEURS (SANS COMPOSANT ROND INTERNE - STYLE PREMIUM)
   ========================================================================= */
.stats-row, .vote-meta {
    display: flex;
    align-items: center;
    gap: 16px;
    width: 100%;
}

/* Boîte contenant le texte et le chiffre */
.stat-card, .votes-count, .vote-price, .vote-free {
    flex: 1;
    background-color: #F8F9FB; /* Fond mat uni épuré */
    border: 1px solid #EDEDF2;
    border-radius: 16px; /* Angles rectangulaires adoucis */
    padding: 16px 20px;
    display: flex;
    flex-direction: row; /* Alignement horizontal propre */
    align-items: center;
    gap: 12px;
    height: auto;
    min-height: 68px;
    pointer-events: none;
    user-select: none;
}

/* Ciblage du chiffre/nombre (ex: "2" ou "500") */
.votes-count::first-letter, 
.vote-price::first-letter,
.stat-card strong, 
.votes-count strong,
.vote-price strong {
    font-size: 1.3rem;
    font-weight: 800;
    color: var(--main-purple); /* Met en valeur la donnée essentielle */
    line-height: 1;
}

/* Libellé de description (ex: "Votes reçus", "FCFA / vote") */
.stat-label, .votes-count, .vote-price, .vote-free {
    font-size: 0.88rem;
    font-weight: 600;
    color: #4A4A4E;
}

/* Teinte subtile exclusive pour le badge "Vote gratuit" s'il s'affiche */
.vote-free {
    background-color: rgba(231, 198, 255, 0.15);
    border-color: rgba(156, 4, 218, 0.12);
    color: var(--dark-purple-gradient);
}

.action-zone, .vote-box {
    display: flex;
    flex-direction: column;
    gap: 16px;
    width: 100%;
}

/* ==========================================================================
   5. ZONE INTERACTIVE (INPUTS STYLE LINÉAIRE STRIPE)
   ========================================================================= */
.payment-form, .pay-form {
    width: 100%;
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.form-grid, .input-row {
    display: flex;
    gap: 12px;
}

.form-grid input, .pay-form input {
    width: 100%;
    height: 52px;
    border: none;
    border-bottom: 2px solid var(--gray-border);
    background-color: transparent;
    border-radius: 0px;
    padding: 0 4px;
    font-size: 0.95rem;
    font-weight: 500;
    color: var(--text-dark);
    outline: none;
    transition: border-bottom-color 0.3s ease;
}

.form-grid input:focus, .pay-form input:focus {
    border-bottom-color: var(--main-purple);
}

.form-grid select, .pay-form select {
    width: 100%;
    height: 52px;
    border: 1px solid var(--gray-border);
    background-color: var(--bg-light);
    border-radius: 12px;
    padding: 0 16px;
    font-size: 0.9rem;
    font-weight: 600;
    color: var(--text-dark);
    outline: none;
    cursor: pointer;
    appearance: none;
    -webkit-appearance: none;
    background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://w3.org' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%23111111' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'><polyline points='6 9 12 15 18 9'></polyline></svg>");
    background-repeat: no-repeat;
    background-position: right 18px center;
}

/* ==========================================================================
   6. BOUTONS D'ACTIONS MINI-RECTANGLES
   ========================================================================= */
.btn-primary, .btn-vote {
    width: 100%;
    height: 56px;
    background-color: var(--text-dark);
    color: var(--white);
    border: none;
    border-radius: 14px;
    font-size: 0.95rem;
    font-weight: 700;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    position: relative;
    transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    text-decoration: none;
}

.btn-primary::after, .btn-vote::after {
    content: '↗';
    position: absolute;
    right: 20px;
    font-size: 1rem;
    transition: transform 0.3s ease;
}

.btn-primary:hover, .btn-vote:hover {
    background-color: var(--main-purple);
}

.btn-primary:hover::after, .btn-vote:hover::after {
    transform: translate(2px, -2px);
}

.btn-primary:active, .btn-vote:active {
    transform: scale(0.98);
}

.btn-secondary, .btn-vote-outline {
    width: 100%;
    height: 54px;
    background: var(--white);
    color: var(--text-dark);
    border: 1.5px solid var(--text-dark);
    border-radius: 14px;
    font-size: 0.95rem;
    font-weight: 700;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    transition: all 0.25s ease;
}

.btn-secondary:hover, .btn-vote-outline:hover {
    background-color: var(--text-dark);
    color: var(--white);
}

/* ALERTES */
#paymentMessage, .message-box, .vote-box p {
    width: 100%;
    padding: 12px;
    border-radius: 12px;
    text-align: center;
    font-size: 0.85rem;
    font-weight: 600;
    background: var(--bg-light);
    color: var(--main-purple);
    border: 1px dashed var(--light-purple-bg);
}

/* ==========================================================================
   7. RESPONSIVE DESIGN (TABLETTES & SMARTPHONES)
   ========================================================================= */
@media(max-width: 820px) {

    .profile-card, .candidate-card {
        display: flex;
        
        flex-direction: column;
        max-width: 430px;
        border-radius: 24px;
        gap: 20px;
        padding: 14px;
    }
    
    .profile-image-area, .candidate-media-wrapper, .candidate-media {
        border-radius: 16px;
    }
    
    .profile-header h1, .candidate-header h1 {
        font-size: 1.8rem;
    }
    
    .form-grid, .input-row {
        flex-direction: column;
        gap: 12px;
    }
}

</style>