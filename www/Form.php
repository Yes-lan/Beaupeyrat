<?php
    require './tools/Fonctions.php'; // Inclusion du fichier de fonctions
    $pdo = connexion();
    
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

    
    <div id="formContent">
        <!-- Formulaire de connexion -->
        <form method="post" >
            <input type="text" id="login" name="login" placeholder="login" required>
            
            <br>
            <!-- Champ mot de passe avec icône pour afficher/masquer le mot de passe -->
            <div style="position: relative; width: 80%; margin: 15px auto;">
                <input type="password" id="password"  name="password" placeholder="password" required style="width: 100%; padding-right: 40px;">
                <i class="fas fa-eye" id="togglePassword" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer;"></i>
            </div>
            
            
            <!-- Case à cocher pour se souvenir de l'utilisateur -->
            <input type="checkbox" id="check" name="check" value="true"> se souvenir de moi 
            <br>
            <br>
            <!-- Bouton de redirection vers la page d'inscription -->
            <button class="boutton_enregistrement" onclick="window.location.href='./inscription.php'">inscription</button>

            <!-- Bouton de soumission du formulaire -->
            <input type="submit" name="Valider" value="Se connecter"  >
        </form>

        <?php
        // Vérifie si le formulaire a été soumis
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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
