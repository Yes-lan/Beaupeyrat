<?php
    // Configuration des paramètres de connexion à la base de données
    $host = 'lamp_mysql';               // Nom de l'hôte MySQL
    $dbname = 'Utilisateur';            // Nom de la base de données
    $username = 'root';                 // Nom d'utilisateur MySQL
    $password = 'rootpassword';         // Mot de passe de l'utilisateur

    try {
        $pdo = new PDO("mysql:host=lamp_mysql;dbname=$dbname;charset=utf8", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Active le mode d'erreur exception
    } catch (PDOException $e) {
        // Affiche une erreur en cas d'échec de connexion
        die("Erreur de connexion : " . $e->getMessage());
    }
