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

// GESTION RECUP ID

$game_id = $_GET['id'];

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

$gameWithEverything = $gamesManager->getGameWithEverything($game_id);

?>

<!DOCTYPE html>
<html lang="<?= htmlspecialchars($lang) ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="color-scheme" content="light dark">
    <link rel="stylesheet" href="./../src/utils/style.css">
    <title><?= htmlspecialchars($traductions['title']) ?></title>
</head>

<body>
    <main class="container">
        <h1><?= htmlspecialchars($traductions['title']) ?></h1>
        <p><?= htmlspecialchars($traductions['welcome']) ?></p>

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
                </tr>
            </thead>
            <tbody>
                    <tr>
                        <td><?= htmlspecialchars($gameWithEverything['game_name']) ?></td>
                        <td><?= htmlspecialchars($gameWithEverything['release_date']) ?></td>
                        <td><?= htmlspecialchars($gameWithEverything['game_min_age']) ?></td>
                        <td><?= htmlspecialchars($gameWithEverything['studio_name']) ?></td>
                    </tr>
            </tbody>
        </table>
    </main>
</body>

</html>