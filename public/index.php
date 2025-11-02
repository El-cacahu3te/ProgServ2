<?php

use Managers\GamesManager;

require_once __DIR__ . '/../src/classes/Managers/GamesManager.php';

const DATABASE_CONFIGURATION_FILE = __DIR__ . '/../src/config/database.ini';

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
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="color-scheme" content="light dark">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">

    <title>Page d'accueil | GameRat</title>
</head>

<body>
    <main class="container">
        <h1>Dernier jeux</h1>
        <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Date de sortie</th>
                    <th>Âge minimum</th>
                    <th>Studio</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($gamesWithStudio as $game) { ?>
                    <tr>
                        <td><?= htmlspecialchars($game['game_name']) ?></td>
                        <td><?= htmlspecialchars($game['release_date']) ?></td>
                        <td><?= htmlspecialchars($game['game_min_age']) ?></td>
                        <td><?= htmlspecialchars($game['studio_name']) ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </main>
</body>

</html>