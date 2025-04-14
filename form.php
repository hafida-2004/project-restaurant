<?php include("connexion.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="formulaire.css">
    <title>Document</title>
</head>
<body>
    <div class="container">
        <form method="POST" action="#" enctype="" >
            <div class="titre">
                <h1>Formulaire d'Inscription :</h1>
            </div>
            <div class="form">
                <div class="input_field">
                <label for="nomID"><strong>Nom </strong></label>
                <input type="text" name="nom" id="nomID" required>
                </div>
                <div class="input_field">
                    <label for="prenomID"><strong>Prénom </strong></label>
                    <input type="text" name="prenom" id="prenomID" required>
                </div>  
                <div class="input_field">
                    <label for="datenaissanceID"><strong>Date de naissance </strong></label>
                    <input type="date" name="datenaissance" id="datenaissanceID" required>
                </div>
                <div class="input_field">
                    <label for="adresseID"><strong>Adresse </strong></label>
                    <textarea name="adresse" id="adresseID" required></textarea>
                </div>
                <div class="input_field">
                    <label><strong>Sexe :</strong></label>
                    <label for="male">
                        <input type="radio" id="male" name="sexe" value="male" required> Mâle
                    </label>
                    <label for="female">
                        <input type="radio" id="female" name="sexe" value="female"> Femelle
                    </label>
                </div>
                <div class="input_field">
                    <label for="fonctionID"><strong>Fonction </strong></label>
                    <select name="fonction" id="fonctionID" required>
                    <option value="ETD">Etudiant</option>
                    <option value="PROF">Professeur</option>
                    <option value="ADMIN">Administation</option>
                    </select>
                </div>
                <div class="input_field">
                    <label for="brancheID"><strong>Branche </strong></label>
                    <select name="branche" id="brancheID" required>
                    <option value="DSI">Developpement de systeme d'information</option>
                    <option value="SE">Systèmes Électriques</option>
                    <option value="CPI">Conception de Produits Industriels</option>
                    </select>
                </div>
                <div class="input_field">
                    <label><strong>Intérêt :</strong></label>
                    <label for="lectureID">
                        <input type="checkbox" name="interet[]" id="lectureID" value="LEC" > Lecture
                    </label>
                    <label for="voyageID">
                        <input type="checkbox" name="interet[]" id="voyageID" value="VOG" > Voyage
                    </label>
                    <label for="sportID">
                        <input type="checkbox" name="interet[]" id="sportID" value="SPR" > Sport
                    </label>
                </div>
                <div class="input_field">
                    <label for="photoId"><strong>Photo </strong></label>
                    <input type="file" name="photo" id="photoId" required>
                </div>
                <div class="input_field">
                    <label for="emailID"><strong>Email </strong></label>
                    <input type="email" name="email" id="emailID" required>
                </div>
                <div class="input_field">
                    <label for="passwordID1"><strong>Password1 </strong></label>
                    <input type="password" name="password1" id="passwordID1" required>
                </div>
                <div class="input_field">
                    <label for="passwordID2"><strong>Password2 </strong></label>
                    <input type="password" name="password2" id="passwordID2" required>
                </div>
                <div class="input_field">
                    <input type="submit" value="Enregistrer" name="enregistrer">
                </div>
                <div class="input_field">
                    <input type="reset" value="effacer">
                </div>
            </div>
        </form>
    </div>
</body>
</html>
<?php
    if(isset($_POST['enregistrer'])){
        // Vérifier si les champs existent et ne sont pas vides
        $nom = isset($_POST['nom']) ? $_POST['nom'] : '';
        $prenom = isset($_POST['prenom']) ? $_POST['prenom'] : '';
        $datenaissance = isset($_POST['datenaissance']) ? $_POST['datenaissance'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $adresse = isset($_POST['adresse']) ? $_POST['adresse'] : '';
        $sexe = isset($_POST['sexe']) ? $_POST['sexe'] : '';
        $fonction = isset($_POST['fonction']) ? $_POST['fonction'] : '';
        $branche = isset($_POST['branche']) ? $_POST['branche'] : '';
        $interet = isset($_POST['interet']) ? implode(',', $_POST['interet']) : ''; // Convertir tableau en string
        $photo = isset($_POST['photo']) ? $_POST['photo'] : '';
        $password1 = isset($_POST['password1']) ? $_POST['password1'] : '';
        $password2 = isset($_POST['password2']) ? $_POST['password2'] : '';

        // Vérifier que les mots de passe ne sont pas vides
        if (empty($password1) || empty($password2)) {
            die("Les mots de passe ne peuvent pas être vides.");
        }

        // Sécuriser les données avant insertion
        $nom = mysqli_real_escape_string($cn, $nom);
        $prenom = mysqli_real_escape_string($cn, $prenom);
        $datenaissance = mysqli_real_escape_string($cn, $datenaissance);
        $email = mysqli_real_escape_string($cn, $email);
        $adresse = mysqli_real_escape_string($cn, $adresse);
        $sexe = mysqli_real_escape_string($cn, $sexe);
        $fonction = mysqli_real_escape_string($cn, $fonction);
        $branche = mysqli_real_escape_string($cn, $branche);
        $interet = mysqli_real_escape_string($cn, $interet);
        $photo = mysqli_real_escape_string($cn, $photo);
        $password1 = mysqli_real_escape_string($cn, $password1);
        $password2 = mysqli_real_escape_string($cn, $password2);

        // Requête SQL corrigée
        $query = "INSERT INTO `profile` (`nom`, `prenom`, `datenaissance`, `email`, `adresse`, `sexe`, `fonction`, `branche`, `interet`, `photo`, `password1`, `password2`)
                VALUES ('$nom', '$prenom', '$datenaissance', '$email', '$adresse', '$sexe', '$fonction', '$branche', '$interet', '$photo', '$password1', '$password2')";

        $data = mysqli_query($cn, $query);

    }
?>