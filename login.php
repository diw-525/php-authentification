<?php

// Afficher le formulaire (email, password)
// Traiter le formulaire
// - Vérifier que l'email est présent en BDD
// - S'il existe :
//   - On peut comparer le mot de passe saisi avec le hash
//   - Avec password_verify ?
//   - Si c'est true, on connecte le user
//     - On démarre la session, on ajoute le user dans la session
//   - Si c'est false, on affiche un message d'erreur
// - S'il n'existe pas (l'email) :
//   - On affiche un message d'erreur

// Dans la navbar, on affiche le pseudo de l'utilisateur dès qu'il est connecté.

require 'config/config.php';
require 'views/partials/header.php';

$error = $email = $password = null;
if (!empty($_POST)) { // Traitement du login
    $email = sanitize($_POST['email']);
    $password = sanitize($_POST['password']);

    // - Vérifier que l'email est présent en BDD
    $query = $db->prepare('SELECT * FROM user
    WHERE email = :email OR pseudo = :email');
    $query->execute(['email' => $email]); // ->execute(compact('email'))
    $user = $query->fetch();

    if ($user) { // On va vérifier le mot de passe

        // Retourne true si le hash correspond au mot de passe
        $isValid = password_verify($password, $user['password']);

        if ($isValid) {
            // Je dois me connecter avec la session
            $_SESSION['user'] = [
                'pseudo' => $user['pseudo'],
                'email' => $user['email'],
            ];

            redirect(); // redirige vers la home
        } else {
            // On a une erreur
            $error = 'Mot de passe invalide';
        }  

    } else { // On a une erreur
        $error = 'Mot de passe invalide';
    }
}

?>

<div class="container">
    <?= $error; ?>

    <form action="" method="POST">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" class="form-control" value="<?= $email; ?>">

        <label for="password">Mot de passe</label>
        <input type="password" name="password" id="password" class="form-control" value="<?= $password; ?>">

        <button>Connexion</button>
    </form>
</div>

<?php require 'views/partials/footer.php';
