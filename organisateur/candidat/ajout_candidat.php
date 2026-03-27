<?php
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ajouter'])){
    $nom = htmlspecialchars(trim($_POST['nom']));
    $prenom = htmlspecialchars(trim($_POST['prenom']));
    //$mail = htmlspecialchars(trim($_POST['email']));
    $bio = htmlspecialchars(trim($_POST['bio']));
    $email= filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL); 
    if(!$email){
        $_SESSION['status'] = "mail invalide"; 
    }
  //  if(empty($name))
    $concours = htmlspecialchars(trim($_POST['concours']));

    if(isset($_FILE['imgCandidat']) && $_FILE['imgCandidat']['error'] === 0){
        $allowed_types = ['image/jpeg', 'image/png', 'image/webp'];
        $max_size = 2 * 1024 * 1024; // 2MB
        $type = $_FILE['imgCandidat']['type']; 
        $size = $_FILE['imgCandidat']['size']; 

        if(in_array($type, $allowed_types)){
            if($size <= $max_size){
                $chemin_photo = '../../uploads/candidats'; 
                if(!is_dir($chemin_photo)){
                    mkdir($upload_dir, 0755, true);
                }
                $extention = pathinfo($_FILE['imgCandidat']['name'], PATHINFO_EXTENTION); 
                $name_photo = uniqid('user_', true) . ".".$extention; 
                move_uploaded_file(
                    $_FILE['imgCandidat']['temp_name'], 
                    $chemin_photo . $name_photo
                ); 
            } else{
                $msg = "Taille max est de 2M"; 
            }
        } else{
             $msg = "<p style='color:red;'>
                    Cet email a été envoyé automatiquement. Merci de ne pas y répondre.</p>";
        }
    } 
     $insert = "INSERT INTO candidats (
        id_organisateur,  
        nom_candidat, 
        prenom_candidat, 
        email_candidat, 
        photo_candidat, 
        biography, 
        id_concours) VALUES (?,?,?,?,?,?,?)" ; 
    $insertCan = $pdo->prapre($insert); 
    $insertCan->execute([$id_org, $nomCan, $prenom, $email, 
        $name_photo, $bio, $concours]); 
    header("location: dashboard.php");
    exit();
}

?>

<link rel="stylesheet" href="<?= BASE_URL ?>assets/css/formulaire_nouveau.css">
<div id="modalCandidat" class="modal">
    <div class="modal-content">

        <div class="modal-header">
            <h2>Nouveau Candidat</h2>
            <p>Tous les champs marqués avec * sont obligatoires</p>
        </div>

        <form class="modal-body" method="post" action="">

            <div class="form-row">
                <input type="text" placeholder="Nom *" name="nom" required>
                <input type="text" placeholder="Prénom *" name="prenom" required>
            </div>

            <input type="email" placeholder="Email *" name="email" class="full-width" required>

            <div class="form-row">
                <div class="select-wrapper">
                    <select required>
                        <option value="" name="concours" disabled selected>Concours *</option>
                        <?php foreach($concours as $concours_item){ ?>
                            <option value="<?= $concours_item['id_concours'] ?>"><?= $concours_item['titre'] ?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="file-input">
                    <input type="file" id="photo" name="imgCandidat" accept="image/png,image/jpeg" hidden>
                    <label for="photo">Photo</label>
                </div>
            </div>

            <textarea placeholder="Biographie" name="bio" class="full-width"></textarea>

            <div class="form-footer">
                <button type="submit" name ="ajouter" class="btn-submit">Ajouter</button>
            </div>

        </form>
    </div>
</div>

