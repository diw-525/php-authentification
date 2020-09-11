<?php

/**
 * Système d'authentification en PHP
 * 
 * Il nous faudra 4 pages :
 * - Inscription (/register)
 * - Connexion (/login)
 * - Mot de passe oublié (/forget)
 * - Formulaire de changement de mot de passe (/reset/123)
 * 
 * On va devoir stocker les utilisateurs donc il nous faut une table user :
 * - id
 * - email
 * - password
 * - pseudo
 * 
 * On va stocker les tokens de réinitilisation du mot de passe dans une table reset_token :
 * - id
 * - token
 * - expired_at
 * - user_id
 */

require 'config/config.php';
require 'views/partials/header.php'; ?>

<?php var_dump($_SESSION); ?>

<?php require 'views/partials/footer.php';
