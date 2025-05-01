<?php
include 'config.php';

if ($conn) {
    echo "Connexion réussie à la base de données '{$dbname}'.";
} else {
    echo "Échec de la connexion à la base de données.";
}
?>
