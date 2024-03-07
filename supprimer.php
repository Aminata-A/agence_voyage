<?php
include_once('connexion.php');

// Vérification si l'identifiant du billet à supprimer est présent dans l'URL
if(isset($_GET['id']) && !empty($_GET['id'])) {
    $id_billet = $_GET['id'];

    // Suppression du billet de la table Billets
    $sql_delete = "DELETE FROM Billets WHERE id_billet = $id_billet";
    
    if ($conn->query($sql_delete) === TRUE) {
        echo "Billet supprimé avec succès.";
    } else {
        echo "Erreur lors de la suppression du billet: " . $conn->error;
    }
} else {
    echo "Identifiant du billet non spécifié.";
    exit;
}
?>
