<?php
class Post {
    private $conn;
    private $table = "posts";

    public $id;
    public $user_id;
    public $title;
    public $content;
    public $created_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table . " (user_id, title, content) VALUES (:user_id, :title, :content)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":content", $this->content);
        return $stmt->execute();
    }
}
?>
