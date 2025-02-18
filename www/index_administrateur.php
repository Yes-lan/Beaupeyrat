<?php
require './connexion_BDD.php'; // Inclusion du fichier de connexion à la base de données

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
        <link rel="stylesheet" href="./style/admin.css">
    </head>

    <body>
    <h1>Page d'administration</h1>
    <p>Vous êtes connecté en tant qu'administrateur</p>
        <table>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Email</th>
            </tr>
            <?php
        // Parcours des résultats de la requête et affichage dans le tableau
        foreach ($pdo as $row) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['id']) . "</td>";
            echo "<td>" . htmlspecialchars($row['nom']) . "</td>";
            echo "<td>" . htmlspecialchars($row['email']) . "</td>";
            echo "</tr>";
        }
        ?>
        </table>
    </body> 
</html>