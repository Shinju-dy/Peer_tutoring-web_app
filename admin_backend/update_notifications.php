<?php
include_once '../php/config.php';

// Update is_read column for all notifications
$sql_update = "UPDATE notifications SET is_read = 1";
mysqli_query($conn, $sql_update);

// Count unread notifications
$sql_unread = "SELECT COUNT(*) as unread_count FROM notifications WHERE is_read = 0";
$result_unread = mysqli_query($conn, $sql_unread);
$unread_data = mysqli_fetch_assoc($result_unread);
$unread_count = $unread_data['unread_count'];

echo json_encode(['unread_count' => $unread_count]);
?>
