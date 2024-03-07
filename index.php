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
    $numero_passport = $_POST['numero_passport'];
    $classe = $_POST['classe'];
    $id_destination = $_POST['id_destination'];
    


    // Insertion des données dans la table Clients
    $sql_clients = "INSERT INTO Clients (nom, prenom, email, telephone, adresse, numero_passport) 
    VALUES ('$nom', '$prenom', '$email', '$telephone', '$adresse', '$numero_passport')";


    if ($conn->query($sql_clients) === TRUE) {
        // Récupération de l'id_client généré par l'insertion
        $id_client = $conn->insert_id;

        // Insertion des données dans la table Billets
        $sql_billets = "INSERT INTO Billets (classe, id_client, id_destination) 
                        VALUES ('$classe', '$id_client', '$id_destination')";

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
    <title>Formulaire de réservation</title>
    <style>
        .billet {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>


    <h2>Réserver un billet</h2>
    <form method="POST" action="">
        <ul> 
        <li><label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom" required></li>

        <li><label for="prenom">Prénom :</label>
        <input type="text" id="prenom" name="prenom" required></li>

        <li><label for="email">Email :</label>
        <input type="email" id="email" name="email" required></li>

        <li><label for="telephone">Téléphone :</label>
        <input type="text" id="telephone" name="telephone" required></li>

        <li><label for="adresse">Adresse :</label>
        <textarea id="adresse" name="adresse" required></textarea></li>


        <li><label for="classe">premiere</label>
        <input type="radio" id="classe" name="classe" required>
        <label for="classe">eco</label>
        <input type="radio" id="classe" name="classe" required></li>


        <li><label for="numero_passport">Numéro de passeport :</label>
        <input type="text" id="numero_passport" name="numero_passport" required></li>

        <li><label for="id_destination">Navette :</label>
        <select id="id_destination" name="id_destination"></li>
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

        <input type="submit" name="submit" value="Réserver">
        </ul>
    </form>

    <h2>Billets réservés</h2>
    <div class="billets">
    <?php
        // Sélection des billets et des clients associés
        $sql = "SELECT Billets.*, Clients.nom AS client_nom, Clients.prenom AS client_prenom, Clients.numero_passport, Destinations.nom AS destination_nom 
                FROM Billets 
                INNER JOIN Clients ON Billets.id_client = Clients.id_client 
                INNER JOIN Destinations ON Billets.id_destination = Destinations.id_destination";
        $result = $conn->query($sql);

        // Vérification s'il y a des résultats
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='billet'>";
                echo "<p>ID Billet: " . $row['id_billet'] . "</p>";
                echo "<p>Date Réservation: " . $row['date_reservation'] . "</p>";
                echo "<p>Classe: " . $row['classe'] . "</p>";
                echo "<p>Client: " . $row['client_nom'] . " " . $row['client_prenom'] . "</p>";
                echo "<p>Numéro de passeport: " . $row['numero_passport'] . "</p>"; // Ajout du numéro de passeport
                echo "<p>Navette: " . $row['destination_nom'] . "</p>";
                echo "<a href='modifier.php?id=" . $row['id_billet'] . "'>Modifier</a>";
                echo "<a href='supprimer.php?id=" . $row['id_billet'] . "'>Supprimer</a>";
                echo "</div>";
            }
        } else {
            echo "<p>Aucun billet réservé.</p>";
        }

        // Fermeture de la connexion
        $conn->close();
        ?>

    </div>
</body>
</html>
