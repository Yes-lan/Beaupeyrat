<?php

    function creation_table($table) {
        connexion();
        
        // Construction de la requête SQL
        $sql = "CREATE TABLE IF NOT EXISTS  $table (
            id INT AUTO_INCREMENT PRIMARY KEY,
            login VARCHAR(50) NOT NULL,
            email VARCHAR(100) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL)";
    
        
    }


    function connexion() {
                // Configuration des paramètres de connexion à la base de données
        $host = 'lamp_mysql';               // Nom de l'hôte MySQL
        $dbname = 'Utilisateur';            // Nom de la base de données
        $username = 'root';                 // Nom d'utilisateur MySQL
        $password = 'rootpassword';         // Mot de passe de l'utilisateur

        try {
            $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Active le mode d'erreur exception
            return $pdo ;
        } catch (PDOException $e) {
            // Affiche une erreur en cas d'échec de connexion
            die("Erreur de connexion : " . $e->getMessage());
        }
    }

    function checkUserRole($requiredRole) {
        session_start();
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== $requiredRole) {
            header('Location: ../pagination.php');
            exit;
        }
    }
    
?>