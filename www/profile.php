<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Profil de l'utilisateur</title>
</head>
<body>
    <h1>Profil de l'utilisateur</h1>
    <?php if (isset($_SESSION['login'])): ?>
        <p>Nom d'utilisateur : <strong><?php echo htmlspecialchars($_SESSION['login']); ?></strong></p>
        <p>Rôle : <strong><?php echo htmlspecialchars($_SESSION['role']); ?></strong></p>
    <?php else: ?>
        <p>Vous n'êtes pas connecté.</p>
    <?php endif; ?>
</body>
</html>
