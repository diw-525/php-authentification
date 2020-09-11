<?php

/**
 * Ici, on va stocker des variables pour la configuration
 * On aura également des fonctions et PDO
 */

$baseUrl = 'http://localhost/authentification';

/**
 * Configuration pour la base de données
 */
define('DB_HOST', 'localhost');
define('DB_NAME', 'authentification');
define('DB_USER', 'root');
define('DB_PASSWORD', '');

/**
 * Connexion à la base de données
 */
$db = new PDO(
    'mysql:host='.DB_HOST.';dbname='.DB_NAME,
    DB_USER,
    DB_PASSWORD,
    [PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING]
);

/**
 * Permet de cleaner un input
 */
function sanitize($value) {
    return trim(htmlspecialchars($value));
}
