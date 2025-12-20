<?php

require __DIR__ . '/../../src/utils/autoloader.php';
require_once __DIR__ . '/../../src/i18n/load-translation.php';


//GESTION DES COOKIES
const COOKIE_NAME = 'lang';
const COOKIE_LIFETIME = 120 * 24 * 60 * 60; // 120 jours
const DEFAULT_LANG = 'fr';


$lang = $_COOKIE[COOKIE_NAME] ?? DEFAULT_LANG;
$traductions = loadTranslation($lang);

use Managers\UserManager;
use Users\User;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
// Création d'une instance de UserManager
$userManager = new UserManager();

$username = '';
$password = '';
$email = '';
$birthdate = '';
$birthdateConverted = null;
$bio = '';
$errors = [];

//GESTION DES MAILS
const MAIL_CONFIGURATION_FILE = __DIR__ . '/../../src/config/mail.ini';
// changer balise 'infomaniak' en 'local' pour utiliser en local
$config = parse_ini_file(MAIL_CONFIGURATION_FILE, true)['infomaniak'];

if (!$config) {
    throw new Exception("Erreur lors de la lecture du fichier de configuration : " .
        MAIL_CONFIGURATION_FILE);
}

$mailHost = $config['host'];
$mailPort = filter_var($config['port'], FILTER_VALIDATE_INT);
$mailAuthentication = filter_var($config['authentication'], FILTER_VALIDATE_BOOLEAN);
$mailUsername = $config['username'];
$mailPassword = $config['password'];
$from_email = $config['from_email'];
$from_name = $config['from_name'];


// Gère la soumission du formulaire
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Récupération des données du formulaire
    $username = $_POST["username"] ?? '';
    $password = $_POST["password"] ?? '';
    $email = $_POST["email"] ?? '';
    $birthdate = $_POST["birthdate"] ?? '';
    $birthdateConverted = new DateTime($birthdate);
    $bio = $_POST["biographie"] ?? '';

    try {
        // Création d'un nouvel objet `User`
        $user = new User(
            null, // Comme c'est une création, l'ID est null. La base de données l'assignera automatiquement.
            $username,
            $password,
            $email,
            $birthdateConverted,
            $bio
        );
    } catch (InvalidArgumentException $e) {
        $errors[] = $e->getMessage();
    }

    // S'il n'y a pas d'erreurs, ajout de l'utilisateur et on envoie le mail.
    if (empty($errors)) {
        try {
            // Ajout de l'utilisateur à la base de données
            $userId = $userManager->addUser($user);

            //Envoi du mail de confirmation
            $mail = new PHPMailer(true);

            try {
                $mail->isSMTP();
                $mail->Host = $mailHost;
                $mail->Port = $mailPort;
                $mail->SMTPAuth = $mailAuthentication;
                $mail->Username = $mailUsername;
                $mail->Password = $mailPassword;
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $mail->CharSet = "UTF-8";
                $mail->Encoding = "base64";

                // Expéditeur et destinataire
                $mail->setFrom($from_email, $from_name);
                $mail->addAddress($email, $username);

                // Contenu du mail
                $mail->isHTML(true);
                $mail->Subject = 'Nouveau compte créé';
                $mail->Body = "
                    <h3>Le compte de {$username} a été créé !</h3>
                    <p>L'équipe Gamerat</p>
                ";

                $mail->send();
            } catch (Exception $e) {
                // On log l'erreur mais on ne bloque pas l'inscription
                error_log("Erreur lors de l'envoi du mail : {$mail->ErrorInfo}");
            }

            // Pour être connecté à son nouveau compte avant la redirection
            session_start();
            $_SESSION['user_id'] = $userId;
            $_SESSION['username'] = $username;

            // Redirection vers la page d'accueil avec tous les utilisateurs
            header("Location: ../index.php");
            exit();
        } catch (PDOException $e) {
            // Liste des codes d'erreurs : https://en.wikipedia.org/wiki/SQLSTATE
            if ($e->getCode() === "23000") {
                // Erreur de contrainte d'unicité (par exemple, email déjà utilisé)
                $errors[] = "L'adresse e-mail est déjà utilisée.";
            } else {
                $errors[] = "Erreur lors de l'interaction avec la base de données : " . $e->getMessage();
            }
        } catch (Exception $e) {
            $errors[] = "Erreur inattendue : " . $e->getMessage();
        }
    }
}



?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../css/style.css">
    <title>Créez votre compte</title>
</head>

<body>
    <main class="container">
        <p><a href="../index.php"><?= htmlspecialchars($traductions['home']) ?></a> > <?= htmlspecialchars($traductions['create']) ?></p>
        <h1><?= htmlspecialchars($traductions['create_your_account']) ?> !</h1>

        <?php if ($_SERVER["REQUEST_METHOD"] === "POST") { ?>
            <?php if (empty($errors)) { ?>
                <p style="color: green;"><?= htmlspecialchars($traductions['create_success']) ?></p>
            <?php } else { ?>
                <p style="color: red;"><?= htmlspecialchars($traductions['create_failure']) ?></p>
                <ul>
                    <?php foreach ($errors as $error) { ?>
                        <li><?php echo $error; ?></li>
                    <?php } ?>
                </ul>
            <?php } ?>
        <?php } ?>

        <form action="create.php" method="POST">
            <label for="username"><?= htmlspecialchars($traductions['username']) ?></label>
            <input type="text" id="username" name="username" value="<?= htmlspecialchars($username ?? ''); ?>" required minlength="2">

            </br>
            </br>

            <label for="password"><?= htmlspecialchars($traductions['password']) ?></label>
            <input type="password" id="password" name="password" value="<?= htmlspecialchars($password ?? ''); ?>" required minlength="6">

            </br>
            </br>

            <label for="email">E-mail</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($email ?? ''); ?>" required>

            </br>
            </br>

            <label for="birthdate"><?= htmlspecialchars($traductions['birthdate']) ?></label>
            <input type="date" id="birthdate" name="birthdate" value="<?= htmlspecialchars($birthdate ?? ''); ?>" required min="0">

            </br>
            </br>

            <label for="biographie"><?= htmlspecialchars($traductions['biography']) ?></label>
            <input type="text" id="biographie" name="biographie" value="<?= htmlspecialchars($bio ?? ''); ?>" required maxlength="300">

            </br>
            </br>

            <button type="submit"><?= htmlspecialchars($traductions['create']) ?></button>
        </form>
    </main>
</body>

</html>