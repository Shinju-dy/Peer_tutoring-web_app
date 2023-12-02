<?php
session_start();
require_once '../php/config.php'; // Use your existing config.php file

if (isset($_POST['submit'])) {
    $admin_username = $_POST['admin_username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM admin_users WHERE admin_username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $admin_username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['admin_username'] = $user['admin_username'];
            header('Location: ../admin/dashboard.php
            '); // Redirect to the desired page after successful login
        } else {
            $_SESSION['error_message'] = 'Invalid password!';
            header('Location: ../admin/admin_login.php'); // Redirect to the login page after a failed login attempt

        }
    } else {
        $_SESSION['error_message'] = 'User not found!';
        header('Location: ../admin/admin_login.php');
    }
} else {
    header('Location: ../admin/admin_login.php');
}
?>

