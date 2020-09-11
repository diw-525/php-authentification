<?php

// Afficher un formulaire

require 'config/config.php';
require 'views/partials/header.php';

// Traiter le formulaire
$errors = [];
$email = $pseudo = null; // Initialisation des champs

if (!empty($_POST)) { // Quand le formulaire est soumis
    foreach ($_POST as $field => $value) {
        $$field = sanitize($value); // $email = sanitize($_POST['email']);
    }

    // $email = sanitize($_POST['email']);
    // $pseudo = sanitize($_POST['pseudo']);
    // $password = sanitize($_POST['password']);
    // $cfPassword = sanitize($_POST['cfPassword']);

    // Vérifier le formulaire
    if (false === filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Email non valide.';
    }

    if (empty($pseudo)) {
        $errors['pseudo'] = 'Pseudo non valide';
    }

    // Mot de passe doit contenir 8 caractères, 1 chiffre et un caractère
    // spécial
    if (!preg_match('/(.){8,}/', $password)) {
        $errors['password-1'] = 'Le mot de passe doit faire 8 caractères';
    }

    if (!preg_match('/[0-9]+/', $password)) {
        $errors['password-2'] = 'Le mot de passe doit contenir un chiffre';
    }

    if (!preg_match('/[^a-zA-Z0-9 ]+/', $password)) {
        $errors['password-3'] = 'Le mot de passe doit contenir un caractère spécial';
    }

    if ($password !== $cfPassword) {
        $errors['password-4'] = 'Les mots de passe doivent correspondre';
    }

    // Envoyer les données sur la BDD
    $query = $db->prepare(
        'INSERT INTO user (email, pseudo, password)
        VALUES (:email, :pseudo, :password)'
    );

    if (empty($errors)) { // Si on a pas d'erreurs, on ajoute le user
        $password = password_hash($password, PASSWORD_DEFAULT);

        $query->execute([
            'email' => $email,
            'pseudo' => $pseudo,
            'password' => $password,
        ]);

        echo "INSERT INTO user (email, pseudo, password)
            VALUES ($email, $pseudo, $password)";

        // Redirection
        header('Location: '.$baseUrl);
    }
}

?>

<div class="container">
    <!-- Affichage des erreurs -->
    <?php if (!empty($errors)) { ?> 
    <div class="alert alert-danger">
        <?php foreach ($errors as $field => $error) { ?>
            <p><?= $field ?>: <?= $error; ?></p>
        <?php } ?>
    </div>
    <?php } ?>

    <form action="" method="POST">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" class="form-control" value="<?= $email; ?>">

        <label for="pseudo">Pseudo</label>
        <input type="text" name="pseudo" id="pseudo" class="form-control" value="<?= $pseudo; ?>">

        <label for="password">Mot de passe</label>
        <input type="password" name="password" id="password" class="form-control">

        <label for="cfPassword">Confirmer le mot de passe</label>
        <input type="password" name="cfPassword" id="cfPassword" class="form-control">

        <button class="btn btn-primary">S'inscrire</button>
    </form>
</div>

<?php

require 'views/partials/footer.php';
