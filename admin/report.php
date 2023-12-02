<?php
session_start();
include_once '../php/config.php';

include_once '../admin_backend/generate_pdf.php';
if (isset($_GET['download_pdf']) && $_GET['download_pdf'] == 1) {
    // Buffer the output to capture the HTML content
    ob_start();
}

// Check if the user is logged in as an admin
if (!isset($_SESSION['admin_username'])) {
    header('Location: ../admin/admin_login.php'); // Redirect to the login page if the user is not logged in
    exit();
}

// Fetch data from the request_tutor table
$sql_request_tutor = "SELECT * FROM request_tutor";
$result_request_tutor = mysqli_query($conn, $sql_request_tutor);
$request_tutor_data = mysqli_fetch_all($result_request_tutor, MYSQLI_ASSOC);

// Fetch data from the applications table
$sql_applications = "SELECT * FROM applications";
$result_applications = mysqli_query($conn, $sql_applications);
$applications_data = mysqli_fetch_all($result_applications, MYSQLI_ASSOC);

// Fetch data from the users table
$sql_users = "SELECT * FROM users";
$result_users = mysqli_query($conn, $sql_users);
$users_data = mysqli_fetch_all($result_users, MYSQLI_ASSOC);

// Initialize an empty array for the selected data and an empty string for the table header
$selected_data = [];
$table_header = '';

// Check if the table is selected from the dropdown menu
if (isset($_GET['table'])) {
    switch ($_GET['table']) {
        case 'request_tutor':
            $selected_data = $request_tutor_data;
            $table_header = "<th>ID</th><th>User Type</th><th>Programme</th><th>Course</th><th>Preferred Time</th><th>Preferred Gender</th><th>Notes</th><th>Accepted By</th><th>Status</th><th>Created At</th>";
            break;
        case 'applications':
            $selected_data = $applications_data;
            $table_header = "<th>ID</th><th>Email</th><th>Programme</th><th>Level</th><th>CGPA</th><th>Gender</th><th>User ID</th><th>Created At</th>";
            break;
        case 'users':
            $selected_data = $users_data;
            $table_header = "<th>ID</th><th>Index Number</th><th>First Name</th><th>Last Name</th><th>Phone Number</th><th>Created At</th><th>Approved</th>";
            break;
        case 'tutors':
            $selected_data = array_filter($users_data, function($user) {
                return $user['approved'] == 1;
            });
            $table_header = "<th>ID</th><th>Index Number</th><th>First Name</th><th>Last Name</th><th>Phone Number</th><th>Created At</th><th>Approved</th>";
                break;
        case 'tutees':
            $selected_data = array_filter($users_data, function($user) {
                return $user['approved'] == 0;
            });
            $table_header = "<th>ID</th><th>Index Number</th><th>First Name</th><th>Last Name</th><th>Phone Number</th><th>Created At</th><th>Approved</th>";
            break;
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
    <title>Reports | Admin</title>
    <link rel="stylesheet" href="../admin_css/reports.css">
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
            <li><a href="../admin/noti_mgt.php">Notification</a>
            <span class="badge"><?php echo $unread_count; ?></span>
            </li>
            <li><a href="../admin/report.php">Reports</a></li>   
            <li><a href="../admin_backend/admin_process_logout.php">Logout</a></li>
        </ul>
    </nav>
</header>
<div class="container">
    <h1>Reports</h1>

    <form method="get">
    <label for="table">Select table:</label>
    <select name="table" id="table">
        <option value="request_tutor">Request Tutor</option>
        <option value="applications">Applications</option>
        <option value="users">Users</option>
        <option value="tutors">Tutors</option>
        <option value="tutees">Tutees</option>
    </select>
    <input type="submit" value="Generate Report">
</form>


<a href="?download_pdf=1&table=<?php echo isset($_GET['table']) ? $_GET['table'] : ''; ?>" class="download-pdf-btn">Download PDF</a>

<h2><?php echo isset($_GET['table']) ? ucfirst(str_replace('_', ' ', $_GET['table'])) : ''; ?> Report</h2>
<table>
    <thead>
        <tr>
            <?php echo $table_header; ?>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($selected_data as $data): ?>
            <tr>
                <?php if ($_GET['table'] === 'applications'): ?>
                    <td><?php echo $data['id']; ?></td>
                    <td><?php echo $data['email']; ?></td>
                    <td><?php echo $data['programme']; ?></td>
                    <td><?php echo $data['level']; ?></td>
                    <td><?php echo $data['cgpa']; ?></td>
                    <td><?php echo $data['gender']; ?></td>
                    <td><?php echo $data['user_id']; ?></td>
                    <td><?php echo $data['created_at']; ?></td>
                <?php else: ?>
                    <?php foreach ($data as $key => $value): ?>
                        <?php if (
    ($key !== 'password') &&
    ($_GET['table'] !== 'request_tutor' || $key !== 'request_id')
): ?>
    <td><?php echo $value; ?></td>
<?php endif; ?>

                    <?php endforeach; ?>
                <?php endif; ?>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
</div>
<?php
if (isset($_GET['download_pdf']) && $_GET['download_pdf'] == 1) {
    $html = ob_get_clean();
    generate_pdf($html);
}
?>
<script src="../JS/noti_mgt_notification_badge.js"></script>
</body>
</html>
