<?php
session_start();
require_once "../config/database.php";

$db = (new Database())->getConnection();

if (isset($_POST["delete_post"]) && isset($_SESSION["user_id"])) {
    $post_id = $_POST["post_id"];

    // Vérifier que l'utilisateur est bien l'auteur
    $query = "SELECT user_id FROM posts WHERE id = :post_id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(":post_id", $post_id);
    $stmt->execute();
    $post = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($post && $_SESSION["user_id"] == $post["user_id"]) {
        // Supprimer l'article et ses commentaires
        $db->prepare("DELETE FROM comments WHERE post_id = :post_id")->execute([":post_id" => $post_id]);
        $db->prepare("DELETE FROM posts WHERE id = :post_id")->execute([":post_id" => $post_id]);

        header("Location: ../views/index.php");
        exit;
    }
}
?>

