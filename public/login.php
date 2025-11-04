<?php
// Constantes

use Managers\UserManager;
require_once __DIR__ . '/../src/classes/Managers/UserManager.php';
const DATABASE_CONFIGURATION_FILE = __DIR__ . '/../src/config/database.ini';
require_once __DIR__ . '/../src/i18n/load-translation.php';


//GESTION DES COOKIES
const COOKIE_NAME = 'lang';
const COOKIE_LIFETIME = 120 * 24 * 60 * 60; // 120 jours
const DEFAULT_LANG = 'fr';

$lang = $_COOKIE[COOKIE_NAME] ?? DEFAULT_LANG;
$traductions = loadTranslation($lang);


$config = parse_ini_file(DATABASE_CONFIGURATION_FILE);

if (!$config) {
    throw new Exception("Erreur lors de la lecture du fichier de configuration : " . DATABASE_CONFIGURATION_FILE);
}

$host = $config['host'];
$port = $config['port'];
$database = $config['database'];
$username = $config['username'];
$password = $config['password'];

$pdo = new PDO("mysql:host=$host;port=$port;dbname=$database;charset=utf8mb4", $username, $password);
$userManager = new UserManager($pdo);

// Démarre la session
session_start();

// Si l'utilisateur est déjà connecté, le rediriger vers l'accueil
if (isset($_SESSION['user_id'])) {
    header('Location: ../index.php');
    exit();
}

// Initialise les variables
$error = '';

// Traite le formulaire de connexion
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validation des données
    if (empty($username) || empty($password)) {
        $error = 'Tous les champs sont obligatoires.';
    } else {
        try {

            // Récupérer l'utilisateur de la base de données
            $stmt = $pdo->prepare('SELECT * FROM users WHERE username = :username');
            $stmt->execute(['username' => $username]);
            $user = $stmt->fetch();

            // Vérifier le mot de passe
            if ($user && password_verify($password, $user['password'])) {
                // Authentification réussie - stocker les informations dans la session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];

                // Rediriger vers la page d'accueil
                header('Location: ./index.php');
                exit();
            } else {
                // Authentification échouée
                $error = 'Nom d\'utilisateur ou mot de passe incorrect.';
            }
        } catch (PDOException $e) {
            $error = 'Erreur lors de la connexion : ' . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
    <title><?= htmlspecialchars($traductions['login'])?></title>
</head>

<body>
    <main class="container">
        <h1><?= htmlspecialchars($traductions['login'])?></h1>

        <?php if ($error): ?>
            <article style="background-color: var(--pico-del-color);">
                <p><strong><?= htmlspecialchars($traductions['error'])?> : </strong> <?= htmlspecialchars($error) ?></p>
            </article>
        <?php endif; ?>

        <form method="post">
            <label for="username">
                <?= htmlspecialchars($traductions['username'])?>
                <input type="text" id="username" name="username" required autofocus>
            </label>

            <label for="password">
                <?= htmlspecialchars($traductions['password'])?>
                <input type="password" id="password" name="password" required>
            </label>

            <button type="submit"><?= htmlspecialchars($traductions['login'])?></button>
        </form>

        <p><?= htmlspecialchars($traductions['no_account_yet'])?> <a href="register.php"><?= htmlspecialchars($traductions['create_account'])?></a></p>

        <p><a href="./index.php"><?= htmlspecialchars($traductions['back_to_home_screen'])?></a></p>
    </main>
</body>

</html>
