<html>
    <head>
        <link rel="stylesheet" href="/asset/form.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        <title>Page de d'inscription du Formulaire</title>
        <meta charset="UTF-8">
    </head> 
<body>    
<div class="wrapper">
    <div id="formContent">
        <!-- Formulaire d'inscription -->
        <form method="post" action="./Form.php"> 
            <input type="text" id="login" name="login" placeholder="login" required>
            <div style="position: relative; width: 80%; margin: auto;">
                <input type="password" id="password" class="fadeIn third" name="password" placeholder="password" required style="width: 100%; padding-right: 40px;">
                <i class="fas fa-eye" id="togglePassword" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer;"></i>
            </div>
            <input type="email" id="email" name="email" placeholder="email" required>
            <br>
            <input type="text" id="user" name="user" placeholder="user" required> <!-- Nouveau champ pour le nom d'utilisateur -->
            <br>
            <select name="role">
                <option value="invite" selected>Invite</option>
                <option value="admin">Admin</option>
            </select>
            <br>
            <input type="checkbox" id="check" name="check" value="true"> se souvenir de moi 
            <center>
                <!-- Boutons de navigation -->
                <button class="boutton_enregistrement" onclick="window.location.href='./Form.php'">login</button>
                <input type="submit" name="Valider" class="fadeIn fourth" value="S'inscrire" action="Form.php">
            </center>
        </form>
        <div id="result">
            <?php
                // Vérification si le formulaire a été soumis
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    if (isset($_POST['check'])) {
                        $_POST['login'] = "" ;
                    } else {
                        echo "La case n'est pas cochée.";
                    }
                    // Affichage des valeurs soumises
                    if (!empty ($_POST['login'])){
                        echo "<p>Login: " . htmlspecialchars($_POST['login']) . "</p>";
                    }
                    if (!empty ($_POST['password'])){
                        echo "<p>pasword: " . htmlspecialchars($_POST['password']) . "</p>";
                    }
                    if (!empty ($_POST['email'])){
                        echo "<p>email: " . htmlspecialchars($_POST['email']) . "</p>";
                    }
                    if (!empty ($_POST['user'])){
                        echo "<p>user: " . htmlspecialchars($_POST['user']) . "</p>";
                    }
                }
            ?>
        </div>
    </div>
    
</div>
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