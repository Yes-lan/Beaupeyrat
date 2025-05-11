<?php
include './tools/fonctions.php';
session_start();
$pdo = connexion();

// Vérifiez si la clé 'role' est définie dans $_SESSION
if (!isset($_SESSION['role']) || $_SESSION['role'] === null) {
    $_SESSION['role'] = 'invite'; // Définit 'invite' par défaut si le rôle est NULL
}

// Debug : Affichez les valeurs de session
error_log("Rôle actuel dans la session : " . ($_SESSION['role'] ?? 'Non défini'));
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Pagination</title>
        <link href="./asset/pagination.css" rel="stylesheet">
    </head>
    <body>
        <div style="text-align: left;">
            <?php if ($_SESSION['role'] !== 'invite' && $_SESSION['role'] === 'admin'): ?>
                <p>Utilisateur connecté (Rôle : <strong><?php echo htmlspecialchars($_SESSION['role']); ?></strong>)</p>
            <?php else: ?>
                <p>Utilisateur non connecté</p>
            <?php endif; ?>
            <?php if ($_SESSION['role'] === 'admin'): ?>
                <button onclick="window.location.href='./admin/index_administrateur.php'" style="margin-bottom: 20px;">Accéder à la page administrateur</button>
            <?php endif; ?>
            <center>
            <h1>Liste des films</h1>
            <table>
                <?php
                // Préparation de la requête SQL
                $limit = 5; // Nombre d'éléments par page
                $request = 'SELECT COUNT(*) as total FROM film';
                $stmt = $pdo->prepare($request);
                $stmt->execute();
                $total = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
                $totalPages = ceil($total / $limit); // Nombre total de pages
                $page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Page actuelle
                $offset = ($page - 1) * $limit; // Décalage pour la pagination
                ?>

                <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Titre</th>
                    <th>Synopsis</th>
                    <th>Studio</th>
                </tr>

                <?php
                // Affichage des résultats de la requête
                $request = 'SELECT * FROM film LIMIT :limit OFFSET :offset';
                $stmt = $pdo->prepare($request);
                $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
                $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
                $stmt->execute();
                while ($row = $stmt->fetch()) {
                    ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td style="text-align: left;">
                            <?php if (!empty($row['img'])): ?>
                                <img src="./uploads/<?php echo htmlspecialchars($row['img']); ?>" alt="Image" style="width: 100px; height: auto;">
                            <?php else: ?>
                                Pas d'image
                            <?php endif; ?>
                        </td>
                        <td><?php echo $row['title']; ?></td>
                        <td><?php echo $row['synopsis']; ?></td>
                        <td><?php echo $row['studio']; ?></td>
                    </tr>
                    <?php
                }
                ?>
                <tr>
                    <td colspan="5">
                        <div class="pagination">
                            <?php
                            // Affichage des liens de pagination
                            for ($i = 1; $i <= $totalPages; $i++) {
                                if ($i == $page) {
                                    echo '<strong>' . $i . '</strong>';
                                } else {
                                    echo '<a href="?page=' . $i . '">' . $i . '</a>';
                                }
                            }
                            ?>
                        </div>
                    </td>
                </tr>
            </table>
            </center>
        </div>
    </body>
</html>