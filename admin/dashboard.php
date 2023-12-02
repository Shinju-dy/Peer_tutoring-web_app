<?php
session_start();
include_once '../php/config.php';

if (!isset($_SESSION['admin_username'])) {
    header('Location: ../admin/admin_login.php'); // Redirect to the login page if the user is not logged in
    exit();
}


// Fetch the number of users, tutors, and tutees
$user_count = 0;
$tutor_count = 0;
$tutee_count = 0;

// Count users
$result = $conn->query("SELECT COUNT(*) as count FROM users");
if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $user_count = $row['count'];
}

// Count tutors
$result = $conn->query("SELECT COUNT(*) as count FROM users WHERE approved = 1");
if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $tutor_count = $row['count'];
}

// Count tutees
$result = $conn->query("SELECT COUNT(*) as count FROM users WHERE approved = 0");
if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $tutee_count = $row['count'];
}

// Fetch the count of requests by status
 $status_counts = [
    'pending' => 0,
    'accepted' => 0,
    'cancelled' => 0,
];

$result = $conn->query("SELECT status, COUNT(*) as count FROM request_tutor GROUP BY status");
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $status_counts[$row['status']] = $row['count'];
    }
}


// Fetch the count of requests by preferred gender
$gender_counts = [
    'male' => 0,
    'female' => 0,
];

$result = $conn->query("SELECT preferred_gender, COUNT(*) as count FROM request_tutor GROUP BY preferred_gender");
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $gender_counts[$row['preferred_gender']] = $row['count'];
    }
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="../admin_css/dashboard.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Dashboard | Admin</title>
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
    <h1>Welcome To The Admin Dashboard</h1>
    
    <!-- Add this code inside the container <div> in dashboard.php -->
<div class="stats-container">
    <div class="box1">
    <div class="title">Users</div>
    <div class="value" id="users"><?php echo $user_count; ?></div>
</div>
<div class="box2">
    <div class="title">Tutors</div>
    <div class="value" id="tutors"><?php echo $tutor_count; ?></div>
</div>
<div class="box3">
    <div class="title">Tutees</div>
    <div class="value" id="tutees"><?php echo $tutee_count; ?></div>
</div>
</div>

        <div class="charts-wrapper">
            <div class="chart-container">
                <canvas id="statusChart"></canvas>
            </div>
            <div class="chart-container">
                <canvas id="genderChart"></canvas>
            </div>
        </div>

</div>

<script>
    // Requests by status pie chart
    const statusCounts = <?php echo json_encode($status_counts); ?>;
    const statusChart = new Chart(document.getElementById('statusChart'), {
        type: 'pie',
        data: {
            labels: Object.keys(statusCounts),
            datasets: [{
                data: Object.values(statusCounts),
                backgroundColor: ['#3f84fc', '#1dab47','#fc413f'],
            }]
        },
        options: {
            plugins: {
                title: {
                    display: true,
                    text: 'Requests by Status'
                }
            }
        }
    });
</script>

<script>
    
// Preferred gender bar chart
const genderCounts = <?php echo json_encode($gender_counts); ?>;
const genderData = {
  labels: ["Male", "Female"],
  datasets: [
    {
      label: "Male",
      data: [genderCounts["male"] || 0, 0],
      backgroundColor: ["#3f84fc"],
    },
    {
      label: "Female",
      data: [0, genderCounts["female"] || 0],
      backgroundColor: [ "#fc413f"],
    },
  ],
};
const genderOptions = {
  plugins: {
    title: {
      display: true,
      text: "Preferred Gender for Request",
    },
  },
  scales: {
    x: {
      title: {
        display: true,
        text: "Gender",
      },
      ticks: {
        autoSkip: false,
      },
    },
    y: {
      title: {
        display: true,
        text: "Number of Requests",
      },
      beginAtZero: true,
      ticks: {
        stepSize: 1,
      },
    },
  },
};
const genderChart = new Chart(document.getElementById("genderChart"), {
  type: "bar",
  data: genderData,
  options: genderOptions,
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