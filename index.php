<?php
// Include the database connection file
include_once 'includes/db.php';

// Include any other necessary files or functions here

// Start a session (for user authentication)
session_start();

// Check if the user is logged in, if not redirect to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

// Include header or navigation section here

// Display the main content of the index page
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LAZY DUPKA</title>
    <!-- Include Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="flex h-screen bg-gray-100">
    <!-- Sidebar -->
    <div class="w-1/6 bg-gray-800 text-gray-100">
        <div class="p-4">
            <h2 class="text-lg font-semibold mb-4">Navigation</h2>
            <ul>
                <li><a href="#" class="block py-2 px-4 hover:bg-gray-700">Dashboard</a></li>
                <li><a href="profile.php" class="block py-2 px-4 hover:bg-gray-700">Profile</a></li>
                <li><a href="#" class="block py-2 px-4 hover:bg-gray-700">Settings</a></li>
                <li><a href="#" class="block py-2 px-4 hover:bg-gray-700">Logout</a></li>
            </ul>
        </div>
    </div>
    <!-- Main Content -->
    <div class="w-5/6 p-8">
        <h1 class="text-2xl font-bold mb-4">Welcome to the Index Page</h1>
        <p>This is the main content area. You can add your content here.</p>
    </div>
</body>
</html>

