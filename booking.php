<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $pickup = $_POST['pickup'];
    $dropoff = $_POST['dropoff'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $message = $_POST['message'];

    $sql = "INSERT INTO bookings (name, phone, email, pickup, dropoff, date, time, message)
            VALUES ('$name', '$phone', '$email', '$pickup', '$dropoff', '$date', '$time', '$message')";

    if ($conn->query($sql) === TRUE) {
        sendBookingEmail($name, $email, $pickup, $dropoff, $date, $time);
        header("Location: thanks.php");
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
}
?>
