<?php
    echo"feur";
    // Configuration de la connexion à la base de données
    $host = 'lamp_mysql';
    $dbname = 'Utilisateur'; 
    $username = 'root'; 
    $password = 'rootpassword';
?>
<html>
<head>
    <title>Page de connexion du Formulaire</title>
    <meta charset="UTF-8">

    <link href="./form.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
<div class="wrapper">
    <button class="boutton_retour" onclick="window.location.href='./Choix.php'">Return</button>
    <button class="boutton_enregistrement" onclick="window.location.href='./inscription.php'">Register</button>
    <div id="formContent">
        <form method="post">

            <input type="text" id="login" class="fadeIn second" name="login" placeholder="login" required>
            <div style="position: relative; width: 80%; margin: 15px auto;">
                <input type="password" id="password" class="fadeIn third" name="password" placeholder="password" required style="width: 100%; padding-right: 40px;">
                <i class="fas fa-eye" id="togglePassword" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer;"></i>
            </div>
            <input type="checkbox" id="check" name="check" value="true"> se souvenir de moi 
            <input type="submit" name="Valider" class="fadeIn fourth" value="Se connecter">
        </form>

        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Connexion à la base de données
            try {
                $pdo = new PDO("mysql:host=lamp_mysql;dbname=$dbname;charset=utf8", $username, $password);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Erreur de connexion : " . $e->getMessage());
            }

            // Vérification des données de connexion
            if (!empty($_POST['login']) && !empty($_POST['password'])) {
                $login = $_POST['login'];
                $password = $_POST['password'];

                // Préparation de la requête SQL
                $sql = "SELECT * FROM user WHERE login = :login";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':login', $login);

                // Exécution de la requête
                $stmt->execute();

                // Vérification des résultats
                if ($stmt->rowCount() > 0) {
                    $user = $stmt->fetch(PDO::FETCH_ASSOC);
                    if (password_verify($password, $user['password'])) {
                        echo "Connexion réussie.";
                    } else {
                        echo "Login ou mot de passe incorrect.";
                    }
                } else {
                    echo "Login ou mot de passe incorrect.";
                }
            } else {
                echo "Veuillez entrer un login et un mot de passe.";
            }
        } 
?>
    </div>
</div>
<script>
document.getElementById('togglePassword').addEventListener('click', function (e) {
    var passwordField = document.getElementById('password');
    var icon = e.target;
    if (passwordField.type === 'password') {
        passwordField.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        passwordField.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
});
</script>
</body>
</html>