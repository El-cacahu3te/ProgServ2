<?php

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

// L'utilisateur n'est pas authentifié
if (!$userId) {
    // Redirige vers la page de connexion si l'utilisateur n'est pas authentifié
    header('Location: auth/login.php');
    exit();
}

// Sinon, récupère les autres informations de l'utilisateur
$username = $_SESSION['username'];
$email = $_SESSION['email'];
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
        <p>
        <a href="games.php"><?= htmlspecialchars($traductions['games_list']) ?></a> |
        <a href="favorites.php"><?= htmlspecialchars($traductions['my_favorites']) ?></a> |
        <a href="auth/logout.php"><?= htmlspecialchars($traductions['logout']) ?></a>
        </p>
        
        <ul>
            <li><strong><?= htmlspecialchars($traductions['private_id']) ?></strong> <?= htmlspecialchars($userId) ?></li>
            <li><strong><?= htmlspecialchars($traductions['private_username']) ?></strong> <?= htmlspecialchars($username) ?></li>
            <li><strong>Email :</strong> <?= htmlspecialchars($email) ?></li>
        </ul>

        <p><a href="index.php"><?= htmlspecialchars($traductions['return_home']) ?></a> | <a href="auth/logout.php"><?= htmlspecialchars($traductions['logout']) ?></a></p>
    </main>


</body>

</html>