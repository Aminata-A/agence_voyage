<?php
$server_name = "localhost";
$user_name = "root";
$password = "";
$database = "agence_de_voyage";

$conn = new mysqli($server_name, $user_name, $password, $database);

if ($conn->connect_error){
    die("Echec de la connexion: " . $con->connect_error);
}
?>
