<?php
ini_set('session.cookie_httponly', 1);
session_start();
include('../php/config.php');

// Check if the form has been submitted to db
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $index_number = $_POST['index_number'];
    $password = $_POST['password'];

    // Prepare a SELECT statement to fetch the user with the provided index_number
    $sql = "SELECT * FROM users WHERE index_number = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $index_number);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    // Check if a user with the provided index_number exists
    if (mysqli_num_rows($result) == 1) {
        // Fetch the user data
        $user = mysqli_fetch_assoc($result);

        // Verify the password
        if (password_verify($password, $user['password'])) {
            // Password is correct, set session variables
            $_SESSION['index_number'] = $user['index_number'];
            $_SESSION['user_id'] = $user['id'];

            // Redirect the user to the homepage
            header('Location: ../front_end/home.php');
            exit();
        } else {
            // Password is incorrect, show error message
            $error_msg = 'Wrong index number or password';
        }
    } else {
        // No user found with the provided index_number, show error message
        $error_msg = 'invalid index number or password';
    }
}
?>


