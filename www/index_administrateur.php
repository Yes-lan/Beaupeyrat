<?php
require './tools/Fonctions.php';
require './tools/header.php';

    $pdo = connexion();
    // Construction de la requête SQL
    $sql = "SELECT * FROM user";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();   
    
?>
<!DOCTYPE html>
    <head>
        <link rel="stylesheet" href="./style/index_administrateur.css">
    </head>
    <body>
        <header>
            <center>
            <h1>Page Administrateur</h1>
            </center>
            
        </header>
        <div class="">
            <nav> 
                <ul class="menu">
                    <li class="index"><a href="#accueil">Ajouter</a></li>
                    <li class="index"><a href="#services">Modifier</a></li>
                    <li class="index"><a href="#contact">Supprimer</a></li>
                </ul>
            </nav>
        </div>
        <div>
            <h2>Liste des utilisateurs</h2>
            <table border="1" class="table">
                <tr>
                    <th>ID</th>
                    <th>Login</th>
                    <th>Email</th>
                </tr>
                <?php
                // Parcours des résultats de la requête et affichage dans le tableau
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['login']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                    echo "</tr>";
                }
                ?>
            </table>
        </div>
    </body>