<?php
require_once "../config/database.php";
require_once "../models/Post.php";
session_start();

$db = (new Database())->getConnection();
$post = new Post($db);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["create_post"])) {
        $post->user_id = $_SESSION["user_id"];
        $post->title = $_POST["title"];
        $post->content = $_POST["content"];
        if ($post->create()) {
            header("Location: ../views/index.php");
        }
    }
}
?>
