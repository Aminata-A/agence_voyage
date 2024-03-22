<?php
    session_start();
    include_once 'connexion.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST"){

        if(!empty($_POST['adresse_mail']) && !empty($_POST['mot_de_passe'])){

            $adresse_mail = $_POST['adresse_mail'];
            $mot_de_passe = $_POST['mot_de_passe'];

            $sql = "SELECT * FROM utilisateurs WHERE adress_mail = '$adresse_mail' AND mot_de_pass = '$mot_de_passe'";
            $result = $conn->query($sql);

            if($result->num_rows == 1){
            
                $_SESSION["logged_in"] = true;
                $_SESSION["adresse_mail"] = $adresse_mail;
                while($row = $result->fetch_assoc()) {
                    $_SESSION["id_utilisateur"] = $row['id_utilisateur'];
                  }
                

                header("Location: index.php"); // Remplacez "votre_page.php" par l'URL de votre page après connexion
                exit();
            } else{
                $error_message = "Veuillez saisir votre nom d'utilisateur et votre mot de passe.";
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='stylesheet' href='utilisateur.css'>
    <title>Boîte à idées - Connexion Utilisateur</title>
</head>
<body>

    <style>
        @import url('https://fonts.cdnfonts.com/css/league-spartan');

*{
   margin: 0;
   padding: 0;
   box-sizing: border-box;
   font-family: 'League Spartan', sans-serif;        
}
header{
   display: flex;
   justify-content: center;
   background-color: #f7f7f7;
}
header div{
   width: 70%;
   display: flex;
   justify-content: space-between;
   align-items: center;
}
header div a{
   text-decoration: none;
   font-weight: bold;
   color: #5ce1e6;
}
.corp{
    padding: 5em;
}
.corp h1{
    color: #5ce1e6;
    text-align: center;
}
.corp p{
    color: #c1ff72;
    font-weight: bold;
    text-align: center;
    margin: 3em;
}
.corp form {
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: #5ce1e625;
    padding: 2em;
    border-radius: 50px;
}
.corp form ul li{
    list-style-type: none;
}
.corp form ul li input{
    width: 30em;
    height:3em;
    margin-bottom: 25px;
}
.corp form ul li label{
    font-weight: 600;
    color: #c1ff72;
}
.etude{
    background-color: #5ce1e6;
    border: none;
    border-radius: 10px;
}

    </style>
    <header>
        <div>
            <img src="images/logo.png" alt="logo" width="80px">
            <a href="utilisateur.php">Inscription</a>
        </div>
    </header>
    <div class="corp ">
        <h1>Bienvenue dans notre boîte à idées</h1>
        <p>Si vous avez un compte, veuillez vous connecter.</p>

    <form action="" method="post">
        <ul>
            <li><label for="adresse_mail">Adresse Email :</label></li>
            <li><input type="email" id="adresse_mail" name="adresse_mail" required></li>

            <li><label for="mot_de_passe">Mot de Passe :</label></li>
            <li><input type="password" id="mot_de_passe" name="mot_de_passe" required></li>    
        
        <p><?php if(isset($error_message)) { echo $error_message; } ?></p>
        <li><input type="submit" value="Se connecter" class="etude"></li>
        </ul>
    </form>
</div>
</body>
</html>
