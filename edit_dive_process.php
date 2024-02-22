<?php
// Include the database connection file
include_once 'includes/db.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all required fields are filled
    if (isset($_POST['dive_id']) && isset($_POST['dive_depth']) && isset($_POST['dive_time']) && isset($_POST['dive_discipline']) && isset($_POST['dive_type']) && isset($_POST['weight_carried']) && isset($_POST['notes']) && isset($_POST['overall_score'])) {
        
        // Sanitize input data to prevent SQL injection
        $dive_id = mysqli_real_escape_string($conn, $_POST['dive_id']);
        $dive_depth = mysqli_real_escape_string($conn, $_POST['dive_depth']);
        $dive_time = mysqli_real_escape_string($conn, $_POST['dive_time']);
        $dive_discipline = mysqli_real_escape_string($conn, $_POST['dive_discipline']);
        $dive_type = mysqli_real_escape_string($conn, $_POST['dive_type']);
        $weight_carried = mysqli_real_escape_string($conn, $_POST['weight_carried']);
        $notes = mysqli_real_escape_string($conn, $_POST['notes']);
        $overall_score = mysqli_real_escape_string($conn, $_POST['overall_score']);
        
        // SQL query to update the dive record
        $sql = "UPDATE Dives SET dive_depth = '$dive_depth', dive_time = '$dive_time', dive_discipline = '$dive_discipline', dive_type = '$dive_type', weight_carried = '$weight_carried', notes = '$notes', overall_score = '$overall_score' WHERE dive_id = '$dive_id'";

        // Execute the update query
        if (mysqli_query($conn, $sql)) {
            // Redirect back to the dashboard page after successful update
            header("Location: index.php");
            exit();
        } else {
            // If update fails, display an error message
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        // If required fields are not filled, display an error message
        echo "Error: All fields are required.";
    }
} else {
    // If form is not submitted via POST method, redirect to the homepage
    header("Location: index.php");
    exit();
}

// Close the database connection
mysqli_close($conn);
?>
