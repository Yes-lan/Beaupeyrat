<?php
    require './Fonctions.php'; // Inclusion du fichier de connexion à la base de données

$pdo = connexion();
if (isset($_POST['Valider'])) {
    // Récupération des valeurs du formulaire
    $login = $_POST['login'];
    $email = $_POST['email'];
    $user = $_POST['user']; // Nouveau champ pour le nom d'utilisateur
    $role = 'invite'; // Nouveau champ pour le rôle de l'utilisateur

    // Hachage du mot de passe
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Préparation de la requête SQL
    $sql = "INSERT INTO user (login, email, password, role) VALUES (:login, :email, :password, :role)"; // Ajout du champ user

    try {
        $stmt = $pdo->prepare($sql);

        // Liaison des paramètres
        $stmt->bindParam(':login', $login);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':role', $role); // Liaison du paramètre role

        // Exécution de la requête
        if ($stmt->execute()) {
            echo "Les données ont été insérées avec succès.";
            $test = true;
        } else {
            echo "Une erreur s'est produite lors de l'insertion des données.";
        }
    } catch (PDOException $e) {
        // Affichage d'une erreur en cas de problème d'exécution de la requête
        die('Erreur : ' . $e->getMessage());
    }

}
?>