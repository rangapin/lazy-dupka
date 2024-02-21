<?php
require_once 'includes/db.php';
session_start();

// Check if the user is logged in
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

// Initialize variables
$userData = [];

// Retrieve user data from the database
$sql = "SELECT * FROM Users WHERE username = ?";
if ($stmt = $conn->prepare($sql)) {
    // Bind parameters
    $stmt->bind_param("s", $_SESSION["username"]);
    
    // Execute the statement
    if ($stmt->execute()) {
        // Get result set
        $result = $stmt->get_result();
        
        // Check if user data exists
        if ($result->num_rows == 1) {
            $userData = $result->fetch_assoc();
        } else {
            echo "User not found. SQL Query: " . $sql;
        }
    } else {
        echo "Error executing SQL statement: " . $stmt->error;
    }
    // Close the statement
    $stmt->close();
} else {
    echo "Error preparing SQL statement: " . $conn->error;
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page with Sidebar Navigation</title>
    <!-- Include Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="flex bg-gray-100">
    <!-- Sidebar -->
    <div class="w-1/6 bg-gray-800 text-gray-100 sticky top-0 h-screen overflow-y-auto">
        <div class="p-4">
            <h2 class="text-lg font-semibold mb-4">LAZY DUPKA</h2>
            <ul>
                <li><a href="index.php" class="block py-2 px-4 hover:bg-gray-700">Dashboard</a></li>
                <li><a href="#" class="block py-2 px-4 hover:bg-gray-700">Edit Profile</a></li>
                <li><a href="#" class="block py-2 px-4 hover:bg-gray-700">Change Password</a></li>
                <li><a href="#" class="block py-2 px-4 hover:bg-gray-700">Logout</a></li>
            </ul>
        </div>
    </div>
    <!-- Main Content -->
    <div class="w-5/6 p-8">
        <h1 class="text-2xl font-bold mb-4">Profile Page</h1>
        <div class="max-w-5xl mx-auto bg-white p-8 rounded shadow-md">
        <form action="update_profile.php" method="post" class="flex flex-wrap gap-4">
                <!-- Existing fields -->
                <!-- Add Personal Best Fields -->
                <div class="w-full">
                    <label for="first_name" class="block text-sm font-semibold text-gray-700 mb-1">First Name:</label>
                    <input type="text" id="first_name" name="first_name" value="" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:border-blue-500">
                </div>
                <div class="w-full">
                    <label for="last_name" class="block text-sm font-semibold text-gray-700 mb-1">Last Name:</label>
                    <input type="text" id="last_name" name="last_name" value="" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:border-blue-500">
                </div>
                <div class="w-full">
                    <label for="age" class="block text-sm font-semibold text-gray-700 mb-1">Age:</label>
                    <input type="number" id="age" name="age" value="" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:border-blue-500">
                </div>
                <div class="w-full">
                    <label for="gender" class="block text-sm font-semibold text-gray-700 mb-1">Gender:</label>
                    <select id="gender" name="gender" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:border-blue-500">
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                <div class="w-full">
                    <label for="weight" class="block text-sm font-semibold text-gray-700 mb-1">Weight:</label>
                    <input type="number" id="weight" name="weight_kg" value="" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:border-blue-500">
                </div>
                <div class="w-full">
                    <label for="height" class="block text-sm font-semibold text-gray-700 mb-1">Height:</label>
                    <input type="number" id="height" name="height" value="" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:border-blue-500">
                </div>
                <div class="w-full">
                    <label for="experience_level" class="block text-sm font-semibold text-gray-700 mb-1">Experience Level:</label>
                    <select id="experience_level" name="experience_level" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:border-blue-500">
                        <option value="Aspiring Freedivers">Aspiring Freedivers</option>
                        <option value="Freediving Enthusiasts">Freediving Enthusiasts</option>
                        <option value="Freediving Instructors and Coaches">Freediving Instructors and Coaches</option>
                        <option value="Safety and Rescue Personnel">Safety and Rescue Personnel</option>
                        <option value="Competitive Freedivers">Competitive Freedivers</option>
                    </select>
                </div>
                <div class="w-full">
                    <label for="free_immersion_pb" class="block text-sm font-semibold text-gray-700 mb-1">Free Immersion PB:</label>
                    <input type="text" id="free_immersion_pb" name="free_immersion_pb" value="" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:border-blue-500">
                </div>
                <div class="w-full">
                    <label for="constant_weight_bifins_pb" class="block text-sm font-semibold text-gray-700 mb-1">Constant Weight Bifins PB:</label>
                    <input type="text" id="constant_weight_bifins_pb" name="constant_weight_bifins_pb" value="" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:border-blue-500">
                </div>
                <div class="w-full">
                    <label for="constant_weight_monofins_pb" class="block text-sm font-semibold text-gray-700 mb-1">Constant Weight Monofins PB:</label>
                    <input type="text" id="constant_weight_monofins_pb" name="constant_weight_monofins_pb" value="" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:border-blue-500">
                </div>
                <div class="w-full">
                    <label for="no_fins_pb" class="block text-sm font-semibold text-gray-700 mb-1">No Fins PB:</label>
                    <input type="text" id="no_fins_pb" name="no_fins_pb" value="" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:border-blue-500">
                </div>
                <div class="w-full">
                    <label for="variable_weight_pb" class="block text-sm font-semibold text-gray-700 mb-1">Variable Weight PB:</label>
                    <input type="text" id="variable_weight_pb" name="variable_weight_pb" value="" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:border-blue-500">
                </div>
                <div class="w-full">
                    <label for="no_limit_pb" class="block text-sm font-semibold text-gray-700 mb-1">No Limit PB:</label>
                    <input type="text" id="no_limit_pb" name="no_limit_pb" value="" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:border-blue-500">
                </div>
                <div class="w-full">
                    <label for="training_goals" class="block text-sm font-semibold text-gray-700 mb-1">Training Goals:</label>
                    <input type="text" id="training_goals" name="training_goals" value="" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:border-blue-500">
                </div>
                <div class="w-full">
                    <label for="diving_history" class="block text-sm font-semibold text-gray-700 mb-1">Diving History:</label>
                    <select id="diving_history" name="diving_history" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:border-blue-500">
                        <option value="not a regular diver">Not a Regular Diver</option>
                        <option value="less than a year">Less Than a Year</option>
                        <option value="more than a year">More Than a Year</option>
                        <option value="more than 5 years">More Than 5 Years</option>
                    </select>
                </div>
                <div class="w-full">
                    <label for="social_media_links" class="block text-sm font-semibold text-gray-700 mb-1">Social Media Links:</label>
                    <input type="text" id="social_media_links" name="social_media_links" value="" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:border-blue-500">
                </div>
                <div class="w-full">
                    <label for="data_sharing_preferences" class="block text-sm font-semibold text-gray-700 mb-1">Data Sharing Preferences:</label>
                    <textarea id="data_sharing_preferences" name="data_sharing_preferences" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:border-blue-500"></textarea>
                </div>
                <div class="w-full">
                    <label for="two_factor_authentication" class="block text-sm font-semibold text-gray-700 mb-1">Two-Factor Authentication:</label>
                    <select id="two_factor_authentication" name="two_factor_authentication" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:border-blue-500">
                        <option value="1">Enabled</option>
                        <option value="0">Disabled</option>
                    </select>
                </div>
                <div class="w-full">
                    <label for="metric_preference" class="block text-sm font-semibold text-gray-700 mb-1">Metric Preference:</label>
                    <select id="metric_preference" name="metric_preference" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:border-blue-500">
                        <option value="imperial">Imperial</option>
                        <option value="metric">Metric</option>
                    </select>
                </div>
                <div class="w-1/2 mx-auto mt-4">
                    <button type="submit" class="w-full bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600 focus:outline-none focus:bg-blue-600">Update Profile</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
