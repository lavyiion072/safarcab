<?php
$host = 'localhost';
$user = 'root';
$pass = 'root';
$dbname = 'taxi_booking';

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}
?>
