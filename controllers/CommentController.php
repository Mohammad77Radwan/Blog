<?php
session_start();
require_once "config/database.php";
require_once "models/Comment.php";

$db = (new Database())->getConnection();
$comment = new Comment($db);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_comment'])) {
    if (isset($_SESSION['user_id'])) {
        $comment->post_id = $_POST['post_id'];
        $comment->user_id = $_SESSION['user_id'];
        $comment->content = $_POST['content'];

        if ($comment->addComment()) {
            header("Location: ../views/post.php?id=" . $comment->post_id);
            exit;
        } else {
            echo "Erreur lors de l'ajout du commentaire.";
        }
    }
}
?>
