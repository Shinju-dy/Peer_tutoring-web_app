<?php
session_start(); // Start the session

session_destroy(); // Destroy all session data

header('Location: ../admin/admin_login.php'); // Redirect the user to the login page
exit();
?>
