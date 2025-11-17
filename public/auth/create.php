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
// Création d'une instance de UserManager
$userManager = new UserManager();

$username = '';
$password = '';
$email = '';
$birthdate = '';
$birthdateConverted = null;
$bio = '';
$errors = [];

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
            //la date de création sera assigné automatiquement 
        );
    } catch (InvalidArgumentException $e) {
        $errors[] = $e->getMessage();
    }


    // S'il n'y a pas d'erreurs, ajout de l'utilisateur
    if (empty($errors)) {
        try {
            // Ajout de l'utilisateur à la base de données
            $userManager->addUser($user);

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
    <title>Créez votre compte</title>
</head>

<body>
    <main class="container">
        <h1>Créez votre compte !</h1>

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
            <label for="username"><?= htmlspecialchars($traductions['pseudonym']) ?></label>
            <input type="text" id="username" name="username" value="<?= htmlspecialchars($username ?? ''); ?>" required minlength="2">

            <label for="password"><?= htmlspecialchars($traductions['password']) ?></label>
            <input type="password" id="password" name="password" value="<?= htmlspecialchars($password ?? ''); ?>" required minlength="6">

            <label for="email">E-mail</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($email ?? ''); ?>" required>

            <label for="birthdate"><?= htmlspecialchars($traductions['birthdate']) ?></label>
            <input type="date" id="birthdate" name="birthdate" value="<?= htmlspecialchars($birthdate ?? ''); ?>" required min="0">

            <label for="biographie"><?= htmlspecialchars($traductions['biography']) ?></label>
            <input type="text" id="biographie" name="biographie" value="<?= htmlspecialchars($bio ?? ''); ?>" required maxlength="300">

            <button type="submit"><?= htmlspecialchars($traductions['create']) ?></button>
        </form>
    </main>
</body>

</html>