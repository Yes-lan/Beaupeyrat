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
    <title>Modifier un personnage</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../style/form.css">
</head>
<body>
    <div class="wrapper">
        <div id="formContent">
            <h2>Modifier un perso</h2>
            <form method="post" enctype="multipart/form-data">
                <input type="submit" name="Return" class="boutton_return" value="index">
                <input type="file" id="image" name="image">
                <br><br>
                <input type="text" id="name" name="Name" placeholder="Name" >
                <input type="text" id="familly" name="familly" placeholder="familly" >
                <input type="text" id="lore" name="lore" placeholder="lore" >
                <input type="submit" value="Modifier" name="modifier">
            </form>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['modifier'])) {
    // Connexion à la base de données
    $pdo = connexion();
    $name = $_POST['Name'];
    $familly = $_POST['familly'];
    $lore = $_POST['lore'];

    // Vérification de l'existence de l'objet
    $sql = "SELECT COUNT(*) FROM perso WHERE nom = :name AND famille = :familly";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':familly', $familly);
    $stmt->execute();
    $count = $stmt->fetchColumn();

    if ($count > 0) {
        $verif = 0;
        // Vérification et traitement de l'image
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $imageData = file_get_contents($_FILES['image']['tmp_name']);
            $imageType = $_FILES['image']['type'];

            // Mise à jour des informations de l'objet avec l'image
            $sql = "UPDATE perso SET lore = :lore, image = :image, image_type = :image_type WHERE nom = :name AND famille = :familly";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':lore', $lore);
            $stmt->bindParam(':image', $imageData, PDO::PARAM_LOB);
            $stmt->bindParam(':image_type', $imageType);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':familly', $familly);
            $verif = 1;
        } else {
            // Mise à jour des informations de l'objet sans l'image
            $sql = "UPDATE perso SET lore = :lore WHERE nom = :name AND famille = :familly";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':lore', $lore);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':familly', $familly);
            $verif = 1;
        }
        
        if ($stmt->execute() && $verif == 1) {
            echo "<p style='color: green;'>Personnage mis à jour avec succès.</p>";
        } else {
            echo "<p style='color: red;'>Erreur lors de la mise à jour du personnage.</p>";
        }
    } else {
        // Préparation de la requête SQL
        $sql = "INSERT INTO perso (nom,famille,lore,image, image_type) VALUES (:name,:famille,:lore,:image, :image_type)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':name',$name);
        $stmt->bindParam(':famille', $familly);
        $stmt->bindParam(':lore', $lore);
        $stmt->bindParam(':image', $imageData, PDO::PARAM_LOB);
        $stmt->bindParam(':image_type', $imageType);
        if ($stmt->execute()) {
            echo "<p style='color: green;'>Image uploadée avec succès.</p>";
            $lastId = $pdo->lastInsertId();
            echo "<script>document.body.style.backgroundImage = 'url(data:$imageType;base64," . base64_encode($imageData) . ")';</script>";
        } else {    
            echo "Erreur lors de l'upload de l'image.";
        }
    }
}
?>
        </div>
    </div>
</body>
</html>