<?php

namespace Managers;

use Users\User;

require_once __DIR__ . '/../../utils/autoloader.php';

use Database;

class UserManager implements UserManagerInterface
{
    private $database;

    public function __construct()
    {
        $this->database = new Database();
    }

    public function getUsers(): array
    {
        // Définition de la requête SQL pour récupérer tous les jeux
        $sql = "SELECT * FROM users";

        // Préparation de la requête SQL
        $stmt = $this->database->getPdo()->prepare($sql);

        // Exécution de la requête SQL
        $stmt->execute();

        // Récupération de tous les users
        $users = $stmt->fetchAll();

        // Retour de tous les users
        return $users;
    }
    public function addUser(User $user): int
    {
        // Définition de la requête SQL pour ajouter un jeu
        $sql = "INSERT INTO users(
            username,
            password,
            email,
            role,
            birthdate,
            biography,
            createdAt
        ) VALUES (
            :username,
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
        $stmt->bindValue(':username', $user->getUsername());
        $stmt->bindValue(':password', $user->getPassword());
        $stmt->bindValue(':email', $user->getEmail());
        $stmt->bindValue(':role', $user->getRole());
        $stmt->bindValue(':birthdate', $user->getBirthdate());
        $stmt->bindValue(':createdAt', $user->getCreatedAt());


        // Exécution de la requête SQL pour ajouter un user
        $stmt->execute();

        // Récupération de l'identifiant du user ajouté
        $userId = $this->database->getPdo()->lastInsertId();

        // Retour de l'identifiant du user ajouté.
        return $userId;
    }
    public function removeUser(int $id): bool
    {
        // Définition de la requête SQL pour supprimer un user
        $sql = "DELETE FROM users WHERE id = :id";

        // Préparation de la requête SQL
        $stmt = $this->database->getPdo()->prepare($sql);

        // Lien avec le paramètre
        $stmt->bindValue(':id', $id);

        // Exécution de la requête SQL pour supprimer un user
        return $stmt->execute();
    }
};
