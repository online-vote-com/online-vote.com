    <!-- Liens CSS -->
    <link rel="stylesheet" href="../assets/css/profile_candidat.css">
    <link rel="stylesheet" href="../assets/css/color.css">

    <?php
    include '../includes/link.php';
    include '../includes/navbar.php';
    include '../config/database.php';

    if(!isset($_GET['id_candidat'])){
        die("Aucun candidat trouvé !");
    }

    $idC = (int) $_GET['id_candidat'];

    $cans = "SELECT con.*, can.* 
            FROM concours con, candidats can
            WHERE can.id_candidat = :id_concours";
    $st = $pdo->prepare($cans);
    $st->execute(['id_concours' => $idC]);
    $listC = $st->fetchAll();
    ?>

    <main class="container profile-page">
        <div class="profile-card">

            <!-- Image du candidat -->
            <div class="profile-image">
                <img src="../assets/images/organisateur/art.jpg" alt="Candidat">
            </div>

            <!-- Contenu principal -->
            <div class="profile-content">

                <h1 class="candidate-name"><?php echo $listC[0]['nom_candidat']; ?></h1>
                <p class="contest-title"><?php echo $listC[0]['titre']; ?></p>

                <!-- Description -->
                <div class="candidate-description">
                    <h3>À propos de moi</h3>
                    <p><?php echo $listC[0]['biography']; ?></p>
                </div>

                <!-- Votes -->
                <div class="vote-section">
                    <div class="vote-info">
                        <span>Montant vote = 1</span>
                        <span>Votes actuels : <strong>345</strong></span>
                    </div>

                    <form class="vote-form">
                        <div class="form-group">
                            <select name="paiement" >
                                <option value="" disabled selected>Mode paiement</option>
                                <option value="om">Orange Money</option>
                                <option value="momo">MTN Mobile Money</option>
                            </select>
                            <input type="number" name="montant" placeholder="Montant" >
                            <input type="tel" name="telephone" placeholder="Numéro" >
                        </div>

                        <div class="vote-footer">
                            <div class="vote-total">Vote total = <span>1000</span></div>
                            <button type="submit" name="vote_submit">Voter</button>
                        </div>
                    </form>
                </div>

            </div>

        </div>
    </main>

    <?php include '../includes/footer.php'; 
    
    if(isset($_POST['vote_submit'])) {
    $idCandidat = (int) $_POST['id_candidat'];
    $nomVotant = trim($_POST['nom']);
    $emailVotant = trim($_POST['email']);
    $ipVotant = $_SERVER['REMOTE_ADDR'];

    // Vérifier si l'email a déjà voté pour ce candidat (optionnel)
    $checkVote = $pdo->prepare("SELECT COUNT(*) FROM Vote WHERE id_candidat = :idC AND id_votant IS NULL AND adr_ip = :ip");
    $checkVote->execute([
        'idC' => $idCandidat,
        'ip' => $ipVotant
    ]);

    if($checkVote->fetchColumn() > 0) {
        echo "<p style='color:red'>Vous avez déjà voté pour ce candidat depuis cet appareil.</p>";
    } else {
        // Insertion du vote
        $insertVote = $pdo->prepare("INSERT INTO Vote (id_candidat, id_concours, adr_ip) VALUES (:idC, :idConcours, :ip)");
        $insertVote->execute([
            'idC' => $idCandidat,
            'idConcours' => $listC[0]['id_concours'],
            'ip' => $ipVotant
        ]);

        echo "<p style='color:green'>Merci pour votre vote !</p>";
    }
}
?>