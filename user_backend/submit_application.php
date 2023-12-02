<?php
$upload_dir = 'uploads';

// Create the directory if it doesn't exist
if (!file_exists($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

// Include database connection file
include_once '../php/config.php';

// Start the session
session_start();

// Get the index number of the logged in user from the session
$index_number = $_SESSION['index_number'];

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Get the form data
    $email = $_POST['email'];
    $programme = $_POST['programme'];
    $level = $_POST['level'];
    $cgpa = $_POST['cgpa'];
    $gender = $_POST['gender'];

    // Check if the database connection is successful
    if (!$conn) {
        die('Database connection failed: ' . mysqli_connect_error());
    }

    // Check if the user with the given index number exists in the database
    $sql = "SELECT id, first_name FROM users WHERE index_number = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 's', $index_number);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $user_id, $first_name);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_free_result($stmt); // Add this line to free up the memory

    if (!$user_id) {
        // Redirect to the become.php page with an error message
        header('Location: /front_end/become.php?status=user_not_found');
        exit;
    }

    // Check if the user has already applied
    $sql = "SELECT id FROM applications WHERE user_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 's', $user_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $applications_id);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_free_result($stmt); // Add this line to free up the memory

    // Check if the application_id is greater than 0
    if ($applications_id > 0) {
        // Redirect to the become.php page with a message
        header('Location: ../front_end/become.php?status=applied');
        exit;
    }

    // Read the content of the uploaded transcript file
    $transcript_file = $_FILES['transcript']['tmp_name'];
    $transcript_content = file_get_contents($transcript_file);
    
    // Check if the transcript file is uploaded successfully
        if ($_FILES['transcript']['error'] == UPLOAD_ERR_OK) {
        // Get the original filename and extension
        $filename = $_FILES['transcript']['name'];
        $ext = pathinfo($filename, PATHINFO_EXTENSION);

        // Save the uploaded file with the original filename and extension
        move_uploaded_file($_FILES['transcript']['tmp_name'], $upload_dir . '/' . $filename);

        // Update the transcript file name in the database
        $sql = "UPDATE applications SET transcript = ? WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'si', $filename, $application_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);


    // Insert the form data into the database with the same user ID
    $sql = "INSERT INTO applications (id, user_id, email, programme, level, cgpa, gender, transcript, created_at ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())";
    $stmt = mysqli_prepare($conn, $sql);

    // Use 's' for binding the string data
    mysqli_stmt_bind_param($stmt, 'ssssidss', $user_id,$user_id, $email, $programme, $level, $cgpa, $gender, $filename);

    
    // Use 'b' for binding the BLOB data
    // mysqli_stmt_bind_param($stmt, 'ssssidss', $user_id,$user_id, $email, $programme, $level, $cgpa, $gender, $transcript_file);

    // Execute the statement
    if (mysqli_stmt_execute($stmt)) {
        // Redirect to the become.php page with a success message
        header('Location: ../front_end/become.php?status=success');
    } else {
        // Redirect to the become.php page with an error message
        header('Location: ../front_end/become.php?status=error');
        exit;
    }
}
}
?>
