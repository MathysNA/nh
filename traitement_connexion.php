

<?php
session_start();

// Connexion à la base de données
$pdo = new PDO('mysql:host=localhost;dbname=test', 'root', '');

// Récupérer les données du formulaire
$email = $_POST['email'];
$mot_de_passe = $_POST['mot_de_passe'];

// Vérifier si l'utilisateur existe
$query = $pdo->prepare("SELECT * FROM Utilisateurs WHERE email = ?");
$query->execute([$email]);

$user = $query->fetch(PDO::FETCH_ASSOC);

if ($user && password_verify($mot_de_passe, $user['mot_de_passe'])) {
    // L'utilisateur est authentifié
    $_SESSION['user_id'] = $user['id'];
    header('Location: agenda.php');
    exit();
} else {
    // Identifiants incorrects
    echo "Email ou mot de passe incorrect.";
}
