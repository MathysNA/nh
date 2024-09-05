
<?php
session_start();
$pdo = new PDO('mysql:host=localhost;dbname=test', 'root', '');
$user_id = $_SESSION['user_id'];

// Récupérer les événements de l'utilisateur connecté
$query = $pdo->prepare("SELECT * FROM Agenda WHERE utilisateur_id = ?");
$query->execute([$user_id]);
$events = $query->fetchAll(PDO::FETCH_ASSOC);

// Convertir les événements en JSON
$eventsArray = [];
foreach ($events as $event) {
    $eventsArray[] = [
        'title' => $event['titre'],
        'start' => $event['date_debut'],
        'end' => $event['date_fin']
    ];
}

echo json_encode($eventsArray);
