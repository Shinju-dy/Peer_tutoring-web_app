<?php
session_start();

$is_tutor = 0;

if (!isset($_SESSION['index_number'])) {
    header('Location: ../front_end/index.php');
    exit();
} else {
    include_once '../php/config.php';
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> UPSA AfterClass | FAQ </title>
    <link rel="stylesheet" type="text/css" href="../css/navreq.css">
    <link rel="stylesheet" href="../css/freq.css">
    <script src="https://kit.fontawesome.com/b390487c26.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" />
    <link rel="icon" type="image/x-icon" href="../Images/a_upsa.png">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
    <!-- css -->
</head>
<body>
  <header>
    <div class="header-content">
      <h1>Frequently Asked Questions</h1>
    </div>
</header>

 <!----Menu Bar-->
 <div id="menu-bar" class="fas fa-bars"></div>
 <!----Menu Bar-->

  <!---Navbar Section Starts-->

  <div class="container">  
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
</div>
<!---Navbar Section ends-->


    

<div class="accordion">
  <div class="accordion-item">
    <div class="accordion-item-header">
      What is AfterClass?
    </div>
    <div class="accordion-item-body">
      <div class="accordion-item-body-content">
        AfterClass is a web-based system  built by UPSA students and for UPSA students that includes both a student platform for learners to find peer tutors and schedule sessions, as well as an administrator dashboard for faculty to oversee and manage all student activity.
      </div>
    </div>
  </div>
  <div class="accordion-item">
    <div class="accordion-item-header">
      How to request for Tutor?
    </div>
    <div class="accordion-item-body">
      <div class="accordion-item-body-content">
        Follow the following steps After creating an account and logging into the sytem in order to request for a tutor;
      <ol style="padding-left: 1rem;">
        <li>kindly click on request tutor on the side bar. secondly complete by filling and submitting the form 
        </li>
        <li>Tutee will be notified through the notification bar on the side bar, once assigned a tutor.</li>
      </ol>
      </div>
    </div>
  </div>
  <div class="accordion-item">
    <div class="accordion-item-header">
        How to become a Tutor?
    </div>
    <div class="accordion-item-body">
      <div class="accordion-item-body-content">
        <ol style="padding-left: 1rem;">
          <li>Sign up and login to AfterClass</li>
          <li>Click on become a tutor on the side bar</li>
          <li>Fill the form, provide and submit the needed document</li>
          <li>Wait to be aprroved by admin (this process may take up to 3 working days)</li>
          <li>You will receive an email and/or notification once you are approved or your request was denied.</li>
        </ol>
      </div>
    </div>
  </div>
  <div class="accordion-item">
    <div class="accordion-item-header">
     Payment Method?
    </div>
    <div class="accordion-item-body">
      <div class="accordion-item-body-content">
       All Tutees are required to pay the tutor GHC 20 after each booked session irrespective of the time it took the tutor to tutor them.
      </div>
    </div>
  </div>
  <div class="accordion-item">
    <div class="accordion-item-header">
      How to report an Issue with Tutor or Tutee?
    </div>
    <div class="accordion-item-body">
      <div class="accordion-item-body-content">
        An issue with a tutor can be reported either through the contact us page on the home page, through the afterclass@gmail.com or 0555491813.
      </div>
    </div>
  </div>

  <div class="accordion-item">
    <div class="accordion-item-header">
     Want To Reach Us?
    </div>
    <div class="accordion-item-body">
      <div class="accordion-item-body-content">
      <ul>
        <li>Email:upsaafterclass@gmail.com
        </li>
        <li>Telephone: +233 555491813</li>
      </ul>
      </div>
    </div>
  </div>

  <div class="accordion-item">
    <div class="accordion-item-header">
     Requirement To Become A Tutor
    </div>
    <div class="accordion-item-body">
      <div class="accordion-item-body-content">
       Tutors are approved based on academic performance of the applicant. It is for these reasons why applicants are required to submit an official scanned copy of their transcript to the system for review. Note that the name of the transcript sent should be the applicants index number.
      </div>
    </div>

</div>
<script src="../JS/main.js"></script>

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