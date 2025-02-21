<?php

// filepath: /c:/Users/Nolan/Desktop/COURS/1 année/Docker (lamp)/www/Choix.php

if (isset($_POST['Valider_C']) == 'Connexion') { 
    header('Location: ./Form.php');
    exit; 
}
if (isset($_POST['Valider_I']) == 'Inscription') {
    header('Location: ./Inscription.php');
    exit; 
    }
echo"feur";
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="./style/Choix.css">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">

</head>
<body>
    <div class="wrapper">
        <div id="formContent">
            <form method="post" >
                <input type="submit" name="Valider_C" class="boutton_connexion" value="Connexion">
                <input type="submit" name="Valider_I" class="boutton_inscription" value="Inscription">
            </form>
        </div>
    </div>
</body>
</html>