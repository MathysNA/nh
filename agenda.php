<?php
session_start();
require 'db.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: connexion.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Ajouter un événement
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['titre'], $_POST['description'], $_POST['date_debut'], $_POST['date_fin'])) {
    $titre = $_POST['titre'];
    $description = $_POST['description'];
    $date_debut = $_POST['date_debut'];
    $date_fin = $_POST['date_fin'];

    $query = $pdo->prepare("INSERT INTO Evenements (utilisateur_id, titre, description, date_debut, date_fin) VALUES (:user_id, :titre, :description, :date_debut, :date_fin)");
    $query->execute([
        'user_id' => $user_id,
        'titre' => $titre,
        'description' => $description,
        'date_debut' => $date_debut,
        'date_fin' => $date_fin
    ]);
}

// Récupérer les événements de l'utilisateur
$query = $pdo->prepare("SELECT * FROM Evenements WHERE utilisateur_id = :user_id ORDER BY date_debut ASC");
$query->execute(['user_id' => $user_id]);
$evenements = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Agenda</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="agenda-container">
    <h1>Mon Agenda</h1>

    <!-- Formulaire pour ajouter un événement -->
    <form action="agenda.php" method="post">
        <h2>Ajouter un événement</h2>
        <input type="text" name="titre" placeholder="Titre" required>
        <textarea name="description" placeholder="Description" rows="4" required></textarea>
        <input type="datetime-local" name="date_debut" required>
        <input type="datetime-local" name="date_fin" required>
        <button type="submit">Ajouter l'événement</button>
    </form>

    <!-- Affichage des événements -->
    <?php if (count($evenements) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Titre</th>
                    <th>Description</th>
                    <th>Date de début</th>
                    <th>Date de fin</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($evenements as $evenement): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($evenement['titre']); ?></td>
                        <td><?php echo htmlspecialchars($evenement['description']); ?></td>
                        <td><?php echo htmlspecialchars($evenement['date_debut']); ?></td>
                        <td><?php echo htmlspecialchars($evenement['date_fin']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Aucun événement trouvé.</p>
    <?php endif; ?>

    <!-- Footer -->
    <footer>
        <a href="deconnexion.php" class="logout-btn">Se déconnecter</a>
    </footer>
</div>

</body>
</html>
