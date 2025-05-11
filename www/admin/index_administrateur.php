<?php
require '../tools/Fonctions.php';
session_start(); // Assurez-vous que la session est démarrée

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    // Redirigez vers pagination.php si l'utilisateur n'est pas admin
    header('Location: ../pagination.php');
    exit;
}

$pdo = connexion();
// Construction de la requête SQL
$sql = "SELECT * FROM film";
$stmt = $pdo->prepare($sql);
$stmt->execute();   
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../asset/index_administrateur.css">
</head>
<body>
    <header>
        <center>
        <h1>Page Administrateur</h1>
        </center>
    </header>
    <div>
        <center>
        <h2>Liste des persos</h2>
        <table border="1" class="table">
            <tr>
                <th>ID</th>
                <th>Titre</th>
                <th>Synopsis</th>
                <th>Studio</th>
                <th>Image</th>
                <th>Action</th>
                <th><a href="./add.php?action=add&table=film">Ajouter</a></th>
            </tr>
        </center>
            <?php
            // Parcours des résultats de la requête et affichage dans le tableau qui n'a pas de bordure
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                ?>
                <tr>
                <td><?php echo htmlspecialchars($row['id']); ?> </td>
                <td><?php echo htmlspecialchars($row['title']); ?></td>
                <td><?php echo htmlspecialchars($row['synopsis']); ?></td>
                <td><?php echo htmlspecialchars($row['studio']); ?></td>
                <td>
                    <?php if (!empty($row['img'])): ?>
                        <img src="../uploads/<?php echo htmlspecialchars($row['img']); ?>" alt="Image" style="width: 100px; height: auto;">
                    <?php else: ?>
                        Pas d'image
                    <?php endif; ?>
                </td>
                <td><a href="./add.php?action=modify&id=<?php echo $row['id']; ?>">Modifier</a>   <a href="./supr.php?action=supr&id=<?php echo $row['id']; ?>">Suprimer</a></td>
                </tr><?php
            }
            ?>
        </table>

        <?php
        $sql = "SELECT * FROM user";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        ?>

        <br>
        <br>
        <div>
        <center>
        <h2>Liste des utilisateurs</h2>
        <table border="1" class="table">
            <tr>
                <th>ID</th>
                <th>Nom d'utilisateur</th>
                <th>Email</th>
                <th>Rôle</th>
                <th>Action</th>
                <th><a href="./add.php?action=add&table=user">Ajouter</a></th>
            </tr>
            <?php
            // Parcours des résultats de la requête et affichage dans le tableau
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                    <td><?php echo htmlspecialchars($row['login']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo htmlspecialchars($row['role']); ?></td>
                    <td>
                        <form method="post" action="">
                            <input type="hidden" name="user_id" value="<?php echo $row['id']; ?>">
                            <select name="role">
                                <option value="admin" <?php echo $row['role'] === 'admin' ? 'selected' : ''; ?>>Admin</option>
                                <option value="invite" <?php echo $row['role'] === 'invite' ? 'selected' : ''; ?>>Invite</option>
                            </select>
                            <button type="submit" name="update_role">Modifier</button>
                        </form>
                    </td>
                </tr>
                <?php
            }
            ?>
        </table>

        <?php
        // Traitement du formulaire pour modifier le rôle
        if (isset($_POST['update_role'])) {
            $userId = $_POST['user_id'];
            $newRole = $_POST['role'];

            $sql = "UPDATE user SET role = :role WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':role', $newRole, PDO::PARAM_STR);
            $stmt->bindParam(':id', $userId, PDO::PARAM_INT);

            if ($stmt->execute()) {
                echo "<p style='color: green;'>Le rôle a été mis à jour avec succès.</p>";
                // Rafraîchir la page pour afficher les modifications
                header("Refresh:0");
            } else {
                echo "<p style='color: red;'>Erreur lors de la mise à jour du rôle.</p>";
            }
        }
        ?>
    </div>
</body>
</html>