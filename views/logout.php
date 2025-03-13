<?php
session_start();

// Prevent caching of the page
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: 0");

// Unset all session variables
session_unset();

// Destroy the session
session_destroy();

// Ensure no session data is left behind for the current page
session_regenerate_id(true);

// Redirect to the homepage (index.php)
header("Location: index.php");
exit;
?>