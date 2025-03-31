<?php
session_start();
include 'db.php';
include 'functions.php'; // Encryption functions

// Redirect if no encrypted data received
if (!isset($_GET['data'])) {
    header("Location: index.php");
    exit;
}

// Decrypt booking data
$booking = decryptData($_GET['data']);

if (!$booking || !isset($booking['cab_id'])) {
    echo "<p class='error'>Invalid booking details!</p>";
    exit;
}

// Store booking details in session
$_SESSION['booking'] = $booking;

// Fetch cab details
$cab_id = intval($booking['cab_id']);
$stmt = $conn->prepare("SELECT model, cab_number, fare_per_km, capacity, image_path FROM cabs WHERE cab_id = ?");
$stmt->bind_param("i", $cab_id);
$stmt->execute();
$result = $stmt->get_result();
$cab_details = $result->fetch_assoc();
$stmt->close();

// Set default values if cab details are missing
$cab_details = $cab_details ?: [
    "model" => "Unknown Model",
    "cab_number" => "N/A",
    "fare_per_km" => "0.00",
    "capacity" => "N/A",
    "image_path" => "images/cabs/default.jpg"
];

// Calculate Fare
$distance = floatval($booking['distance'] ?? 0);
$fare_per_km = floatval($cab_details['fare_per_km']);
$one_way_fare = $distance * $fare_per_km;
$round_trip_fare = $one_way_fare * 2; // Double for round trip

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Confirm Booking</title>
    <link rel="stylesheet" href="css/checkout.css">
</head>
<body>

    <header>
        <h1>Confirm Your Booking</h1>
    </header>

    <!-- Modern Checkout Layout -->
    <div class="checkout-container">
        
        <!-- Left Section: User Form -->
        <div class="checkout-left">
            <h2>Enter Your Details</h2>
            <form action="booking.php" method="post">
                <input type="hidden" name="pickup" value="<?= htmlspecialchars($booking['pickup']) ?>">
                <input type="hidden" name="dropoff" value="<?= htmlspecialchars($booking['dropoff']) ?>">
                <input type="hidden" name="date" value="<?= htmlspecialchars($booking['date']) ?>">
                <input type="hidden" name="time" value="<?= htmlspecialchars($booking['time']) ?>">
                <input type="hidden" name="distance" value="<?= $distance ?>">
                <input type="hidden" name="cab_id" value="<?= $cab_id ?>">
                <input type="hidden" id="final_fare" name="final_fare" value="<?= $one_way_fare ?>">

                <label for="first_name">First Name:</label>
                <input type="text" name="first_name" id="first_name" required placeholder="Enter First Name">

                <label style="margin-top:15px" for="last_name">Last Name:</label>
                <input type="text" name="last_name" id="last_name" required placeholder="Enter Last Name">

                <label style="margin-top:15px" for="phone">Phone:</label>
                <input type="text" name="phone" id="phone" required>

                <label style="margin-top:15px" for="email">Email:</label>
                <input type="email" name="email" id="email" required>

                <label style="margin-top:15px" for="trip_type">Trip Type:</label>
                <select name="trip_type" id="trip_type" required>
                    <option value="one_way">One-Way</option>
                    <option value="round_trip">Round Trip</option>
                </select>

                <p><strong>Estimated Fare:</strong> ₹<span id="fare_display"><?= number_format($one_way_fare, 2) ?></span></p>

                <button type="submit">Confirm Booking</button>
            </form>
            <button class="go-back" onclick="window.history.back();">← Go Back</button>
        </div>

        <!-- Right Section: Booking Summary & Cab Details -->
        <div class="checkout-right">
            <h2>Booking Summary</h2>
            <div class="booking-summary">
                <p><strong>Pickup:</strong> <?= htmlspecialchars($booking['pickup'] ?? "Not Set") ?></p>
                <p><strong>Drop-off:</strong> <?= htmlspecialchars($booking['dropoff'] ?? "Not Set") ?></p>
                <p><strong>Date:</strong> <?= htmlspecialchars($booking['date'] ?? "Not Set") ?></p>
                <p><strong>Time:</strong> <?= htmlspecialchars($booking['time'] ?? "Not Set") ?></p>
                <p><strong>Distance:</strong> <?= $distance ?> Km</p>
            </div>

            <h2>Selected Cab</h2>
            <div class="cab-info">
                <img src="<?= htmlspecialchars($cab_details['image_path']) ?>" alt="<?= htmlspecialchars($cab_details['model']) ?>" class="cab-image">
                <p><strong>Model:</strong> <?= htmlspecialchars($cab_details['model']) ?></p>
                <p><strong>Cab Number:</strong> <?= htmlspecialchars($cab_details['cab_number']) ?></p>
                <p><strong>Fare (Per KM):</strong> ₹<?= number_format($fare_per_km, 2) ?></p>
                <p><strong>Capacity:</strong> <?= htmlspecialchars($cab_details['capacity']) ?> Passengers</p>
            </div>
        </div>

    </div>

<script>
document.getElementById("trip_type").addEventListener("change", function() {
    let tripType = this.value;
    let oneWayFare = <?= $one_way_fare ?>;
    let roundTripFare = <?= $round_trip_fare ?>;
    
    let finalFare = (tripType === "round_trip") ? roundTripFare : oneWayFare;
    document.getElementById("fare_display").innerText = finalFare.toFixed(2);
    document.getElementById("final_fare").value = finalFare;
});
</script>

</body>
</html>
