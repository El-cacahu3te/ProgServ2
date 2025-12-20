<?php

namespace Managers;

use Games\Game;

require_once __DIR__ . '/../../utils/autoloader.php';

use PDO;
use Database;
use PDOException;
use DateTime;

class GamesManager
{
    private $database;

    public function __construct()
    {
        $this->database = new Database();
    }

    public function getGames(): array
    {
        // Définition de la requête SQL pour récupérer tous les jeux
        $sql = "SELECT * FROM games";

        // Préparation de la requête SQL
        $stmt = $this->database->getPdo()->prepare($sql);

        // Exécution de la requête SQL
        $stmt->execute();

        // Récupération de tous les jeux
        $games = $stmt->fetchAll();

        // Retour de tous les jeux
        return $games;
    }

    public function getGamesWithStudio(): array
    {
        $sql = "SELECT 
        games.id AS game_id,
        games.name AS game_name,
        games.release_date AS release_date,
        games.game_min_age AS game_min_age,
        games.has_single_player AS has_single_player,
        games.has_multiplayer AS has_multiplayer,
        games.has_coop AS has_coop,
        games.has_pvp AS has_pvp,
        studios.name AS studio_name
        FROM games
        INNER JOIN games_studios ON games_studios.games_id = games.id
        INNER JOIN studios ON studios.id = games_studios.studios_id;";

        // Préparation de la requête SQL
        $stmt = $this->database->getPdo()->prepare($sql);

        // Exécution de la requête SQL
        $stmt->execute();

        // Récupération de tous les jeux
        $gamesWithStudio = $stmt->fetchAll();

        // Retour de tous les jeux
        return $gamesWithStudio;
    }

    public function getGameWithEverything(int $id): ?array
    {
        $sql = "SELECT
        games.id AS game_id,
        games.name AS game_name,
        games.release_date AS release_date,
        games.game_min_age AS game_min_age,
        games.has_single_player AS has_single_player,
        games.has_multiplayer AS has_multiplayer,
        games.has_coop AS has_coop,
        games.has_pvp AS has_pvp,
        studios.name AS studio_name,
        categories.name AS category_name,
        platforms.name AS platform_name
        FROM games
        INNER JOIN games_studios ON games_studios.games_id = games.id
        INNER JOIN studios ON studios.id = games_studios.studios_id
        INNER JOIN games_categories ON games_categories.games_id = games.id
        INNER JOIN categories ON categories.id = games_categories.category_id
        INNER JOIN games_platforms ON games_platforms.games_id = games.id
        INNER JOIN platforms ON platforms.id = games_platforms.platforms_id
        WHERE games.id = :id;";

        // Préparation de la requête SQL
        $stmt = $this->database->getPdo()->prepare($sql);

        // Exécution de la requête SQL
        $stmt->execute(['id' => $id]);

        // Récupération de tous les jeux
        $rows = $stmt->fetchAll();

        // Si jamais l'id est faux ou ne correspond à aucun jeu.
        if (!$rows) {
            return null;
        }

        $gameWithEverything = $rows[0];
        $gameWithEverything['has_single_player'] = (bool)$gameWithEverything['has_single_player'];
        $gameWithEverything['has_multiplayer'] = (bool)$gameWithEverything['has_multiplayer'];
        $gameWithEverything['has_coop'] = (bool)$gameWithEverything['has_coop'];
        $gameWithEverything['has_pvp'] = (bool)$gameWithEverything['has_pvp'];
        $gameWithEverything['categories'] = [];
        $gameWithEverything['platforms'] = [];
        // On mets toutes les catégories et plateformes bout à bout s'il y en a plusieurs.
        foreach ($rows as $row) {
            if (!in_array($row['category_name'], $gameWithEverything['categories'])) {
                $gameWithEverything['categories'][] = $row['category_name'];
            }
            if (!in_array($row['platform_name'], $gameWithEverything['platforms'])) {
                $gameWithEverything['platforms'][] = $row['platform_name'];
            }
        }

        // Retour du jeu
        return $gameWithEverything;
    }

    public function addGame(Game $game): ?int
    {
        try {
            // Définition de la requête SQL pour ajouter un jeu
            $sql = "INSERT INTO games (
            name,
            release_date,
            game_min_age,
            has_single_player,
            has_multiplayer,
            has_coop,
            has_pvp
        ) VALUES (
            :name,
            :release_date,
            :game_min_age,
            :has_single_player,
            :has_multiplayer,
            :has_coop,
            :has_pvp
        )";

            // Préparation de la requête SQL
            $stmt = $this->database->getPdo()->prepare($sql);

            // Lien avec les paramètres
            $stmt->bindValue(':name', $game->getName(), PDO::PARAM_STR);
            //  $stmt->bindValue(':image_slug', $game->getImageSlug());
            $stmt->bindValue(':release_date', $game->getReleaseDate(), PDO::PARAM_STR);
            $stmt->bindValue(':game_min_age', $game->getMinAge(), PDO::PARAM_INT);
            $stmt->bindValue(':has_single_player', $game->getHasSinglePlayer(), PDO::PARAM_BOOL);
            $stmt->bindValue(':has_multiplayer', $game->getHasMultiPlayer(), PDO::PARAM_BOOL);
            $stmt->bindValue(':has_coop', $game->getHasCoop(), PDO::PARAM_BOOL);
            $stmt->bindValue(':has_pvp', $game->getHasPvp(), PDO::PARAM_BOOL);

            // Exécution de la requête SQL pour ajouter un jeu
            $stmt->execute();

            // Récupération de l'identifiant de le jeu ajouté
            $gameId = $this->database->getPdo()->lastInsertId();

            // Retour de l'identifiant du jeu ajouté.
            return $gameId;
        } catch (PDOException $e) {
            error_log("Erreur lors de l'ajout du jeu : " . $e->getMessage());
            return null;
        }
    }

    public function addGameWithEverything(
        string $name,
        string $releaseDate,
        int $minAge,
        bool $hasSinglePlayer,
        bool $hasMultiplayer,
        bool $hasCoop,
        bool $hasPvp,
        string $studioName,
        array $platformIds,
        array $categoryIds
    ): int {
        try{
            //Créer le jeu de base
            $game = new Game(
                null,
                $name,
                new DateTime($releaseDate),
                $minAge,
                $hasSinglePlayer,
                $hasMultiplayer,
                $hasCoop,
                $hasPvp
            );

            $gameId = $this->addGame($game);

            //Ajout erreur si ID non trouvé
            if (!$gameId) {
                throw new Exception("Échec de l'ajout du jeu");
            }

            //Lier le studio (ou le créer)
            $studioId = $this->getOrCreateStudio($studioName);
            $stmt = this->database->getPdo()->prepare(
                "INSERT INTO games_platforms (games_id, platforms_id) VALUES (?, ?)"
            );
            $stmt->execute([$gameId, $studioId]);

            //Lier les platerformes
            $stmt = $this->database->getPdo()->prepare(
                "INSERT INTO games_platforms (games_id, platforms_id) VALUES (?, ?)"
            );
            foreach ($platformIds as $platformId) {
                $stmt->execute([$gameId, $platformId]);
            }

            //Lier les catégories
            $stmt = $this->database->getPdo()->prepare(
                "INSERT INTO games_categories (games_id, category_id) VALUES (?, ?)"
            );
            foreach ($categoryIds as $categoryId) {
                $stmt->execute([$gameId, $categoryId]);
            }

            return $gameId;
        }catch (Exception $e){
            //Tout annuler en cas d'erreur
            $this->database->getPdo->rollback();
            error_log("Erreur lors de l'ajout du jeu complet : " . $e->getMessage());
            return null;
        }
    }

    public function removeGame(int $id): bool
    {
        // Définition de la requête SQL pour supprimer un jeu
        $sql = "DELETE FROM games WHERE id = :id";

        // Préparation de la requête SQL
        $stmt = $this->database->getPdo()->prepare($sql);

        // Lien avec le paramètre
        $stmt->bindValue(':id', $id);

        // Exécution de la requête SQL pour supprimer un jeu
        return $stmt->execute();
    }



    // Gestion des favoris
    public function addFavorite(int $userId, int $gameId): bool
    {
        // Vérifie si le jeu existe
        $game = $this->getGameById($gameId);
        if (!$game) {
            return false;
        }

        // Vérifie si le favori existe déjà
        $stmt = $this->database->getPdo()->prepare("
        SELECT 1 FROM users_favorites WHERE users_id = ? AND games_id = ?
    ");
        $stmt->execute([$userId, $gameId]);
        if ($stmt->fetch()) {
            return false; // Déjà en favori
        }

        // Ajoute le favori
        $stmt = $this->database->getPdo()->prepare("
        INSERT INTO users_favorites (users_id, games_id) VALUES (?, ?)
    ");
        return $stmt->execute([$userId, $gameId]);
    }

    /**
     * Supprime un jeu des favoris d'un utilisateur.
     */
    public function removeFavorite(int $userId, int $gameId): bool
    {
        $stmt = $this->database->getPdo()->prepare("
        DELETE FROM users_favorites WHERE users_id = ? AND games_id = ?
    ");
        return $stmt->execute([$userId, $gameId]);
    }

    /**
     * Récupère les favoris d'un utilisateur.
     */
    public function getFavorites(int $userId): array
    {
        $stmt = $this->database->getPdo()->prepare("
        SELECT 
            g.id AS game_id,
            g.name AS game_name,
            g.release_date AS release_date,
            g.game_min_age AS game_min_age,
            g.has_single_player AS has_single_player,
            g.has_multiplayer AS has_multiplayer,
            g.has_coop AS has_coop,
            g.has_pvp AS has_pvp,
            s.name AS studio_name
        FROM games g
        JOIN users_favorites f ON g.id = f.games_id
        JOIN games_studios gs ON gs.games_id = g.id
        JOIN studios s ON s.id = gs.studios_id
        WHERE f.users_id = ?
    ");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function isFavorite(int $userId, int $gameId): bool
    {
        $stmt = $this->database->getPdo()->prepare("
        SELECT 1 FROM users_favorites WHERE users_id = ? AND games_id = ?
    ");
        $stmt->execute([$userId, $gameId]);
        return (bool)$stmt->fetch();
    }


    public function getGameById(int $id): ?Game
    {
        $stmt = $this->database->getPdo()->prepare("SELECT * FROM games WHERE id = ?");
        $stmt->execute([$id]);
        $gameData = $stmt->fetch(PDO::FETCH_ASSOC);
        return $gameData ? new Game(
            $gameData['id'],
            $gameData['name'],
            new DateTime($gameData['release_date']),
            $gameData['game_min_age'],
            $gameData['has_single_player'],
            $gameData['has_multiplayer'],
            $gameData['has_coop'],
            $gameData['has_pvp']
        ) : null;
    }

    public function getOrCreateStudio(string $studioName): int
    {
        // Cherche si le studio existe déjà
        $studio = $this->getStudioByName($studioName);

        if ($studio) {
            return (int)$studio['id'];
        }

        // Sinon, on le crée
        return $this->addStudio($studioName);
    }
};
