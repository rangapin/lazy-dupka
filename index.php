<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lazy Dupka</title>
    <!-- Include Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Include Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="flex bg-gray-100">
    <!-- Sidebar Navigation -->
    <div class="w-1/6 bg-gray-800 text-gray-100 h-screen">
        <div class="p-4">
            <h2 class="text-lg font-semibold mb-4">Lazy Dupka</h2>
            <ul>
                <li><a href="index.php" class="block py-2 px-4 hover:bg-gray-700">Dashboard</a></li>
                <li><a href="profile.php" class="block py-2 px-4 hover:bg-gray-700">My profile</a></li>
                <li><a href="#" class="block py-2 px-4 hover:bg-gray-700">Change Password</a></li>
                <li><a href="logout.php" class="block py-2 px-4 hover:bg-gray-700">Logout</a></li>
            </ul>
        </div>
    </div>

    <!-- Main Content -->
    <div class="flex-1 p-8">
        <!-- Search Bar -->
        <div class="mb-8">
            <input type="text" placeholder="Search by date, location, etc." class="w-full px-4 py-2 border rounded-md focus:outline-none focus:border-blue-500">
        </div>

        <!-- Two Columns Layout -->
        <div class="flex">
            <!-- Statistics Column -->
            <div class="w-1/2 pr-4">
                <!-- General Statistics -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                    <h2 class="text-2xl font-bold mb-4">General Statistics</h2>
                    <p>Total Dive Sessions: <span id="totalSessions">...</span></p>
                    <p>Average Dive Duration: <span id="avgDuration">...</span></p>
                    <p>Maximum Dive Depth: <span id="maxDepth">...</span></p>
                    <!-- Add more statistics as needed -->
                </div>
            </div>

            <!-- Visual Representations Column -->
            <div class="w-1/2 pl-4">
                <!-- Visual Representations -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                    <h2 class="text-2xl font-bold mb-4">Visual Representations</h2>
                    <!-- Placeholder Chart -->
                    <canvas id="diveChart" style="height: 300px;"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for Placeholder Chart -->
    <script>
        // Generate random data for the placeholder chart
        var labels = ['Session 1', 'Session 2', 'Session 3', 'Session 4', 'Session 5'];
        var data = [];
        for (var i = 0; i < labels.length; i++) {
            data.push(Math.floor(Math.random() * 100)); // Random value between 0 and 100
        }

        // Create the placeholder chart
        var ctx = document.getElementById('diveChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Dive Duration',
                    data: data,
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>

</html>
