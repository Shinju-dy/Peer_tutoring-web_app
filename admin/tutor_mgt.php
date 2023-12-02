
<?php

session_start();
include_once '../php/config.php';

$search = isset($_GET['search']) ? $_GET['search'] : '';

if ($search) {
    $sql = "SELECT applications.id, users.first_name, users.last_name, users.approved, applications.programme, applications.cgpa, applications.gender FROM applications JOIN users ON applications.user_id = users.id WHERE users.first_name LIKE '%$search%' OR users.last_name LIKE '%$search%'";
} else {
    $sql = "SELECT applications.id, users.first_name, users.last_name, users.approved, applications.programme, applications.cgpa, applications.gender FROM applications JOIN users ON applications.user_id = users.id";
}

$result = mysqli_query($conn, $sql);
$applications = mysqli_fetch_all($result, MYSQLI_ASSOC);

if (!isset($_SESSION['admin_username'])) {
    header('Location: ../admin/admin_login.php'); // Redirect to the login page if the user is not logged in
    exit();
}

// Fetch unread notifications count
if (isset($_SESSION['admin_username'])) {
    $sql_unread = "SELECT COUNT(*) as unread_count FROM notifications WHERE is_read = 0";
    $result_unread = mysqli_query($conn, $sql_unread);
    $unread_count = mysqli_fetch_assoc($result_unread)['unread_count'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../images/a_upsa.png" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="../admin_css/tutormgt.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Tutor Management | Admin</title>
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
            <li><a href="../admin/noti_mgt.php">Notification</a>
            <span class="badge"><?php echo $unread_count; ?></span>
            </li>
            <li><a href="../admin/report.php">Reports</a></li>   
            <li><a href="../admin_backend/admin_process_logout.php">Logout</a></li>
        </ul>
    </nav>
</header>

    <div class="container">
    <h1>Tutor Applications</h1>
    <form action="../admin/tutor_mgt.php" method="get" class="search-form" id="search-form">
  <input type="search" name="search" placeholder="Search by name" value="<?php echo $search; ?>" id="search-input">
  <div>
    <input type="submit" value="Search" class="search-btn">
  </div>
</form>

    <table>
        <tr>
        <th>Applicant Name</th>
        <th>Application ID</th>
        <th>Programme</th>
        <th>CGPA</th>
        <th>Gender</th>
        <th>Transcript</th>
        <th>Action</th>
        </tr>
        <?php foreach ($applications as $application): ?>
    <tr style="background-color: <?php echo $application['approved'] == 1 ? 'lightgoldenrodyellow' : ($application['approved'] == 0 ? 'lightsalmon' : 'transparent'); ?>">
        <td><?php echo $application['first_name'] . ' ' . $application['last_name']; ?></td>
        <td><?php echo $application['id']; ?></td>
        <td><?php echo $application['programme']; ?></td>
        <td><?php echo $application['cgpa']; ?></td>
        <td><?php echo $application['gender']; ?></td>
        <td>
        <a href="../admin_backend/download_transcript.php?application_id=<?php echo $application['id']; ?>" target="_blank">Download Transcript</a>
        </td>
        <td>
        <?php if ($application['approved'] != 1) : ?>
    <form action="../admin_backend/approve_tutor.php" method="post" style="display: inline;">
        <input type="hidden" name="id" value="<?php echo $application['id']; ?>">
        <input type="submit" name="approve" value="Approve" class="approve-btn">
    </form>
<?php endif; ?>

            
            <form action="../admin_backend/decline_tutor.php" method="post" style="display: inline;">
                <input type="hidden" name="id" value="<?php echo $application['id']; ?>">
                <input type="submit" name="decline" value="Decline" class="decline-btn">
            </form>
        </td>
    </tr>
<?php endforeach; ?>

    </table>
</div>

<script>
    document.getElementById('search-input').addEventListener('input', function () {
        document.getElementById('search-form').submit();
    });
</script>

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
