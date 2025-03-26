<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/Exception.php';
require 'PHPMailer/SMTP.php';

function sendBookingEmail($name, $email, $pickup, $dropoff, $date, $time) {
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; 
        $mail->SMTPAuth = true;
        $mail->Username = 'your-email@gmail.com'; // Change this
        $mail->Password = 'your-password'; // Change this
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('your-email@gmail.com', 'Taxi Service');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Taxi Booking Confirmation';
        $mail->Body = "<h3>Your Taxi Booking Details</h3>
                       <p>Name: $name</p>
                       <p>Pickup: $pickup</p>
                       <p>Drop-off: $dropoff</p>
                       <p>Date: $date</p>
                       <p>Time: $time</p>";

        $mail->send();
    } catch (Exception $e) {
        error_log("Email not sent: " . $mail->ErrorInfo);
    }
}
?>
