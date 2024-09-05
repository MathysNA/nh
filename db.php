<?php
$host = 'localhost'; // Adresse du serveur de base de données
$db   = 'test'; // Nom de la base de données
$user = 'root'; // Nom d'utilisateur pour la base de données
$pass = ''; // Mot de passe pour la base de données
$charset = 'utf8mb4'; // Jeu de caractères

// Correction de la chaîne de connexion
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
?>

