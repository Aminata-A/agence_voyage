<?php
session_start();
include "connexion.php";

if(isset($_POST['submit'])){
    $type_de_voyage = $_POST['type_de_voyage'];
    $date_depart = $_POST['date_depart'];
    $date_retour = $_POST['date_retour'];
    $lieu_depart = $_POST['lieu_depart'];
    $destination = $_POST['destination'];
    $classe = $_POST['classe'];
    $nombre_voyageur = $_POST['nombre_voyageur'];
    $id_client = $_SESSION["id_client"];

 
    if(empty($type_de_voyage) || empty($date_depart) || empty($date_retour) || empty($lieu_depart) || empty($destination) || empty($nombre_voyageur) || empty($classe) || empty($id_client)){
        exit();
    }

    $sql = "INSERT INTO billets (type_de_voyage, date_depart, date_retour, lieu_depart, destination, nombre_voyageur, classe, id_client)
    VALUES ('$type_de_voyage', '$date_depart', '$date_retour', '$lieu_depart', '$destination', '$nombre_voyageur', '$classe', '$id_client')";

    if($conn->query($sql) === TRUE) {
    } else {
        echo "Erreur lors de l'insertion : " . $conn->error;
    }
    exit(); 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='stylesheet' href='style.css'>
    <title>Document</title>
</head>
<body>
<header>
    <img src="images/Logo.png" alt="" width="80px">
</header>
<div class="form">
    <form method="POST" action="">
        <ul>
            <li><select name="type_de_voyage" id="type_de_voyage">
                <option value="sejour">Sejour</option>
                <option value="vol">Vol</option>
                <option value="hotel">Hotel</option>
                <option value="vol&hotel">Vol + Hotel</option>
                <option value="weekend">Weekend</option>
            </select></li> 

            <div>
            <li><input type="date" id="date_depart" name="date_depart" required></li>

            <li><input type="date" id="date_retour" name="date_retour" required></li>
            </div>

            <div>
            <li><img src="" alt=""><input type="text" placeholder="From" id="lieu_depart" name="lieu_depart" ></li>

            <li><input type="text" placeholder="Where" id="destination" name="destination" required></li>
            </div>
            <li><input type="number" placeholder="Number person" name="nombre_voyageur" required></li>

            <li><input type="radio" id="classe_premiere" name="classe" value="premiere" />
            <label for="classe_premiere">Premiere</label></li>

            <li><input type="radio" id="classe_eco" name="classe" value="eco" />
            <label for="classe_eco">Eco</label></li>

            <li><input type="submit" name="submit" value="S'inscrire" class="button"></li>
        </ul>
    </form>
</div>
</body>
</html>
