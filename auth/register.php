    <?php
    session_start();

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'vendor/autoload.php';
    require '../config/database.php';
    require '../config/mail.php';

    function sendemail_verify($nom, $email, $verif_token){

    $mail = new PHPMailer(true);
    $nom1 = "Online-vote";
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = SMTP_USER;
    $mail->Password   = SMTP_PASS;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port       = 465;

    $mail->setFrom('arthurtotie@gmail.com', $nom1);
    $mail->addAddress($email);

    $mail->isHTML(true);
    $mail->Subject = "Verification Email";

    $mail_template = "
    <!DOCTYPE html>
    <html>
    <head>
    <meta charset='UTF-8'>
    <title>Activation de compte</title>
    </head>

    <body style='margin:0; padding:0; background-color:#f4f4f4; font-family:Arial, Helvetica, sans-serif;'>

    <table width='100%' cellpadding='0' cellspacing='0'>
    <tr>
    <td align='center'>

    <table width='500' cellpadding='0' cellspacing='0' style='background:#ffffff; margin-top:40px; border-radius:10px; padding:30px; box-shadow:0 4px 10px rgba(0,0,0,0.1);'>

    <tr>
    <td align='center'>

    <h2 style='color:#333;'>Bienvenue 🎉</h2>

    <p style='font-size:16px; color:#555;'>
    Ton inscription a été enregistrée avec succès.
    </p>

    <p style='font-size:15px; color:#555;'>
    Clique sur le bouton ci-dessous pour activer ton compte.
    </p>

    <br>

    <a href='https://online-vote.com/email_verif.php?token=$verif_token'
    style='background:#4CAF50; color:#ffffff; padding:12px 25px; text-decoration:none; border-radius:5px; font-size:16px; display:inline-block;'>
    Activer mon compte
    </a>

    <br><br>

    <p style='font-size:13px; color:#888;'>
    Si le bouton ne fonctionne pas, copie et colle ce lien dans ton navigateur :
    </p>

    <p style='font-size:13px; color:#0066cc; word-break:break-all;'>
    https://online-vote.com/register.php/email_verif.php?token=$verif_token
    </p>

    <hr style='border:none; border-top:1px solid #eee; margin:20px 0;'>

    <p style='font-size:12px; color:#999;'>
     Merci de ne pas y répondre.
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

    $mail->send();

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
                sendemail_verify("$nom", "$email", "$verif_token");
                $_SESSION['status']="Consulte ta boite mail pour activer ton compte $email";
                header('location: ../register.php');
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