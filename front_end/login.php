<?php include('../user_backend/process_login.php'); ?>

<?php if (isset($error_msg)): ?>
    <div class="error-message">
        <?php echo $error_msg; ?>
    </div>
<?php endif; ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UPSA AfterClass | Login</title>
    <link rel="shortcut icon" href="Images/a_upsa.png" type="image/x-icon">
    <!--  adding a dot before the reference -->
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <script src="https://kit.fontawesome.com/b390487c26.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/stylein.css">
</head>

<body>
    <div class="contain">
        <div class="form-box">
            <div class="logo">
                <img src="../Images/logotype_hori_upsa.png">
            </div>

            <h3>Login into your account</h3>

            <!-- form starts here -->
        <form action="../front_end/login.php" method="post">
        <div class="input-group">
            <div class="input-field">
                <i class="fa-solid fa-user"></i>
                <input type="text" placeholder="Index Number" name="index_number" required>
            </div>

           <div class="input-field">
                <i class="fa-solid fa-lock"></i>
                <input type="password" placeholder="Password" id="password" name="password" required>
                <div class="toggle-password">
                    <i class="fa-solid fa-eye" id="togglePassword"></i>
                </div>
            </div>

            <div class="btn-field">
                <input type="submit" value="Login" name="submit">
            </div>

            <div>
                <p><a href="../front_end/signup.php">Do not have an account?</a></p>
            </div>
        </div>
    
            </form>
        </div>
    </div>
    <script>
        document.getElementById('togglePassword').addEventListener('click', function () {
            togglePasswordVisibility('password', this);
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
