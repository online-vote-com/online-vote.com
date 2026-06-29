<?php

require "../config/database.php";

$message = strtolower(trim($_POST['message'] ?? ''));

$sql = $pdo->query("SELECT * FROM chatbot_faq WHERE actif=1");

$meilleurScore = 0;

$meilleureReponse = "Désolé, je n'ai pas trouvé de réponse. Contactez l'administrateur.";

// ID de la FAQ choisie (utile pour statistiques)
$idFaq = null;

// On parcourt toutes les FAQ une par une
while($faq = $sql->fetch(PDO::FETCH_ASSOC)) {

    $question = strtolower($faq['question']);

    //  calcule la ressemblance entre 2 phrases (%)
    similar_text($message, $question, $similarity);

    //distance entre les deux textes (erreurs/fautes)
    $lev = levenshtein($message, $question);

    // Longueur maximale des deux textes (pour normalisation)
    $maxLen = max(strlen($message), strlen($question));

    // Score basé sur levenshtein (plus proche = meilleur score)
  if ($maxLen > 0) {

    $ratioErreur = $lev / $maxLen;

    $levScore = (1 - $ratioErreur) * 100;

} else {

    $levScore = 0;
}

    // Score basé sur les mots-clés
    $keywordScore = 0;

    // On transforme les mots-clés en tableau
    $mots = explode(" ", strtolower($faq['mots_cles']));

    // On vérifie si chaque mot-clé est présent dans la phrase utilisateur
    foreach($mots as $mot) {
        if(str_contains($message, $mot)) {
            $keywordScore += 10; // chaque mot trouvé augmente le score
        }
    }


    $scoreFinal =
        ($similarity * 0.4) +   // 40% similarité de phrase
        ($levScore * 0.3) +     // 30% correction de fautes
        ($keywordScore * 2);    // poids fort sur mots-clés

    // Si ce score est meilleur que le précédent
    if($scoreFinal > $meilleurScore) {
        $meilleurScore = $scoreFinal;
        $meilleureReponse = $faq['reponse'];
        $idFaq = $faq['id_faq'];
    }
}


$stmt = $pdo->prepare("
    INSERT INTO chatbot_logs (message, response, score)
    VALUES (?, ?, ?)
");


$stmt->execute([
    $message,          
    $meilleureReponse,
    $meilleurScore    
]);

if($idFaq) {


    $pdo->prepare("
        UPDATE chatbot_faq
        SET nb_consultations = nb_consultations + 1
        WHERE id_faq = ?
    ")->execute([$idFaq]);
}


echo $meilleureReponse;

?>