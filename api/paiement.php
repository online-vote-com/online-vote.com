    <?php

    /**
     * API PAIEMENT MOBILE MONEY
     
     */
    session_start();

    require_once("../config/database.php");
    require_once("../config/payment_config.php");

    header("Content-Type: application/json");

    $idVotant = $_SESSION['id_user'] ?? 0;

    //emepche accès direct sans POST ou via navigateur
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo json_encode([
            "status"=>"error",
            "message"=>"Méthode invalide"]); 
            exit;
    }

    // lire donneés envoyer en js
    $data = json_decode(file_get_contents("php://input"), true);
    
    //vérifier que les données sont valides
    if (!$data) { 
        echo json_encode([
            "status"=>"error",
            "message"=>"JSON invalide"]); 
        exit;
    }

    //vérifier que les données nécessaires sont présentes
    if (empty($data['id_candidat']) || empty($data['id_concours']) || empty($data['montant']) || empty($data['phone']) || empty($data['operator'])) {
        echo json_encode([
            "status"=>"error",
            "message"=>"Données manquantes"]); 
        exit;
    }

    //caster et nettoyer les données
    $idCandidat = (int)$data['id_candidat'];
    $idConcours = (int)$data['id_concours'];
    $montant = (int)$data['montant'];
    $phone = preg_replace('/[^0-9]/', '', $data['phone']);
    if (strlen($phone) === 9) {
    $phone = "237".$phone;
    }
    //$operator = strtoupper(trim($data['operator']));
    $operator = trim($data['operator']);

    // Vérifier concours ouvert
    $stmt = $pdo->prepare("SELECT prix_vote FROM concours WHERE id_concours=? AND status_concours='ouvert'");
    $stmt->execute([$idConcours]);
    $concours = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$concours) { 
        echo json_encode([
            "status"=>"error",
            "message"=>"Concours fermé ou invalide"]); 
        exit; 
    }

    $prixVote = (int)$concours['prix_vote'];
    $nbVotes = floor($montant / $prixVote);
    if ($nbVotes <= 0) { echo json_encode(["status"=>"error","message"=>"Montant insuffisant"]); exit; }

    // Générer transaction ID ou Créer transaction unique
   // $transaction_id = uniqid("VOTE_");
    $transaction_id = "VOTE_".bin2hex(random_bytes(8));

    // Enregistrer paiement en attente
    $stmtInsert = $pdo->prepare("
    INSERT INTO paiements
    (transaction_id, montant, quantite_vote, operator, phone_number, status_paiement, id_votant, id_candidat, id_concours)
    VALUES (?,?,?,?,?,'attente',?,?,?)
    ");

    $stmtInsert->execute([
    $transaction_id,
    $montant,
    $nbVotes,
    $operator,
    $phone,
    $idVotant,
    $idCandidat,
    $idConcours
    ]);

    // Appel angaraa - fonction pour initier paiement dans config/payment_config.php
    $response = callAangaraa($phone, $montant, $transaction_id, $operator);

    if (!$response || (isset($response['success']) && $response['success']===false)) {
        echo json_encode([
            "status"=>"error",
            "message"=>$response['message'] ?? "Erreur paiement",
            "mesomb_debug"=>$response
        ]);
        exit;
    }

    // Paiement lancé correctement
    echo json_encode([
        "status"=>"success",
        "message"=>"Demande envoyée. Confirmez sur votre téléphone.",
        "transaction_id"=>$transaction_id
    ]);
    exit;
    ?>