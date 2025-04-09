<?php
include 'db.php';
include 'functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fare_type = isset($_POST['fare_type']) ? trim($_POST['fare_type']) : null;
    
    if($fare_type == "oneway"){
        $pickup = isset($_POST['pickup']) ? trim($_POST['pickup']) : null;
        $dropoff = isset($_POST['dropoff']) ? trim($_POST['dropoff']) : null;
        $date = isset($_POST['date']) ? trim($_POST['date']) : null;
        $time = isset($_POST['time']) ? trim($_POST['time']) : null;
        $distance = isset($_POST['distance']) ? trim($_POST['distance']) : null;
    }else if($fare_type == "roundtrip"){
        $pickup = isset($_POST['pickup']) ? trim($_POST['pickup']) : null;
        $dropoff = isset($_POST['dropoff']) ? trim($_POST['dropoff']) : null;
        $date = isset($_POST['date']) ? trim($_POST['date']) : null;
        $time = isset($_POST['time']) ? trim($_POST['time']) : null;
        $returndate = isset($_POST['returndate']) ? trim($_POST['returndate']) : null;
        $returntime = isset($_POST['returntime']) ? trim($_POST['returntime']) : null;
        $distance = isset($_POST['distance']) ? trim($_POST['distance']) : null;
    }
    else{
        echo "<p class='error'>Something went wrong-Faretype is not proper - 401</p>";
        exit;
    }
    
    if (!$pickup || !$dropoff || !$date || !$time) {
        echo "<p class='error'>Invalid pickup or drop-off location or date or time. Please try again.</p>";
        exit;
    }

    // Convert selected date & time to DateTime format
    $selectedDateTime = new DateTime("$date $time");

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

    // Fetch available cabs with schedule check
    $stmt = $conn->prepare("
        SELECT c.cab_id, c.model, c.cab_number, c.fare_per_km, c.capacity, c.image_path
        FROM cabs c
        order by c.fare_per_km;
    ");
    
    $selectedDateTimeFormatted = $selectedDateTime->format("Y-m-d H:i:s");
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo '<div class="cab-container">';
        while ($cab = $result->fetch_assoc()) {
            $bookingDetails = [
                "cab_id"   => $cab['cab_id'],
                "pickup"   => $pickup,
                "dropoff"  => $dropoff,
                "date"     => $date,
                "time"     => $time,
                "distance" => $distance,
                "returndate" => $returndate ?? null,
                "returntime" => $returntime ?? null
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
                    </div>
                    <a href="checkout.php?data=' . urlencode($encryptedData) . '" class="book-now">Book Now</a>
                </div>
            ';
        }
        echo '</div>'; // Close cab list container
    } else {
        echo "<p class='error'>No cabs available at $pickup.</p>";
    }
    
} else {
    echo "<p class='error'>Invalid request.</p>";
}
?>
