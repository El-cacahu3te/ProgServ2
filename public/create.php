<?php

require __DIR__ . '/../src/utils/autoloader.php';

use Managers\UserManager;
use User\User;

// Création d'une instance de UserManager
$userManager = new UserManager();

// Gère la soumission du formulaire
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Récupération des données du formulaire
    $username = $_POST["username"];
    $password = $_POST["password"];
    $email = $_POST["email"];
    $birthdate = $_POST["birthdate"];
    $bio = $_POST["biographie"]; 
}

    try {
        // Création d'un nouvel objet `User`
        $user = new User(
            null, // Comme c'est une création, l'ID est null. La base de données l'assignera automatiquement.
            $username,
            $password,
            $email,
            $birthdate,
            $bio //la date de création sera assigné automatiquement 
        );
    } catch (InvalidArgumentException $e) {
        $errors[] = $e->getMessage();
    }


    // S'il n'y a pas d'erreurs, ajout de l'utilisateur
    if (empty($errors)) {
        try {
            // Ajout de l'utilisateur à la base de données
            $userManager->addUser($user);

            // Redirection vers la page d'accueil avec tous les utilisateurs
            header("Location: index.php");
            exit();
        } catch (PDOException $e) {
            // Liste des codes d'erreurs : https://en.wikipedia.org/wiki/SQLSTATE
            if ($e->getCode() === "23000") {
                // Erreur de contrainte d'unicité (par exemple, email déjà utilisé)
                $errors[] = "L'adresse e-mail est déjà utilisée.";
            } else {
                $errors[] = "Erreur lors de l'interaction avec la base de données : " . $e->getMessage();
            }
        } catch (Exception $e) {
            $errors[] = "Erreur inattendue : " . $e->getMessage();
        }
    }

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Créez votre compte</title>
</head>

<body>
    <main class="container">
        <h1>Créez votre compte !</h1>

        <?php if ($_SERVER["REQUEST_METHOD"] === "POST") { ?>
            <?php if (empty($errors)) { ?>
                <p style="color: green;">Le formulaire a été soumis avec succès !</p>
            <?php } else { ?>
                <p style="color: red;">Le formulaire contient des erreurs :</p>
                <ul>
                    <?php foreach ($errors as $error) { ?>
                        <li><?php echo $error; ?></li>
                    <?php } ?>
                </ul>
            <?php } ?>
        <?php } ?>

        <form action="create.php" method="POST">
            <label for="username">Pseudonyme</label>
            <input type="text" id="username" name="username" value="<?= htmlspecialchars($username ?? ''); ?>" required minlength="2">

            <label for="password">Mot de passe</label>
            <input type="password" id="password" name="password" value="<?= htmlspecialchars($password ?? ''); ?>" required minlength="6">

            <label for="email">E-mail</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($email ?? ''); ?>" required>

            <label for="birthdate">Date de naissance</label>
            <input type="number" id="birthdate" birthdate="age" value="<?= htmlspecialchars($birthdate ?? ''); ?>" required min="0">

            <label for="biographie">Biographie</label>
            <input type="text" id="biographie" value="<?= htmlspecialchars($bio ?? ''); ?>" required maxlength="300">


            <button type="submit">Créer</button>
        </form>
    </main>
</body>

</html>