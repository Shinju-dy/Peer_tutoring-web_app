<?php
include_once '../php/config.php';

if (isset($_POST['decline']) && isset($_POST['id'])) {
    $id = $_POST['id'];
    
    // Fetch applicant data
    $sql = "SELECT * FROM applications WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $application = $result->fetch_assoc();

    // Get the user_id from the application
    $user_id = $application['user_id'];

    // Remove the declined tutor from the 'applications' table
    $sql = "DELETE FROM applications WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $id);
    $stmt->execute();

    // Update the 'approved' column in the 'users' table to 0
    $sql = "UPDATE users SET approved = 0 WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $user_id);
    $stmt->execute();
   
    // Insert notification for the declined tutor
    $message = "News!!! We regret to inform you that your application to become a tutor has been declined because, your acadamic performance does not meet the required standard for you to be approved as a tutor on UPSA Afterclass. Thank You";
    $sql = "INSERT INTO user_notifications (user_id, message, created_at) VALUES (?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $user_id, $message);
    $stmt->execute();
    

    // Redirect to the tutor management page
    header("Location: ../admin/tutor_mgt.php");
}
?>
