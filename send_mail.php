<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Load PHPMailer
include 'db.php'; // Include database connection

function sendBookingEmails($user_id, $booking_id, $cab_id) {
    global $conn; // Use the global database connection

    // Fetch booking details
    $query = "SELECT b.*, u.first_name, u.last_name, u.email, u.phone, 
                c.model, c.fuel_type, c.capacity, c.type
              FROM bookings b 
              JOIN users u ON b.user_id = u.user_id
              JOIN cabs c ON b.cab_id = c.cab_id
              WHERE b.booking_id = ? AND b.user_id = ? AND b.cab_id = ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("iii", $booking_id, $user_id, $cab_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        return "No booking found.";
    }

    $booking = $result->fetch_assoc();
    $user_name = $booking['first_name'] . " " . $booking['last_name'];
    $user_email = $booking['email'];
    $user_phone = $booking['phone'];
    $pickup = $booking['pickup_point'];
    $dropoff = $booking['dropoff_point'];
    $date = $booking['pickup_date'];
    $time = $booking['pickup_time'];
    $fare = $booking['total_fare'];
    $cab_model = $booking['model'];
    $fuel_type = $booking['fuel_type'];
    $capacity = $booking['capacity'];
    $type = $booking['type'];

    // Initialize PHPMailer
    $mail = new PHPMailer(true);
    
    try {
        // SMTP Configuration
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = ''; // Your email
        $mail->Password = ''; // App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // 🟢 1st Email: Send Booking Confirmation to the User
        $mail->setFrom('', 'Cab Service');
        $mail->addAddress("", $user_name);
        $mail->addReplyTo('', 'Support');
        $mail->isHTML(true);
        $mail->Subject = "Your Booking Details - ID #$booking_id";
        $mail->Body = "
            <div style='font-family:Arial, sans-serif; padding:20px; background:#f8f9fa; border-radius:10px; text-align:center;'>
                <h2 style='color:#28a745;'>🚖 Booking Confirmed!</h2>
                <p>Dear <strong>$user_name</strong>,</p>
                <p>Your cab booking has been confirmed. Here are the details:</p>
                <table style='margin: 20px auto; border-collapse: collapse; width: 80%;'>
                    <tr><td style='padding:10px; border:1px solid #ddd;'><strong>Booking ID:</strong></td><td style='padding:10px; border:1px solid #ddd;'>$booking_id</td></tr>
                    <tr><td style='padding:10px; border:1px solid #ddd;'><strong>Pickup:</strong></td><td style='padding:10px; border:1px solid #ddd;'>$pickup</td></tr>
                    <tr><td style='padding:10px; border:1px solid #ddd;'><strong>Drop-off:</strong></td><td style='padding:10px; border:1px solid #ddd;'>$dropoff</td></tr>
                    <tr><td style='padding:10px; border:1px solid #ddd;'><strong>Date & Time:</strong></td><td style='padding:10px; border:1px solid #ddd;'>$date at $time</td></tr>
                    <tr><td style='padding:10px; border:1px solid #ddd;'><strong>Cab Model:</strong></td><td style='padding:10px; border:1px solid #ddd;'>$cab_model</td></tr>
                    <tr><td style='padding:10px; border:1px solid #ddd;'><strong>Cab Fuel:</strong></td><td style='padding:10px; border:1px solid #ddd;'>$fuel_type</td></tr>
                    <tr><td style='padding:10px; border:1px solid #ddd;'><strong>Capacity:</strong></td><td style='padding:10px; border:1px solid #ddd;'>$capacity</td></tr>
                    <tr><td style='padding:10px; border:1px solid #ddd;'><strong>Cab Type:</strong></td><td style='padding:10px; border:1px solid #ddd;'>$type</td></tr>
                    <tr><td style='padding:10px; border:1px solid #ddd;'><strong>Fare:</strong></td><td style='padding:10px; border:1px solid #ddd;'>₹$fare</td></tr>
                </table>
                <p><strong>Safar Cabs</strong> will contact you soon on your mobile number.</p>
                <p>Best Regards,<br><strong>Cab Service Team</strong></p>
            </div>
        ";
        $mail->send();

        // 🟠 2nd Email: Notify Cab Service Provider
        $mail->clearAddresses();
        $mail->addAddress("", "Cab Service Provider"); // Replace with actual cab provider email
        $mail->Subject = "New Booking Received - ID #$booking_id";
        $mail->Body = "
            <div style='font-family:Arial, sans-serif; padding:20px; background:#fff; border:1px solid #ddd; padding:20px;'>
                <h2 style='color:#d9534f;'>🚖 New Booking Alert!</h2>
                <p>A new cab booking has been received. Details:</p>
                <table style='margin: 20px auto; border-collapse: collapse; width: 80%;'>
                    <tr><td style='padding:10px; border:1px solid #ddd;'><strong>Booking ID:</strong></td><td style='padding:10px; border:1px solid #ddd;'>$booking_id</td></tr>
                    <tr><td style='padding:10px; border:1px solid #ddd;'><strong>User Name:</strong></td><td style='padding:10px; border:1px solid #ddd;'>$user_name</td></tr>
                    <tr><td style='padding:10px; border:1px solid #ddd;'><strong>User Phone:</strong></td><td style='padding:10px; border:1px solid #ddd;'>$user_phone</td></tr>
                    <tr><td style='padding:10px; border:1px solid #ddd;'><strong>Pickup:</strong></td><td style='padding:10px; border:1px solid #ddd;'>$pickup</td></tr>
                    <tr><td style='padding:10px; border:1px solid #ddd;'><strong>Drop-off:</strong></td><td style='padding:10px; border:1px solid #ddd;'>$dropoff</td></tr>
                    <tr><td style='padding:10px; border:1px solid #ddd;'><strong>Fare:</strong></td><td style='padding:10px; border:1px solid #ddd;'>₹$fare</td></tr>
                    <tr><td style='padding:10px; border:1px solid #ddd;'><strong>Cab Model:</strong></td><td style='padding:10px; border:1px solid #ddd;'>$cab_model</td></tr>
                    <tr><td style='padding:10px; border:1px solid #ddd;'><strong>Cab Fuel:</strong></td><td style='padding:10px; border:1px solid #ddd;'>$fuel_type</td></tr>
                    <tr><td style='padding:10px; border:1px solid #ddd;'><strong>Capacity:</strong></td><td style='padding:10px; border:1px solid #ddd;'>$capacity</td></tr>
                    <tr><td style='padding:10px; border:1px solid #ddd;'><strong>Cab Type:</strong></td><td style='padding:10px; border:1px solid #ddd;'>$type</td></tr>
                </table>
                <p>Please assign a driver and confirm with the customer.</p>
            </div>
        ";
        $mail->send();

        return "Emails sent successfully!";
    } catch (Exception $e) {
        return "Email could not be sent. Error: {$mail->ErrorInfo}";
    }
}
?>
