<?php

use Managers\GamesManager;

require_once __DIR__ . '/../src/classes/Managers/GamesManager.php';
require_once __DIR__ . '/../src/i18n/load-translation.php';
const DATABASE_CONFIGURATION_FILE = __DIR__ . '/../src/config/database.ini';

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

// L'utilisateur n'est pas authentifié
if (!$userId) {
    // Redirige vers la page de connexion si l'utilisateur n'est pas authentifié
    header('Location: auth/login.php');
    exit();
}

// Sinon, récupère les autres informations de l'utilisateur
$username = $_SESSION['username'];
$email = $_SESSION['email'];

// Gestion base de données (pour aller récupérer les favoris)
$config = parse_ini_file(DATABASE_CONFIGURATION_FILE);

if (!$config) {
    throw new Exception("Erreur lors de la lecture du fichier de configuration : " . DATABASE_CONFIGURATION_FILE);
}

$host = $config['host'];
$port = $config['port'];
$database = $config['database'];
$dbUsername = $config['username'];
$password = $config['password'];

$pdo = new PDO("mysql:host=$host;port=$port;charset=utf8mb4", $dbUsername, $password);

$gamesManager = new GamesManager($pdo);

//Récupérer les favoris de l'utilisateur
$gamesFavorites = $gamesManager->getFavorites($userId);


// Gérer la suppression de favoris
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'], $_POST['game_id'])) {
    $gameId = (int)$_POST['game_id'];
    if ($_POST['action'] === 'removeFavorite') {
        $gamesManager->removeFavorite($userId, $gameId);
        header('Location: private.php');
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="./css/style.css">
    <title>Gestion du compte</title>
</head>

<body>
    <main class="container">
        <h1><?= htmlspecialchars($traductions['private_page']) ?></h1>

        <p><?= htmlspecialchars($traductions['private_msg']) ?></p>
        <p><strong><?= htmlspecialchars($traductions['private_welcome']) ?></strong></p>
        
        <ul>
            <li><strong><?= htmlspecialchars($traductions['private_id']) ?></strong> <?= htmlspecialchars($userId) ?></li>
            <li><strong><?= htmlspecialchars($traductions['private_username']) ?></strong> <?= htmlspecialchars($username) ?></li>
            <li><strong>Email :</strong> <?= htmlspecialchars($email) ?></li>
        </ul>

        <h2><?= htmlspecialchars($traductions['my_favorites']) ?></h2>

        <?php if (empty($gamesFavorites)): ?>
            <p><?= htmlspecialchars($traductions['no_favorites'] ?? 'Vous n\'avez pas encore de jeux favoris.') ?></p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th><?= htmlspecialchars($traductions['game_name']) ?></th>
                        <th><?= htmlspecialchars($traductions['release_date']) ?></th>
                        <th><?= htmlspecialchars($traductions['game_min_age']) ?></th>
                        <th><?= htmlspecialchars($traductions['studio_name']) ?></th>
                        <th><?= htmlspecialchars($traductions['favorite']) ?></th>
                        <th><?= htmlspecialchars($traductions['view']) ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($gamesFavorites as $game) { ?>
                        <tr>
                            <td><?= htmlspecialchars($game['game_name']) ?></td>
                            <td><?= htmlspecialchars($game['release_date']) ?></td>
                            <td><?= htmlspecialchars($game['game_min_age']) ?></td>
                            <td><?= htmlspecialchars($game['studio_name']) ?></td>
                            <td>
                                <form method="post" style="display:inline">
                                    <input type="hidden" name="action" value="removeFavorite">
                                    <input type="hidden" name="game_id" value="<?= $game['game_id'] ?>">
                                    <button class="empty" type="submit">❤️</button>
                                </form>
                            </td>
                            <td><a href="view.php?id=<?= $game['game_id'] ?>">➡️</a></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php endif; ?>


        <p><a href="index.php"><?= htmlspecialchars($traductions['return_home']) ?></a> 
        | <a href="auth/logout.php"><?= htmlspecialchars($traductions['logout']) ?></a> | <a href="admin.php"><?= htmlspecialchars($traductions['gestion_des_jeux']) ?></a></p>
    </main>


</body>

</html>