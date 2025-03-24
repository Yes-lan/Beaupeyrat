<?php
include('../tools/Fonctions.php');
if (isset($_POST['Return']) && $_POST['Return'] == 'index') { 
    header('Location: ./index_administrateur.php');
    exit; 
}

$pdo = connexion();

if (isset($_GET['action']) && $_GET['action'] == 'add') {
    echo "add";
    $page = "add";
}
if (isset($_GET['action']) && $_GET['action'] == 'modify') {
    echo "modify";
    $page = "modify";
}
if (isset($_GET['action']) && $_GET['action'] == 'supr') {
    echo "supr";
    $page = "supr";
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['valider']) && $_POST['valider'] == 'valider') {
        if($page == "add"){
            $name = $_POST['name'];
            $familly = $_POST['familly'];
            $lore = $_POST['lore'];
            $sql = "INSERT INTO perso (nom, famille, lore) VALUES (:name, :familly, :lore)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':familly', $familly, PDO::PARAM_STR);
            $stmt->bindParam(':lore', $lore, PDO::PARAM_STR);
            if ($stmt->execute()) {
                echo "<p class='color: green;'>Objet ajouté avec succès.</p>";
            } else {
                echo "<p style='color: red;'>Erreur lors de l'ajout du objet.</p>";
            }
        }
        if($page == "supr"){
            $table = $_POST['table'];
            $id = $_POST['id'];
            $sql = "DELETE FROM $table WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            if ($stmt->execute()) {
                echo "<p class='color: green;'>Objet supprimé avec succès.</p>";
            } else {
                echo "<p style='color: red;'>Erreur lors de la suppression du objet.</p>";
            }
        }
        if($page == "modify"){
            $name = $_POST['name'];
            $familly = $_POST['familly'];
            $lore = $_POST['lore'];
            $id = $_POST['id'];
            $sql = "UPDATE perso SET nom = :nom , famille = :familly, lore = :lore where id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':familly', $familly, PDO::PARAM_STR);
            $stmt->bindParam(':lore', $lore, PDO::PARAM_STR);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':nom', $name, PDO::PARAM_INT);
            
        
            if ($stmt->execute()) {
                echo "<p class='color: green;'>Objet modifié avec succès.</p>";
            } else {
                echo "<p style='color: red;'>Erreur lors de la modification du objet.</p>";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Ajouter un personnage</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../style/form.css">
</head>
<body>
    <div class="wrapper">
        <div id="formContent">
        <form method="post" action="">
            <input type="submit" name="Return" class="boutton_return" value="index">
        </form>
            <form method="post">
                <?php
                if ($page == "modify") {
                    echo '<input type="text" name="id" placeholder="ID">';
                    echo '<input type="text" id="name" name="name" placeholder="Nom">';
                    echo'<input type="text" id="familly" name="familly" placeholder="Famille" >';
                    echo '<input type="text" id="lore" name="lore" placeholder="Lore" >';
                }
                if ($page == "supr") {
                    echo '<input type="text" id="table" name="table" placeholder="Table" >';
                    echo '<input type="text" id="id" name="id" placeholder="ID">';
                    
                }
                if ($page == "add") {
                    echo '<input type="text" id="name" name="name" placeholder="Nom">';
                    echo '<input type="text" id="familly" name="familly" placeholder="Famille" >';
                    echo '<input type="text" id="lore" name="lore" placeholder="Lore" >';
                }
                ?>
                <input type="submit" name="valider" value="valider">
            </form>

        </div>
    </div>
</body>
</html>
