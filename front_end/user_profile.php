<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['index_number'])) {
    header('Location: ../front_end/index.php');
    exit();
}

// Check for connection errors
include_once '../php/config.php';
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


$index_number = $_SESSION['index_number'];
$sql = "SELECT * FROM users WHERE index_number = '$index_number'";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);

$first_name = $user['first_name'];
$last_name = $user['last_name'];
$phone_number = $user['phone_number'];
$role_type = $user['approved'] == 1 ? 'Tutor' : 'Tutee';


// Fetch the 'approved' column value for the current user
$index_number = $_SESSION['index_number'];
$query = "SELECT approved FROM users WHERE index_number = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, 's', $index_number);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);
$is_tutor = $row['approved'];
mysqli_close($conn);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UPSA AfterClass | Profile</title>
    <link rel="shortcut icon" href="../Images/a_upsa.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/user_profile.css">
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

            <div class="profile-container">
            <h2>Your Profile</h2>
            <p><strong>First Name:</strong> <?php echo $first_name; ?></p>
            <p><strong>Last Name:</strong> <?php echo $last_name; ?></p>
            <p><strong>Index Number:</strong> <?php echo $index_number; ?></p>
            <p><strong>Phone Number:</strong> <?php echo $phone_number; ?></p>
            <p><strong>Role Type:</strong> <?php echo $role_type; ?></p>
            </div>



      <script>
    const menu = document.querySelector("#menu-bar");
    const navbar = document.querySelector(".nav");

    menu.addEventListener('click', () =>{
        menu.classList.toggle('fa-times');
    navbar.classList.toggle('active');
    });
    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../JS/notification-badge.js"></script>
</body>
</html>