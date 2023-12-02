<?php
session_start();
if (isset($_SESSION['index_number'])) {
    $index_number = $_SESSION['index_number'];
} else {
    header('Location: ../front_end/index.php');
    exit();
}

include_once '../php/config.php';

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT n.*, r.programme, r.course, r.preferred_time, r.preferred_gender, r.notes, r.accepted_by, u.first_name, 
t.first_name AS tutor_first_name, t.last_name AS tutor_last_name, t.phone_number AS tutor_phone_number,
a.programme AS tutor_programme, a.level AS tutor_level
FROM user_notifications n
LEFT JOIN request_tutor r ON n.request_id = r.request_id
LEFT JOIN users u ON r.id = u.index_number
LEFT JOIN users t ON r.accepted_by = t.index_number
LEFT JOIN applications a ON t.id = a.user_id
WHERE n.user_id = ?
ORDER BY created_at DESC";

$sql_tutee_check = "SELECT * FROM users WHERE index_number = ? AND approved = 0";
$stmt_tutee_check = $conn->prepare($sql_tutee_check);
$stmt_tutee_check->bind_param("i", $index_number);
$stmt_tutee_check->execute();
$tutee_check_result = $stmt_tutee_check->get_result();
$is_tutee = $tutee_check_result->num_rows > 0;
$stmt_tutee_check->close();

$sql_tutor_check = "SELECT * FROM users WHERE index_number = ? AND approved = 1";
$stmt_tutor_check = $conn->prepare($sql_tutor_check);
$stmt_tutor_check->bind_param("i", $index_number);
$stmt_tutor_check->execute();
$tutor_check_result = $stmt_tutor_check->get_result();
$is_tutor = $tutor_check_result->num_rows > 0;
$stmt_tutor_check->close();

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $index_number);
$stmt->execute();
$result = $stmt->get_result();
$notifications = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Add this code after fetching the notifications
//echo "<pre>";
//print_r($notifications);
//echo "</pre>";

$conn->close();
?>


    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>AfterClass | Notification</title>
    <link rel="shortcut icon" href="../Images/a_upsa.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/user_noti.css"> 
    <link rel="stylesheet" href="../css/navreq.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://kit.fontawesome.com/b390487c26.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    </head>

    <body>
        <!----Menu Bar-->
    <div id="menu-bar" class="fas fa-bars"></div>
    <!----Menu Bar-->
    <!---Navbar Section Starts-->
    <nav class="nav">
        <ul>
        <li><a href="../front_end/home.php"class="logo">
                  <img src="../Images/a_upsa.png" alt="logo">
                  <span class="nav-item">AfterClass</span>
              </a></li>

              <li><a href="../front_end/home.php">
                <i class="fas fa-home"></i>
                  <span class="nav-item">Home</span>
              </a></li>

              <li><a href="../front_end/user_profile.php">
                <i class="fas fa-user"></i>
                  <span class="nav-item">Profile</span>
              </a></li>

              <li><a href="../front_end/request.php">
                  <i class="fas fa-exchange-alt"></i>
                  <span class="nav-item">Request Tutor</span>
              </a></li>

              <?php if ($is_tutor != 1): ?>
              <li><a href="../front_end/become.php">
                <i class="fas fa-user-plus"></i>
                <span class="nav-item">Become Tutor</span>
              </a></li>
              <?php endif; ?>

                <li><a href="../front_end/notification.php">
                  <i class="fas fa-envelope"></i>
                  <span class="badge-notification"></span>
                  <span class="nav-item">Notification</span>
              </a></li>

              <li><a href="../front_end/faq.php">
                  <i class="fas fa-question"></i>
                  <span class="nav-item">FAQ</span>
              </a></li>
              
              <li><a href="../user_backend/process_logout.php" class="logout">
                  <i class="fas fa-sign-out-alt"></i>
                  <span class="nav-item">Logout</span>
              </a></li>
        </ul>
        </nav>

        
    <div class="containers">
    <h1 class="title">Notifications</h1>
    <?php if (count($notifications) > 0): ?>
    <ul class="notification-list">
    <?php foreach ($notifications as $notification): ?>
    <li class="notification">
        <div class="notification-message">
            <?php if (strpos($notification['message'], 'approved') !== false || strpos($notification['message'], 'declined') !== false): ?>
                <!-- Display tutor application status (approved/declined) -->
                <?php echo str_replace('News!!!', '<span class="news-highlight">News!!!</span>', $notification['message']); ?>
                
            <?php elseif ($notification['accepted_by'] && !$is_tutor): ?>
                <!-- Display tutor information for the tutee -->
                Your tutor request for <?php echo $notification['course']; ?> has been accepted by <?php echo ucfirst($notification['tutor_first_name']) . ' ' . ucfirst($notification['tutor_last_name']); ?><br>
                <strong>Tutor's Programme:</strong> <?php echo $notification['tutor_programme']; ?><br>
                <strong>Tutor's Level:</strong> <?php echo $notification['tutor_level']; ?><br>
                <strong>Tutor's Phone number:</strong> <?php echo $notification['tutor_phone_number']; ?><br>
                <strong>Status:</strong> <?php echo ucfirst($notification['status']); ?>
                <?php if ($notification['status'] == 'accepted' && $is_tutee): ?>
                    <form action="../user_backend/process_cancel_request.php?request_id=<?php echo $notification['request_id']; ?>" method="POST">
                        <input type="hidden" name="notification_id" value="<?php echo $notification['id']; ?>">
                        <button type="submit" class="cancel-button">Cancel</button>
                    </form>
                <?php endif; ?>
            <?php elseif ($is_tutor && isset($notification['message']) && strpos($notification['message'], 'cancelled') !== false): ?>
                <!-- Display cancellation message for the tutor -->
                <?php echo str_replace('News!!!', '<span class="notification-message-highlight">News!!!</span>', $notification['message']); ?>
            <?php elseif ($is_tutor): ?>
                <!-- Display the request information for the tutor -->
                You have a new tutor request from <?php echo ucfirst($notification['first_name']); ?><br>
                <strong>Programme:</strong> <?php echo $notification['programme']; ?><br>
                <strong>Course:</strong> <?php echo $notification['course']; ?><br>
                <strong>Preferred time:</strong> <?php echo $notification['preferred_time']; ?> GMT<br>
                <strong>Preferred gender:</strong> <?php echo ucfirst($notification['preferred_gender']); ?><br>
                <strong>Notes:</strong> <?php echo ucfirst($notification['notes']); ?>
                <?php if ($notification['accepted_by']): ?>
                    <br><strong>Status:</strong> <?php echo ucfirst($notification['status']); ?>
                <?php endif; ?>
            <?php endif; ?>
        </div>

            <div class="notification-meta">
                <small><?php echo $notification['created_at']; ?></small>
                <?php if ($is_tutor && $notification['status'] == 'pending' && strpos($notification['message'], 'approved') === false && strpos($notification['message'], 'declined') === false): ?>

                <form action="../user_backend/process_accept_request.php?request_id=<?php echo $notification['request_id']; ?>" method="POST">
                    <input type="hidden" name="notification_id" value="<?php echo $notification['id']; ?>">
                    <button type="submit" class="accept-button">Accept</button>
        
                <?php endif; ?>
            </div>
        </li>
        <?php endforeach; ?>
    </ul>
    <?php else: ?>
    <p class="no-notifications-message">You have no notifications.</p>
    <?php endif; ?>
</div>

    <script src="../JS/notification-badge.js"></script>

      <script>
    const menu = document.querySelector("#menu-bar");
    const navbar = document.querySelector(".nav");

    menu.addEventListener('click', () =>{
        menu.classList.toggle('fa-times');
    navbar.classList.toggle('active');
    });
    </script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
    // Mark all notifications as read when the page is loaded
    $.ajax({
        url: '../user_backend/mark_notifications_read.php',
        type: 'POST'
    });
});
</script>

</body>
</html>
