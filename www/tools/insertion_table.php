<?php

    require_once 'Fonctions.php';

    $pdo = connexion();

    // Construction de la requête SQL
    $sql = "CREATE TABLE IF NOT EXISTS  perso (
        id INT AUTO_INCREMENT PRIMARY KEY,
        lore VARCHAR(250) NOT NULL,
        famille VARCHAR(150) NOT NULL UNIQUE,
        lien VARCHAR(255) NOT NULL)";


    // Vérification de la création de la table
    if ($pdo->exec($sql) === false) {
        echo "Erreur lors de la création de la table.";
    }
    else {
        echo "La table a été créée avec succès.";// pour fermer la connexion à la base de données
    }
$pdo = null;
?>