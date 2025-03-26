<?php
$host = "localhost"; // Change if needed
$user = "root"; // Default XAMPP/WAMP user
$pass = "root"; // Default password is empty
$dbname = "taxi_booking";

// Connect to database
$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}
?>
