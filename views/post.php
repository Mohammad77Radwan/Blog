<?php
session_start();
require_once "../config/database.php";

$db = (new Database())->getConnection();
$post_id = $_GET["id"];
$post = new Post($db);
$currentPost = $post->getPostById($post_id);

if (!$currentPost) {
    echo "Article non trouvé.";
    exit;
}

$query = "SELECT comments.*, users.username FROM comments JOIN users ON comments.user_id = users.id WHERE comments.post_id = :post_id ORDER BY comments.created_at DESC";
$stmt = $db->prepare($query);
$stmt->bindParam(":post_id", $post_id);
$stmt->execute();
$comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($currentPost['title']) ?></title>
</head>
<body>
    <h1><?= htmlspecialchars($currentPost['title']) ?></h1>
    <p>Par <strong><?= htmlspecialchars($currentPost['username']) ?></strong> le <?= $currentPost['created_at'] ?></p>
    <p><?= nl2br(htmlspecialchars($currentPost['content'])) ?></p>

    <?php if (isset($_SESSION["user_id"]) && $_SESSION["user_id"] == $currentPost["user_id"]): ?>
        <form action="../controllers/PostController.php" method="POST">
            <input type="hidden" name="post_id" value="<?= $currentPost['id'] ?>">
            <button type="submit" name="delete_post">Supprimer l'article</button>
        </form>
    <?php endif; ?>

    <h2>Commentaires</h2>
    <?php foreach ($comments as $comment): ?>
        <div>
            <strong><?= htmlspecialchars($comment["username"]) ?></strong>: <?= nl2br(htmlspecialchars($comment["content"])) ?>
            <p><?= $comment["created_at"] ?></p>
        </div>
    <?php endforeach; ?>

    <?php if (isset($_SESSION["user_id"])): ?>
        <form action="../controllers/CommentController.php" method="POST">
            <input type="hidden" name="post_id" value="<?= $currentPost['id'] ?>">
            <textarea name="content" required></textarea>
            <button type="submit" name="add_comment">Envoyer</button>
        </form>
    <?php else: ?>
        <p><a href="login.php">Connectez-vous</a> pour commenter.</p>
    <?php endif; ?>
</body>
</html>
