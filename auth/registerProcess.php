<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
require 'config/database.php';
require 'config/mail.php';

function sendemail_verify($nom, $email, $verif_token){

    $mail = new PHPMailer(true);

    try {

        // DEBUG (à supprimer plus tard)
        $mail->SMTPDebug = 2;
        $mail->Debugoutput = 'html';

        // CONFIG SMTP
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = SMTP_USER;
        $mail->Password   = SMTP_PASS;

        // ⚠️ PORT PLUS COMPATIBLE
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 465;

        // EMAIL
        $mail->setFrom(SMTP_USER, "Online Vote");
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = "Verification Email";

        $mail->Body = "
        <h2>Bienvenue $nom 🎉</h2>
        <p>Ton inscription a été enregistrée avec succès.</p>

        <p>Clique sur le bouton pour activer ton compte :</p>

        <a href='https://online-vote.com/email_verif.php?token=$verif_token'
        style='background:#4CAF50;color:white;padding:10px 20px;text-decoration:none;border-radius:5px'>
        Activer mon compte
        </a>

        <p>Ou copie ce lien :</p>

        https://online-vote.com/email_verif.php?token=$verif_token
        ";

        $mail->send();

        return true;

    } catch (Exception $e) {

        echo "Erreur Mail : " . $mail->ErrorInfo;
        return false;

    }
}

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $nom = htmlspecialchars($_POST['nom']);

    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);

    if (!$email) {
        $_SESSION['status'] = "Email invalide";
        header("Location: register.php");
        exit();
    }

    $password = $_POST['mdp'];
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $verif_token = bin2hex(random_bytes(16));

    // vérifier email existant
    $check_mail = "SELECT id_user FROM users WHERE email = :email LIMIT 1";

    $stm = $pdo->prepare($check_mail);
    $stm->execute([':email' => $email]);

    $user = $stm->fetch(PDO::FETCH_ASSOC);

    if($user){

        $_SESSION['status'] = "Cet email est déjà utilisé";
        header("Location: register.php");
        exit();

    } else {

        $stmt = $pdo->prepare("
            INSERT INTO users (nom_user, email, pwd, email_token)
            VALUES (?, ?, ?, ?)
        ");

        $stmt->execute([
            $nom,
            $email,
            $hashed_password,
            $verif_token
        ]);

        if($stmt){

           // sendemail_verify($nom, $email, $verif_token);
            if(sendemail_verify($nom, $email, $verif_token)){
    echo "MAIL ENVOYÉ";
}else{
    echo "MAIL NON ENVOYÉ";
}

            $_SESSION['status'] = "Consulte ta boite mail pour activer ton compte $email";

            header("Location: register.php");
            exit();
        }
    }


       /* $photo_name = null; // valeur par défaut    

        if(isset($_FILES['photo']) && $_FILES['photo']['error'] === 0){

            $allowed_types = ['image/jpeg', 'image/png', 'image/webp'];
        // $max_size = 2 * 1024 * 1024; // 2MB
        $max_size = 30* 1024 * 1024; // 2MB
            if(in_array($_FILES['photo']['type'], $allowed_types)){

                if($_FILES['photo']['size'] <= $max_size){

                    $upload_dir = "uploads/";

                    if(!is_dir($upload_dir)){
                        mkdir($upload_dir, 0755, true);
                    }

                    $extension = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
                    $photo_name = uniqid("user_", true) . "." . $extension;

                    move_uploaded_file(
                        $_FILES['photo']['tmp_name'],
                        $upload_dir . $photo_name
                    );

                } else {
                    die("Image trop volumineuse (max 2MB)");
                }

            } else {
                die("Format d'image non autorisé");
            }
        }  
        
        $stmt = $pdo->prepare("
            INSERT INTO users 
            (nom_user, prenom_user, email, pwd, photo_user) 
            VALUES (?, ?, ?, ?, ?)
        ");

        $stmt->execute([
            $nom,
            $prenom,
            $email,
            $hashed_password,
            $photo_name
        ]);
        */

       // header("Location: login");
       // exit();
    }
    ?>