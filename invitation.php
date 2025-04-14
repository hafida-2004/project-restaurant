
<?php
// Inclure la connexion à la base de données
include("connexion.php");

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    echo "<p>Veuillez vous connecter pour voir vos invitations.</p>";
    exit();
}

$user_id = $_SESSION['user_id'];

// Requête SQL pour récupérer les invitations en attente depuis la table `amis`
$sql = "SELECT a.id, u.nom, u.prenom, u.photo 
        FROM amis a
        JOIN profile u ON a.envoyeur_id = u.id
        WHERE a.destinataire_id = $user_id AND a.statut = 'en attente'";

$result = mysqli_query($cn, $sql);

echo "<div class='invitation-title'><h2>Invitations reçues</h2></div>";

if ($result && mysqli_num_rows($result) > 0) {
    while ($invitation = mysqli_fetch_assoc($result)) {
        $photo = !empty($invitation['photo']) ? "images/" . htmlspecialchars($invitation['photo']) : "images/default.jpg";
        
        echo "<div class='invitation-card'>
                <img src='" . $photo . "' alt='Photo de " . htmlspecialchars($invitation['nom']) . "' class='profile-pic'>
                <p><strong>" . htmlspecialchars($invitation['prenom'] . " " . $invitation['nom']) . "</strong> vous a envoyé une invitation.</p>
                <form method='POST' action='traiter_invitation.php'>
                    <input type='hidden' name='invitation_id' value='" . $invitation['id'] . "'>
                    <button type='submit' name='action' value='accepter'>Accepter</button>
                    <button type='submit' name='action' value='refuser'>Refuser</button>
                </form>
              </div>";
    }
} else {
    echo "<p>Aucune invitation en attente.</p>";
}

// Fermer la connexion
mysqli_close($cn);
?>