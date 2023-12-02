<?php
include_once '../php/config.php';
// rest of your code here
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AfterClass | Login</title>
    <link rel="shortcut icon" href="../Images/a_upsa.png" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <script src="https://kit.fontawesome.com/b390487c26.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../admin_css/admin_index.css">
</head>

<body>
    <div class="contain">
        <div class="form-box">
            <div class="logo">
                <img src="../Images/logotype_hori_upsa.png">
            </div>

            <?php if (isset($_SESSION['error_message'])): ?>
                <div class="error-message">
                    <p><?php echo $_SESSION['error_message']; ?></p>
                </div>
                <?php unset($_SESSION['error_message']); ?>
            <?php endif; ?>

            <h3>Login into your Admin account</h3>
            <!-- form starts here -->
            <form action="../admin_backend/process_admin_login.php" method="post">
        <div class="input-group">
            <div class="input-field">
                <i class="fa-solid fa-user"></i>
                <input type="text" placeholder="username" name="admin_username" required>
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
