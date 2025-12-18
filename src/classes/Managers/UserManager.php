<?php

namespace Managers;

use Users\User;

require_once __DIR__ . '/../../utils/autoloader.php';

use Database;
use PDO;
use PDOException;

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
    public function addUser(User $user): ?int
    {
        try {
            // Définition de la requête SQL pour ajouter un user
            // Rôle à ajouter un jour
            $sql = "INSERT INTO users(
            username,
            password,
            email,
            birthdate,
            bio
            
        ) VALUES (
            :username,
            :password,
            :email,
            :birthdate,
            :bio
        )";

            // Préparation de la requête SQL
            $stmt = $this->database->getPdo()->prepare($sql);

            // Lien avec les paramètres
            $stmt->bindValue(':username', $user->getUsername(), PDO::PARAM_STR);

            // Hash le mdp

            $hashedPassword = password_hash($user->getPassword(), PASSWORD_DEFAULT);
            $stmt->bindValue(':password', $hashedPassword, PDO::PARAM_STR);

            $stmt->bindValue(':email', $user->getEmail(), PDO::PARAM_STR);
            // $stmt->bindValue(':role', $user->getRole(),PDO::PARAM_STR);
            $stmt->bindValue(':birthdate', $user->getBirthdate()->format('Y-m-d'), PDO::PARAM_STR);
            $stmt->bindValue(':bio', $user->getBiography(), PDO::PARAM_STR);

            // Exécution de la requête SQL pour ajouter un user
            $stmt->execute();

            // Récupération de l'identifiant du user ajouté
            $userId = $this->database->getPdo()->lastInsertId();


            // Retour de l'identifiant du user ajouté.
            return (int) $userId;
        } catch (PDOException $e) {
            error_log("Erreur lors de l'ajout de l'utilisateur : " . $e->getMessage());
            return null;
        }
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
    public function getUserIdByEmail(string $email): ?int
    {
        $stmt = $this->database->getPdo()->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? (int)$row['id'] : null;
    }
};
