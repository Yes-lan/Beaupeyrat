<?php

    require './connexion_BDD.php'; // Inclusion du fichier de connexion à la base de données


if (isset($_POST['Valider'])) {
    // Récupération des valeurs du formulaire
    $login = $_POST['login'];
    $email = $_POST['email'];
    $user = $_POST['user']; // Nouveau champ pour le nom d'utilisateur

    // Hachage du mot de passe
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Préparation de la requête SQL
    $sql = "INSERT INTO user (login, email, password, user) VALUES (:login, :email, :password, :user)"; // Ajout du champ user

    try {
        $stmt = $pdo->prepare($sql);

        // Liaison des paramètres
        $stmt->bindParam(':login', $login);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':user', $user); // Liaison du paramètre user

        // Exécution de la requête
        if ($stmt->execute()) {
            echo "Les données ont été insérées avec succès.";
        } else {
            echo "Une erreur s'est produite lors de l'insertion des données.";
        }
    } catch (PDOException $e) {
        // Affichage d'une erreur en cas de problème d'exécution de la requête
        die('Erreur : ' . $e->getMessage());
    }
}
?>