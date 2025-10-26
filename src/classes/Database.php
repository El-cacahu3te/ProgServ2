<?php
class Database implements DatabaseInterface
{
    const DATABASE_CONFIGURATION_FILE = __DIR__ . '/../config/database.ini';

    private $pdo;

    public function __construct()
    {
        // Documentation : https://www.php.net/manual/fr/function.parse-ini-file.php
        $config = parse_ini_file(self::DATABASE_CONFIGURATION_FILE, true);

        if (!$config) {
            throw new Exception("Erreur lors de la lecture du fichier de configuration : " . self::DATABASE_CONFIGURATION_FILE);
        }

        $host = $config['host'];
        $port = $config['port'];
        $database = $config['database'];
        $username = $config['username'];
        $password = $config['password'];

        // Documentation :
        //   - https://www.php.net/manual/fr/pdo.connections.php
        //   - https://www.php.net/manual/fr/ref.pdo-mysql.connection.php
        $this->pdo = new PDO("mysql:host=$host;port=$port;charset=utf8mb4", $username, $password);

        // Création de la base de données si elle n'existe pas
        $sql = "CREATE DATABASE IF NOT EXISTS `$database` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        // Sélection de la base de données
        $sql = "USE `$database`;";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        // Création de la table `users` si elle n'existe pas
        $sqlUser = "CREATE TABLE IF NOT EXISTS user (
            id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(100) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL, 
            email VARCHAR(255) NOT NULL UNIQUE,
            birthdate DATE NOT NULL,
            bio TEXT, 
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        );";

        $stmt = $this->pdo->prepare($sqlUser);

        $stmt->execute();

        // Création de la table `games` si elle n'existe pas
        $sqlGame = "CREATE TABLE IF NOT EXISTS game (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            release_date DATE NOT NULL,
            game_min_age INTEGER NOT NULL,
            has_single_player BOOLEAN DEFAULT FALSE,
            has_multiplayer BOOLEAN DEFAULT FALSE,
            has_coop BOOLEAN DEFAULT FALSE,
            has_pvp BOOLEAN DEFAULT FALSE
        );";

        $stmt = $this->pdo->prepare($sqlGame);

        $stmt->execute();
    }

    public function getPdo(): PDO
    {
        return $this->pdo;
    }
}
