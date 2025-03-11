<?php
session_start();
require_once "../config/database.php";

$db = (new Database())->getConnection();

if (!isset($_GET["id"])) {
    header("Location: index.php");
    exit;
}

$post_id = $_GET["id"];
$query = "SELECT posts.*, users.username FROM posts JOIN users ON posts.user_id = users.id WHERE posts.id = :post_id";
$stmt = $db->prepare($query);
$stmt->bindParam(":post_id", $post_id);
$stmt->execute();
$post = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$post) {
    echo "Article non trouvé.";
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title><?= htmlspecialchars($post["title"]) ?></title>
</head>
<body>
    <h1><?= htmlspecialchars($post["title"]) ?></h1>
    <p>Par <strong><?= htmlspecialchars($post["username"]) ?></strong> le <?= $post["created_at"] ?></p>
    <p><?= nl2br(htmlspecialchars($post["content"])) ?></p>
    <a href="index.php">Retour</a>
</body>
</html>
