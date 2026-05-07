<?php
        session_start();
        include '../includes/link.php'; 
        include '../config/database.php';

        if(!isset($_SESSION['id_user']) || $_SESSION['role'] != 'organisateur'){
            header("Location: ../login.php");
            exit();
        }

// Nombre de concours
        $id_org = $_SESSION['id_user'];
        $sqlCon = "SELECT COUNT(*) FROM concours WHERE id_organisateur = :id_org"; 
        $pdo_sta = $pdo->prepare($sqlCon);
        $pdo_sta->execute([':id_org' => $id_org]);
        $nbrConcours = $pdo_sta->fetchColumn();

// Liste des concours
       /*
        $sql_concours = "SELECT con.*, org.nom_user 
        FROM concours con JOIN ON users org
        WHERE con.id_organisateur = org.id_user"; */
$sql_concours = "SELECT con.*, org.nom_user
                 FROM concours con
                 JOIN users org ON con.id_organisateur = org.id_user
                 WHERE con.id_organisateur = :id_org";

$stmt_concours = $pdo->prepare($sql_concours);
$stmt_concours->execute([':id_org' => $id_org]);
$concours = $stmt_concours->fetchAll(PDO::FETCH_ASSOC);

//totla votes 
$sqlVotes = "SELECT COUNT(v.id_vote) AS total_votes
FROM votes v
JOIN concours c ON v.id_concours = c.id_concours
WHERE c.id_organisateur = :id_organisateur";

$stmtVotes = $pdo->prepare($sqlVotes);
$stmtVotes->execute([':id_organisateur' => $id_org]);
$totalVotes = $stmtVotes->fetchColumn();

// Nombre de candidats
    $sql = "SELECT COUNT(*) FROM candidats WHERE id_organisateur = :id_org"; 
    // $sql = "SELECT *, (SELECT COUNT(*) FROM candidats) As totalCan FROM candidats";
        $pdo_C = $pdo->prepare($sql);
        $pdo_C->execute([':id_org' => $id_org]);
        $nbrC = $pdo_C->fetchColumn();
        
// Total paiements
        $sqlP = "SELECT SUM(p.montant) AS montantTotal
        FROM paiements p
        JOIN concours c ON p.id_concours = c.id_concours
        WHERE c.id_organisateur = :id_org
        AND p.status_paiement = 'succes'";
        $stmt = $pdo->prepare($sqlP);
        $stmt->execute([':id_org' => $id_org]);
        $total_P = $stmt->fetchColumn() ?? 0;
    
// Candidats détaillés
        $sql_candidat = "SELECT can.*, con.titre
        FROM candidats can
        JOIN concours con ON can.id_concours = con.id_concours
        WHERE con.id_organisateur = :id_org";

        $stmt = $pdo->prepare($sql_candidat);
        $stmt->execute([':id_org' => $id_org]);

        $candidats = $stmt->fetchAll(PDO::FETCH_ASSOC);

//revenus - 04%  votants actifs et votes aujourdh'ui
$query = "SELECT 
    SUM(c.prix_vote) * 0.96 AS revenus_nets,
    COUNT(DISTINCT v.id_vote) AS votants_actifs, 
    SUM(CASE WHEN DATE(v.date_vote) = CURDATE() THEN 1 ELSE 0 END) AS votes_aujourdhui
FROM votes v
JOIN concours c ON v.id_concours = c.id_concours
WHERE c.id_organisateur = :id_organisateur";

$stmt = $pdo->prepare($query);
$stmt->execute([':id_organisateur' => $id_org]);
$stats = $stmt->fetch(PDO::FETCH_ASSOC);

//top conours 
    $queryTC = "SELECT 
    c.id_concours,
    c.titre,
    COUNT(v.id_vote) AS total_votes,
    ROW_NUMBER() OVER (ORDER BY COUNT(v.id_vote) DESC) AS rang
FROM concours c
LEFT JOIN votes v ON v.id_concours = c.id_concours
GROUP BY c.id_concours, c.titre
ORDER BY total_votes DESC LIMIT 5";

    $result = $pdo->query($queryTC);
    $topConcours = $result->fetchAll(PDO::FETCH_ASSOC);


?>