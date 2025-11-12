<?php

use Managers\GamesManager;

require_once __DIR__ . '/../src/classes/Managers/GamesManager.php';

const DATABASE_CONFIGURATION_FILE = __DIR__ . '/../src/config/database.ini';
require_once __DIR__ . '/../src/i18n/load-translation.php';

// GESTION DES COOKIES
// Constantes
const COOKIE_NAME = 'lang';
const COOKIE_LIFETIME = 120 * 24 * 60 * 60; // 120 jours
const DEFAULT_LANG = 'fr';

// Déterminer la langue préférée
$lang = $_COOKIE[COOKIE_NAME] ?? DEFAULT_LANG;

$traductions = loadTranslation($lang);

// Changer la langue préférée
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $lang = $_POST['language'] ?? DEFAULT_LANG;

    setcookie(COOKIE_NAME, $lang, time() + COOKIE_LIFETIME);
    header('Location: index.php');
    exit;
}


//GESTION DE LA BASE DE DONNEES

// Documentation : https://www.php.net/manual/fr/function.parse-ini-file.php
$config = parse_ini_file(DATABASE_CONFIGURATION_FILE);

if (!$config) {
    throw new Exception("Erreur lors de la lecture du fichier de configuration : " . DATABASE_CONFIGURATION_FILE);
}

$host = $config['host'];
$port = $config['port'];
$database = $config['database'];
$username = $config['username'];
$password = $config['password'];

// Documentation :
//   - https://www.php.net/manual/fr/pdo.connections.php
//   - https://www.php.net/manual/fr/ref.pdo-mysql.connection.php
$pdo = new PDO("mysql:host=$host;port=$port;charset=utf8mb4", $username, $password);

$gamesManager = new GamesManager($pdo);

$gamesWithStudio = $gamesManager->getGamesWithStudio();

/*
// Sélection de la base de données
$sql = "USE `$database`;";
$stmt = $pdo->prepare($sql);
$stmt->execute();


// Définition de la requête SQL pour récupérer tous les utilisateurs
$sql = "SELECT * FROM games";

// Préparation de la requête SQL
$stmt = $pdo->prepare($sql);

// Exécution de la requête SQL
$stmt->execute();

// Récupération de tous les utilisateurs
$games = $stmt->fetchAll();
*/
?>

<!DOCTYPE html>
<html lang="<?= htmlspecialchars($lang) ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="color-scheme" content="light dark">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
    <title><?= htmlspecialchars($traductions['title']) ?></title>
</head>

<body>
    <main class="container">
        <form class = "login" action = login.php>
            <button type="submit"><?= htmlspecialchars($traductions['login']) ?></button>
        </form>
        <h1><?= htmlspecialchars($traductions['welcome']) ?></h1>

        <form method="post" action="index.php">
        <label for="language"><?= htmlspecialchars($traductions['choose_language']) ?></label>
        <select name="language" id="language">
            <option value="fr" <?= $lang === 'fr' ? ' selected' : '' ?>><?= htmlspecialchars($traductions['languages']['fr']) ?></option>
            <option value="en" <?= $lang === 'en' ? ' selected' : '' ?>><?= htmlspecialchars($traductions['languages']['en']) ?></option>
        </select>
        <button type="submit"><?= htmlspecialchars($traductions['submit']) ?></button>
    </form>

        <table>
            <thead>
                <tr>
                    <th><?= htmlspecialchars($traductions['game_name'])?></th>
                    <th><?= htmlspecialchars($traductions['release_date'])?></th>
                    <th><?= htmlspecialchars($traductions['game_min_age'])?></th>
                    <th><?= htmlspecialchars($traductions['studio_name'])?></th>
                    <th><?= htmlspecialchars($traductions['view'])?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($gamesWithStudio as $game) { ?>
                    <tr>
                        <td><?= htmlspecialchars($game['game_name']) ?></td>
                        <td><?= htmlspecialchars($game['release_date']) ?></td>
                        <td><?= htmlspecialchars($game['game_min_age']) ?></td>
                        <td><?= htmlspecialchars($game['studio_name']) ?></td>
                        <td><a href="view.php?id=<?=$game['game_id']?>">x</a></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </main>
</body>

</html>