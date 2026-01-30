    <?php
    session_start();

    include '../config/database.php';
    include '../includes/link.php';
    include '../includes/navbar.php';

    if (!isset($_GET['id_candidat']) || !is_numeric($_GET['id_candidat'])) {
        die("Aucun candidat trouvé !");
    }

    $idC = (int) $_GET['id_candidat'];

    // Récupérer les infos du candidat et du concours
    $sql = "SELECT con.*, can.* 
            FROM concours con
            JOIN candidats can ON can.id_concours = con.id_concours
            WHERE can.id_candidat = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$idC]);
    $candidat = $stmt->fetch();

    if (!$candidat) {
        die("Candidat introuvable !");
    }

    $stmtVote = $pdo->prepare("SELECT COUNT(*) FROM Vote WHERE id_candidat = ?");
    $stmtVote->execute([$idC]);
    $voteCount = $stmtVote->fetchColumn();

    $message = "";

  
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['vote_submit'])) {

        $ip = $_SERVER['REMOTE_ADDR'];
        $idConc = $candidat['id_concours'];

        if ($candidat['type_vote'] !== 'payant') {
           
            if (!isset($_SESSION['user_id'])) {
                header("Location: login.php");
                exit;
            }

            $idVotant = $_SESSION['user_id'];

            // Vérifier double vote
            $check = $pdo->prepare("SELECT COUNT(*) FROM Vote WHERE id_candidat = ? AND id_votant = ?");
            $check->execute([$idC, $idVotant]);

            if ($check->fetchColumn() > 0) {
                $message = "<p style='color:red'>Vous avez déjà voté pour ce candidat.</p>";
            } else {
                $insert = $pdo->prepare("INSERT INTO Vote (id_candidat, id_concours, id_votant, adr_ip) VALUES (?, ?, ?, ?)");
                $insert->execute([$idC, $idConc, $idVotant, $ip]);
                $message = "<p style='color:green'>Vote enregistré !</p>";
                $voteCount++;
            }

        } else {
            // Concours payant
            if (!isset($_POST['montant'], $_POST['methode'], $_POST['telephone']) 
                || !is_numeric($_POST['montant']) 
                || empty($_POST['methode']) 
                || empty($_POST['telephone'])) 
            {
                $message = "<p style='color:red'>Veuillez remplir tous les champs correctement.</p>";
            } else {
                $montant = floatval($_POST['montant']);
                $prixVote = floatval($candidat['prix_vote']);
                $nbVotes = floor($montant / $prixVote);

                if ($nbVotes <= 0) {
                    $message = "<p style='color:red'>Le montant est inférieur au prix d'un vote.</p>";
                } else {
                    $methode = $_POST['methode'];
                    $tel = $_POST['telephone'];

                    // Insérer le paiement
                    $stmtPay = $pdo->prepare("INSERT INTO paiement (montant, methode, status_paiement) VALUES (?, ?, 'succes')");
                    $stmtPay->execute([$montant, $methode]);
                    $idPaiement = $pdo->lastInsertId();

                    // Insérer les votes correspondants
                    $insertVote = $pdo->prepare("INSERT INTO Vote (id_candidat, id_concours, id_paiement, adr_ip) VALUES (?, ?, ?, ?)");
                    for ($i = 0; $i < $nbVotes; $i++) {
                        $insertVote->execute([$idC, $idConc, $idPaiement, $ip]);
                    }

                    $voteCount += $nbVotes;
                    $message = "<p style='color:green'>Merci ! $nbVotes vote(s) enregistré(s) pour $montant FCFA.</p>";
                   // header('location: concours.php?id_concours=' . $idC);
                }
            }
        }
    }
    ?>

    <link rel="stylesheet" href="../assets/css/profile_candidat.css">
    <link rel="stylesheet" href="../assets/css/color.css">

    <main class="container profile-page">
        <div class="profile-card">

            <div class="profile-image">
                <img src="../assets/images/organisateur/art.jpg" alt="Candidat">
            </div>

            <div class="profile-content">

                <h1 class="candidate-name"><?= htmlspecialchars($candidat['nom_candidat']) ?></h1>
                <p class="contest-title"><?= htmlspecialchars($candidat['titre']) ?></p>

                <div class="candidate-description">
                    <h3>À propos de moi</h3>
                    <p><?= nl2br(htmlspecialchars($candidat['biography'])) ?></p>
                </div>

                <div class="vote-section">
                    <div class="vote-info">
                        <span>
                            Montant vote : <?= $candidat['type_vote'] === 'payant' ? $candidat['prix_vote'] . ' FCFA' : 'Gratuit'; ?>
                        </span>
                        <span>Votes actuels : <strong><?= $voteCount ?></strong></span>
                    </div>

                    <?= $message ?>

                    <?php if ($candidat['type_vote'] === 'payant'): ?>
                        <form method="POST" class="vote-form">
                            <input type="number" name="montant" placeholder="Montant à payer" required>
                            <input type="tel" name="telephone" placeholder="Numéro" required>
                            <select name="methode" required placeholder="Mode de paiement">
                                <option value="Orange">Orange Money</option>
                                <option value="MTN">MTN Mobile Money</option>
                            </select>
                            <button type="submit" name="vote_submit">Payer & Voter</button>
                        </form>
                    <?php elseif (isset($_SESSION['user_id'])): ?>
                        <form method="POST" class="vote-form">
                            <button type="submit" name="vote_submit">Voter</button>
                        </form>
                    <?php else: ?>
                        <p style="color:red">Vous devez être connecté pour voter à ce concours gratuit.</p>
                        <a href="login.php" class="btn">Se connecter</a>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </main>

    <?php include '../includes/footer.php'; ?>
