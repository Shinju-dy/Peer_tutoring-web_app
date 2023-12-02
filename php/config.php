<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "peer_tutoring_system";

// Create a database connection
$conn = mysqli_connect($host, $user, $password, $database);

// Check for connection errors
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>