<?php

// On démarre la session
session_start();

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

/**
 * Permet de rediriger vers une url
 */
function redirect($url = '/') {
    global $baseUrl;

    header('Location: '.$baseUrl.$url);
}

/**
 * Permet de savoir si l'utilisateur est connecté
 */
function isLogged() {
    // return isset($_SESSION['user']) ? $_SESSION['user'] : false;
    return $_SESSION['user'] ?? false;
}
