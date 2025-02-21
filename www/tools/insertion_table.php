<?php



    // Construction de la requête SQL
    $sql = "CREATE TABLE IF NOT EXISTS  admi (
        id INT AUTO_INCREMENT PRIMARY KEY,
        login VARCHAR(50) NOT NULL,
        email VARCHAR(100) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL)";


    // Vérification de la création de la table
    if ($pdo->exec($sql) === false) {
        echo "Erreur lors de la création de la table.";
    }
    else {
        echo "La table a été créée avec succès.";// pour fermer la connexion à la base de données
    }
$pdo = null;
?>