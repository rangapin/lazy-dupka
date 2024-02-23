<?php
// Include the database connection file
include_once 'includes/db.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);


// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data and sanitize
    $first_name = isset($_POST['first_name']) ? trim($_POST['first_name']) : '';
    $last_name = isset($_POST['last_name']) ? trim($_POST['last_name']) : '';
    $age = isset($_POST['age']) ? intval($_POST['age']) : 0;
    $gender = isset($_POST['gender']) ? trim($_POST['gender']) : '';
    $weight = isset($_POST['weight']) ? floatval($_POST['weight']) : 0;
    $height = isset($_POST['height']) ? floatval($_POST['height']) : 0;
    $freediving_experience_level = isset($_POST['freediving_experience_level']) ? trim($_POST['freediving_experience_level']) : '';
    $free_immersion_pb = isset($_POST['free_immersion_pb']) ? trim($_POST['free_immersion_pb']) : '';
    $constant_weight_bifins_pb = isset($_POST['constant_weight_bifins_pb']) ? trim($_POST['constant_weight_bifins_pb']) : '';
    $constant_weight_monofins_pb = isset($_POST['constant_weight_monofins_pb']) ? trim($_POST['constant_weight_monofins_pb']) : '';
    $no_fins_pb = isset($_POST['no_fins_pb']) ? trim($_POST['no_fins_pb']) : '';
    $variable_weight_pb = isset($_POST['variable_weight_pb']) ? trim($_POST['variable_weight_pb']) : '';
    $no_limit_pb = isset($_POST['no_limit_pb']) ? trim($_POST['no_limit_pb']) : '';
    $training_goals = isset($_POST['training_goals']) ? trim($_POST['training_goals']) : '';
    $previous_diving_history = isset($_POST['previous_diving_history']) ? trim($_POST['previous_diving_history']) : '';
    $social_media_links = isset($_POST['social_media_links']) ? trim($_POST['social_media_links']) : '';
    $data_sharing_preferences = isset($_POST['data_sharing_preferences']) ? trim($_POST['data_sharing_preferences']) : '';
    $two_factor_authentication = isset($_POST['two_factor_authentication']) ? intval($_POST['two_factor_authentication']) : 0;
    $metric_preference = isset($_POST['metric_preference']) ? trim($_POST['metric_preference']) : '';

    // Prepare SQL statement to update the user's profile
    $sql = "UPDATE Users SET first_name=?, last_name=?, age=?, gender=?, weight=?, height=?, freediving_experience_level=?, free_immersion_pb=?, constant_weight_bifins_pb=?, constant_weight_monofins_pb=?, no_fins_pb=?, variable_weight_pb=?, no_limit_pb=?, training_goals=?, previous_diving_history=?, social_media_links=?, data_sharing_preferences=?, two_factor_authentication=?, metric_preference=? WHERE user_id=?";

    // Prepare the SQL statement
    $stmt = mysqli_prepare($conn, $sql);

    // Check if the statement was prepared successfully
    if ($stmt) {
        // Bind parameters
        mysqli_stmt_bind_param($stmt, 'ssisddsssssssss...', $first_name, $last_name, $age, $gender, $weight, $height, $freediving_experience_level, $free_immersion_pb, $constant_weight_bifins_pb, $constant_weight_monofins_pb, $no_fins_pb, $variable_weight_pb, $no_limit_pb, $training_goals, $previous_diving_history, $social_media_links, $data_sharing_preferences, $two_factor_authentication, $metric_preference, $user_id);

    
        // Execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            // Profile updated successfully, redirect to profile page
            header("Location: profile.php");
            exit;
        } else {
            // Error updating profile
            echo "Error updating profile: " . mysqli_error($conn);
        }

        // Close statement
        mysqli_stmt_close($stmt);
    } else {
        // Error preparing statement
        echo "Error preparing statement: " . mysqli_error($conn);
    }

    // Close connection
    mysqli_close($conn);
} else {
    // Redirect to profile page if accessed directly without form submission
    header("Location: profile.php");
    exit;
}
?>
