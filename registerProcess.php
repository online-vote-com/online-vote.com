    <?php
    session_start();

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'vendor/autoload.php';
    require 'config/database.php';
    require 'config/mail.php';

    function sendemail_verify($nom, $email, $verif_token){

    $mail = new PHPMailer(true);

   // $mail->SMTPDebug = 2;
//$mail->Debugoutput = 'html';
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = SMTP_USER;
    $mail->Password   = SMTP_PASS;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port       = 465;

    $mail->setFrom(SMTP_USER, "Online Vote");
    $mail->addAddress($email);

    $mail->isHTML(true);
    $mail->Subject = "Verification Email";

   $mail_template = "
<!DOCTYPE html>
<html>
<head>
<meta charset='UTF-8'>
<title>Activation de votre compte</title>
</head>

<body style='margin:0;padding:0;background-color:#F8F9FA;font-family:Arial,Helvetica,sans-serif;'>

<table width='100%' cellpadding='0' cellspacing='0'>
<tr>
<td align='center'>

<table width='520' cellpadding='0' cellspacing='0' style='background:#FFFFFF;margin-top:40px;border-radius:10px;overflow:hidden;box-shadow:0 4px 15px rgba(0,0,0,0.08);'>

<tr>
<td style='background:#9C04DA;padding:25px;text-align:center;'>

<h2 style='color:#FFFFFF;margin:0;font-size:24px;'>
Bienvenue $nom 🎉
</h2>

<p style='color:#E7C6FF;margin-top:8px;font-size:14px;'>
Activation de votre compte
</p>

</td>
</tr>

<tr>
<td style='padding:35px;text-align:center;'>

<p style='font-size:16px;color:#333;margin-top:0;'>
Votre inscription a été enregistrée avec succès.
</p>

<p style='font-size:15px;color:#555;'>
Cliquez sur le bouton ci-dessous pour activer votre compte.
</p>

<br>

<a href='https://online-vote.com/email_verif?token=$verif_token'
style='background:#9C04DA;color:#FFFFFF;padding:14px 30px;text-decoration:none;border-radius:6px;font-size:16px;font-weight:bold;display:inline-block;'>
Activer mon compte
</a>

<br><br>

<p style='font-size:13px;color:#777;'>
Si le bouton ne fonctionne pas, copiez et collez ce lien dans votre navigateur :
</p>

<p style='font-size:13px;color:#9C04DA;word-break:break-all;'>
https://online-vote.com/email_verif?token=$verif_token
</p>

<hr style='border:none;border-top:1px solid #EEEEEE;margin:25px 0;'>

<p style='font-size:12px;color:#999;margin:0;'>
Cet email a été envoyé automatiquement. Merci de ne pas y répondre.
</p>

<p style='font-size:12px;color:#BBBBBB;margin-top:6px;'>
© 2026 Online Vote
</p>

</td>
</tr>

</table>

</td>
</tr>
</table>

</body>
</html>
";
  $mail->Body = $mail_template;

try {
    $mail->send();
} catch (Exception $e) {
    echo "Erreur Mail : {$mail->ErrorInfo}";
}

    }



    if($_SERVER["REQUEST_METHOD"] == "POST"){

        $nom = htmlspecialchars($_POST['nom']);
       // $prenom = htmlspecialchars($_POST['prenom']);
       // $mail = htmlspecialchars($_POST['email']);
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        if (!$email) {
             $_SESSION['email'] = "Email invalide";
            header("Location: register.php");
            exit();
         } 
        $password = $_POST['mdp'];

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        // $verif_token = md5(rand());
        $verif_token = bin2hex(random_bytes(16));

        $check_mail = "SELECT id_user FROM users WHERE email = :email LIMIT 1"; 
         $stm = $pdo->prepare($check_mail); 
         $stm->execute([':email' => $email]);
        $user = $stm->fetch(PDO::FETCH_ASSOC);

         if($user){
       
             $_SESSION['email'] = 'Cet email est déjà utilisé';
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
                sendemail_verify($nom, $email, $verif_token);
                $_SESSION['status']="Consulte ta boite mail pour activer ton compte $email";
                header('location: register.php');
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