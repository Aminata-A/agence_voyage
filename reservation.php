
<?php include_once 'connexion.php'?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="reservation.css" rel="stylesheet" />
    <title>Document</title>

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
                echo"<h5> Sen Navette </h5>";
                echo "<p>ID Billet: " . $row['id_billet'] . "</p>";
                echo "<p>Date Réservation: " . $row['date_reservation'] . "</p>";
                echo "<p>Nom & Prenom: " . $row['client_nom'] . " " . $row['client_prenom'] . "</p>";
                echo "<p>Numéro de passeport: " . $row['numero_passport'] . "</p>"; 
                echo "<p>Navette: " . $row['destination_nom'] . "</p>";
                echo "<p>Date de depart: " . $row['date_depart'] . "</p>"; 
                echo "<p>Date de retour: " . $row['date_retour'] . "</p>";
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

    </main>
</body>
</html>