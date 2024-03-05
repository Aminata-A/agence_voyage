<?php
    session_start();
    include_once 'connexion.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST"){

        if(!empty($_POST['email']) && !empty($_POST['mot_de_pass'])){

            $email = $_POST['email'];
            $mot_de_pass = $_POST['mot_de_pass'];

            $sql = "SELECT * FROM clients WHERE email = '$email' AND mot_de_pass = '$mot_de_pass'";
            $result = $conn->query($sql);

            if($result->num_rows == 1){
            
                $_SESSION["logged_in"] = true;
                $_SESSION["email"] = $email;
                while($row = $result->fetch_assoc()) {
                    $_SESSION["id_client"] = $row['id_client'];
                  }
                

                //sheader("Location: clients.php");
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
    <title>Agence de voyage</title>
</head>
<body>
    <div>
        <h1>Bienvenue dans notre boîte à idées</h1>
        <p>Si vous avez un compte, veuillez vous connecter.</p>

    <form action="" method="post">
        <ul>
            <li><label for="email">Adresse Email :</label></li>
            <li><input type="email" id="email" name="email" required></li>

            <li><label for="mot_de_pass">Mot de Passe :</label></li>
            <li><input type="password" id="mot_de_pass" name="mot_de_pass" required></li>    
        
        <p><?php if(isset($error_message)) { echo $error_message; } ?></p>
        <li><input type="submit" value="Se connecter" ></li>
        </ul>
    </form>
</div>
</body>
</html>
