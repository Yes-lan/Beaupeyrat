<?php
session_start();
?>
<div class="header">
    <p>Bienvenue, <?php echo isset($_SESSION['login']) ? htmlspecialchars($_SESSION['login']) : 'Invité'; ?>!</p>
    <?php if (isset($_SESSION['role'])): ?>
        <p>Votre rôle : <strong><?php echo htmlspecialchars($_SESSION['role']); ?></strong></p>
    <?php endif; ?>
</div>
