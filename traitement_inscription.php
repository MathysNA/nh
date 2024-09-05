<?php
// Connexion à la base de données
$pdo = new PDO('mysql:host=localhost;dbname=test', 'root', '');

// Récupérer les données du formulaire
$nom = $_POST['nom'];
$email = $_POST['email'];
$mot_de_passe = password_hash($_POST['mot_de_passe'], PASSWORD_DEFAULT);  // Hasher le mot de passe

// Insérer l'utilisateur dans la base de données
$query = $pdo->prepare("INSERT INTO Utilisateurs (nom, email, mot_de_passe) VALUES (?, ?, ?)");
$query->execute([$nom, $email, $mot_de_passe]);

// Rediriger vers la page de connexion
header('Location: connexion.php');
exit();
