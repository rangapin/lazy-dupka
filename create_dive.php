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

<body class="flex bg-gray-100">
    <!-- Sidebar Navigation -->
    <div class="w-1/6 bg-gray-800 text-gray-100 h-screen">
        <div class="p-4">
            <h2 class="text-lg font-semibold mb-4">LAZY DUPKA</h2>
            <ul>
                <li><a href="index.php" class="block py-2 px-4 hover:bg-gray-700">Dashboard</a></li>
                <li><a href="#" class="block py-2 px-4 hover:bg-gray-700">My dives</a></li>
                <li><a href="#" class="block py-2 px-4 hover:bg-gray-700">My sessions</a></li>
                <li><a href="profile.php" class="block py-2 px-4 hover:bg-gray-700">My profile</a></li>
                <li><a href="logout.php" class="block py-2 px-4 hover:bg-gray-700">Logout</a></li>
            </ul>
        </div>
    </div>

    <!-- Main Content -->
    <div class="flex-1 p-8">
        <!-- Create Dive Form Card -->
        <div class="bg-white rounded-lg shadow-md p-6 my-8">
            <h2 class="text-2xl font-bold mb-4">Create Dive</h2>
            <form action="create_dive.php" method="POST">
                <!-- Input fields for creating a dive -->
                <!-- Note: Replace input fields with the actual fields from your database -->
                <div class="grid grid-cols-1 gap-4">
                    <!-- Depth (m) -->
                    <div>
                        <label for="dive_depth" class="block text-sm font-semibold text-gray-700 mb-1">Depth:</label>
                        <input type="text" id="dive_depth" name="dive_depth" required
                            class="w-full px-3 py-2 border rounded-md focus:outline-none focus:border-blue-500">
                    </div>
                    <!-- Dive time -->
                    <div>
                        <label for="dive_time" class="block text-sm font-semibold text-gray-700 mb-1">Dive Time:</label>
                        <input type="text" id="dive_time" name="dive_time" required
                            class="w-full px-3 py-2 border rounded-md focus:outline-none focus:border-blue-500">
                    </div>
                    <!-- Discipline -->
                    <div>
                        <label for="discipline" class="block text-sm font-semibold text-gray-700 mb-1">Discipline:</label>
                        <select id="discipline" name="discipline"
                            class="w-full border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:border-blue-500">
                            <option value="Free Immersion (FIM)">Free Immersion (FIM)</option>
                            <option value="Constant Weight Bi Fins (CWTBF)">Constant Weight Bi Fins (CWTBF)</option>
                            <option value="Constant Weight (CWT)">Constant Weight (CWT)</option>
                            <option value="No Fins (CWTNF)">No Fins (CWTNF)</option>
                            <option value="Variable Weight (VW)">Variable Weight (VW)</option>
                            <option value="No Limit (NL)">No Limit (NL)</option>
                        </select>
                    </div>
                    <!-- Dive Type -->
                    <div class="mb-4">
                        <label for="dive_type" class="block text-gray-700 text-sm font-bold mb-2">Dive Type:</label>
                        <select id="dive_type" name="dive_type"
                            class="w-full border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:border-blue-500">
                            <option value="warm up">Warm Up</option>
                            <option value="fun dive">Fun Dive</option>
                            <option value="training">Training</option>
                            <option value="competition">Competition</option>
                        </select>
                    </div>
                    <!-- Weight Carried (kg) -->
                    <div>
                        <label for="weight_carried" class="block text-sm font-semibold text-gray-700 mb-1">Weight
                            Carried:</label>
                        <input type="text" id="weight_carried" name="weight_carried"
                            class="w-full px-3 py-2 border rounded-md focus:outline-none focus:border-blue-500">
                    </div>
                    <!-- Notes -->
                    <div>
                        <label for="notes" class="block text-sm font-semibold text-gray-700 mb-1">Notes:</label>
                        <textarea id="notes" name="notes"
                            class="w-full px-3 py-2 border rounded-md focus:outline-none focus:border-blue-500"></textarea>
                    </div>
                    <!-- Overall Score -->
                    <div class="mb-4">
                        <label for="overall_score" class="block text-gray-700 text-sm font-bold mb-2">Overall
                            Score:</label>
                        <select id="overall_score" name="overall_score"
                            class="w-full border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:border-blue-500">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                    </div>

                </div>
                <div class="mt-6 flex justify-center">
                    <button type="submit"
                        class="w-1/3 bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600 focus:outline-none focus:bg-blue-600">Create
                        Dive</button>
                </div>

            </form>
        </div>
    </div>
</body>

</html>

