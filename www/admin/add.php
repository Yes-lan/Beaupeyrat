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
    <title>Ajouter un utilisateur</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../style/form.css">
</head>
<body>
    <div class="wrapper">
        <div id="formContent">
            <h2>Ajouter un perso</h2>
            <form method="post" enctype="multipart/form-data">
                <input type="submit" name="Return" class="boutton_return" value="index">
                <input type="file" id="image" name="image" >
                <br><br>
                <input type="text" id="name" name="Name" placeholder="Name" >
                <input type="text" id="familly" name="familly" placeholder="familly" >
                <input type="text" id="lore" name="lore" placeholder="lore" >
                <input type="submit" value="Ajouter">
            </form>
<?php
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $imageData = file_get_contents($_FILES['image']['tmp_name']);
            $imageType = $_FILES['image']['type'];


            // Connexion à la base de données
            $pdo = connexion();
            $name = $_POST['Name'];
            $familly = $_POST['familly'];
            $lore = $_POST['lore'];


            // Préparation de la requête SQL
            $sql = "INSERT INTO perso (nom,famille,lore,image, image_type) VALUES (:name,:famille,:lore,:image, :image_type)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':name',$name);
            $stmt->bindParam(':famille', $familly);
            $stmt->bindParam(':lore', $lore);
            $stmt->bindParam(':image', $imageData, PDO::PARAM_LOB);
            $stmt->bindParam(':image_type', $imageType);
            $stmt->execute();
            if ($stmt->execute()) {
                echo "<p style='color: green;'>Image uploadée avec succès.</p>";
                $lastId = $pdo->lastInsertId();
                echo "<script>document.body.style.backgroundImage = 'url(data:$imageType;base64," . base64_encode($imageData) . ")';</script>";
            } else {    
                echo "Erreur lors de l'upload de l'image.";
            }
        }
    
?>
        </div>
    </div>
</body>
</html>