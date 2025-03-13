<?php
session_start();
require_once "config/database.php";

$db = (new Database())->getConnection();
$query = "SELECT posts.*, users.username FROM posts JOIN users ON posts.user_id = users.id ORDER BY posts.created_at DESC";
$stmt = $db->prepare($query);
$stmt->execute();
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog</title>
    <link rel="stylesheet" href="public/css/styles.css">
</head>
<body>
    <h1>Bienvenue sur le Blog</h1>

    <!-- Display links only for logged-in users -->
    <?php if (isset($_SESSION["user_id"])): ?>
        <p>Connecté en tant que <strong><?= htmlspecialchars($_SESSION["username"]) ?></strong></p>
        <a href="views/create_post.php">Créer un article</a>
        <a href="views/logout.php" class="logout-btn">Se déconnecter</a>
    <?php else: ?>
        <a href="views/register.php">S'inscrire</a>
        <a href="views/login.php">Se connecter</a>
    <?php endif; ?>

    <h2>Articles</h2>
    <?php foreach ($posts as $post): ?>
        <div>
            <h3><a href="views/post.php?id=<?= $post['id'] ?>"><?= htmlspecialchars($post['title']) ?></a></h3>
            <p>Par <strong><?= htmlspecialchars($post['username']) ?></strong> le <?= $post['created_at'] ?></p>
        </div>
    <?php endforeach; ?>

</body>
</html>
