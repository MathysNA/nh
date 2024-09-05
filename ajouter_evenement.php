<?php
session_start();
$pdo = new PDO('mysql:host=localhost;dbname=test', 'root', '');

// Récupérer les données de l'événement depuis la requête AJAX
$data = json_decode(file_get_contents('php://input'), true);
$titre = $data['title'];
$date_debut = $data['start'];
$date_fin = $data['end'];
$user_id = $_SESSION['user_id'];

// Insérer l'événement dans la base de données
$query = $pdo->prepare("INSERT INTO Agenda (utilisateur_id, titre, date_debut, date_fin) VALUES (?, ?, ?, ?)");
$query->execute([$user_id, $titre, $date_debut, $date_fin]);

echo json_encode(['status' => 'success']);
