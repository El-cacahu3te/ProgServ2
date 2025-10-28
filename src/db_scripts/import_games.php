<?php 
/**
 * Script d'import des jeux depuis game.csv
 * À placer dans : src/db_scripts/import_games.php
 */

if (!isset($_GET['confirm']) || $_GET['confirm'] !== 'yes') {
    ?>
    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Import Games</title>
        <style>
            body { font-family: Arial, sans-serif; max-width: 600px; margin: 50px auto; padding: 20px; }
            .warning { background: #fff3cd; border: 2px solid #ffc107; padding: 20px; border-radius: 5px; }
            .btn { display: inline-block; background: #dc3545; color: white; padding: 15px 30px;
                   text-decoration: none; border-radius: 5px; font-weight: bold; margin-top: 20px; }
            .btn:hover { background: #c82333; }
        </style>
    </head>
    <body>
        <div class="warning">
            <h1>⚠️ ATTENTION</h1>
            <p><strong>Cette action va :</strong></p>
            <ul>
                <li>VIDER complètement la table <code>game</code></li>
                <li>IMPORTER les données depuis <code>game.csv</code></li>
            </ul>
            <p><strong>Êtes-vous sûr de vouloir continuer ?</strong></p>
            <a href="?confirm=yes" class="btn">OUI, lancer l'import</a>
        </div>
    </body>
    </html>
    <?php
    exit;
}

// ═══════════════════════════════════════════════════════════════════
// LECTURE DE LA CONFIGURATION
// ═══════════════════════════════════════════════════════════════════

// __DIR__ = /chemin/vers/src/db_scripts
// On remonte d'un niveau pour aller dans /src puis dans /config
$configPath = __DIR__ . '/../config/database.ini';

if (!file_exists($configPath)) {
    die("❌ Fichier de configuration introuvable : $configPath");
}

$config = parse_ini_file($configPath);

$host = $config['host'];
$port = $config['port'];
$database = $config['database'];
$username = $config['username'];
$password = $config['password'];

echo "📋 Configuration chargée<br>";

// ═══════════════════════════════════════════════════════════════════
// CONNEXION À LA BASE DE DONNÉES
// ═══════════════════════════════════════════════════════════════════

try {
    $pdo = new PDO(
        "mysql:host=$host;port=$port;dbname=$database;charset=utf8mb4",
        $username,
        $password
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "✅ Connexion réussie !<br>";
} catch (PDOException $e) {
    die("❌ Erreur de connexion : " . $e->getMessage());
}

// ═══════════════════════════════════════════════════════════════════
// VIDAGE DE LA TABLE
// ═══════════════════════════════════════════════════════════════════

try {
    $pdo->exec("TRUNCATE TABLE game"); 
    echo "✅ Table game vidée !<br>";
} catch (PDOException $e) {
    die("❌ Erreur lors du vidage : " . $e->getMessage());
}

// ═══════════════════════════════════════════════════════════════════
// PRÉPARATION DE LA REQUÊTE
// ═══════════════════════════════════════════════════════════════════

$sql = "INSERT INTO game (name, release_date, game_min_age, has_single_player, has_multiplayer, has_coop, has_pvp)
        VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = $pdo->prepare($sql);
echo "✅ Requête préparée !<br><br>";

// ═══════════════════════════════════════════════════════════════════
// OUVERTURE DU FICHIER CSV
// ═══════════════════════════════════════════════════════════════════

// CORRECTION : Utiliser __DIR__ pour le chemin absolu
$csvPath = __DIR__ . '/game.csv';

if (!file_exists($csvPath)) {
    die("❌ Fichier CSV introuvable : $csvPath");
}

$file = fopen($csvPath, 'r');

if (!$file) {
    die("❌ Erreur : impossible d'ouvrir game.csv");
}

echo "✅ Fichier CSV ouvert !<br><br>";

fgetcsv($file); // Ignore la première ligne (en-têtes)

$compteur = 0;
$erreurs = 0;

while ($ligne = fgetcsv($file)) {
    try {
        $stmt->execute($ligne);
        $compteur++;
        echo "✅ Jeu inséré : " . htmlspecialchars($ligne[0]) . "<br>";
    } catch (PDOException $e) {
        $erreurs++;
        echo "❌ Erreur pour " . htmlspecialchars($ligne[0]) . " : " . $e->getMessage() . "<br>";
    }
}

fclose($file);

// ═══════════════════════════════════════════════════════════════════
// RÉSUMÉ
// ═══════════════════════════════════════════════════════════════════

echo "<br>";
echo "<div style='background: #d4edda; padding: 20px; border-radius: 5px; border: 2px solid #28a745;'>";
echo "<h2 style='margin: 0;'>🎉 Import terminé !</h2>";
echo "<p style='font-size: 1.2em; margin: 10px 0;'>";
echo "<strong>$compteur</strong> jeux insérés avec succès";
if ($erreurs > 0) {
    echo "<br><span style='color: #856404;'><strong>$erreurs</strong> erreur(s)</span>";
}
echo "</p>";
echo "</div>";
?>