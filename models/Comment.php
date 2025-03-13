<?php
class Comment {
    private $conn;
    private $table = "comments";

    public $id;
    public $post_id;
    public $user_id;
    public $content;
    public $created_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function addComment() {
        $query = "INSERT INTO " . $this->table . " (post_id, user_id, content) VALUES (:post_id, :user_id, :content)";
        $stmt = $this->conn->prepare($query);

        // Sanitize inputs
        $this->content = htmlspecialchars(strip_tags($this->content));

        // Bind parameters
        $stmt->bindParam(":post_id", $this->post_id);
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":content", $this->content);

        return $stmt->execute();
    }
}
?>
