<?php

// Database credentials
$host = "localhost"; // Change this to your database host if necessary
$username = "root"; // Change this to your database username
$password = ""; // Change this to your database password
$database = "lazy-dupka"; // Change this to your database name

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set charset to UTF-8
$conn->set_charset("utf8");

?>
