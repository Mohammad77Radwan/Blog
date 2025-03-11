<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Créer un article</title>
</head>
<body>
    <h2>Créer un article</h2>
    <form action="../controllers/PostController.php" method="POST">
        <input type="text" name="title" placeholder="Titre" required>
        <textarea name="content" placeholder="Contenu" required></textarea>
        <button type="submit" name="create_post">Publier</button>
    </form>
</body>
</html>
