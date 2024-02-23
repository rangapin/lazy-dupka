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
<!--                 <li><a href="profile.php" class="block py-2 px-4 hover:bg-gray-700">My Profile</a></li> -->
                <li><a href="create_dive.php" class="block py-2 px-4 hover:bg-gray-700">Add a Dive</a></li>
<!--                 <li><a href="view_sessions.php" class="block py-2 px-4 hover:bg-gray-700">View my sessions</a></li> -->
<!--                 <li><a href="#" class="block py-2 px-4 hover:bg-gray-700">Change Password</a></li>
 -->                <li><a href="logout.php" class="block py-2 px-4 hover:bg-gray-700">Logout</a></li>
            </ul>
        </div>
    </div>

    <!-- Main Content -->
    <div class="flex-1 p-8">
        <!-- Search Bar -->
<!--         <div class="mb-8">
            <input type="text" placeholder="Search by date, location, etc."
                class="w-full px-4 py-2 border rounded-md focus:outline-none focus:border-blue-500">
        </div> -->

        <!-- Dive Sessions Table -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-2xl font-bold mb-4">Dive List</h2>
            <table class="w-full">
                <thead>
                    <tr>
                        <th class="border py-2 px-4">Date</th>
                        <th class="border py-2 px-4">Depth</th>
                        <th class="border py-2 px-4">Duration</th>
                        <th class="border py-2 px-4">Discipline</th>
                        <th class="border py-2 px-4">Type</th>
                        <th class="border py-2 px-4">Weight</th>
                        <th class="border py-2 px-4">Notes</th>
                        <th class="border py-2 px-4">Overall Score</th>
                        <th class="border py-2 px-4">Edit</th>
                        <th class="border py-2 px-4">Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Include the database connection file
                    include_once 'includes/db.php';

                    // Query to fetch dive records from the database
                    $sql = "SELECT dive_id, date, dive_depth, dive_time, dive_discipline, dive_type, weight_carried, notes, overall_score FROM Dives";

                    // Execute the query
                    $result = mysqli_query($conn, $sql);

                    // Check if the query was successful
                    if ($result) {
                        // Loop through the result set and fetch each row as an associative array
                        while ($row = mysqli_fetch_assoc($result)) {
                            // Output the dive data in the table rows
                            echo "<tr>";
                            echo "<td class='border py-2 px-4'>" . $row['date'] . "</td>";
                            echo "<td class='border py-2 px-4'>" . $row['dive_depth'] . "</td>";
                            echo "<td class='border py-2 px-4'>" . $row['dive_time'] . "</td>";
                            echo "<td class='border py-2 px-4'>" . $row['dive_discipline'] . "</td>";
                            echo "<td class='border py-2 px-4'>" . $row['dive_type'] . "</td>";
                            echo "<td class='border py-2 px-4'>" . $row['weight_carried'] . "</td>";
                            echo "<td class='border py-2 px-4'>" . $row['notes'] . "</td>";
                            echo "<td class='border py-2 px-4'>" . $row['overall_score'] . "</td>";
                            echo "<td class='border px-4 py-2'><a href='edit_dive.php?id=" . $row['dive_id'] . "' class='bg-yellow-500 hover:bg-yellow-200 text-white px-3 py-1 rounded'>Edit</a></td>";
                            echo "<td class='border px-4 py-2'><a href='delete_dive.php?id=" . $row['dive_id'] . "' class='bg-red-500 hover:bg-red-200 text-white px-3 py-1 rounded'>Delete</a></td>";
                            echo "</tr>";
                        }
                    } else {
                        // If the query fails, display an error message
                        echo "Error: " . mysqli_error($conn);
                    }

                    // Close the database connection
                    mysqli_close($conn);
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
