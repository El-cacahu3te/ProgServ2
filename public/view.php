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

// Démarre la session
session_start();

// Vérifie si l'utilisateur est authentifié
$userId = $_SESSION['user_id'] ?? null;

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

if ($userId) {
    $username = $_SESSION['username'];
    $isFavorite = $gamesManager->isFavorite($userId, $game_id);
} else {
    $username = $traductions['guest'];
}

// Gérer les formulaires
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['language'])) {
        $lang = $_POST['language'] ?? DEFAULT_LANG;
        setcookie(COOKIE_NAME, $lang, time() + COOKIE_LIFETIME);
        header('Location: view.php?id=' . $gameId);
        exit;
    }
    if ($userId && isset($_POST['action'], $_POST['game_id'])) {
        $gameId = (int)$_POST['game_id'];
        if ($_POST['action'] === 'addFavorite') {
            $gamesManager->addFavorite($userId, $gameId);
        } elseif ($_POST['action'] === 'removeFavorite') {
            $gamesManager->removeFavorite($userId, $gameId);
        }
        header('Location: view.php?id=' . $gameId);
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
    <title><?= htmlspecialchars($gameWithEverything['game_name']) ?></title>
</head>

<body>

    <main class="container">
        <p><a href="index.php">Accueil</a> > <?= htmlspecialchars($gameWithEverything['game_name']) ?></p>
        <form method="post" action="view.php?id=<?= $gameWithEverything['game_id'] ?>">
            <label for="language"><?= htmlspecialchars($traductions['choose_language']) ?></label>
            <select name="language" id="language">
                <option value="fr" <?= $lang === 'fr' ? ' selected' : '' ?>><?= htmlspecialchars($traductions['languages']['fr']) ?></option>
                <option value="en" <?= $lang === 'en' ? ' selected' : '' ?>><?= htmlspecialchars($traductions['languages']['en']) ?></option>
            </select>
            <button type="submit"><?= htmlspecialchars($traductions['submit']) ?></button>
        </form>
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
        <h1>
            <?= htmlspecialchars($gameWithEverything['game_name']) ?>
            <?php if ($userId): ?>
                <?php if ($isFavorite): ?>
                    <form method="post" style="display:inline">
                        <input type="hidden" name="action" value="removeFavorite">
                        <input type="hidden" name="game_id" value="<?= $gameWithEverything['game_id'] ?>">
                        <button class="empty" type="submit" class="favorite">❤️</button>
                    </form>
                <?php else: ?>
                    <form method="post" style="display:inline">
                        <input type="hidden" name="action" value="addFavorite">
                        <input type="hidden" name="game_id" value="<?= $gameWithEverything['game_id'] ?>">
                        <button class="empty" type="submit" class="favorite">🤍</button>
                    </form>
                <?php endif; ?>
            <?php endif; ?>
        </h1>

        <h2><?= htmlspecialchars($gameWithEverything['studio_name']) ?></h2>
        <span class="details"><?= htmlspecialchars($traductions['release_date']) ?>: <?= htmlspecialchars($gameWithEverything['release_date']) ?></span>
        <span class="details"><?= htmlspecialchars($traductions['game_min_age']) ?>: <?= htmlspecialchars($gameWithEverything['game_min_age']) ?></span>

        <h3>Catégories :</h3>
        <ul>
            <?php foreach ($gameWithEverything['categories'] as $category): ?>
                <li class="details" class="details"><?= htmlspecialchars($category) ?></li>
            <?php endforeach; ?>
        </ul>

        <h3><?= htmlspecialchars($traductions['platform']) ?></h3>
        <ul>
            <?php foreach ($gameWithEverything['platforms'] as $platform): ?>
                <li class="details"><?= htmlspecialchars($platform) ?></li>
            <?php endforeach; ?>
        </ul>
        <h3><?= htmlspecialchars($traductions['game_mode']) ?></h3>
        <ul>
            <?php if ($gameWithEverything['has_single_player']): ?>
                <li class="details"><?= htmlspecialchars($traductions['single_player']) ?></li>
            <?php endif; ?>
            <?php if ($gameWithEverything['has_multiplayer']): ?>
                <li class="details"><?= htmlspecialchars($traductions['multiplayer']) ?></li>
            <?php endif; ?>
            <?php if ($gameWithEverything['has_coop']): ?>
                <li class="details"><?= htmlspecialchars($traductions['coop']) ?></li>
            <?php endif; ?>
            <?php if ($gameWithEverything['has_pvp']): ?>
                <li class="details"><?= htmlspecialchars($traductions['pvp']) ?></li>
            <?php endif; ?>
        </ul>
    </main>
</body>

</html>