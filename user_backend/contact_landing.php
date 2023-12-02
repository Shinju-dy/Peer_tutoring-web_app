<?php
include_once '../php/config.php';

if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['message'])) {
    // Get the form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $contact_message = $_POST['message'];

    // Insert the new notification for the admin
    $title = 'New Home Message';
    $message = "{$name} ({$email}) sent a message: {$contact_message}";
    $sql = "INSERT INTO notifications (title, message) VALUES (?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $title, $message);
    mysqli_stmt_execute($stmt);

    // Redirect to a confirmation or thank you page (create this page if necessary)
    header("Location: ../front_end/index.php");
}
?>
