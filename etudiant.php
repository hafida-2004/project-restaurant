<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
if (!isset($_SESSION['user_id']) || $_SESSION['fonction'] != "ETD") {
    header("Location: login.php");
    exit();
}
$photoPath = "images/" . ($_SESSION['photo'] ?? 'default.jpg');
if (!file_exists($photoPath) || empty($_SESSION['photo'])) {
    $photoPath = "images/default.jpg"; 
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="etudiant.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <title>Espace Étudiant</title>
</head>
<body>
    
    <header>
        <span class="logo">
            <img src="images/school.png">
        </span>
        <nav class="navigation">
            <img src="<?php echo htmlspecialchars($photoPath); ?>" alt="Photo de profil" width="50">
            <p><?php echo isset($_SESSION['prenom'], $_SESSION['nom']) ? htmlspecialchars($_SESSION['prenom'] . " " . $_SESSION['nom']) : 'Utilisateur'; ?></p>
            <a href="logout.php">LogOUT</a>
        </nav>
    </header>
        <div class="container">
            <div class="sidebar">
                <ul>
                    <li><a href="etudiant.php?"><i class="fa-solid fa-house-chimney"></i> Accueil</a></li>
                    <li><a href="etudiant.php?page=profil"><i class="fas fa-user"></i> Profil</a></li>
                    <li><a href="etudiant.php?page=chercher"><i class="fas fa-search"></i> Chercher</a></li>
                    <li><a href="etudiant.php?page=invitation"><i class="fas fa-envelope-open-text"></i> Invitation</a></li>
                    <li><a href="etudiant.php?page=amis"><i class="fas fa-users"></i> Amis</a></li>
                    <li><a href="etudiant.php?page=message"><i class="fas fa-comment"></i> Message</a></li>
                </ul>
            </div>
            <div class="content">
            <?php
            error_reporting(E_ALL);
            ini_set('display_errors', 1);
            $page = isset($_GET['page']) ? htmlspecialchars($_GET['page']) : "";
            if ($page === "profil" && file_exists("profil.php")) {
                include("profil.php");
            } elseif ($page === "invitation" && file_exists("invitation.php")) {
                include("invitation.php");
            } elseif ($page === "amis" && file_exists("amis.php")) {
                include("amis.php");  
            }elseif ($page === "message" && file_exists("message.php")) {
                include("message.php");  
            }elseif ($page === "chercher" && file_exists("chercher.php")) {
                include("chercher.php"); 
            }else {
                echo "<h2>Bienvenue sur votre espace</h2>";
            }
            ?>
            </div>
        </div>
</body>
</html>