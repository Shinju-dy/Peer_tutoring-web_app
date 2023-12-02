<?php
session_start();
require_once '../php/config.php';

if (isset($_POST['submit'])) {
    $first_name = mysqli_real_escape_string($conn, $_POST['firstName']);
    $last_name = mysqli_real_escape_string($conn, $_POST['lastName']);
    $index_number = mysqli_real_escape_string($conn, $_POST['indexNumber']);
    $phone_number = mysqli_real_escape_string($conn, $_POST['phoneNumber']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirmPassword']);

    // Check if index number already exists in the database
    $sql = "SELECT * FROM users WHERE index_number = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $index_number);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        $error_message = "This Account already exists";
        $url_params = http_build_query(array('error_message' => $error_message));
        header("Location: ../front_end/signup.php?$url_params");
        exit();
    }

    // Check if password and confirm password match
    if ($password !== $confirm_password) {
        $error_message = "Passwords do not match";
        $url_params = http_build_query(array('error_message' => $error_message));
        header("Location: ../signup.php?$url_params");
        exit();
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

   // Insert user into the database
    $sql = "INSERT INTO users (id, index_number, first_name, last_name, phone_number, password, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssssss', $index_number, $index_number, $first_name, $last_name, $phone_number, $hashed_password);
    $stmt->execute();


    // Redirect to login page
    header('Location: ../front_end/login.php');
    exit();
}
?>
