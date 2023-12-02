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
      <title>UPSA AfterClass | Request</title>
    <link rel="shortcut icon" href="../Images/a_upsa.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/stylereq.css">
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
  <!---Navbar Section End-->

 <?php
    if (isset($_GET['success']) && $_GET['success'] == 1) {
        echo '<div class="success-message">Dear User, your request has been made successfully.</div>';
    }
  ?>

  <div class="container" >
    <div class="title">Request a Tutor</div>
    <div class="content" >

    
   <!-- form starts here -->
    <form action="../user_backend/process_request.php" method="POST">
        <div class="user-details">

        <div class="input-box">
        <span class="details">I am:</span>
        <select id="user_type" name="user_type">
        <option value="">Please Select Your Role</option>
            <option value="tutee">Tutee</option>
            <option value="tutor">Tutor</option>
        </select>
        </div>

          <div class="input-box">
            <span class="details">Programme</span>
            <select id="programme" name="programme" class="hov" onchange="populateCourses()">
              <option value="">Please select a programme</option>
              <option value="Information Technology">Information Technology</option>
              <option value="Business Administration">Business Administration</option>
              <option value="Accounting">Accounting</option>
            </select>
          </div>
          <div class="input-box">
            <span class="details">Course</span>
            <select id="course" name="course" class="hov">
              <option value="">Please select a course</option>
            </select>
          </div>
       
          <div class="input-box">
            <span class="details">Preferred time</span>
            <input type="time" placeholder="Enter Prefered meeting time" name="preferred_time" required>
          </div>
        </div>

        <div class="gender-details">
        <input type="radio" name="preferred_gender" id="dot-1" value="male">
        <input type="radio" name="preferred_gender" id="dot-2" value="female">
            
          <span class="gender-title">Prefered tutor gender</span>
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
        <textarea name= "notes" id="notes"placeholder="Any note for Tutor?"></textarea>
        <div class="button">
          <input type="submit" value="Request">
        </div>
      </form>
    </div>
  </div>
<!-- form ends here -->

  <script>
    const menu = document.querySelector("#menu-bar");
    const navbar = document.querySelector(".nav");

    menu.addEventListener('click', () =>{
        menu.classList.toggle('fa-times');
    navbar.classList.toggle('active');
    });
    </script>



<script>
  const programmeSelect = document.getElementById("programme");
  const courseSelect = document.getElementById("course");

  programmeSelect.addEventListener("change", (event) => {
    const programme = event.target.value;
    courseSelect.innerHTML = "";

    if (programme === "Information Technology") {
      addOption(courseSelect, "Please select a course", "Please select a course");

      addOption(courseSelect, "Web Development", "Web Development");
      addOption(courseSelect, "Computer Intro. Hardware", "Computer Intro. Hardware");
      addOption(courseSelect, "Intro. Programming", "Intro. Programming");
    } else if (programme === "Business Administration") {
      addOption(courseSelect, "Please select a course", "Please select a course");

      addOption(courseSelect, "Business Ethics", "Business Ethics");
      addOption(courseSelect, "Quantitative Methods", "Quantitative Methods");
      addOption(courseSelect, "Elements of marketing", "Elements of marketing");
    } else if (programme === "Accounting") {
      addOption(courseSelect, "Please select a course", "Please select a course");

      addOption(courseSelect, "Business Statistics", "Business Statistics");
      addOption(courseSelect, "Total Quality mgt", "Total Quality mgt");
      addOption(courseSelect, "Intro to Economics", "Intro to Economics");
    }
  });

  function addOption(selectElement, text, value) {
    const option = document.createElement("option");
    option.text = text;
    option.value = value;
    selectElement.add(option);
  }
</script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../JS/notification-badge.js"></script>
</body>
</html>