<?php
include_once('connexion.php');

// Vérification si l'identifiant du billet à modifier est présent dans l'URL
if(isset($_GET['id']) && !empty($_GET['id'])) {
    $id_billet = $_GET['id'];

    // Sélection des informations du billet à modifier
    $sql = "SELECT Billets.*, Clients.nom AS client_nom, Clients.prenom AS client_prenom, Clients.email, Clients.telephone, Clients.adresse, Destinations.nom AS destination_nom 
            FROM Billets 
            INNER JOIN Clients ON Billets.id_client = Clients.id_client 
            INNER JOIN Destinations ON Billets.id_destination = Destinations.id_destination
            WHERE id_billet = $id_billet";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $nom = $row['client_nom'];
        $prenom = $row['client_prenom'];
        $email = $row['email'];
        $telephone = $row['telephone'];
        $adresse = $row['adresse'];
        $date_depart = $row['date_depart'];
        $date_retour = $row['date_retour'];
        $id_destination = $row['id_destination'];
    } else {
        echo "Aucun billet trouvé avec cet identifiant.";
        exit;
    }
} else {
    echo "Identifiant du billet non spécifié.";
    exit;
}

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
    $id_destination = $_POST['id_destination'];

    // Mise à jour des données dans la table Clients
    $sql_update_client = "UPDATE Clients 
                         SET nom = '$nom', prenom = '$prenom', email = '$email', telephone = '$telephone', adresse = '$adresse' 
                         WHERE id_client = " . $row['id_client'];

    if ($conn->query($sql_update_client) === TRUE) {
        // Mise à jour des données dans la table Billets
        $sql_update_billet = "UPDATE Billets 
                              SET date_depart = '$date_depart', date_retour = '$date_retour', id_destination = '$id_destination' 
                              WHERE id_billet = $id_billet";
        
        if ($conn->query($sql_update_billet) === TRUE) {
            echo "Billet modifié avec succès.";
        } else {
            echo "Erreur lors de la modification du billet: " . $conn->error;
        }
    } else {
        echo "Erreur lors de la modification du client: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un billet</title>
</head>
<body>
    <h2>Modifier un billet</h2>
    <form method="POST" action="">
        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom" value="<?php echo $nom; ?>" required><br>

        <label for="prenom">Prénom :</label>
        <input type="text" id="prenom" name="prenom" value="<?php echo $prenom; ?>" required><br>

        <label for="email">Email :</label>
        <input type="email" id="email" name="email" value="<?php echo $email; ?>" required><br>

        <label for="telephone">Téléphone :</label>
        <input type="text" id="telephone" name="telephone" value="<?php echo $telephone; ?>" required><br>

        
        <label for="date_depart">Date de depart :</label>
        <input type="date" id="date_depart" name="date_depart" value="<?php echo $date_depart; ?>" required><br>

        <label for="date_retour">Date de retour :</label>
        <input type="date" id="date_retour" name="date_retour" value="<?php echo $date_retour; ?>" required><br>

        <label for="adresse">Adresse :</label>
        <textarea id="adresse" name="adresse" required><?php echo $adresse; ?></textarea><br>


        <label for="id_destination">Navette :</label>
        <select id="id_destination" name="id_destination">
            <?php
            // Sélection des destinations depuis la base de données
            $result = $conn->query("SELECT * FROM Destinations");
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $selected = ($row['id_destination'] == $id_destination) ? "selected" : "";
                    echo "<option value='" . $row['id_destination'] . "' $selected>" . $row['nom'] . " - " . $row['prix'] . "</option>";
                }
            }
            ?>
        </select><br>

        <input type="submit" name="submit" value="Enregistrer les modifications">
    </form>
</body>
</html>
