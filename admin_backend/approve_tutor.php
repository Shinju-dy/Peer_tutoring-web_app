<?php
include_once '../php/config.php';

if (isset($_POST['approve']) && isset($_POST['id'])) {
    $id = $_POST['id'];
    
    // Fetch applicant data
    $sql = "SELECT * FROM applications WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $application = $result->fetch_assoc();

    // Update the 'approved' status for the user
    $user_id = $application['user_id'];
    $sql = "UPDATE users SET approved = 1 WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $user_id);
    $stmt->execute();

    
    $message = "News!!! Congratulations! Your application to become a tutor has been approved.";
    $sql = "INSERT INTO user_notifications (user_id, message, created_at) VALUES (?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $user_id, $message);
    $stmt->execute();
     


    // Redirect to the tutor management page
    header("Location: ../admin/tutor_mgt.php");
}
?>
