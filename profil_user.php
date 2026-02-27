
<?php
include 'includes/navbar.php';
include 'includes/link.php';
include 'config/database.php';
if(!isset($_SESSION['id_user'])){
    header("Location: login.php");
    exit;
}
$nom = $_SESSION['nom'];
 $pnom =  $_SESSION['prenom'];
 $email =  $_SESSION['mail'];
 $role =   $_SESSION['role'];
$photo =  $_SESSION['photo'];
$statut =  $_SESSION['status']; 
         

 
$id = $_SESSION['id_user'];
$res = $pdo->prepare("SELECT COUNT(*) FROM votes WHERE id_votant = ?");
 $res->execute([$id]);
$vote = $res->fetchColumn();



?>
<link rel="stylesheet" href="assets/css/profil_user.css">
<link rel="stylesheet" href="assets/css/color.css">

<div class="container">
    <div class="profile-card">
        <!-- Image -->
        <div class="profile-image">
            <img src="uploads/12.png" alt="Utilisateur">
        </div>

        <!-- Contenu -->
        <div class="profile-content">
            <h1><?php  echo $nom ?></h1>
            <h2><?php echo $role ?></h2>
            <p>Bienvenue sur votre profil ! Consultez vos informations personnelles et suivez votre activité sur notre plateforme de vote.</p>

            <div class="info-grid">
                <div class="info-card">
                    <h3>Email</h3>
                    <span>jane.doe@example.com</span>
                </div>
                <div class="info-card">
                    <h3>Téléphone</h3>
                    <span>+237 6XXXXXXXX</span>
                </div>
                <div class="info-card">
                    <h3>Date d'inscription</h3>
                    <span>01 Mars 2026</span>
                </div>
                <div class="info-card">
                    <h3>Votes effectués</h3>
                    <span><?php echo $vote ?></span>
                </div>
            </div>
            <a href="#" class="btn-edit">Modifier Profil</a>
        </div>
    </div>
</div>

<?php
 include 'includes/footer.php';     
?>