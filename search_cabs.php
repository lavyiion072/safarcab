<?php
include 'db.php';
include 'functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pickup = isset($_POST['pickup']) ? trim($_POST['pickup']) : null;
    $dropoff = isset($_POST['dropoff']) ? trim($_POST['dropoff']) : null;
    $date = isset($_POST['date']) ? trim($_POST['date']) : null;
    $time = isset($_POST['time']) ? trim($_POST['time']) : null;
    $distance = isset($_POST['distance']) ? trim($_POST['distance']) : null;
    if (!$pickup || !$dropoff || !$date || !$time) {
        echo "<p class='error'>Invalid pickup or drop-off location or date or time. Please try again.</p>";
        exit;
    }

    // Check if locations exist
    $stmt = $conn->prepare("SELECT location_id FROM locations WHERE city_name = ?");
    $stmt->bind_param("s", $pickup);
    $stmt->execute();
    $result = $stmt->get_result();
    $pickup_location = $result->fetch_assoc();

    $stmt->bind_param("s", $dropoff);
    $stmt->execute();
    $result = $stmt->get_result();
    $dropoff_location = $result->fetch_assoc();

    if (!$pickup_location || !$dropoff_location) {
        echo "<p class='error'>One or both locations are not available in our service area.</p>";
        exit;
    }

    $pickup_location_id = $pickup_location['location_id'];

    // Fetch available cabs
    $stmt = $conn->prepare("
        SELECT cabs.*, locations.city_name AS location 
        FROM cabs
        JOIN cab_locations ON cabs.cab_id = cab_locations.cab_id
        JOIN locations ON cab_locations.location_id = locations.location_id
        WHERE cab_locations.location_id = ? AND cabs.availability = 1
    ");
    $stmt->bind_param("i", $pickup_location_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($cab = $result->fetch_assoc()) {
            // Encrypt booking details inside the loop
            $bookingDetails = [
                "cab_id"   => $cab['cab_id'],
                "pickup"   => $pickup,
                "dropoff"  => $dropoff,
                "date"     => $date,
                "time"     => $time,
                "distance" => $distance
            ];
            
            $encryptedData = encryptData($bookingDetails);

            echo '
                <div class="cab-card">
                    <img src="' . htmlspecialchars($cab['image_path']) . '" alt="' . htmlspecialchars($cab['model']) . '">
                    <div class="cab-details">
                        <h3>' . htmlspecialchars($cab['model']) . '</h3>
                        <p><strong>Number:</strong> ' . htmlspecialchars($cab['cab_number']) . '</p>
                        <p><strong>Fare:</strong> ₹' . htmlspecialchars($cab['fare_per_km']) . '/km</p>
                        <p><strong>Capacity:</strong> ' . htmlspecialchars($cab['capacity']) . ' passengers</p>
                        <p><strong>Available at:</strong> ' . htmlspecialchars($cab['location']) . '</p>
                    </div>
                    <a href="checkout.php?data=' . urlencode($encryptedData) . '" class="book-now">Book Now</a>
                </div>
            ';
        }
    } else {
        echo "<p class='error'>No cabs available at $pickup.</p>";
    }
} else {
    echo "<p class='error'>Invalid request.</p>";
}
?>
