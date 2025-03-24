<?php
require '../tools/Fonctions.php';
require '../tools/header.php';

$pdo = connexion();
// Construction de la requête SQL
$sql = "SELECT * FROM perso";
$stmt = $pdo->prepare($sql);
$stmt->execute();   
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../style/index_administrateur.css">
</head>
<body>
    <header>
        <center>
        <h1>Page Administrateur</h1>
        </center>
    </header>
    <div>
        <nav> 
            <ul class="menu">
                <li class="index" name="add"><a href="./add.php?action=add">Ajouter</a></li>
                <li class="index" name="modify"><a href="./add.php?action=modify">Modify</a></li>
                <li class="index" name="supr"><a href="./add.php?action=supr">Search_supr</a></li>
            </ul>
        </nav>
    </div>
    <div>
        <center>
        <h2>Liste des persos</h2>
        <table border="1" class="table">
            <tr>
                <th>ID</th>
                <th>name</th>
                <th>familly</th>
                <th>lore</th>
            </tr>
        </center>
            <?php
            // Parcours des résultats de la requête et affichage dans le tableau
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                echo "<td>" . htmlspecialchars($row['nom']) . "</td>";
                echo "<td>" . htmlspecialchars($row['famille']) . "</td>";
                echo "<td>" . htmlspecialchars($row['lore']) . "</td>";
                echo "</tr>";
            }
            ?>
        </table>

        <?php
        $sql = "SELECT * FROM user";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        ?>

        <br>
        <br>
        <div>
        <center>
        <h2>Liste des users </h2>
        <table border="1" class="table">
            <tr>
                <th>ID</th>
                <th>name</th>
                <th>familly</th>
                <th>lore</th>
            </tr>
        </center>
            <?php
            // Parcours des résultats de la requête et affichage dans le tableau
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                echo "<td>" . htmlspecialchars($row['login']) . "</td>";
                echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                echo "<td>" . htmlspecialchars($row['role']) . "</td>";
                echo "</tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>