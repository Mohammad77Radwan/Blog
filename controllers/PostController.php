<?php
session_start();
require_once "config/database.php";
require_once "models/Post.php";

$db = (new Database())->getConnection();
$post = new Post($db);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['create_post'])) {
    if (isset($_SESSION['user_id'])) {
        $post->user_id = $_SESSION['user_id'];
        $post->title = $_POST['title'];
        $post->content = $_POST['content'];

        if ($post->create()) {
            header("Location: ../views/index.php");
            exit;
        } else {
            echo "Erreur lors de la création de l'article.";
        }
    }
}
?>
