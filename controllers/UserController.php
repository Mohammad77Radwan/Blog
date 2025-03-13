<?php
session_start();
require_once "config/database.php";
require_once "models/User.php";

$db = (new Database())->getConnection();
$user = new User($db);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["register"])) {
        $user->username = $_POST["username"];
        $user->email = $_POST["email"];
        $user->password = $_POST["password"];

        if ($user->create()) {
            header("Location: ../views/login.php");
            exit;
        } else {
            echo "Erreur lors de l'inscription.";
        }
    }

    if (isset($_POST["login"])) {
        $user->email = $_POST["email"];
        $user->password = $_POST["password"];

        $loggedInUser = $user->login();
        if ($loggedInUser) {
            $_SESSION["user_id"] = $loggedInUser["id"];
            $_SESSION["username"] = $loggedInUser["username"];
            header("Location: ../views/index.php");
            exit;
        } else {
            echo "Identifiants invalides.";
        }
    }
}
?>
