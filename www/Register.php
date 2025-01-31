<?php

// Configuration de la connexion à la base de données
$host = 'lamp_mysql';
$dbname = 'Utilisateur'; 
$username = 'root'; 
$password = 'rootpassword';
try {
    // Connexion à la base de données
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Erreur : ' . $e->getMessage());
}

if (isset($_POST['Valider'])){
    // Récupération des valeurs du formulaire
    $login = $_POST['login'];
    $email = $_POST['email'];
    $user = $_POST['user']; // Nouveau champ pour le nom d'utilisateur

    // Hachage du mot de passe
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Préparation de la requête SQL
    $sql = "INSERT INTO user 
    (login, email, password, user) 
    VALUES
    (:login, :email, :password, :user)"; // Ajout du champ user

    try {

        $stmt = $pdo->prepare($sql);

        // Liaison des paramètres
        $stmt->bindParam(':login', $login);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':user', $user); // Liaison du paramètre user

        // Exécution de la requête
        if($stmt->execute()){
            echo "Les données ont été insérées avec succès.";
        } else {
            echo "Une erreur s'est produite lors de l'insertion des données.";
        }
    } catch(PDOException $e) {
        die('Erreur : ' . $e->getMessage());
    }
}
?>