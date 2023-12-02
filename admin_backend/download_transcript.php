<?php
include_once '../php/config.php';

$application_id = isset($_GET['application_id']) ? $_GET['application_id'] : '';

if ($application_id) {
    $sql = "SELECT transcript FROM applications WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $application_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($transcript_filename);
    $stmt->fetch();

    if ($transcript_filename) {
        $file_path = "../uploads/" . $transcript_filename;


        if (file_exists($file_path)) {
            header("Content-Type: application/pdf");
            header("Content-Disposition: inline; filename=transcript_$application_id.pdf");
            header("Content-Length: " . filesize($file_path));
            readfile($file_path);
        } else {
            echo "Error: Transcript file not found";
        }
    } else {
        echo "Error: Transcript not found";
    }
} else {
    echo "Error: Invalid application ID";
}
?>
