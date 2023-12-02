<?php
include_once '../php/config.php';

if (isset($_POST['submit'])) {
    // Get the form data
    $email = $_POST['email'];
    $programme = $_POST['programme'];
    $level = $_POST['level'];
    $cgpa = $_POST['cgpa'];
    $gender = $_POST['gender'];
    $transcript = addslashes(file_get_contents($_FILES['transcript']['tmp_name']));
    $user_id = $_POST['user_id'];

    // Get the user ID of the applicant
    $sql = "SELECT user_id FROM applications WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $application_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user_id = mysqli_fetch_assoc($result)['user_id'];


    // Insert the new application into the database
    $sql = "INSERT INTO applications (email, programme, level, cgpa, gender, transcript, user_id) VALUES ('$email', '$programme', '$level', '$cgpa', '$gender', '$transcript', '$user_id')";
    mysqli_query($conn, $sql);

   // Insert the new notification for the admin
        $title = 'New Tutor Applicant';
        $message = "{$applicant_name} with index number {$applicant_index_number} just applied to be a tutor";
        $sql = "INSERT INTO notifications (user_id, title, message) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "iss", $user_id, $title, $message);
        mysqli_stmt_execute($stmt);


    // Redirect to the dashboard
    header("Location: ../admin/noti_mgt.php");
}
?>
