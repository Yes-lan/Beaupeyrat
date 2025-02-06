<?php
/// Configuration de la connexion à la base de données
$host = 'lamp_mysql';
$dbname = 'Utilisateur'; 
$username = 'root'; 
$password = 'rootpassword';

$pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sql = "SELECT id FROM user WHERE login = :login";

    // Vérification de la création de la table
if ($pdo->exec($sql) === false) {
    echo "Erreur lors de la création de la table.";
}
else {
    echo "La table a été créée avec succès.";// pour fermer la connexion à la base de données
}

///donne l'ID de l'utilisateur

$stmt = $pdo->prepare($sql);
$stmt->bindParam(':login', $login);
$stmt->execute();


$pdo = null;