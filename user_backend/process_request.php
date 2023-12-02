<?php
session_start();

if (!isset($_SESSION['index_number'])) {
    header('Location: ../front_end/login.php');
    exit();
}

include_once '../php/config.php';

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['index_number'];
    $sql = "SELECT index_number FROM users WHERE id='$user_id'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $index_number = $row['index_number'];
    $user_type = $_POST['user_type'];
    $programme = $_POST['programme'];
    $course = $_POST['course'];
    $preferred_time = $_POST['preferred_time'];
    $preferred_gender = $_POST['preferred_gender'];
    $notes = $_POST['notes'];

    // Generate request ID
    $request_id = uniqid();

    $sql = "INSERT INTO request_tutor (request_id, id, user_type, programme, course, preferred_time, preferred_gender, notes) VALUES ('$request_id', '$index_number', '$user_type', '$programme', '$course', '$preferred_time', '$preferred_gender', '$notes')";

// ...

if (mysqli_query($conn, $sql)) {
    // Retrieve all approved tutors from the users table and join with the applications table
    $sql = "SELECT users.*, applications.* FROM users JOIN applications ON users.id = applications.user_id WHERE users.approved=1";
    $result = mysqli_query($conn, $sql);

    // Send notification to each tutor
    while ($row = mysqli_fetch_assoc($result)) {
        $tutor_id = $row['user_id'];
        $tutor_name = $row['first_name'] . ' ' . $row['last_name'];
        $tutor_programme = $row['programme'];
        $tutor_level = $row['level'];
        $tutor_phone_number = $row['phone_number'];

        $sql = "INSERT INTO user_notifications (user_id, message, request_id) VALUES ('$tutor_id', 'You have a new tutor request from $first_name for $course.', '$request_id')";

        if (!mysqli_query($conn, $sql)) {
            die("Error: " . mysqli_error($conn));
        }
    }

    // Redirect to request page with success message
    header('Location: ../front_end/request.php?success=1');
    exit();
} else {
    echo "Error: " . mysqli_error($conn);
}

mysqli_close($conn);
}
?>