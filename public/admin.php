<?php

use Managers\GamesManager;

require_once __DIR__ . '/../src/classes/Managers/GamesManager.php';
require_once __DIR__ . '/../src/i18n/load-translation.php';
const DATABASE_CONFIGURATION_FILE = __DIR__ . '/../src/config/database.ini';

//Cookies
const COOKIE_NAME = 'lang';
const COOKIE_LIFETIME = 120 * 24 * 60 * 60;
const DEFAULT_LANG = 'fr';

$lang = $_COOKIE[COOKIE_NAME] ?? DEFAULT_LANG;
$traductions = loadTranslation($lang);

session_start();

//Vérif si l'utilisateur est authentifié

$userId = $_SESSION['user_id'] ?? null;

if (!$userId) {
    header('Location: auth/login.php');
    exit();
}

$username = $_SESSION['username'];

//Gestion de la BD
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

$gamesManager = new GamesManager();

//Récupérer les listes pour les formulaires

$platforms = $gamesManager->getAllPlatforms();
$categories = $gamesManager->getAllCategories();
$studios = $gamesManager->getAllStudios();
$games = $gamesManager->getGamesWithStudio();

$successMessage = '';
$errorMessage = '';

// Traitement des formulaires
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Ajout d'un jeu
    if (isset($_POST['action']) && $_POST['action'] === 'add') {
        $name = $_POST['name'] ?? '';
        $releaseDate = $_POST['release_date'] ?? '';
        $minAge = (int)($_POST['min_age'] ?? 0);
        $studioName = trim($_POST['studio_name'] ?? '');

        // Modes de jeu
        $hasSinglePlayer = isset($_POST['has_single_player']);
        $hasMultiplayer = isset($_POST['has_multiplayer']);
        $hasCoop = isset($_POST['has_coop']);
        $hasPvp = isset($_POST['has_pvp']);

        // Plateformes et catégories (arrays de IDs)
        $platformIds = $_POST['platforms'] ?? [];
        $categoryIds = $_POST['categories'] ?? [];

        // Validation basique
        if (empty($name) || empty($releaseDate) || empty($studioName) || empty($platformIds) || empty($categoryIds)) {
            $errorMessage = "Tous les champs obligatoires doivent être remplis.";
        } else {
            $gameId = $gamesManager->addGameWithEverything(
                $name,
                $releaseDate,
                $minAge,
                $hasSinglePlayer,
                $hasMultiplayer,
                $hasCoop,
                $hasPvp,
                $studioName,
                $platformIds,
                $categoryIds
            );

            if ($gameId) {
                $successMessage = "Le jeu '$name' a été ajouté avec succès !";
                // Recharger la liste des jeux
                $games = $gamesManager->getGamesWithStudio();
            } else {
                $errorMessage = "Erreur lors de l'ajout du jeu.";
            }
        }
    }

    // Suppression d'un jeu
    if (isset($_POST['action']) && $_POST['action'] === 'delete') {
        $gameId = (int)($_POST['game_id'] ?? 0);

        if ($gamesManager->removeGameWithEverything($gameId)) {
            $successMessage = "Jeu supprimé";
            // Recharger la liste des jeux
            $games = $gamesManager->getGamesWithStudio();
        } else {
            $errorMessage = "Erreur lors de la suppression du jeu.";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="<?= htmlspecialchars($lang) ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="./css/style.css">
    <title><?= htmlspecialchars($traductions['gestion_des_jeux']) ?></title>
</head>

<body>
    <main class="container">
        <p><a href="index.php"><?= htmlspecialchars($traductions['return_home']) ?></a> > <a href="private.php"><?= htmlspecialchars($traductions['private_page']) ?></a> > Administration</p>

        <h1><?= htmlspecialchars($traductions['gestion_des_jeux']) ?></h1>

        <?php if ($successMessage): ?>
            <div class="success"><?= htmlspecialchars($successMessage) ?></div>
        <?php endif; ?>

        <?php if ($errorMessage): ?>
            <div class="error"><?= htmlspecialchars($errorMessage) ?></div>
        <?php endif; ?>

        <!-- formulaire d'ajout -->
        <h2><?= htmlspecialchars($traductions['add_game']) ?></h2>
        <form method="post" action="admin.php">
            <input type="hidden" name="action" value="add">

            <div class="form-group">
                <label for="name"><?= htmlspecialchars($traductions['game_name']) ?></label>
                <input type="text" id="name" name="name" required>
            </div>

            <div class="form-group">
                <label for="release_date"><?= htmlspecialchars($traductions['release_date']) ?></label>
                <input type="date" id="release_date" name="release_date" required>
            </div>

            <div class="form-group">
                <label for="min_age"><?= htmlspecialchars($traductions['game_min_age']) ?></label>
                <input type="number" id="min_age" name="min_age" min="0" max="18" value="0" required>
            </div>

            <div class="form-group">
                <label for="studio_name"><?= htmlspecialchars($traductions['studio_name']) ?> * (<?= htmlspecialchars($traductions['created_automatically']) ?>)</label>
                <input type="text" id="studio_name" name="studio_name" list="studios-list" required>
                <datalist id="studios-list">
                    <?php foreach ($studios as $studio): ?>
                        <option value="<?= htmlspecialchars($studio['name']) ?>">
                        <?php endforeach; ?>
                </datalist>
            </div>

            <div class="form-group">
                <label><?= htmlspecialchars($traductions['game_mode']) ?>(s)</label>
                <div class="checkbox-group">
                    <div class="checkbox-item">
                        <input type="checkbox" id="has_single_player" name="has_single_player" value="1">
                        <label for="has_single_player"><?= htmlspecialchars($traductions['single_player']) ?></label>
                    </div>
                    <div class="checkbox-item">
                        <input type="checkbox" id="has_multiplayer" name="has_multiplayer" value="1">
                        <label for="has_multiplayer"><?= htmlspecialchars($traductions['multiplayer']) ?></label>
                    </div>
                    <div class="checkbox-item">
                        <input type="checkbox" id="has_coop" name="has_coop" value="1">
                        <label for="has_coop"><?= htmlspecialchars($traductions['coop']) ?></label>
                    </div>
                    <div class="checkbox-item">
                        <input type="checkbox" id="has_pvp" name="has_pvp" value="1">
                        <label for="has_pvp"><?= htmlspecialchars($traductions['pvp']) ?></label>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label><?= htmlspecialchars($traductions['platform']) ?> * <?= htmlspecialchars($traductions['selection_multiple']) ?></label>
                <div class="checkbox-group">
                    <?php foreach ($platforms as $platform): ?>
                        <div class="checkbox-item">
                            <input type="checkbox" id="platform_<?= $platform['id'] ?>"
                                name="platforms[]" value="<?= $platform['id'] ?>">
                            <label for="platform_<?= $platform['id'] ?>"><?= htmlspecialchars($platform['name']) ?></label>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="form-group">
                <label><?= htmlspecialchars($traductions['categories']) ?> * (<?= htmlspecialchars($traductions['selection_multiple']) ?>)</label>
                <div class="checkbox-group">
                    <?php foreach ($categories as $category): ?>
                        <div class="checkbox-item">
                            <input type="checkbox" id="category_<?= $category['id'] ?>"
                                name="categories[]" value="<?= $category['id'] ?>">
                            <label for="category_<?= $category['id'] ?>"><?= htmlspecialchars($category['name']) ?></label>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <button type="submit"><?php echo htmlspecialchars($traductions['add_game']); ?></button>
        </form>

        <!-- Liste de jeux -->
        <h2><?= htmlspecialchars($traductions['list_of_games']) ?></h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th><?= htmlspecialchars($traductions['game_name']) ?></th>
                    <th><?= htmlspecialchars($traductions['studio_name']) ?></th>
                    <th><?= htmlspecialchars($traductions['release_date']) ?></th>
                    <th><?= htmlspecialchars($traductions['game_min_age']) ?></th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($games as $game): ?>
                    <tr>
                        <td><?= htmlspecialchars($game['game_id']) ?></td>
                        <td><?= htmlspecialchars($game['game_name']) ?></td>
                        <td><?= htmlspecialchars($game['studio_name']) ?></td>
                        <td><?= htmlspecialchars($game['release_date']) ?></td>
                        <td><?= htmlspecialchars($game['game_min_age']) ?></td>
                        <td>
                            <form method="post" style="display:inline">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="game_id" value="<?= $game['game_id'] ?>">
                                <button type="submit" class="empty">🗑️</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <p><a href="index.php"><?= htmlspecialchars($traductions['return_home']) ?></a> | <a href="private.php"><?= htmlspecialchars($traductions['my_favorites']) ?></a></p>
    </main>
</body>

</html>