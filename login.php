<?php
session_start();
include("connexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($cn, $_POST['login']);
    $password = mysqli_real_escape_string($cn, $_POST['password']);
    $query = "SELECT * FROM  profile  WHERE email='$email'";
    $result = mysqli_query($cn, $query);
    $user = mysqli_fetch_assoc($result);

    if ($user) {
        if ($password === $user['password1']) { 
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['photo'] = $user['photo'];
            $_SESSION['nom'] = $user['nom'];
            $_SESSION['prenom'] = $user['prenom'];
            $_SESSION['fonction'] = $user['fonction'];
            if ($user['fonction'] == "ETD") {
                header("Location: etudiant.php");
            } elseif ($user['fonction'] == "PROF") {
                header("Location: professeur.php");
            } else {
                header("Location: admin.php");
            }
            exit();
        } else {
            echo "Mot de passe incorrect.";
        }
    } else {
        echo "Utilisateur non trouvé.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <title>Document</title>
</head>
<body>
    <header>
        <span class="logo">
            <img src="images/school.png">
        </span>
        <nav class="navigation">
            <a href="site.php">Accueil</a>
            <a href="#">Services</a>
            <button class="btnLogin">Login</button>
        </nav>
    </header>
    <div class="wrapper">
        <span class="icon-close">
            <i class="fa-solid fa-xmark"></i>
        </span>
        <div class="form-box">
            <h2>Login</h2>
            <form method="post" action="#">
                <div class="input-box">
                    <span class="icon"><i class="fa-solid fa-envelope"></i></span>
                    <input type="email" name="login" id="loginID" title="Entrer votre Email">
                    <label for="loginID">Email</label>
                </div>
                <div class="input-box">
                    <span class="icon"><i class="fa-solid fa-lock"></i></span>
                    <input type="password" name="password" id="passwordID" title="Entrer votre Mot de Passe">
                    <label for="passwordID">Password</label>
                </div>
                <div class="remember-forget">
                    <label><input type="checkbox">Remember me</label>
                    <a href="#">Forgot Password</a>
                </div>
                <button type="submit" class="btn">login</button>
                <div class="login-register">
                    <p>Don't have an account ?<a href="form.php" class="register-link">Register</a></p>
                </div>
            </form>
        </div>
    </div>
    
</body>
</html>