<?php
include ('../tools/Fonctions.php');
$pdo = connexion();

if (isset($_GET['id']) && isset($_GET['value']) == 'user') {
    $id = $_GET['id'];
    // Validation de l'ID
    $sql = "DELETE FROM user WHERE user.id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    if ($stmt->execute()){
    header('Location: ./index_administrateur.php');
    exit;
    }
} else {
    echo "<p style='color: red;'>Aucun utilisateur trouvé avec cet ID ou valeur incorrecte.</p>";
    exit;
}

?>