<?php
session_start();
require_once "../config/database.php";

$db = (new Database())->getConnection();

if (!isset($_GET["id"])) {
    header("Location: index.php");
    exit;
}

$post_id = $_GET["id"];

// Récupérer l'article
$query = "SELECT posts.*, users.username FROM posts JOIN users ON posts.user_id = users.id WHERE posts.id = :post_id";
$stmt = $db->prepare($query);
$stmt->bindParam(":post_id", $post_id);
$stmt->execute();
$post = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$post) {
    echo "Article non trouvé.";
    exit;
}

// Récupérer les commentaires
$commentQuery = "SELECT comments.*, users.username FROM comments JOIN users ON comments.user_id = users.id WHERE comments.post_id = :post_id ORDER BY comments.created_at DESC";
$commentStmt = $db->prepare($commentQuery);
$commentStmt->bindParam(":post_id", $post_id);
$commentStmt->execute();
$comments = $commentStmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title><?= htmlspecialchars($post["title"]) ?></title>
    <link rel="stylesheet" href="../public/css/style.css">
</head>
<body>
    <h1><?= htmlspecialchars($post["title"]) ?></h1>
    <p>Par <strong><?= htmlspecialchars($post["username"]) ?></strong> le <?= $post["created_at"] ?></p>
    <p><?= nl2br(htmlspecialchars($post["content"])) ?></p>

    <?php if (isset($_SESSION["user_id"]) && $_SESSION["user_id"] == $post["user_id"]): ?>
        <form action="../controllers/PostController.php" method="POST">
            <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
            <button type="submit" name="delete_post">Supprimer l'article</button>
        </form>
    <?php endif; ?>

    <h2>Commentaires</h2>
    <?php foreach ($comments as $comment): ?>
        <div class="comment">
            <p><strong><?= htmlspecialchars($comment["username"]) ?></strong>: <?= nl2br(htmlspecialchars($comment["content"])) ?></p>
            <p class="date"><?= $comment["created_at"] ?></p>
        </div>
    <?php endforeach; ?>

    <?php if (isset($_SESSION["user_id"])): ?>
        <h3>Ajouter un commentaire</h3>
        <form action="../controllers/CommentController.php" method="POST">
            <input type="hidden" name="post_id" value="<?= $post["id"] ?>">
            <textarea name="content" required></textarea>
            <button type="submit" name="add_comment">Envoyer</button>
        </form>
    <?php else: ?>
        <p><a href="login.php">Connectez-vous</a> pour commenter.</p>
    <?php endif; ?>

    <a href="index.php">Retour</a>
</body>
</html>
