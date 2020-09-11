<?php

require 'config/config.php';
require 'views/partials/header.php';

// On vérifie si le token existe
$query = $db->prepare('SELECT * FROM reset_token WHERE token = :token');
$query->execute(['token' => $_GET['token']]);
$token = $query->fetch();

// S'il n'existe pas
if (!$token) {
    http_response_code(404);
    die('404'); // On arrête le script
}

// S'il est expiré
$now = new DateTime();
$expiredAt = new DateTime($token['expired_at']);

if ($now > $expiredAt) {
    // @todo: Quand le token est expiré, on supprime le token
    http_response_code(404);
    die('404'); // On arrête le script
}

// S'il existe
if (!empty($_POST)) {
    $password = sanitize($_POST['password']);
    $cfPassword = sanitize($_POST['cfPassword']);

    // @todo: On fait les vérifications du mot de passe
    // 8 caractères, égal...

    $password = password_hash($password, PASSWORD_DEFAULT);

    // On mets à jour le mot de passe du user
    $query = $db->prepare('UPDATE user SET password = :password');
    $query->execute(['password' => $password]);

    // On supprime le token
    $db->query('DELETE FROM reset_token WHERE id = '.$token['id']);

    redirect('/login.php');
}

?>

<div class="container">
    <form action="" method="POST">
        <label for="password">Mot de passe</label>
        <input type="password" name="password" id="password" class="form-control">

        <label for="cfPassword">Confirmer le mot de passe</label>
        <input type="password" name="cfPassword" id="cfPassword" class="form-control">

        <button class="btn btn-primary">Demander un nouveau mot de passe</button>
    </form>
</div>

<?php require 'views/partials/footer.php';
