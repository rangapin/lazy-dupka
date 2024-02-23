<?php
// Include the database connection file
include_once 'includes/db.php';

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
        // Insert successful, create a session if it doesn't exist
        $session_date = date("Y-m-d", strtotime($date));
        $sql_session_check = "SELECT * FROM Sessions WHERE session_date = ?";
        $stmt_session_check = mysqli_prepare($conn, $sql_session_check);
        mysqli_stmt_bind_param($stmt_session_check, "s", $session_date);
        mysqli_stmt_execute($stmt_session_check);
        $result_session_check = mysqli_stmt_get_result($stmt_session_check);
        if (mysqli_num_rows($result_session_check) == 0) {
            // No session exists for this date, create a new session
            $sql_create_session = "INSERT INTO Sessions (session_date) VALUES (?)";
            $stmt_create_session = mysqli_prepare($conn, $sql_create_session);
            mysqli_stmt_bind_param($stmt_create_session, "s", $session_date);
            mysqli_stmt_execute($stmt_create_session);
            if (mysqli_stmt_affected_rows($stmt_create_session) > 0) {
                echo "<script>alert('Session created successfully.');</script>";
            } else {
                echo "<script>alert('Failed to create session.');</script>";
            }
            mysqli_stmt_close($stmt_create_session);
        }
        mysqli_stmt_close($stmt_session_check);

        // Show pop-up message for successful dive insertion
        echo "<script>alert('Dive inserted successfully.');</script>";
        // Redirect to create_dive page
        echo "<script>window.location.href = 'create_dive.php';</script>";
        exit;
    } else {
        // Error handling for dive insertion
        echo "Error: " . mysqli_error($conn);
    }

    // Close statement and connection
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>




