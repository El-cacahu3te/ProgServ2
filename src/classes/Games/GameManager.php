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
        // Définition de la requête SQL pour récupérer tous les utilisateurs
        $sql = "SELECT * FROM games";

        // Préparation de la requête SQL
        $stmt = $this->database->getPdo()->prepare($sql);

        // Exécution de la requête SQL
        $stmt->execute();

        // Récupération de tous les utilisateurs
        $games = $stmt->fetchAll();

        // Retour de tous les utilisateurs
        return $games;
    }

    public function addGame(Game $game): int
    {
        // Définition de la requête SQL pour ajouter un utilisateur
        $sql = "INSERT INTO games (
            name,
            image_slug,
            types,
            platforms,
            release_date,
            ratings,
            average_rating,
            price
        ) VALUES (
            :name,
            :image_slug,
            :types,
            :platforms,
            :release_date,
            :ratings,
            :average_rating,
            :price
        )";

        // Préparation de la requête SQL
        $stmt = $this->database->getPdo()->prepare($sql);

        // Lien avec les paramètres
        $stmt->bindValue(':name', $game->getName());
        $stmt->bindValue(':image_slug', $game->getImageSlug());
        $stmt->bindValue(':types', json_encode($game->getTypes()));
        $stmt->bindValue(':platforms', json_encode($game->getPlatforms()));
        $stmt->bindValue(':release_date', $game->getReleaseDate());
        $stmt->bindValue(':ratings', json_encode($game->getRatings()));
        $stmt->bindValue(':average_rating', $game->getAverageRating());
        $stmt->bindValue(':price', $game->getPrice());

        // Exécution de la requête SQL pour ajouter un utilisateur
        $stmt->execute();

        // Récupération de l'identifiant de l'utilisateur ajouté
        $gameId = $this->database->getPdo()->lastInsertId();

        // Retour de l'identifiant de l'utilisateur ajouté.
        return $gameId;
    }

    public function removeGame(int $id): bool
    {
        // Définition de la requête SQL pour supprimer un utilisateur
        $sql = "DELETE FROM games WHERE id = :id";

        // Préparation de la requête SQL
        $stmt = $this->database->getPdo()->prepare($sql);

        // Lien avec le paramètre
        $stmt->bindValue(':id', $id);

        // Exécution de la requête SQL pour supprimer un utilisateur
        return $stmt->execute();
    }
};
