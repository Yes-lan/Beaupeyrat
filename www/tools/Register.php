<?php
    require './Fonctions.php'; // Inclusion du fichier de connexion à la base de données

$pdo = connexion();
if (isset($_POST['Valider'])) {
    // Récupération des valeurs du formulaire
    $login = $_POST['login'];
    $email = $_POST['email'];
    $role = isset($_POST['role']) ? $_POST['role'] : 'invite'; // Rôle par défaut : invite

    // Hachage du mot de passe
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Préparation de la requête SQL
    $sql = "INSERT INTO user (login, email, password, role) VALUES (:login, :email, :password, :role)";

    try {
        $stmt = $pdo->prepare($sql);

        // Liaison des paramètres
        $stmt->bindParam(':login', $login);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':role', $role);

        // Exécution de la requête
        if ($stmt->execute()) {
            echo "Utilisateur inscrit avec succès.";
        } else {
            echo "Erreur lors de l'inscription.";
        }
    } catch (PDOException $e) {
        // Affichage d'une erreur en cas de problème d'exécution de la requête
        die('Erreur : ' . $e->getMessage());
    }

}
?>