<!DOCTYPE html>
<html>
<head>
    <title>Upload et Afficher une Image</title>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: 'Lato', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-size: cover;
            background-repeat: no-repeat;
        }
        .wrapper {
            text-align: center;
            background-color: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Uploader une Image</h2>
        <form method="post" enctype="multipart/form-data">
            <input type="file" name="image" accept="image/*" required>
            <br><br>
            <input type="submit" name="upload" value="Uploader">
        </form>
<?php
if (isset($_POST['upload'])) {
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $imageData = file_get_contents($_FILES['image']['tmp_name']);
        $imageType = $_FILES['image']['type'];

        // Connexion à la base de données
        $host = 'lamp_mysql';
        $dbname = 'Utilisateur';
        $username = 'root';
        $password = 'rootpassword';

        try {
            $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Préparation de la requête SQL
            $sql = "INSERT INTO images (image, image_type) VALUES (:image, :image_type)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':image', $imageData, PDO::PARAM_LOB);
            $stmt->bindParam(':image_type', $imageType);

            // Exécution de la requête
            if ($stmt->execute()) {
                echo "<p style='color: green;'>Image uploadée avec succès.</p>";
                $lastId = $pdo->lastInsertId();
                echo "<script>document.body.style.backgroundImage = 'url(data:$imageType;base64," . base64_encode($imageData) . ")';</script>";
            } else {
                echo "<p style='color: red;'>Erreur lors de l'upload de l'image.</p>";
            }
        } catch (PDOException $e) {
            echo "<p style='color: red;'>Erreur de connexion à la base de données : " . $e->getMessage() . "</p>";
        }
    } else {
        echo "<p style='color: red;'>Veuillez sélectionner une image.</p>";
    }
}
?>
    </div>
</body>
</html>
