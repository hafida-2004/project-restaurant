<?php
include("connexion.php");

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    echo "<p>Veuillez vous connecter pour voir votre liste d'amis.</p>";
    exit();
}

$user_id = (int) $_SESSION['user_id']; // Sécurisation de l'ID

// Requête SQL en procédural
$sql = "SELECT u.id, u.nom, u.prenom, u.photo 
        FROM amis a
        JOIN profile u ON a.ami_id = u.id
        WHERE a.user_id = $user_id
        UNION
        SELECT u.id, u.nom, u.prenom, u.photo 
        FROM amis a
        JOIN profile u ON a.user_id = u.id
        WHERE a.ami_id = $user_id";

$result = mysqli_query($cn, $sql);

echo "<div class='ami-title'><h2>Liste des Amis</h2></div>";

if ($result && mysqli_num_rows($result) > 0) {
    while ($ami = mysqli_fetch_assoc($result)) {
        $photo = !empty($ami['photo']) ? "images/" . htmlspecialchars($ami['photo']) : "images/default.jpg";
        
        echo "<div class='friend-card'>
                <img src='" . $photo . "' alt='Photo de " . htmlspecialchars($ami['nom']) . "' class='profile-pic'>
                <p><strong>" . htmlspecialchars($ami['prenom'] . " " . $ami['nom']) . "</strong></p>
                <a href='etudiant.php?page=message&id=" . $ami['id'] . "' class='message-button'>Écrire</a>
              </div>";
    }
} else {
    echo "<p>Vous n'avez pas encore d'amis.</p>";
}

// Fermer la connexion
mysqli_close($cn);
?>
