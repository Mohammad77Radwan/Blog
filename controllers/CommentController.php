<?php
session_start();
require_once "../config/database.php";

if (!isset($_SESSION["user_id"]) || !isset($_POST["add_comment"])) {
    header("Location: ../views/index.php");
    exit;
}

$db = (new Database())->getConnection();
$user_id = $_SESSION["user_id"];
$post_id = $_POST["post_id"];
$content = $_POST["content"];

$query = "INSERT INTO comments (post_id, user_id, content) VALUES (:post_id, :user_id, :content)";
$stmt = $db->prepare($query);
$stmt->bindParam(":post_id", $post_id);
$stmt->bindParam(":user_id", $user_id);
$stmt->bindParam(":content", $content);

if ($stmt->execute()) {
    header("Location: ../views/post.php?id=" . $post_id);
} else {
    echo "Erreur lors de l'ajout du commentaire.";
}
?>
