<?php
session_start();
include_once '../php/config.php';
include_once '../admin_backend/fetch_noti.php';

$sql = "SELECT * FROM notifications ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);
$notifications = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Mark all notifications as read
$update_query = "UPDATE notifications SET is_read = 1";
mysqli_query($conn, $update_query);

// Update unread count to 0
$unread_count = 0;

if (!isset($_SESSION['admin_username'])) {
    header('Location: ../admin/admin_login.php'); // Redirect to the login page if the user is not logged in
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notification Management | Admin</title>
    <link rel="stylesheet" href="../admin_css/noti_mgt.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="shortcut icon" href="../images/a_upsa.png" type="image/x-icon">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<header>
    <a href="../admin/dashboard.php"><img src="../Images/logotype_hori_upsa.png" alt="logo"></a>
    <nav>
        <div class="hamburger" onclick="toggleMenu()">
            <span></span>
            <span></span>
            <span></span>
        </div>
        <ul id="navMenu" >
        <li><a href="../admin/dashboard.php">Dashboard</a></li>
            <li><a href="../admin/tutor_mgt.php">Tutors</a></li>
            <li>
            <a href="../admin/noti_mgt.php">Notification</a>
            <span class="badge"><?php echo $unread_count; ?></span>
            </li>
            <li><a href="../admin/report.php">Reports</a></li>   
            <li><a href="../admin_backend/admin_process_logout.php">Logout</a></li>
        </ul>
    </nav>
</header>

    <div class="container">
        <h1>Admin Notification</h1>

        <!-- Display the notifications in a table -->
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Message</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($notifications as $notification): ?>
                    <tr>
                        <td><?php echo $notification['title']; ?></td>
                        <td><?php echo $notification['message']; ?></td>
                        <td><?php echo $notification['created_at']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script>
  function toggleMenu() {
  var navMenu = document.getElementById("navMenu");
  var header = document.querySelector("header");
  var container = document.querySelector(".container");
  navMenu.classList.toggle("show-menu");
  header.classList.toggle("show-menu");
  container.classList.toggle("menu-toggled");
}
</script>
<script src="../JS/noti_mgt_notification_badge.js"></script>
</body>
</html>


