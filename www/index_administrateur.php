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
    // Construction de la requête SQL
    $sql = "SELECT * FROM user";
    
    // Vérification de la création de la table
    if ($pdo->exec($sql) === false) {
        echo "Erreur lors de la création de la table.";
    }
    else {
        echo "La table a été créée avec succès.";// pour fermer la connexion à la base de données
    }

?>
<!DOCTYPE html>
<head>
    <head>
        <link rel="stylesheet" href="admin.css">
    </head>

    <body>
    <h1>Page d'administration</h1>
    <p>Vous êtes connecté en tant qu'administrateur</p>
        <table>
            <tr><th><a href="index.php">Retour à l'accueil</a></th></tr>
        </table>
    </body>
</html>