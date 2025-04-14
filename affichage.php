<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Affichage</title>
        <style>
            body{
                background: gray;
            }
            table{
                background: white;
            }
            .update{
                background-color: green;
                color: white;
                border: 0;
                outline: none;
                border-radius: 5px;
                height: 35px;
                width: 100px;
                font-weight: bold;
                cursor: pointer;
                margin-right: 15px;
                margin-left: 4px;
            }
            .delete{
                background-color: red;
                color: white;
                border: 0;
                outline: none;
                border-radius: 5px;
                height: 35px;
                width: 100px;
                font-weight: bold;
                cursor: pointer;
                margin-left: 19px;
            }
        </style>
    </head>
</html>
<?php
    include("connexion.php");

    $query = "SELECT * FROM users"; 
    $data = mysqli_query($cn, $query);

    if (!$data) {
        die("Erreur SQL : " . mysqli_error($cn)); 
    }

    $total = mysqli_num_rows($data);

    if ($total > 0) {
        ?>
            <center><table border="1" cellspacing="5" width="100%">
                <h2>Affichage des enregistrements</h2>
                <tr>
                    <th>ID</th>
                    <th width="8%">Nom</th>
                    <th width="8%">Prénom</th>
                    <th width="10%">Date de naissance</th>
                    <th width="10%">Email</th>
                    <th width="10%">Adresse</th>
                    <th width="8%">Sexe</th>
                    <th width="6%">Fonction</th>
                    <th width="6%">Branche</th>
                    <th width="6%">Intérêts</th>
                    <th width="4%">Photo</th>
                    <th>Opérations</th>
                </tr>
        <?php
        while ($result = mysqli_fetch_assoc($data)) {
            echo"<tr>
                    <td>".htmlspecialchars($result['id'])."</td>
                    <td>".htmlspecialchars($result['nom'])."</td>
                    <td>".htmlspecialchars($result['prenom'])."</td>
                    <td>".htmlspecialchars($result['datenaissance'])."</td>
                    <td>".htmlspecialchars($result['email'])."</td>
                    <td>".htmlspecialchars($result['adresse'])."</td>
                    <td>".htmlspecialchars($result['sexe'])."</td>
                    <td>".htmlspecialchars($result['fonction'])."</td>
                    <td>".htmlspecialchars($result['branche'])."</td>
                    <td>".htmlspecialchars($result['interet'])."</td>
                    <td>";
            /*if (!empty($result['photo'])) {
                //echo '<img src="images/' . htmlspecialchars($result['photo']) . '" width="100">';
                echo '<img src="affichage.php?id=' . htmlspecialchars($result['id']) . '" width="100">';
            }*/
            if (!empty($result['photo']) && file_exists("images/" . $result['photo'])) {
                echo '<img src="images/' . htmlspecialchars($result['photo']) . '" width="100">';
            } else {
                echo '<img src="images/default.png" width="100">'; // Image par défaut si l'image est introuvable
            }
            
            echo "</td>
                    <td><a href='update.php'><input type='submit' value='Update' class='update'</a>
                    <a href='delete.php'><input type='reset' value='Delete' class='delete'</a></td>
                </tr>";
        }
    } else {
        echo "Aucun enregistrement trouvé";
    }
?>
</table></center>