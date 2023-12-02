<?php
include '../php/config.php';

// rest of your code here
?>
<?php
// Check if the error message is set in the URL parameters
if (isset($_GET['error_message'])) {
    $error_message = $_GET['error_message'];
    echo "<div class='error-message'>$error_message</div>";
}
?>


<?php // This is your PHP code here ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UPSA AfterClass | Signup</title>
    <link rel="shortcut icon" href="../Images/a_upsa.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/styleup.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <script src="https://kit.fontawesome.com/b390487c26.js" crossorigin="anonymous"></script>
</head>
<body>
<div class="contain">
<div class="form-box">
    <div class="logo">
        <img src="../Images/logotype_hori_upsa.png" alt="">
    </div>
    <h3>Create an AfterClass account</h3>

    <!-- form starts here -->
    <form action="../user_backend/process_signup.php" method="post">
        <div class="input-group">
            <div class="input-field">
                <i class="fa-solid fa-user"></i>
                <input type="text" placeholder="First Name" id="firstName" name="firstName" required>
            </div>

            <div class="input-field">
                <i class="fa-solid fa-user"></i>
                <input type="text" placeholder="Last Name" id="lastName" name="lastName" required>
            </div>

            <div class="input-field">
                <i class="fas fa-id-badge"></i>
                <input type="text" placeholder="Index Number" id="indexNumber" name="indexNumber" required>
            </div>

            <div class="input-field">
                <i class="fa-solid fa-phone"></i>
                <input type="tel" placeholder="Phone Number" id="phoneNumber" name="phoneNumber" required>
            </div>

            <div class="input-field">
                <i class="fa-solid fa-lock"></i>
                <input type="password" placeholder="Password" id="password" name="password" required>
                <div class="toggle-password">
                    <i class="fa-solid fa-eye" id="togglePassword"></i>
                </div>
            </div>

            <div class="input-field">
                <i class="fa-solid fa-lock"></i>
                <input type="password" placeholder="Confirm Password" id="confirmPassword" name="confirmPassword" required>
                <div class="toggle-password">
                    <i class="fa-solid fa-eye" id="toggleConfirmPassword"></i>
                </div>
            </div>

            <div class="btn-field">
                <input type="submit" value="Sign Up" name="submit">
            </div>
            <div>
                <a href="../front_end/login.php">Already have an account?</a>
            </div>
        </div>
            </form>
        </div>
    </div>

<script>
    document.getElementById('togglePassword').addEventListener('click', function () {
        togglePasswordVisibility('password', this);
    });

    document.getElementById('toggleConfirmPassword').addEventListener('click', function () {
        togglePasswordVisibility('confirmPassword', this);
    });

    function togglePasswordVisibility(inputId, iconElement) {
        const input = document.getElementById(inputId);
        if (input.type === 'password') {
            input.type = 'text';
            iconElement.classList.remove('fa-eye');
            iconElement.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            iconElement.classList.remove('fa-eye-slash');
            iconElement.classList.add('fa-eye');
        }
    }
</script>
</body>
</html>
