HP corrigé :
php
Copier
Modifier
<?php
include("connexion.php");

$search_results = [];
if (isset($_POST['search'])) {
    // Récupérer les entrées de recherche
    $nom = mysqli_real_escape_string($cn, $_POST['nom']);
    $prenom = mysqli_real_escape_string($cn, $_POST['prenom']);
    
    // Construire la requête SQL
    $query = "SELECT id, CONCAT(nom, ' ', prenom) AS nom_complet, email FROM profile WHERE nom LIKE '%$nom%' AND prenom LIKE '%$prenom%'";
    
    // Exécuter la requête et vérifier les erreurs
    $result = mysqli_query($cn, $query);
    
    if ($result) {
        // Si la requête réussit, récupérer les résultats
        while ($row = mysqli_fetch_assoc($result)) {
            $search_results[] = $row;
        }
    } else {
        // Si la requête échoue, afficher l'erreur SQL
        echo "<p>Erreur de la requête SQL : " . mysqli_error($cn) . "</p>";
    }
}

// Fermer la connexion à la base de données
mysqli_close($cn);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <title>Recherche Étudiant</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: rgb(195, 147, 147);
            text-align: center;
        }
        form {
            background: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            display: inline-block;
        }
        input[type="text"] {
            padding: 10px;
            margin: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            padding: 10px 15px;
            background: blue;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        table {
            width: 50%;
            margin: 20px auto;
            border-collapse: collapse;
            background: white;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
        }
        th {
            background: #007BFF;
            color: white;
        }
    </style>
</head>
<body>
    <h2>Recherche d'un Étudiant</h2>
    <form method="POST">
        <input type="text" name="nom" placeholder="Nom" required>
        <input type="text" name="prenom" placeholder="Prénom" required>
        <button type="submit" name="search"><i class="fa-solid fa-magnifying-glass"></i></button>
    </form>

    <?php if (!empty($search_results)) { ?>
        <table>
            <tr>
                <th>ID</th>
                <th>Nom Complet</th>
                <th>Email</th>
            </tr>
            <?php foreach ($search_results as $etudiant) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($etudiant['id']); ?></td>
                    <td><?php echo htmlspecialchars($etudiant['nom_complet']); ?></td>
                    <td><?php echo htmlspecialchars($etudiant['email']); ?></td>
                </tr>
            <?php } ?>
        </table>
    <?php } elseif (isset($_POST['search'])) { ?>
        <p>Aucun étudiant trouvé.</p>
    <?php } ?>
</body>
</html>