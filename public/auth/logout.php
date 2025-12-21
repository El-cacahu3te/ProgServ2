<?php

require_once __DIR__ . '/../../src/i18n/load-translation.php';


//GESTION DES COOKIES
const COOKIE_NAME = 'lang';
const COOKIE_LIFETIME = 120 * 24 * 60 * 60; // 120 jours
const DEFAULT_LANG = 'fr';

$lang = $_COOKIE[COOKIE_NAME] ?? DEFAULT_LANG;
$traductions = loadTranslation($lang);


// Démarrer la session
session_start();

// Vérifie si l'utilisateur est authentifié
$userId = $_SESSION['user_id'] ?? null;

// Détruit la session
session_destroy();
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../css/style.css">
    <title><?= $traductions['logout'] ?></title>
</head>

<body>
    <main class="container">
        <h1><?= $traductions['logout_success'] ?></h1>
        <p><a href="../index.php"><?= $traductions['return_home'] ?></a> | <a href="login.php"><?= $traductions['login'] ?></a></p>
    </main>
</body>

</html>