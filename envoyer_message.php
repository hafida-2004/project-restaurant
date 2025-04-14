<?php
session_start();
include("connexion.php");

if (!isset($_SESSION['user_id'])) {
    exit("Vous devez être connecté.");
}

$user_id = (int) $_SESSION['user_id']; // Sécurisation de l'ID utilisateur

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['destinataire_id'], $_POST['message'])) {
    $destinataire_id = (int) $_POST['destinataire_id']; // Sécurisation de l'ID du destinataire
    $message = trim($_POST['message']);

    if (!empty($message)) {
        // Requête d'insertion dans la base de données
        $sql = "INSERT INTO messages (expediteur_id, destinataire_id, contenu, date_envoi) 
                VALUES ($user_id, $destinataire_id, '" . mysqli_real_escape_string($cn, $message) . "', NOW())";
        
        $result = mysqli_query($cn, $sql);

        if ($result) {
            echo "Message envoyé avec succès.";
        } else {
            echo "Erreur lors de l'envoi du message : " . mysqli_error($cn);
        }
    }
}

// Rediriger l'utilisateur vers la page de messages avec le destinataire spécifié
header("Location: etudiant.php?page=message&id=" . $destinataire_id);
exit();
?>
