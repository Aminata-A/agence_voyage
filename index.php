<?php
include_once ('connexion.php');

// Traitement du formulaire si des données ont été soumises
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération des données du formulaire
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $telephone = $_POST['telephone'];
    $adresse = $_POST['adresse'];
    $date_reservation = $_POST['date_reservation'];
    $heure_reservation = $_POST['heure_reservation'];
    $prix = $_POST['prix'];
    $statut = $_POST['statut'];
    $id_destination = $_POST['id_destination'];

    // Insertion des données dans la table Clients
    $sql = "INSERT INTO Clients (nom, prenom, email, telephone, adresse) 
            VALUES ('$nom', '$prenom', '$email', '$telephone', '$adresse')";

    if ($conn->query($sql) === TRUE) {
        // Récupération de l'id_client généré par l'insertion
        $id_client = $conn->insert_id;

        // Insertion des données dans la table Billets
        $sql = "INSERT INTO Billets (date_reservation, heure_reservation, prix, statut, id_client, id_destination) 
                VALUES ('$date_reservation', '$heure_reservation', '$prix', '$statut', '$id_client', '$id_destination')";

        if ($conn->query($sql) === TRUE) {
            echo "Billet ajouté avec succès.";
        } else {
            echo "Erreur lors de l'insertion du billet: " . $conn->error;
        }
    } else {
        echo "Erreur lors de l'insertion du client: " . $conn->error;
    }

    // Fermeture de la connexion
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire de réservation</title>
</head>
<body>
    <h2>Réserver un billet</h2>
    <form method="POST" action="">
        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom" required><br>

        <label for="prenom">Prénom :</label>
        <input type="text" id="prenom" name="prenom" required><br>

        <label for="email">Email :</label>
        <input type="email" id="email" name="email" required><br>

        <label for="telephone">Téléphone :</label>
        <input type="text" id="telephone" name="telephone" required><br>

        <label for="adresse">Adresse :</label>
        <textarea id="adresse" name="adresse" required></textarea><br>

        <label for="date_reservation">Date de réservation :</label>
        <input type="date" id="date_reservation" name="date_reservation" required><br>

        <label for="heure_reservation">Heure de réservation :</label>
        <input type="time" id="heure_reservation" name="heure_reservation" required><br>

        <label for="prix">Prix :</label>
        <input type="number" id="prix" name="prix" step="0.01" required><br>

        <label for="statut">Statut :</label>
        <input type="text" id="statut" name="statut" required><br>

        <label for="id_destination">Destination :</label>
        <select id="id_destination" name="id_destination">


            <?php
            // Sélection des destinations depuis la base de données
            $result = $conn->query("SELECT * FROM Destinations");
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['id_destination'] . "'>" . $row['nom'] .'  '. $row['prix'] . "</option>";
                }
            }
            ?>
        </select><br>

        <input type="submit" name="submit" value="Réserver">
    </form>

    <?php
// Connexion à la base de données
$conn = new mysqli("localhost", "root", "", "voyage");

// Vérification de la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Sélection des billets et des clients associés
$sql = "SELECT Billets.*, Clients.nom AS client_nom, Clients.prenom AS client_prenom, Destinations.nom AS destination_nom 
        FROM Billets 
        INNER JOIN Clients ON Billets.id_client = Clients.id_client 
        INNER JOIN Destinations ON Billets.id_destination = Destinations.id_destination";
$result = $conn->query($sql);

// Vérification s'il y a des résultats
if ($result->num_rows > 0) {
    // Affichage des résultats dans un tableau HTML
    echo "<table border='1'>
            <tr>
                <th>ID Billet</th>
                <th>Date Réservation</th>
                <th>Heure Réservation</th>
                <th>Prix</th>
                <th>Statut</th>
                <th>Client</th>
                <th>Destination</th>
            </tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row['id_billet'] . "</td>
                <td>" . $row['date_reservation'] . "</td>
                <td>" . $row['heure_reservation'] . "</td>
                <td>" . $row['prix'] . "</td>
                <td>" . $row['statut'] . "</td>
                <td>" . $row['client_nom'] . " " . $row['client_prenom'] . "</td>
                <td>" . $row['destination_nom'] . "</td>
            </tr>";
    }
    echo "</table>";
} else {
    echo "Aucun billet réservé.";
}

// Fermeture de la connexion
$conn->close();
?>
</body>
</html>
