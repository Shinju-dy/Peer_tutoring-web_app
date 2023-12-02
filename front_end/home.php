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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UPSA AfterClass | Home</title>
    <link rel="stylesheet" href="../css/main_style.css">
     <!---Changes Made Here-->
    <link rel="icon" type="image/x-icon" href="../Images/a_upsa.png">
	<link rel="stylesheet" type="text/css" href="../css/navstyle.css">
    <script src="https://kit.fontawesome.com/b390487c26.js" crossorigin="anonymous"></script>
   <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
   <!---Changes Made Here-->
</head>
<body>
     <!----Menu Bar-->
     <div id="menu-bar" class="fas fa-bars"></div>
     <!----Menu Bar-->
        <header>
            <div class="header-content">
                <h1>Fostering Long-Term Success in Peer Tutoring Initiatives. Step by Step, One Student at a Time.</h1>
                
                <p>We at AfterClass are firm believers in the potential of peer tutoring to foster productive, collaborative classroom communities and increase student achievement.</p>
            </div>
        </header>

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
        <!---Navbar Section End-->
        <!-- About us 1 -->
        <section class="about">
            <div class="row">
                <div class="about-left">
                    <h2>In the realm of peer-to-peer tutoring, AfterClass is synonymous with success.</h2>
                    <img src="../Images/close-up-woman-class.jpg" alt="">
                </div>

                <div class="about-middle">
                    <h2>Our History</h2>
                    <p>The University of Professional Studies, Accra (UPSA) is a progressive public institution that provides both academic and professional higher education in Ghana. </p>
                    <p>AfterClass is a web-based system created for University of Professional Studies, Accra (UPSA) students by UPSA information Technology Student in  April 2023.
                    </p>
                </div>

                <div class="about-right">
                    <h2>Vision & Mission</h2>
                    <p>Generating new knowledge and revealing gaps in knowledge through peer instruction, then, effectively supports students' ability to solve novel problems.
                    </p>
                    <p>To be an effective tool to generate new knowledge through discussion between peers and improve student understanding and metacognition.</p>
                </div>
            </div>
        </section>
    
        <!-- About 2 -->
        <section class="about2">
            <div class="row">
                <div class="about2-left">
                    <h2>What we can do for you</h2>
                    <h1>About Us</h1>
                    <p>AfterClass is a free, peer-to-peer tutoring platform where anyone, from anywhere, can get live help, build their skills, and pay it forward by becoming a tutor themselves.</p>
                    <p>Our software includes both a student platform for learners to find peer tutors and schedule sessions, as well as an administrator dashboard for faculty to oversee and manage all student activity.</p>
                    <p>Our system includes a student platform where students can find peer tutors and schedule sessions, as well as an administrator dashboard where faculty can monitor and manage all student activity.</p>
    
                </div>
                
                <div class="about2-right">
                    <div class="row">
                        <div class="card">
                            <img src="../Images/desk.png" width="45px" alt="">

                            <h2>Better Flexibility</h2>  
                        </div> 
                        <div class="card">
                            <img src="../Images/graduation-cap.png" width="45px" alt="">
                           
                            <h2>Academic support.</h2>
                        </div>
                    </div>
                    <div class="row">
                        <div class="card">
                            <img src="../Images/computer.png" width="45px"alt="">
                          
                            <h2>Saves Resources.</h2>
                        </div>
                        <div class="card">
                            <img src="../Images/network.png" width="44px"alt="">
                           
                            <h2>Better Networking</h2>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    

        <!-- process -->
        <section class="process">
            <div class="row">
                <h1>What is our Process</h1>
            </div>
            <div class="row">
                <div class="process-content">
                    <div class="progress-bar">
                        <div class="c1"></div>
                        <div class="c2"></div>
                        <div class="c3"></div>
                    </div>
                    <div class="row">
                        <div class="box1">
                            <h2>One</h2>
                            <p>Request for a Tutor by filling a form in the tutor page.</p>
                        </div>
                        <div class="box2">
                            <h2>Two</h2>
                            <p>Wait for a short moment to be assigned a tutor.</p>
                        </div>
                        <div class="box3">
                            <h2>Three</h2>
                            <p>Contact Tutor via and schedule meeting online or in-person.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    

        <!-- Testimony -->
        <section class="testimony">
            <div class="row">

                <div class="test">
                    <div class="image">
                        <img src="../Images/shinju.jpeg" alt="">
                    </div>
                    <div class="test-content">
                        <p>"AfterClass facilitates the discovery of peer tutors, the acquisition of course aid, and the enhancement of study skills. The program is user-friendly for kids, and it allows administrators to keep tabs on who provides and receives help. AfterClass is awesome.”</p>
                        <h2>Pearl Yeboah</h2>
                        <div class="icons">
                            <box-icon name='star' type='solid' color='whitesmoke'></box-icon>
                            <box-icon name='star' type='solid' color='whitesmoke'></box-icon>
                            <box-icon name='star' type='solid' color='whitesmoke'></box-icon>
                            <box-icon name='star' type='solid' color='whitesmoke'></box-icon>
                            <box-icon name='star' type='solid' color='whitesmoke'></box-icon>
                        </div>
                    </div>
                </div>

                <div class="test">
                    <div class="image">
                        <img src="../Images/abdul.jpeg" alt="">
                    </div>
                    <div class="test-content">
                        <p>"AfterClass facilitates the discovery of peer tutors, the acquisition of course aid, and the enhancement of study skills. The program is user-friendly for kids, and it allows administrators to keep tabs on who provides and receives help. AfterClass is awesome.”</p>
                        <h2>Jawad Mumuni</h2>
                        <div class="icons">
                            <box-icon name='star' type='solid' color='whitesmoke'></box-icon>
                            <box-icon name='star' type='solid' color='whitesmoke'></box-icon>
                            <box-icon name='star' type='solid' color='whitesmoke'></box-icon>
                            <box-icon name='star' type='solid' color='whitesmoke'></box-icon>
                            <box-icon name='star-half' type='solid' color='whitesmoke'></box-icon>
                        </div>
                    </div>
                </div>
    
                <div class="test">
                    <div class="image">
                        <img src="../Images/eli.jfif" alt="">
                    </div>
                    <div class="test-content">
                        <p>“AfterClass facilitates the discovery of peer tutors, the acquisition of course aid, and the enhancement of study skills. The program is user-friendly for kids, and it allows administrators to keep tabs on who provides and receives help. In other words, AfterClass is awesome.”</p>
                        <h2>Elian Assamoah</h2>
                        <div class="icons">
                            <box-icon name='star' type='solid' color='whitesmoke'></box-icon>
                            <box-icon name='star' type='solid' color='whitesmoke'></box-icon>
                            <box-icon name='star' type='solid' color='whitesmoke'></box-icon>
                            <box-icon name='star' type='solid' color='whitesmoke'></box-icon>
                            <box-icon name='star' type='solid' color='whitesmoke'></box-icon>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    

        <!-- Contact -->
        <section class="contact">
            <div class="row">
                <h1>Send Us A Feedback</h1>
            </div>
            <div class="row">
            <form action="../user_backend/contact_us.php" method="POST">
            <input type="text" name="name" placeholder="Enter your name">
            <input type="text" name="email" placeholder="Enter your email">
            <textarea name="message" placeholder="Enter your message"></textarea>
            <input type="submit" value="Send">
        </form>

            </div>
        </section>

        <!-- Footer -->
        <footer>
            <p><box-icon name='copyright' type='solid' color='whitesmoke' class="copy"></box-icon>2023 AfterClass. All rights Reserved.</p>
        </footer>

    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
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