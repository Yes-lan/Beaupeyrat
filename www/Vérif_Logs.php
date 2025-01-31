<?php
    //Conenxion à la base de données
    $db = new PDO('mysql:host=localhost;dbname=utilisateur', 'root', '');


    //Vérification de la connexion
    if ($db === false) 
    {
        die("Connexion échouée : ");
    }
    //Requête SQL pour récupérer les données de l'utilisateur
    $sql = "SELECT * FROM user";
    $stmt = $db->prepare($sql);
    $stmt->execute();



?>