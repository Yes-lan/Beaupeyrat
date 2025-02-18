<?php
    require './connexion_BDD.php'; // Inclusion du fichier de connexion à la base de données
?>

<html>
<head>
    <title>Page de connexion du Formulaire</title>
    <meta charset="UTF-8"> <!-- Encodage des caractères -->
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">

    <!-- Feuille de style  -->
    <link href="./style/form.css" rel="stylesheet">
    <!-- Importation de Font Awesome pour les icônes -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
<div class="wrapper">
    <!-- Bouton de retour vers la page Choix.php -->
    <button class="boutton_retour" onclick="window.location.href='./Choix.php'">Return</button>

    <!-- Bouton de redirection vers la page d'inscription -->
    <button class="boutton_enregistrement" onclick="window.location.href='./inscription.php'">Register</button>

    <div id="formContent">
        <!-- Formulaire de connexion -->
        <form method="post" action="./Bingo.php">
            <input type="text" id="login" name="login" placeholder="login" required>

            <!-- Champ mot de passe avec icône pour afficher/masquer le mot de passe -->
            <div style="position: relative; width: 80%; margin: 15px auto;">
                <input type="password" id="password"  name="password" placeholder="password" required style="width: 100%; padding-right: 40px;">
                <i class="fas fa-eye" id="togglePassword" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer;"></i>
            </div>

            <!-- Case à cocher pour se souvenir de l'utilisateur -->
            <input type="checkbox" id="check" name="check" value="true"> se souvenir de moi 

            <!-- Bouton de soumission du formulaire -->
            <input type="submit" name="Valider" value="Se connecter" action="./Bingo.php" >
        </form>

        <?php
        // Vérifie si le formulaire a été soumis
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Tentative de connexion à la base de données
            try {
                $pdo = new PDO("mysql:host=lamp_mysql;dbname=$dbname;charset=utf8", $username, $password);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Active le mode d'erreur exception
            } catch (PDOException $e) {
                // Affiche une erreur en cas d'échec de connexion
                die("Erreur de connexion : " . $e->getMessage());
            }

            // Vérifie que les champs login et password ne sont pas vides
            if (!empty($_POST['login']) && !empty($_POST['password'])) {
                $login = $_POST['login'];
                $password = $_POST['password'];

                // Préparation de la requête SQL pour sécuriser contre les injections SQL
                $sql = "SELECT * FROM user WHERE login = :login";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':login', $login);

                // Exécution de la requête
                $stmt->execute();

                // Vérifie si un utilisateur correspond au login saisi
                if ($stmt->rowCount() > 0) {
                    $user = $stmt->fetch(PDO::FETCH_ASSOC);

                    // Vérifie si le mot de passe saisi correspond au mot de passe haché en base de données
                    if (password_verify($password, $user['password'])) {
                        echo "Connexion réussie.";
                    } else {
                        echo "Login ou mot de passe incorrect.";
                    }
                } else {
                    echo "Login ou mot de passe incorrect.";
                }
            } else {
                // Message si les champs ne sont pas remplis
                echo "Veuillez entrer un login et un mot de passe.";
            }
        } 
        ?>
    </div>
</div>

<!-- Script JavaScript pour afficher/masquer le mot de passe -->
<script>
    document.getElementById('togglePassword').addEventListener('click', function (e) {
        var passwordField = document.getElementById('password');
        var icon = e.target;

        // Bascule entre le type 'password' et 'text' pour afficher ou masquer le mot de passe
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
