<?php
include_once 'includes/db.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if session is started
session_start();

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize input fields
    $dive_depth = isset($_POST['dive_depth']) ? trim($_POST['dive_depth']) : '';
    $dive_time = isset($_POST['dive_time']) ? trim($_POST['dive_time']) : '';
    $dive_discipline = isset($_POST['dive_discipline']) ? trim($_POST['dive_discipline']) : '';
    $dive_type = isset($_POST['dive_type']) ? trim($_POST['dive_type']) : '';
    $weight_carried = isset($_POST['weight_carried']) ? trim($_POST['weight_carried']) : '';
    $notes = isset($_POST['notes']) ? trim($_POST['notes']) : '';
    $overall_score = isset($_POST['overall_score']) ? trim($_POST['overall_score']) : '';

    // Truncate 'dive_discipline' if it exceeds the maximum length allowed by the column
    $max_length_dive_discipline = 255; // Adjust this value based on your database schema
    $dive_discipline = mb_substr($dive_discipline, 0, $max_length_dive_discipline, 'UTF-8'); // Added 'UTF-8'

    // Get the current date and time
    $date = date("Y-m-d H:i:s");

    // SQL to insert a new dive record
    $sql = "INSERT INTO Dives (dive_depth, dive_time, dive_discipline, dive_type, weight_carried, notes, overall_score, date) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    // Prepare the SQL statement
    $stmt = mysqli_prepare($conn, $sql);

    // Check if the statement was prepared successfully
    if (!$stmt) {
        // Handle the error
        echo "Error: " . mysqli_error($conn);
        exit;
    }

    // Bind parameters
    mysqli_stmt_bind_param($stmt, "ssssssss", $dive_depth, $dive_time, $dive_discipline, $dive_type, $weight_carried, $notes, $overall_score, $date);

    // Execute the prepared statement
    if (mysqli_stmt_execute($stmt)) {
        // Insert successful, show pop-up message
        echo "<script>alert('Dive inserted successfully.');</script>";
        // Redirect to create_dive page
        echo "<script>window.location.href = 'create_dive.php';</script>";
        exit;
    } else {
        // Error handling
        echo "Error: " . mysqli_error($conn);
    }

    // Close statement and connection
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>




