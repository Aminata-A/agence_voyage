<?php
include_once('connexion.php');

// Traitement du formulaire si des données ont été soumises
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération des données du formulaire
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $telephone = $_POST['telephone'];
    $adresse = $_POST['adresse'];
    $date_depart = $_POST['date_depart'];
    $date_retour = $_POST['date_retour'];
    $numero_passport = $_POST['numero_passport'];
    $id_destination = $_POST['id_destination'];
    


    // Insertion des données dans la table Clients
    $sql_clients = "INSERT INTO Clients (nom, prenom, email, telephone, adresse, numero_passport) 
    VALUES ('$nom', '$prenom', '$email', '$telephone', '$adresse', '$numero_passport')";


    if ($conn->query($sql_clients) === TRUE) {
        // Récupération de l'id_client généré par l'insertion
        $id_client = $conn->insert_id;

        // Insertion des données dans la table Billets
        $sql_billets = "INSERT INTO Billets ( date_depart, date_retour, id_client, id_destination) 
                        VALUES ( '$date_depart', '$date_retour', '$id_client', '$id_destination')";

        if ($conn->query($sql_billets) === TRUE) {
            echo "Billet ajouté avec succès.";

            // Après le code d'insertion dans la base de données et l'affichage de "Billet ajouté avec succès."
            header("Location: {$_SERVER['REQUEST_URI']}");
            exit();

        } else {
            echo "Erreur lors de l'insertion du billet: " . $conn->error;
        }
    } else {
        echo "Erreur lors de l'insertion du client: " . $conn->error;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style.css" rel="stylesheet" />
    <title>Formulaire de réservation</title>

</head>
<body>
    <header>
        <img src="images/logo.png" alt="logo" class='logo'>

        <ul>
            <li><a href="index.php">accueil</a></li>
            <li><a href="reservation.php">reservation</a></li>
            <li><a href="#">Bon plan</a></li>
            <li><a href="#">Contact</a></li>

        </ul>

        <a href="#" class="button">Contact</a>
    </header>
    <main>
    <h1>Dale len ak jamm thji sen agence de voyage <span> SenNavette </span> !</h1>
    <h4> Découvrez le Sénégal comme jamais auparavant</h4>

    <div class="banniere">

    <form method="POST" action="" >
        <div>
    <h2>Réserver votre billet</h2>
        <ul> 
        <div class="form">
        <li><input type="text" id="nom" name="nom" class="info-client" placeholder="nom"  required></li>

        <li><input type="text" id="prenom" name="prenom" class="info-client" placeholder="prenom" required></li>
        </div>

        <div class="form">
        <li><input type="email" id="email" name="email" class="info-client" placeholder="email" required></li>

        <li><input type="text" id="telephone" name="telephone" class="info-client" placeholder="Numero téléphone ex:77 *** ** **" required></li>
        </div>

        <div class="form">            
        <div>
        <label for="date_depart" >Date de depart</label>
        <li><input type="date" id="date_depart" name="date_depart" class="info-client" placeholder="date_depart" required></li>
        </div>


        <div>
        <label for="date_retout" >Date de retour</label>
        <li><input type="date" id="date_retour" name="date_retour"  class="info-client" placeholder="Numero téléphone ex:77 *** ** **" required></li>
        </div>
        </div>


        <div class="form">
        <li><select id="id_destination" name="id_destination" class="info-client"></li>
            <?php
            // Sélection des destinations depuis la base de données
            $result = $conn->query("SELECT * FROM Destinations");
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['id_destination'] . "'>" . $row['nom'] . " - " . $row['prix'] . "</option>";
                }
            }
            ?>
        </select><br>
        <li><input type="text" id="numero_passport" name="numero_passport" class="info-client" placeholder="Numéro de passeport ex: XX123456Y1" required></li>
        </div>

        
        <li><textarea id="adresse" name="adresse" placeholder="Adresse" required></textarea></li>

        <input type="submit" name="submit" value="Réserver" class="boutton">
        </ul>
        </div>
    </form>
            <img src="images/coucher.jpeg" alt="senegal">
    </div>

    <div class="test">
    <img src="images/horaire.png" alt="horaire" class="horaire">
    <img src="images/logo.png" alt="logo" class="horaire">
    </div>
        </main>
</body>
</html>
