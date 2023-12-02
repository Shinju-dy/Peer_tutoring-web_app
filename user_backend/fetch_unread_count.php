<?php
session_start();
if (isset($_SESSION['index_number'])) {
    $index_number = $_SESSION['index_number'];
} else {
    echo 0;
    exit();
}

include_once '../php/config.php';

if (!$conn) {
    echo 0;
    exit();
}

// Fetch the unread notification count
$sql_unread_count = "SELECT COUNT(*) AS unread_count FROM user_notifications WHERE user_id = ? AND is_read = 0";
$stmt_unread_count = $conn->prepare($sql_unread_count);
$stmt_unread_count->bind_param("s", $index_number);
$stmt_unread_count->execute();
$unread_count_result = $stmt_unread_count->get_result();
$unread_count_row = $unread_count_result->fetch_assoc();
$unread_count = $unread_count_row['unread_count'];
$stmt_unread_count->close();

 $conn->close();
echo $unread_count;
?>
