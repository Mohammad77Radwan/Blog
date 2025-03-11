<?php
session_start();
require_once "../config/database.php";

$db = (new Database())->getConnection();
$query = "SELECT posts.*, users.username FROM posts JOIN users ON posts.user_id = users.id ORDER BY posts.created_at DESC";
$stmt = $db->prepare($query);
$stmt->execute();
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Blog</title>
</head>
<body>
    <h1>Bienvenue sur le Blog</h1>
    <?php if (isset($_SESSION["user_id"])): ?>
        <p>Connecté en tant que <strong><?= $_SESSION["username"] ?></strong></p>
        <a href="create_post.php">Créer un article</a>
        <a href="logout.php">Se déconnecter</a>
    <?php else: ?>
        <a href="register.php">S'inscrire</a>
        <a href="login.php">Se connecter</a>
    <?php endif; ?>
    <h2>Articles</h2>
    <?php foreach ($posts as $post): ?>
        <div>
            <h3><a href="post.php?id=<?= $post['id'] ?>"><?= htmlspecialchars($post['title']) ?></a></h3>
            <p>Par <strong><?= htmlspecialchars($post['username']) ?></strong> le <?= $post['created_at'] ?></p>
        </div>
    <?php endforeach; ?>
</body>
</html>
