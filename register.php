<?php
// Include the database connection file
require_once 'includes/db.php';

// Initialize the session
session_start();

// Check if the user is already logged in, if yes, redirect to index.php
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: index.php");
    exit;
}

// Define variables and initialize with empty values
$username = $password = $confirm_password = $email = "";
$username_err = $password_err = $confirm_password_err = $email_err = $register_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate username
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter a username.";
    } else {
        $username = trim($_POST["username"]);
    }

    // Validate password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $password_err = "Password must have at least 6 characters.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate confirm password
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Please confirm password.";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "Password did not match.";
        }
    }

    // Validate email
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter your email.";
    } elseif (!filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL)) {
        $email_err = "Please enter a valid email address.";
    } else {
        $email = trim($_POST["email"]);
    }

    // Check input errors before inserting into database
    if (empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($email_err)) {

// Prepare an insert statement
$sql = "INSERT INTO users (username, password, email) VALUES (?, ?, ?)";

if ($stmt = $conn->prepare($sql)) {
    // Bind variables to the prepared statement as parameters
    $stmt->bind_param("sss", $param_username, $param_password, $param_email);

    // Set parameters
    $param_username = $username;
    $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
    $param_email = $email;

    // Attempt to execute the prepared statement
    if ($stmt->execute()) {
        // Redirect to login page after successful registration
        header("location: login.php");
        exit();
    } else {
        $register_err = "Error: " . $conn->error; // Display MySQL error message
    }

    // Close statement
    $stmt->close();
} else {
    $register_err = "Error preparing SQL statement: " . $conn->error; // Display MySQL error message
}


    }

    // Close connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - My Freediving Training Log</title>
    <!-- Include Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">

    <div class="flex h-screen">
        <!-- Image Container (Full Height) -->
        <div class="hidden md:block md:w-1/2 bg-cover bg-center h-full" style="background-image: url('./images/m3.png');">
        </div>

        <!-- Form Container -->
        <div class="w-full md:w-1/2 flex items-center justify-center p-6">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="max-w-md mx-auto bg-white p-8 rounded-lg shadow-md">
                <h2 class="text-2xl font-semibold mb-6">Register</h2>

                <?php
                if (!empty($register_err)) {
                    echo '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                        <strong>Error:</strong> ' . $register_err . '
                    </div>';
                }
                ?>

                <div class="mb-4">
                    <label for="username" class="block text-gray-700 text-sm font-bold mb-2">Username</label>
                    <input type="text" id="username" name="username" class="border border-gray-400 rounded w-full py-2 px-3 focus:outline-none focus:border-blue-500" value="<?php echo htmlspecialchars($username); ?>">
                    <span class="text-sm text-red-500"><?php echo $username_err; ?></span>
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                    <input type="password" id="password" name="password" class="border border-gray-400 rounded w-full py-2 px-3 focus:outline-none focus:border-blue-500">
                    <span class="text-sm text-red-500"><?php echo $password_err; ?></span>
                </div>
                <div class="mb-4">
                    <label for="confirm_password" class="block text-gray-700 text-sm font-bold mb-2">Confirm Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" class="border border-gray-400 rounded w-full py-2 px-3 focus:outline-none focus:border-blue-500">
                    <span class="text-sm text-red-500"><?php echo $confirm_password_err; ?></span>
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                    <input type="email" id="email" name="email" class="border border-gray-400 rounded w-full py-2 px-3 focus:outline-none focus:border-blue-500" value="<?php echo htmlspecialchars($email); ?>">
                    <span class="text-sm text-red-500"><?php echo $email_err; ?></span>
                </div>
                <div class="mb-6">
                    <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">Register</button>
                </div>
                <p>Already have an account? <a href="login.php" class="text-blue-500 hover:text-blue-700">Login here</a>.</p>
            </form>
        </div>
    </div>

</body>

</html>
