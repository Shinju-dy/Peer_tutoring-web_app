<?php
include_once '../php/config.php';

if (isset($_POST['notification_id']) && isset($_GET['request_id'])) {
    $notification_id = $_POST['notification_id'];
    $request_id = $_GET['request_id'];

    // Update the status of the request to "cancelled"
    $sql = "UPDATE request_tutor SET status = 'cancelled' WHERE request_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $request_id);
    $stmt->execute();

    // Update the status of the corresponding notification to "cancelled"
    $sql = "UPDATE user_notifications SET status = 'cancelled' WHERE request_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $request_id);
    $stmt->execute();


    $sql = "SELECT accepted_by, u.first_name AS tutee_first_name, u.last_name AS tutee_last_name FROM request_tutor r JOIN users u ON r.id = u.index_number WHERE request_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $request_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $tutor_id = $row['accepted_by'];
    $tutee_first_name = $row['tutee_first_name'];
    $tutee_last_name = $row['tutee_last_name'];

    // Get the tutor's first name
    $sql = "SELECT first_name FROM users WHERE index_number = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $tutor_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $tutor_first_name = $row['first_name'];
        
    // Create the message
    $message = "News!!! Dear Tutor, unfortunately " . ucfirst($tutee_first_name) . " " . ucfirst($tutee_last_name) . " has cancelled the tutoring session.";
    $sql = "INSERT INTO user_notifications (user_id, message, created_at, status) VALUES (?, ?, NOW(), 'cancelled')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $tutor_id, $message);
    $stmt->execute();


    // Delete the original notification for the tutee
    $sql = "DELETE FROM user_notifications WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $notification_id);
    $stmt->execute();
}

header("Location: ../front_end/notification.php");
?>
