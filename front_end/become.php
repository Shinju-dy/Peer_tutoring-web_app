<?php
session_start();
// echo 'Session ID: ' . session_id();
if (isset($_SESSION['index_number'])) {
    $index_number = $_SESSION['index_number'];
    // use $index_number in your queries to retrieve user information
} else {
    // redirect the user to the login page
    header('Location: ../front_end/index.php');
    exit();
}

include_once '../php/config.php';

// Check for connection errors
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());

    $index_number = $_SESSION['index_number'];
    $query = "SELECT approved FROM users WHERE index_number = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 's', $index_number);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    if (isset($row['approved'])) {
        $is_tutor = $row['approved'];
    }
    mysqli_close($conn);
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>UPSA AfterClass | Apply</title>
    <link rel="shortcut icon" href="Images/a_upsa.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/stylebec.css">
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

                <li><a href="../front_end/become.php">
                <i class="fas fa-user-plus"></i>
                <span class="nav-item">Become Tutor</span>
                </a></li>
             

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
  <!---Navbar Section End-->

   <?php if (isset($_GET['status'])): ?>
      <?php
        $status = $_GET['status'];
        if ($status == 'success') {
          echo '<div class="status-message">Dear user, your application has been sent successfully.</div>';
        } elseif ($status == 'applied') {
          echo '<div class="status-message">Dear user, you have already applied.</div>';
        }
      ?>
     <?php endif; ?>

    <!-- form begins here --> 
    <div class="container" >
    <div class="title">Become a Tutor</div>
    <div class="content" >
    <form action="../user_backend/submit_application.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="MAX_FILE_SIZE" value="2000000">
        <div class="user-details">
          <div class="input-box">
            <span class="details">Email</span>
            <input type="email" placeholder="Enter your Email" required name="email">
          </div>
          <div class="input-box">
          <span class="details">Programme</span>
          <select name="programme" id="programme" required>
              <option value="">Select Programme</option>
              <option value="Information Technology">Information Technology</option>
              <option value="Business Administration">Business Administration</option>
              <option value="Accounting">Accounting</option>
            </select>
          </div>
          <div class="input-box">
            <span class="details">Level</span>
            <select id="level" name="level" required>
            <span class="details">Level</span>
            <option value="">Select Level</option>
            <option value="100">100</option>
            <option value="200">200</option>
            <option value="300">300</option>
            <option value="400">400</option>
          </select>
          </div>
           
          <div class="input-box">
            <span class="details">CGPA</span>
            <input type="text" placeholder="Enter Your CGPA" required name="cgpa">

          </div>
        </div>
        <div class="gender-details">
            <input type="radio" name="gender" id="dot-1" value="Male" required>
            <input type="radio" name="gender" id="dot-2" value="Female" required>
            <span class="gender-title"> Gender</span>
            <div class="category">
              <label for="dot-1">
                <span class="dot one"></span>
                <span class="gender">Male</span>
              </label>
              <label for="dot-2">
                <span class="dot two"></span>
                <span class="gender">Female</span>
              </label>
            </div>
          </div>
          <div class="input-box">
        <input type="file" id="transcript" name="transcript" accept="application/pdf" style="display:none" required>
        <label for="transcript" id="custom-button" style="background-color: #069df5; border-radius: 5px; padding:0.4rem; cursor: pointer;">Upload Transcript</label>

    <span id="custom-text" style="font-size: small;">No file chosen</span>
</div>

        <div class="button">
          <input type="submit" value="Submit">
        </div>
      </form>
    </div>
  </div>
  <!-- form ends here -->
  <script>
  document.getElementById('transcript').addEventListener('change', function() {
    var fileName = this.files[0].name;
    document.getElementById('custom-text').innerHTML = fileName;
  });
</script>


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