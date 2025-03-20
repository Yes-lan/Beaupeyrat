<?php
require './Fonctions.php'; // Inclusion du fichier de connexion à la base de données
$pdo = connexion();
    $sql = "INSERT INTO perso (login, email, password) VALUES (:login, :email, :password)";
?>