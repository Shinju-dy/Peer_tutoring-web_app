<?php
session_start();
if (isset($_SESSION['index_number'])) {
    $index_number = $_SESSION['index_number'];
} else {
    exit();
}

include_once '../php/config.php';

if (!$conn) {
    exit();
}

// Mark all unread notifications as read
$sql_mark_as_read = "UPDATE user_notifications SET is_read = 1 WHERE user_id = ? AND is_read = 0";
$stmt_mark_as_read = $conn->prepare($sql_mark_as_read);
$stmt_mark_as_read->bind_param("s", $index_number);
$stmt_mark_as_read->execute();
$stmt_mark_as_read->close();

$conn->close();
?>
