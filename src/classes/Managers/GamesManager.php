<?php

namespace Managers;

use Games\Game;

require_once __DIR__ . '/../../utils/autoloader.php';
use PDO; 
use Database;
use PDOException;

class GamesManager implements GamesManagerInterface
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
        INNER JOIN game_studios ON games.id = game_studios.game_id
        INNER JOIN studios ON game_studios.studios_id = studios.id;";

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
        INNER JOIN game_studios ON games.id = game_studios.game_id
        INNER JOIN studios ON game_studios.studios_id = studios.id
        INNER JOIN game_categories ON games.id = game_categories.game_id
        INNER JOIN categories ON game_categories.category_id = categories.id
        INNER JOIN game_platforms ON games.id = game_platforms.game_id
        INNER JOIN platforms ON game_platforms.platform_id = platforms.id

        WHERE games.id = :id;";

        // Préparation de la requête SQL
        $stmt = $this->database->getPdo()->prepare($sql);

        // Exécution de la requête SQL
        $stmt->execute(['id' => $id]);

        // Récupération de tous les jeux
        $gameWithEverything = $stmt->fetch();
 
        // Retour de tous les jeux
        return $gameWithEverything;
    }

    public function addGame(Game $game): int
    {
        // Définition de la requête SQL pour ajouter un jeu
        $sql = "INSERT INTO games (
            name,
            release_date,
            game_min_age,
            has_single_player,
            has_multi_player,
            has_coop,
            has_pvp
        ) VALUES (
            :name,
            :release_date,
            :game_min_age,
            :has_single_player,
            :has_multi_player,
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
        $stmt->bindValue(':has_multi_player', $game->getHasMultiPlayer(), PDO::PARAM_BOOL);
        $stmt->bindValue(':has_coop', $game->getHasCoop(), PDO::PARAM_BOOL);
        $stmt->bindValue(':has_pvp', $game->getHasPvp(), PDO::PARAM_BOOL);

        // Exécution de la requête SQL pour ajouter un jeu
        $stmt->execute();

        // Récupération de l'identifiant de le jeu ajouté
        $gameId = $this->database->getPdo()->lastInsertId();

        // Retour de l'identifiant du jeu ajouté.
        return $gameId;
    } catch (PDOException $e){
         error_log("Erreur lors de l'ajout de l'utilisateur : " . $e->getMessage());
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
    /*
    public function linkGameToStudio(Game $game, Studio $studio): void
    {
        $sql = "INSERT INTO game_studios (gameId, studioId) VALUES (:game_id, :studio_id)";

        $stmt = $this->database->getPdo()->prepare($sql);

        $stmt->bindValue(':game_id', $game->getId());
        $stmt->bindValue(':studio_id', $studio->getId());
    }
        */
};
