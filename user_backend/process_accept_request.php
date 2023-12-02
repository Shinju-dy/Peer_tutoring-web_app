<?php
    session_start();

    // Check if user is logged in
    if (!isset($_SESSION['index_number'])) {
        // Redirect to the login page with an error message
        header('Location: ../front_end/login.php?status=not_logged_in');
        exit;
    }

    // Check if the user is a tutor by checking the `approved` column
    include_once '../php/config.php';
    $user_id = $_SESSION['index_number'];
    $sql = "SELECT approved FROM users WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 's', $user_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $approved);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    if ($approved != 1) {
        // Redirect to the notification page with an error message
        header('Location: ../front_end/notification.php?status=not_tutor');
        exit;
    } else {

        // Get the request ID from the query parameter
        if (!isset($_GET['request_id'])) {
            // Redirect to the notification page with an error message
            header('Location: ../front_end/notification.php?status=no_request_id');
            exit;
        }

        $request_id = $_GET['request_id'];

        // Check if the request has already been accepted
        $sql = "SELECT accepted_by FROM request_tutor WHERE request_id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 's', $request_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $accepted_by);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);

        if ($accepted_by) {
            // Redirect to the notification page with an error message
            header('Location: ../front_end/notification.php?status=request_already_accepted');
            exit;
        }

        // Update the request with the tutor's ID
        $sql = "UPDATE request_tutor SET accepted_by = ? WHERE request_id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'ss', $_SESSION['index_number'], $request_id);    
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        // Retrieve the user's information
        $user_id = '';
        $course= '';
        $programme = '';
        $preferred_time = '';
        $preferred_gender = '';
        $notes = '';
        $sql = "SELECT id, programme, course, preferred_time, preferred_gender, notes FROM request_tutor WHERE request_id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 's', $request_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $user_id, $programme, $course, $preferred_time, $preferred_gender, $notes);

        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);

        // Retrieve the tutor's information
        $tutor_id = $_SESSION['index_number'];
        $programme = '';
        $level = '';
        $first_name = '';
        $last_name = '';
        $phone_number = '';
        $sql = "SELECT a.programme, a.level, u.first_name, u.last_name, u.phone_number FROM applications a INNER JOIN users u ON a.user_id = u.id WHERE u.id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 's', $tutor_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $programme, $level, $first_name, $last_name, $phone_number);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);

        // Update the status of the corresponding request to "accepted"
        $sql = "UPDATE request_tutor SET status = 'accepted' WHERE request_id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 's', $request_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        // Update the notification status
        $sql = "UPDATE user_notifications SET status = 'accepted' WHERE request_id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 's', $request_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        // Send notification to user
        $message = $first_name . ' ' . $last_name . ' has accepted your tutor request for ' . $course . '.\n';
        $message .= 'Programme: ' . $programme . '\n';
        $message .= 'Level: ' . $level . '\n';
        $message .= 'Phone Number: ' . $phone_number . '\n';
        $sql = "INSERT INTO user_notifications (user_id, message, request_id, status) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        $status = 'accepted';
        mysqli_stmt_bind_param($stmt, 'ssss', $user_id, $message, $request_id, $status);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        mysqli_close($conn);

        // Redirect to the notification page with a success message
        header('Location: ../front_end/notification.php?status=request_accepted');
        exit;

        }
?>
