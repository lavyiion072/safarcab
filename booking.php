<?php
session_start();
include 'db.php';
include 'send_mail.php';

// Check if POST data exists
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: index.php");
    exit;
}

// Function to sanitize input
function validate_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// Sanitize input
$first_name = validate_input($_POST['first_name']);
$last_name = validate_input($_POST['last_name']);
$phone = validate_input($_POST['phone']);
$email = validate_input($_POST['email']);
$address = validate_input($_POST['address']);
$city = validate_input($_POST['city']);
$state = validate_input($_POST['state']);
$pincode = validate_input($_POST['pincode']);
$pickup = validate_input($_POST['pickup']);
$dropoff = validate_input($_POST['dropoff']);
$date = validate_input($_POST['date']);
$time = validate_input($_POST['time']);
$distance = filter_var($_POST['distance'], FILTER_VALIDATE_FLOAT);
$cab_id = filter_var($_POST['cab_id'], FILTER_VALIDATE_INT);
$final_fare = filter_var($_POST['final_fare'], FILTER_VALIDATE_FLOAT);

// Validate data
$errors = [];
if (empty($first_name) || empty($last_name)) $errors[] = "Name is required.";
if (!preg_match("/^[6-9]\d{9}$/", $phone)) $errors[] = "Invalid mobile number.";
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Invalid email format.";
if (strlen($pincode) != 6 || !is_numeric($pincode)) $errors[] = "Invalid pincode.";
if (!$cab_id) $errors[] = "Invalid cab selection.";
if (!$distance || $distance <= 0) $errors[] = "Invalid distance.";
if (!$final_fare || $final_fare < 0) $errors[] = "Invalid fare amount.";

if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
    header("Location: checkout.php");
    exit;
}
// ✅ **Step 1: Check if the user exists**
$stmt = $conn->prepare("SELECT user_id FROM users WHERE phone = ? OR email = ?");
$stmt->bind_param("ss", $phone, $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $user_id = $row['user_id'];
} else {
    // Insert user
    $hashed_password = md5($phone); // You may consider a stronger hash like password_hash()
    $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, email, phone, city, state, pincode, address, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssss", $first_name, $last_name, $email, $phone, $city, $state, $pincode, $address, $hashed_password);
    
    if ($stmt->execute()) {
        $user_id = $stmt->insert_id;
    } else {
        $_SESSION['errors'][] = "Error inserting user.";
        header("Location: checkout.php");
        exit;
    }
}

// ✅ **Step 2: Check if the cab is available**
$stmt = $conn->prepare("SELECT availability FROM cabs WHERE cab_id = ? AND availability = 1");
$stmt->bind_param("i", $cab_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    $_SESSION['errors'][] = "Selected cab is not available.";
    header("Location: checkout.php");
    exit;
}

// ✅ **Step 3: Insert into bookings**
$stmt = $conn->prepare("INSERT INTO bookings (user_id, cab_id, pickup_point, dropoff_point, pickup_city, dropoff_city, trip_type, pickup_date, pickup_time, total_distance, base_fare, total_fare, status) 
VALUES (?, ?, ?, ?, ?, ?, 'one-way', ?, ?, ?, ?, ?, 'pending')");
$stmt->bind_param("iisssssssdd", $user_id, $cab_id, $pickup, $dropoff, $city, $state, $date, $time, $distance, $final_fare, $final_fare);

if ($stmt->execute()) {
    $booking_id = $stmt->insert_id;

    // ✅ **Step 4: Insert into cab_schedule**
    $stmt = $conn->prepare("INSERT INTO cab_schedule (cab_id, booking_id, available_from, available_until) VALUES (?, ?, ?, DATE_ADD(?, INTERVAL 3 HOUR))");
    $datetime = "$date $time";
    $stmt->bind_param("iiss", $cab_id, $booking_id, $datetime, $datetime);
    if ($stmt->execute()) {
        // ✅ **Step 5: Update cab availability**
        $stmt = $conn->prepare("UPDATE cabs SET availability = 0 WHERE cab_id = ?");
        $stmt->bind_param("i", $cab_id);
        $stmt->execute();
        
        // ✅ **Redirect to thank you page**
        if (sendBookingEmails($user_id, $booking_id, $cab_id)) {
            print_r("Mail Sent");
            $_SESSION['booking_confirmed'] = true;
            header("Location: thanks.php");
            exit;
        } else {
            echo "Failed to send booking email.";
        }
    } else {
        $_SESSION['errors'][] = "Error inserting cab schedule.";
        header("Location: checkout.php");
        exit;
    }
} else {
    $_SESSION['errors'][] = "Error inserting booking.";
    header("Location: checkout.php");
    exit;
}

$conn->close();
?>
