<?php
    include_once("connexion.php");

    if(isset($_POST['submit'])){
        // Récupération des données du formulaire
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $email = $_POST['email'];
        $telephone = $_POST['telephone'];
        $adresse = $_POST['adresse'];
        $mot_de_passe = $_POST['mot_de_passe'];

        // Vérification des champs requis
        if(empty($nom) || empty($prenom) || empty($email) || empty($telephone) || empty($adresse) || empty($mot_de_passe)){
            header("location: login.php?error=Veuillez remplir tous les champs");
            exit();
        }

        // Requête SQL pour l'insertion des données
        $sql = "INSERT INTO clients (nom, prenom, email, telephone, adresse, mot_de_pass)
        VALUES ( '$nom', '$prenom', '$email', '$telephone', '$adresse', '$mot_de_passe')";

        if($conn->query($sql) === TRUE) {
            echo "Enregistrement inséré avec succès.";
        } else {
            echo "Erreur lors de l'insertion : " . $conn->error;
        }
        exit(); // Arrête l'exécution du script après l'insertion
    }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agence de voyage inscription</title>
</head>
<body>
    
        <form action="" method="post">
            <ul>
                <div>
                    <li><label for="nom">Nom :</label></li>
                    <li><input type="text" id="nom" name="nom" required></li>
                    
                    <li><label for="prenom">Prénom :</label></li>
                    <li><input type="text" id="prenom" name="prenom" required ></li>


                    <li><label for="email">Adresse Email :</label></li>
                    <li><input type="email" id="email" name="email" required></li>

                    <li><label for="telephone">Téléphone :</label></li>
                    <li><input type="tel" id="telephone" name="telephone" required></li>

                    <li><label for="adresse">Adresse Complet:</label></li>
                    <li><input type="text" id="adresse" name="adresse" required></li>

                    <li><label for="mot_de_passe">Mot de Passe :</label></li>
                    <li><input type="password" id="mot_de_passe" name="mot_de_passe" required></li>

                    <li><input type="submit" name="submit" value="S'inscrire" class="button"></li>
                </div>
            </ul>
        </form>

</body>
</html>
