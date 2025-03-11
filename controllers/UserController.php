<?php
require_once "../config/database.php";
require_once "../models/User.php";
session_start();

$db = (new Database())->getConnection();
$user = new User($db);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["register"])) {
        $user->username = $_POST["username"];
        $user->email = $_POST["email"];
        $user->password = $_POST["password"];
        if ($user->create()) {
            header("Location: ../views/login.php");
        }
    }
}
?>
