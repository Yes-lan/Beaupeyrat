<?php
include('../tools/Fonctions.php');
if (isset($_POST['Return']) && $_POST['Return'] == 'index') { 
    header('Location: ./index_administrateur.php');
    exit; 
}

$pdo = connexion();

if (isset($_GET['action']) && $_GET['action'] == 'add') {
    $page = "add";
    $table = isset($_GET['table']) ? $_GET['table'] : 'film'; // Determine the table (default to 'film')
} elseif (isset($_GET['action']) && $_GET['action'] == 'modify') {
    $page = "modify";
    if (isset($_GET['id'])) {
        $table = isset($_GET['table']) ? $_GET['table'] : 'film';
        $id = $_GET['id'];
        // Validation de l'ID
        $sql = "SELECT * FROM $table WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($data) {
            if ($table == "film") {
                $title = $data['title'];
                $synopsis = $data['synopsis'];
                $studio = $data['studio'];
            } elseif ($table == "user") {
                $login = $data['login'];
                $email = $data['email'];
                $role = $data['role'];
            }
        } else {
            echo "<p style='color: red;'>Aucun enregistrement trouvé avec cet ID.</p>";
            exit;
        }
    } else {
        echo "<p style='color: red;'>ID manquant pour la modification.</p>";
        exit;
    }
} else {
    header('Location: ./index_administrateur.php');
    exit; 
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['valider']) && $_POST['valider'] == 'valider') {
        if ($page == "add") {
            if ($table == "film") {
                $title = $_POST['title'];
                $synopsis = $_POST['synopsis'];
                $studio = $_POST['studio'];
                $imgType = isset($_POST['img_type']) ? $_POST['img_type'] : 'default';
                $photo = null;

                // Handle file upload
                if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
                    $uploadDir = '../uploads/';
                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0777, true);
                    }
                    $photoName = basename($_FILES['photo']['name']);
                    $uploadFile = $uploadDir . $photoName;

                    if (move_uploaded_file($_FILES['photo']['tmp_name'], $uploadFile)) {
                        $photo = $photoName;
                    } else {
                        echo "<p style='color: red;'>Erreur lors du téléchargement de l'image.</p>";
                    }
                }

                $sql = "INSERT INTO film (title, synopsis, studio, img_type, img) VALUES (:title, :synopsis, :studio, :imgType, :img)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':title', $title, PDO::PARAM_STR);
                $stmt->bindParam(':synopsis', $synopsis, PDO::PARAM_STR);
                $stmt->bindParam(':studio', $studio, PDO::PARAM_STR);
                $stmt->bindParam(':imgType', $imgType, PDO::PARAM_STR);
                $stmt->bindParam(':img', $photo, PDO::PARAM_STR);
                if ($stmt->execute()) {
                    echo "<p style='color: green;'>Film ajouté avec succès.</p>";
                } else {
                    echo "<p style='color: red;'>Erreur lors de l'ajout du film.</p>";
                }
            } elseif ($table == "user") {
                $login = $_POST['login'];
                $email = $_POST['email'];
                $role = isset($_POST['role']) ? $_POST['role'] : 'invite';
                $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

                $sql = "INSERT INTO user (login, email, password, role) VALUES (:login, :email, :password, :role)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':login', $login, PDO::PARAM_STR);
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                $stmt->bindParam(':password', $password, PDO::PARAM_STR);
                $stmt->bindParam(':role', $role, PDO::PARAM_STR);
                if ($stmt->execute()) {
                    echo "<p style='color: green;'>Utilisateur ajouté avec succès.</p>";
                } else {
                    echo "<p style='color: red;'>Erreur lors de l'ajout de l'utilisateur.</p>";
                }
            }
        }
        if ($page == "modify") {
            $title = $_POST['title'];
            $synopsis = $_POST['synopsis'];
            $studio = $_POST['studio'];
            $photo = null;

            // Handle file upload
            if (isset($_FILES['img']) && $_FILES['img']['error'] == 0) {
                $uploadDir = '../uploads/';
                // Vérifiez si le répertoire existe, sinon créez-le
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                $photoName = basename($_FILES['img']['name']);
                $uploadFile = $uploadDir . $photoName;

                if (move_uploaded_file($_FILES['img']['tmp_name'], $uploadFile)) {
                    $photo = $photoName;
                } else {
                    echo "<p style='color: red;'>Erreur lors du téléchargement de l'image.</p>";
                }
            }

            $sql = "UPDATE film SET title = :title, synopsis = :synopsis, studio = :studio, photo = :photo WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':title', $title, PDO::PARAM_STR);
            $stmt->bindParam(':synopsis', $synopsis, PDO::PARAM_STR);
            $stmt->bindParam(':studio', $studio, PDO::PARAM_STR);
            $stmt->bindParam(':photo', $photo, PDO::PARAM_STR);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            if ($stmt->execute()) {
                echo "<p style='color: green;'>Objet modifié avec succès.</p>";
            } else {
                echo "<p style='color: red;'>Erreur lors de la modification de l'objet.</p>";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Gestion des enregistrements</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../asset/form.css">
</head>
<body>
    <div class="wrapper">
        <div id="formContent">
        <form method="post" action="" enctype="multipart/form-data">
            <input type="submit" name="Return" class="boutton_return" value="index">
        </form>
            <form method="post" enctype="multipart/form-data">
                <?php
                if ($page == "add" && $table == "film") {
                    echo '<input type="text" id="title" name="title" placeholder="Titre">';
                    echo '<input type="text" id="synopsis" name="synopsis" placeholder="Synopsis">';
                    echo '<input type="text" id="studio" name="studio" placeholder="Studio">';
                    echo '<input type="text" id="img_type" name="img_type" placeholder="Type">';
                    echo '<input type="file" id="photo" name="photo">';
                } elseif ($page == "add" && $table == "user") {
                    echo '<input type="text" id="login" name="login" placeholder="Nom d\'utilisateur">';
                    echo '<input type="email" id="email" name="email" placeholder="Email">';
                    echo '<input type="password" id="password" name="password" placeholder="Mot de passe">';
                    echo '<select name="role">';
                    echo '<option value="admin">Admin</option>';
                    echo '<option value="invite" selected>Invite</option>';
                    echo '</select>';
                }
                if ($page == "modify" && $table == "film") {
                    echo '<input type="hidden" name="id" value="' . htmlspecialchars($id) . '">';
                    echo '<input type="text" id="title" name="title" placeholder="Titre" value="' . htmlspecialchars($title) . '">';
                    echo '<input type="text" id="synopsis" name="synopsis" placeholder="Synopsis" value="' . htmlspecialchars($synopsis) . '">';
                    echo '<input type="text" id="lore" name="studio" placeholder="studio" value="' . htmlspecialchars($studio) . '">';
                    echo '<input type="file" id="photo" name="photo">';
                }
                if($page == "modify" && $table == "user"){
                    echo '<input type="hidden" name="id" value="' . htmlspecialchars($id) . '">';
                    echo '<input type="text" id="title" name="title" placeholder="Titre" value="' . htmlspecialchars($name) . '">';
                    echo '<input type="text" id="synopsis" name="synopsis" placeholder="Synopsis" value="' . htmlspecialchars($familly) . '">';
                    echo '<input type="text" id="lore" name="studio" placeholder="studio" value="' . htmlspecialchars($lore) . '">';
                }
                if ($page == "supr") {
                    echo '<input type="text" id="table" name="table" placeholder="Table">';
                    echo '<input type="text" id="id" name="id" placeholder="ID">';
                }
                ?>
                <input type="submit" name="valider" value="valider">
            </form>
        </div>
    </div>
</body>
</html>
