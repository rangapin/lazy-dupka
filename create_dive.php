<?php
include_once 'includes/db.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if session is started
session_start();

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize input fields
    $session_id = isset($_SESSION['session_id']) ? $_SESSION['session_id'] : null;
    $dive_time = isset($_POST['dive_time']) ? trim($_POST['dive_time']) : '';
    $dive_depth = isset($_POST['dive_depth']) ? trim($_POST['dive_depth']) : '';
    $dive_discipline = isset($_POST['dive_discipline']) ? trim($_POST['dive_discipline']) : '';
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
    if (!is_numeric($dive_depth) || $dive_depth <= 0) {
        echo "Depth must be a positive number.";
        exit;
    }

    // Validate discipline (assuming it should not be empty)
    if (empty($dive_discipline)) {
        echo "Discipline is required.";
        exit;
    }

    // Validate weight carried (assuming it should be a positive number)
    if (!is_numeric($weight_carried) || $weight_carried <= 0) {
        echo "Weight carried must be a positive number.";
        exit;
    }

    // Validate dive type (assuming it should be one of the specified values)
    $allowed_dive_types = array("warm up", "fun dive", "training", "competition");
    if (!in_array($dive_type, $allowed_dive_types)) {
        echo "Invalid dive type.";
        exit;
    }

    // Validate overall score (assuming it should be a number between 1 and 5)
    if (!is_numeric($overall_score) || $overall_score < 1 || $overall_score > 5) {
        echo "Overall score must be a number between 1 and 5.";
        exit;
    }

    // Get the current date and time
    $date = date("Y-m-d H:i:s");

    // Generate a unique dive number
    $dive_number = generateDiveNumber($conn, $session_id);

    // SQL to insert a new dive record
    $sql = "INSERT INTO Dives (session_id, dive_number, dive_time, dive_depth, dive_discipline, weight_carried, dive_type, notes, overall_score, date) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    /// Prepare the SQL statement
$stmt = mysqli_prepare($conn, $sql);

// Check if the statement was prepared successfully
if (!$stmt) {
    // Handle the error
    echo "Error: " . mysqli_error($conn);
    exit;
}

// Bind parameters
mysqli_stmt_bind_param($stmt, "isddssssds", $session_id, $dive_number, $dive_time, $dive_depth, $dive_discipline, $weight_carried, $dive_type, $notes, $overall_score, $date);

// Execute the prepared statement
if (mysqli_stmt_execute($stmt)) {
    // Insert successful, show pop-up message
    echo "<script>alert('Dive inserted successfully.');</script>";
    // Redirect to index page
    echo "<script>window.location.href = 'index.php';</script>";
    exit;
} else {
    // Error handling
    echo "Error: " . mysqli_error($conn);
}


// Close statement and connection
mysqli_stmt_close($stmt);
mysqli_close($conn);
}

function generateDiveNumber($conn, $session_id) {
    // Initialize the next dive number
    $next_dive_number = 0;
    
    // SQL to get the total number of dives for the current session
    $sql = "SELECT COUNT(*) AS num_dives FROM Dives WHERE session_id = ?";
    
    // Prepare the SQL statement
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        echo "Error: " . mysqli_error($conn);
        exit;
    }
    
    // Bind parameters and execute the statement
    mysqli_stmt_bind_param($stmt, "i", $session_id);
    if (!mysqli_stmt_execute($stmt)) {
        echo "Error: " . mysqli_stmt_error($stmt);
        exit;
    }

    // Bind the result and fetch the number of dives
    mysqli_stmt_bind_result($stmt, $num_dives);
    if (mysqli_stmt_fetch($stmt)) {
        // Increment the number of dives to get the next dive number
        $next_dive_number = $num_dives + 1;
    } else {
        echo "Error: Failed to fetch dive count.";
        exit;
    }

    // Close the statement
    mysqli_stmt_close($stmt);

    return $next_dive_number;
}

?>


