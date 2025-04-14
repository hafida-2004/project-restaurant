<?php
// Inclure la connexion à la base de données
include("connexion.php");

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    echo "<p>Veuillez vous connecter pour voir votre profil.</p>";
    exit();
}

$user_id = $_SESSION['user_id'];

// Requête SQL sans préparation (attention aux injections SQL si `user_id` vient d'un formulaire)
$sql = "SELECT * FROM  profile  WHERE id = $user_id";
$result = mysqli_query($cn, $sql);

// Vérifier si l'utilisateur existe
if ($result && mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
} else {
    echo "<p>Aucun utilisateur trouvé.</p>";
    exit();
}

// Déterminer l'image de profil
$photoPath = "images/" . ($_SESSION['photo'] ?? 'default.jpg');
if (!file_exists($photoPath) || empty($_SESSION['photo'])) {
    $photoPath = "photos.png"; 
}

// Fermer la connexion
mysqli_close($cn);
?>

<div class="profile-container">
    <div class="profile-card">
        <h1>
            <img src="<?php echo htmlspecialchars($photoPath); ?>" alt="Photo de profil" width="130">
            <b><?php echo htmlspecialchars($user['prenom'] . ' ' . $user['nom']); ?></b>
        </h1>
        <p><strong>Date de naissance :</strong> <?php echo htmlspecialchars($user['datenaissance']); ?></p>
        <p><strong>Email :</strong> <?php echo htmlspecialchars($user['email']); ?></p>
        <p><strong>Adresse :</strong> <?php echo htmlspecialchars($user['adresse']); ?></p>
        <p><strong>Sexe :</strong> <?php echo htmlspecialchars($user['sexe']); ?></p>
        <p><strong>Fonction :</strong> <?php echo htmlspecialchars($user['fonction']); ?></p>
        <p><strong>Branche :</strong> <?php echo htmlspecialchars($user['branche']); ?></p>
        <p><strong>Intérêt :</strong> <?php echo htmlspecialchars($user['interet']); ?></p>
    </div>
</div>

