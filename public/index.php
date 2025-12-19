<?php

require_once __DIR__ . '/../src/utils/autoloader.php';
require_once __DIR__ . '/../src/classes/Managers/GamesManager.php';
const DATABASE_CONFIGURATION_FILE = __DIR__ . '/../src/config/database.ini';
require_once __DIR__ . '/../src/i18n/load-translation.php';

use Managers\GamesManager;

// GESTION DES COOKIES
// Constantes
const COOKIE_NAME = 'lang';
const COOKIE_LIFETIME = 120 * 24 * 60 * 60; // 120 jours
const DEFAULT_LANG = 'fr';

// Déterminer la langue préférée
$lang = $_COOKIE[COOKIE_NAME] ?? DEFAULT_LANG;

$traductions = loadTranslation($lang);

// Démarre la session
session_start();

// Vérifie si l'utilisateur est authentifié
$userId = $_SESSION['user_id'] ?? null;

//GESTION DE LA BASE DE DONNEES

// Documentation : https://www.php.net/manual/fr/function.parse-ini-file.php
$config = parse_ini_file(DATABASE_CONFIGURATION_FILE);

if (!$config) {
    throw new Exception("Erreur lors de la lecture du fichier de configuration : " . DATABASE_CONFIGURATION_FILE);
}

$host = $config['host'];
$port = $config['port'];
$database = $config['database'];
$admin = $config['username'];
$password = $config['password'];

// Documentation :
//   - https://www.php.net/manual/fr/pdo.connections.php
//   - https://www.php.net/manual/fr/ref.pdo-mysql.connection.php
$pdo = new PDO("mysql:host=$host;port=$port;charset=utf8mb4", $admin, $password);

$gamesManager = new GamesManager();

$gamesWithStudio = $gamesManager->getGamesWithStudio();

$favoritesIds = [];
if ($userId) {
    $username = $_SESSION['username'];
    $gamesFavorites = $gamesManager->getFavorites($userId);
    $favoritesIds = array_map(
        fn($game) => $game['game_id'],
        $gamesFavorites
    );
    $favoritesIds = array_flip($favoritesIds);
} else {
    $username = $traductions['guest'];
}

// Gérer les formulaires
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['language'])) {
        $lang = $_POST['language'] ?? DEFAULT_LANG;

        setcookie(COOKIE_NAME, $lang, time() + COOKIE_LIFETIME);
        header('Location: index.php');
        exit;
    }
    if ($userId && isset($_POST['action'], $_POST['game_id'])) {
        $gameId = (int)$_POST['game_id'];
        if ($_POST['action'] === 'addFavorite') {
            $gamesManager->addFavorite($userId, $gameId);
        } elseif ($_POST['action'] === 'removeFavorite') {
            $gamesManager->removeFavorite($userId, $gameId);
        }
        header('Location: index.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="<?= htmlspecialchars($lang) ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="color-scheme" content="light dark">
    <link rel="stylesheet" href="./css/style.css">
    <title><?= htmlspecialchars($traductions['title']) ?></title>
</head>

<body>
    <main class="container">
        <h1><?= htmlspecialchars($traductions['welcome']) ?></h1>
        <?php if (!$userId): ?>
            <form class="login" action="auth/login.php">
                <button type="submit"><?= htmlspecialchars($traductions['login']) ?></button>
            </form>
            <form class="create" action="auth/create.php">
                <button type="submit"><?= htmlspecialchars($traductions['create_account']) ?></button>
            </form>
        <?php else: ?>
            <h2><?= htmlspecialchars($traductions['userWelcome']) ?> <a href="private.php"><?= htmlspecialchars($username) ?></a></h2>
        <?php endif; ?>
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
                    <th><?= htmlspecialchars($traductions['game_name']) ?></th>
                    <th><?= htmlspecialchars($traductions['release_date']) ?></th>
                    <th><?= htmlspecialchars($traductions['game_min_age']) ?></th>
                    <th><?= htmlspecialchars($traductions['studio_name']) ?></th>
                    <?php if ($userId): ?>
                        <th><?= htmlspecialchars($traductions['favorite']) ?></th>
                    <?php endif; ?>
                    <th><?= htmlspecialchars($traductions['view']) ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($gamesWithStudio as $game) { ?>
                    <tr>
                        <td><?= htmlspecialchars($game['game_name']) ?></td>
                        <td><?= htmlspecialchars($game['release_date']) ?></td>
                        <td><?= htmlspecialchars($game['game_min_age']) ?></td>
                        <td><?= htmlspecialchars($game['studio_name']) ?></td>
                        <?php if ($userId): ?>
                            <td>
                                <?php if (isset($favoritesIds[$game['game_id']])): ?>
                                    <form method="post" style="display:inline">
                                        <input type="hidden" name="action" value="removeFavorite">
                                        <input type="hidden" name="game_id" value="<?= $game['game_id'] ?>">
                                        <button class="empty" type="submit" class="favorite">❤️</button>
                                    </form>
                                <?php else: ?>
                                    <form method="post" style="display:inline">
                                        <input type="hidden" name="action" value="addFavorite">
                                        <input type="hidden" name="game_id" value="<?= $game['game_id'] ?>">
                                        <button class="empty" type="submit" class="favorite">🤍</button>
                                    </form>
                                <?php endif; ?>
                            </td>
                        <?php endif; ?>
                        <td><a href="view.php?id=<?= $game['game_id'] ?>">➡️</a></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </main>
</body>

</html>