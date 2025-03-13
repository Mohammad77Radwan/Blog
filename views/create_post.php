<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un article</title>
</head>
<body>
    <h2>Créer un article</h2>
    <form action="../controllers/PostController.php" method="POST">
        <input type="text" name="title" placeholder="Titre de l'article" required>
        <textarea name="content" placeholder="Contenu de l'article" required></textarea>
        <button type="submit" name="create_post">Créer</button>
    </form>
</body>
</html>
