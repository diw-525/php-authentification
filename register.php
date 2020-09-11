<?php

// Afficher un formulaire

require 'config/config.php';
require 'views/partials/header.php';

// Traiter le formulaire

if (!empty($_POST)) { // Quand le formulaire est soumis
    foreach ($_POST as $field => $value) {
        $$field = sanitize($value); // $email = sanitize($_POST['email']);
    }

    // $email = sanitize($_POST['email']);
    // $pseudo = sanitize($_POST['pseudo']);
    // $password = sanitize($_POST['password']);
    // $cfPassword = sanitize($_POST['cfPassword']);

    // Vérifier le formulaire
    

    // Envoyer les données sur la BDD
    $password = password_hash($password, PASSWORD_DEFAULT);

    $query = $db->prepare(
        'INSERT INTO user (email, pseudo, password)
        VALUES (:email, :pseudo, :password)'
    );

    $query->execute([
        'email' => $email,
        'pseudo' => $pseudo,
        'password' => $password,
    ]);

    echo "INSERT INTO user (email, pseudo, password)
          VALUES ($email, $pseudo, $password)";
}

?>

<div class="container">
    <form action="" method="POST">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" class="form-control">

        <label for="pseudo">Pseudo</label>
        <input type="text" name="pseudo" id="pseudo" class="form-control">

        <label for="password">Mot de passe</label>
        <input type="password" name="password" id="password" class="form-control">

        <label for="cfPassword">Confirmer le mot de passe</label>
        <input type="password" name="cfPassword" id="cfPassword" class="form-control">

        <button class="btn btn-primary">S'inscrire</button>
    </form>
</div>

<?php

require 'views/partials/footer.php';
