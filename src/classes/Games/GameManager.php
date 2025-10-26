<?php

namespace Games;

require_once __DIR__ . '/../../utils/autoloader.php';

use Database;

class GamesManager implements GamesManagerInterface
{
    private $database;

    public function __construct()
    {
        $this->database = new Database();
    }

    public function getgames(): array
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
        $stmt->bindValue(':name', $game->getName());
        //  $stmt->bindValue(':image_slug', $game->getImageSlug());
        $stmt->bindValue(':release_date', $game->getReleaseDate());
        $stmt->bindValue(':game_min_age', $game->getMinAge());
        $stmt->bindValue(':has_single_player', $game->getHasSinglePlayer());
        $stmt->bindValue(':has_multi_player', $game->getHasMultiPlayer());
        $stmt->bindValue(':has_coop', $game->getHasCoop());
        $stmt->bindValue(':has_pvp', $game->getHasPvp());

        // Exécution de la requête SQL pour ajouter un jeu
        $stmt->execute();

        // Récupération de l'identifiant de le jeu ajouté
        $gameId = $this->database->getPdo()->lastInsertId();

        // Retour de l'identifiant du jeu ajouté.
        return $gameId;
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
};
