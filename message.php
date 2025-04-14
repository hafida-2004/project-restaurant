<?php
include("connexion.php");

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    exit("Vous devez être connecté.");
}

$user_id = (int) $_SESSION['user_id']; // Sécurisation de l'ID

// Vérifier si un destinataire a été spécifié
if (!isset($_GET['id'])) {
    exit("Aucun destinataire spécifié.");
}

$ami_id = (int) $_GET['id']; // Sécurisation de l'ID

// Vérifier si les deux utilisateurs sont amis
$sql_check = "SELECT id FROM amis WHERE (user_id = $user_id AND ami_id = $ami_id) OR (user_id = $ami_id AND ami_id = $user_id)";
$result_check = mysqli_query($cn, $sql_check);

if (mysqli_num_rows($result_check) === 0) {
    exit("Vous n'êtes pas amis avec cette personne.");
}

// Récupérer les informations de l'ami
$sql_ami = "SELECT prenom, nom, photo FROM users WHERE id = $ami_id";
$result_ami = mysqli_query($cn, $sql_ami);
$ami = mysqli_fetch_assoc($result_ami);

if (!$ami) {
    exit("Ami introuvable.");
}

$ami_nom_complet = htmlspecialchars($ami['prenom'] . " " . $ami['nom']);
$ami_photo = !empty($ami['photo']) ? "images/" . htmlspecialchars($ami['photo']) : "images/default.jpg";

// Récupérer les messages échangés entre les deux amis
$sql_messages = "SELECT envoyeur_id , destinataire_id, statut, date_envoi 
                 FROM messages 
                 WHERE (envoyeur_id  = $user_id AND destinataire_id= $ami_id) 
                 OR (envoyeur_id = $ami_id AND destinataire_id= $user_id) 
                 ORDER BY date_envoi ASC";
$result_messages = mysqli_query($cn, $sql_messages);
?>

<div class="message">
    <div class='messages-header'>
        <img src="<?php echo $ami_photo; ?>" alt="Photo de <?php echo $ami_nom_complet; ?>" class='profile-pic'>
        <h2><?php echo $ami_nom_complet; ?></h2>
    </div>

    <div class='messages-container'>
        <?php while ($message = mysqli_fetch_assoc($result_messages)): ?>
            <?php 
                $classe = ($message['expediteur_id'] == $user_id) ? "message-sent" : "message-received";
                $nom_expediteur = ($message['expediteur_id'] == $user_id) ? "Moi" : htmlspecialchars($ami['prenom']);
            ?>
            <div class='<?php echo $classe; ?>'>
                <strong><?php echo $nom_expediteur; ?>:</strong> <?php echo htmlspecialchars($message['contenu']); ?>
            </div>
        <?php endwhile; ?>
    </div>

    <!-- Formulaire pour envoyer un message -->
    <form class="message-form" method="POST" action="envoyer_message.php">
        <input type="hidden" name="destinataire_id" value="<?php echo $ami_id; ?>">
        <textarea name="message" placeholder="Écrivez votre message..." required></textarea>
        <button type="submit">Envoyer</button>
    </form>
</div>

<?php
// Fermer la connexion
mysqli_close($cn);
?>