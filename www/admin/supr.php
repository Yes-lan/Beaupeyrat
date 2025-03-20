<?php
    require('../tools/Fonctions.php');
    if (isset($_POST['Return']) && $_POST['Return'] == 'index') { 
        header('Location: ./index_administrateur.php');
        exit; 
    }
?>
<!DOCTYPE html>
<html>
<head>
    <title>Supprimer un personnage</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../style/form.css">
</head>
<body>
    <div class="wrapper">
        <div id="formContent">
            <h2>Supprimer un perso</h2>
            <form method="post">
                <input type="submit" name="Return" class="boutton_return" value="index">
                <input type="text" id="objet" name="objet" placeholder="objet" >
                <input type="text" id="name" name="name" placeholder="name" >
                <input type="submit" value="Supprimer">
            </form>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Connexion à la base de données
    $pdo = connexion();
    
    // Vérifie si le champ name est défini
    if (isset($_POST['name']) && !empty($_POST['name']) or isset($_POST['objet']) && !empty($_POST['objet'])) {
        $name = $_POST['name'];
        $table = $_POST['objet'];
        // Préparation de la requête SQL
        $sql = "DELETE FROM perso WHERE nom = :name";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        
        // Exécution de la requête
        if ($stmt->execute()) {
            echo "<p style='color: green;'>Objet supprimé avec succès.</p>";
        } else {
            echo "<p style='color: red;'>Erreur lors de la suppression du objet.</p>";
        }
    }
}
?>
        </div>
    </div>
</body>
</html>