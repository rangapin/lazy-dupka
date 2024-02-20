<?php
include_once 'includes/db.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize input fields
    $dive_time = trim($_POST['dive_time']);
    $depth = trim($_POST['depth']);
    $discipline = trim($_POST['discipline']);
    $weight_carried = trim($_POST['weight_carried']);
    $dive_type = trim($_POST['dive_type']);
    $notes = trim($_POST['notes']);
    $overall_score = trim($_POST['overall_score']);

    // Validate dive time (assuming it should not be empty)
    if (empty($dive_time)) {
        echo "Dive time is required.";
        exit;
    }

    // Validate depth (assuming it should be a positive number)
    if (!is_numeric($depth) || $depth <= 0) {
        echo "Depth must be a positive number.";
        exit;
    }

    // Validate discipline (assuming it should not be empty)
    if (empty($discipline)) {
        echo "Discipline is required.";
        exit;
    }

    // Validate weight carried (assuming it should be a positive number)
    if (!is_numeric($weight_carried) || $weight_carried <= 0) {
        echo "Weight carried must be a positive number.";
        exit;
    }

    // Validate dive type (assuming it should be either "fun dive" or "training dive")
    if ($dive_type !== "fun dive" && $dive_type !== "training dive" ) {
        echo "Invalid dive type.";
        exit;
    }

    // Validate overall score (assuming it should be a number between 1 and 5)
    if (!is_numeric($overall_score) || $overall_score < 1 || $overall_score > 5) {
        echo "Overall score must be a number between 1 and 5.";
        exit;
    }

    // Get the current date and time
    $date_time = date("Y-m-d H:i:s");

    // Generate a unique dive number
    $dive_number = generateDiveNumber($date_time);

    $sql = "INSERT INTO dives (session_id, dive_number, dive_time, depth, discipline, weight_carried, dive_type, notes, overall_score, date) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = mysqli_prepare($conn, $sql);

// Bind parameters
mysqli_stmt_bind_param($stmt, "isddssssds", $session_id, $dive_number, $dive_time, $depth, $discipline, $weight_carried, $dive_type, $notes, $overall_score, $date);

// Execute the prepared statement
if (mysqli_stmt_execute($stmt)) {
// Insert successful
header("Location: index.php");
exit;
} else {
// Error handling
echo "Error: " . mysqli_error($conn);
}

// Close statement and connection
mysqli_stmt_close($stmt);
mysqli_close($conn);
}

/* // Function to generate a unique dive number
function generateDiveNumber($date_time) {
    // Extract date and time components
    $date = date("Ymd", strtotime($date_time));
    $time = date("His", strtotime($date_time));

    // Combine date and time to create a unique dive number
    $dive_number = $date . $time;
    return $dive_number;
} */
?>