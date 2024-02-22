<?php
// Include the database connection file
include_once 'includes/db.php';

// Check if the dive ID is provided in the URL
if (isset($_GET['id'])) {
    // Sanitize the dive ID to prevent SQL injection
    $dive_id = mysqli_real_escape_string($conn, $_GET['id']);

    // SQL query to fetch the dive record based on the provided dive ID
    $sql = "SELECT * FROM Dives WHERE dive_id = '$dive_id'";

    // Execute the select query
    $result = mysqli_query($conn, $sql);

    // Check if the query was successful and if a dive record with the provided ID exists
    if ($result && mysqli_num_rows($result) > 0) {
        // Fetch the dive record as an associative array
        $dive = mysqli_fetch_assoc($result);
    } else {
        // If no dive record found with the provided ID, display an error message
        echo "Error: Dive record not found.";
        exit();
    }
} else {
    // If the dive ID is not provided in the URL, display an error message
    echo "Error: Dive ID not provided.";
    exit();
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Dive - Lazy Dupka</title>
    <!-- Include Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="flex bg-gray-100">
    <!-- Sidebar Navigation -->
    <div class="w-1/6 bg-gray-800 text-gray-100 h-screen">
        <div class="p-4">
            <h2 class="text-lg font-semibold mb-4">Lazy Dupka</h2>
            <ul>
                <li><a href="index.php" class="block py-2 px-4 hover:bg-gray-700">Dashboard</a></li>
                <li><a href="profile.php" class="block py-2 px-4 hover:bg-gray-700">My Profile</a></li>
                <li><a href="create_dive.php" class="block py-2 px-4 hover:bg-gray-700">Add a Dive</a></li>
                <li><a href="#" class="block py-2 px-4 hover:bg-gray-700">Change Password</a></li>
                <li><a href="logout.php" class="block py-2 px-4 hover:bg-gray-700">Logout</a></li>
            </ul>
        </div>
    </div>

    <!-- Main Content -->
    <div class="flex-1 p-8">
        <!-- Edit Dive Form -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-2xl font-bold mb-4">Edit Dive</h2>
            <form action="edit_dive_process.php" method="POST">
                <!-- Hidden input field to pass the dive ID to the update_dive.php file -->
                <input type="hidden" name="dive_id" value="<?php echo $dive['dive_id']; ?>">
                <!-- Input fields for editing the dive record -->
                <!-- Note: Replace input fields with the actual fields from your database -->
                <div class="grid grid-cols-1 gap-4">
                    <!-- Depth (m) -->
                    <div>
                        <label for="dive_depth" class="block text-sm font-semibold text-gray-700 mb-1">Depth:</label>
                        <input type="text" id="dive_depth" name="dive_depth" value="<?php echo $dive['dive_depth']; ?>"
                            required
                            class="w-full px-3 py-2 border rounded-md focus:outline-none focus:border-blue-500">
                    </div>
                    <!-- Dive Time -->
                    <div>
                        <label for="dive_time" class="block text-sm font-semibold text-gray-700 mb-1">Dive Time:</label>
                        <input type="text" id="dive_time" name="dive_time" value="<?php echo $dive['dive_time']; ?>"
                            required
                            class="w-full px-3 py-2 border rounded-md focus:outline-none focus:border-blue-500">
                    </div>
                    <!-- Dive Discipline -->
                    <div class="mb-4">
                        <label for="dive_discipline" class="block text-sm font-semibold text-gray-700 mb-1">Dive
                            Discipline:</label>
                        <select id="dive_discipline" name="dive_discipline"
                            class="w-full border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:border-blue-500">
                            <option value="FIM">FIM</option>
                            <option value="CWTBF">CWTBF</option>
                            <option value="CWT">CWT</option>
                            <option value="CWTNF">CWTNF</option>
                            <option value="VW">VW</option>
                            <option value="NL">NL</option>
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
                    <!-- Weight Carried -->
                    <div>
                        <label for="weight_carried" class="block text-sm font-semibold text-gray-700 mb-1">Weight
                            Carried:</label>
                        <input type="text" id="weight_carried" name="weight_carried"
                            value="<?php echo $dive['weight_carried']; ?>"
                            class="w-full px-3 py-2 border rounded-md focus:outline-none focus:border-blue-500">
                    </div>
                    <!-- Notes -->
                    <div>
                        <label for="notes" class="block text-sm font-semibold text-gray-700 mb-1">Notes:</label>
                        <textarea id="notes" name="notes"
                            class="w-full px-3 py-2 border rounded-md focus:outline-none focus:border-blue-500"><?php echo $dive['notes']; ?></textarea>
                    </div>
                    <!-- Overall Score -->
                    <div>
                        <label for="overall_score" class="block text-sm font-semibold text-gray-700 mb-1">Overall
                            Score:</label>
                        <input type="text" id="overall_score" name="overall_score"
                            value="<?php echo $dive['overall_score']; ?>"
                            class="w-full px-3 py-2 border rounded-md focus:outline-none focus:border-blue-500">
                    </div>
                </div>
                <div class="mt-6 flex justify-center">
                    <button type="submit"
                        class="w-1/3 bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600 focus:outline-none focus:bg-blue-600">Edit
                        Dive</button>
                </div>
            </form>

        </div>
    </div>
</body>

</html>