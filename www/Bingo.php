<?php

// Message de réussite de connexion
echo "<div style='color: green; font-size: 20px; text-align: center; margin-top: 20px;'>
        Connexion réussie ! Bienvenue sur mon site.
      </div>";

// Affiche Le contenu enregistré dans la base de données
if (isset($_POST['Valider']))
{
    $nom = $_POST['login'];
    $password = $_POST['password'];
    echo("  nom :   ");
    echo($nom);
    echo("<br>");
    echo("  password :  ");
    echo($password);
}
?>
