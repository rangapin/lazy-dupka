<?php
// Include the database connection file
include_once 'includes/db.php';

// Initialize an empty array to store sessions
$sessions = [];

// Query to fetch dive records from the database
$sql = "SELECT session_date, deepest_dive, longest_dive, amount_of_dives, location, water_type, water_temperature, wetsuit_thickness, dive_buddy, notes, overall_score FROM Sessions";

// Execute the query
$result = mysqli_query($conn, $sql);

// Check if the query was successful
if ($result) {
    // Loop through the result set and organize dives into sessions
    while ($row = mysqli_fetch_assoc($result)) {
        // Extract session date from the session record
        $session_date = date("Y-m-d", strtotime($row['session_date']));
        
        // Check if the session exists, if not, create it
        if (!isset($sessions[$session_date])) {
            $sessions[$session_date] = [];
        }
        
        // Add the session to the corresponding date
        $sessions[$session_date][] = $row;
    }
} else {
    // If the query fails, display an error message
    echo "Error: " . mysqli_error($conn);
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lazy Dupka - Dashboard</title>
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
                <li><a href="view_sessions.php" class="block py-2 px-4 hover:bg-gray-700">View my sessions</a></li>
                <li><a href="#" class="block py-2 px-4 hover:bg-gray-700">Change Password</a></li>
                <li><a href="logout.php" class="block py-2 px-4 hover:bg-gray-700">Logout</a></li>
            </ul>
        </div>
    </div>

    <!-- Main Content -->
    <div class="flex-1 p-8">
        <!-- Display Sessions -->
        <?php foreach ($sessions as $session_date => $session_data) : ?>
            <div>
                <h2><?php echo $session_date; ?></h2>
                <table>
                    <thead>
                        <tr>
                            <th class="border py-2 px-4">Deepest Dive</th>
                            <th class="border py-2 px-4">Longest Dive</th>
                            <th class="border py-2 px-4">Amount of Dives</th>
                            <th class="border py-2 px-4">Location</th>
                            <th class="border py-2 px-4">Water Type</th>
                            <th class="border py-2 px-4">Water Temperature</th>
                            <th class="border py-2 px-4">Wetsuit Thickness</th>
                            <th class="border py-2 px-4">Dive Buddy</th>
                            <th class="border py-2 px-4">Notes</th>
                            <th class="border py-2 px-4">Overall Score</th>
                            <!-- Add a column for delete button -->
                        </tr>
                    </thead>    
                    <tbody>
                        <?php foreach ($session_data as $session) : ?>
                            <tr>
                                <td class='border py-2 px-4'><?php echo $session['deepest_dive']; ?></td>
                                <td class='border py-2 px-4'><?php echo $session['longest_dive']; ?></td>
                                <td class='border py-2 px-4'><?php echo $session['amount_of_dives']; ?></td>
                                <td class='border py-2 px-4'><?php echo $session['location']; ?></td>
                                <td class='border py-2 px-4'><?php echo $session['water_type']; ?></td>
                                <td class='border py-2 px-4'><?php echo $session['water_temperature']; ?></td>
                                <td class='border py-2 px-4'><?php echo $session['wetsuit_thickness']; ?></td>
                                <td class='border py-2 px-4'><?php echo $session['dive_buddy']; ?></td>
                                <td class='border py-2 px-4'><?php echo $session['notes']; ?></td>
                                <td class='border py-2 px-4'><?php echo $session['overall_score']; ?></td>
                                <!-- Add a button to delete the dive -->
                                <td class='border px-4 py-2'>
                                    <form action="delete_dive.php" method="POST">
                                        <input type="hidden" name="dive_id" value="<?php echo $session['dive_id']; ?>">
                                        <button type="submit" class='bg-red-500 hover:bg-red-200 text-white px-3 py-1 rounded' onclick="return confirm('Are you sure you want to delete this dive?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endforeach; ?>
    </div>
</body>

</html>
