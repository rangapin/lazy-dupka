<?php
// Include the database connection file
include_once 'includes/db.php';

// Check if the dive ID is provided in the URL
if (isset($_GET['id'])) {
    // Sanitize the dive ID to prevent SQL injection
    $dive_id = mysqli_real_escape_string($conn, $_GET['id']);

    // SQL query to delete the dive record
    $sql = "DELETE FROM Dives WHERE dive_id = '$dive_id'";

    // Execute the delete query
    if (mysqli_query($conn, $sql)) {
        // Display confirmation popup and redirect back to the dashboard page after successful deletion
        echo "<script>alert('Dive record deleted successfully.'); window.location.href = 'index.php';</script>";
        exit();
    } else {
        // If deletion fails, display an error message
        echo "Error: " . mysqli_error($conn);
    }
} else {
    // If the dive ID is not provided in the URL, display an error message
    echo "Error: Dive ID not provided.";
}

// Close the database connection
mysqli_close($conn);
?>
