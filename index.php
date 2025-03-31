<?php include 'db.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rashmi Cabs - Book Your Taxi</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script src="js/script.js" defer></script>
</head>
<body>

    <!-- Navbar -->
    <nav>
        <div class="logo">
            <img src="images/logo.png" alt="Taxi Logo">
        </div>
        <ul class="nav-links">
            <li><a href="#">Home</a></li>
            <li><a href="#">About Us</a></li>
            <li><a href="#">Gallery</a></li>
            <li><a href="#">Tariff Card</a></li>
            <li><a href="#">Contact</a></li>
            <li><a href="#search-cabs" class="btn">Book Now</a></li>
        </ul>
    </nav>

    <!-- Search Available Cabs -->
    <section id="search-cabs">
        <h2>Find Your Cab</h2>
        <div class="tab-container">
            <button class="tab-btn active" onclick="showTab('oneway')">One-Way Trip</button>
            <button class="tab-btn" onclick="showTab('roundtrip')">Round Trip</button>
        </div>

        <div id="oneway" class="tab-content active">
            <div style="display: flex; gap: 20px;">
                <div>
                    <h3>Pickup Location</h3>
                    <div id="pickup_map" style="height: 300px; width: 400px;"></div>
                </div>
                <div>
                    <h3>Drop-off Location</h3>
                    <div id="dropoff_map" style="height: 300px; width: 400px;"></div>
                </div>
                <div>
                    <h3>Fare Details</h3>
                    Pickup: <p id="pickup_location"></p>
                    DropOff: <p id="dropoff_location"></p>
                    Distance: <p id="distance"></p>
                </div>
            </div>

            <form id="cabSearchForm" method="post">
                <input type="hidden" id="pickup_city" name="pickup">
                <input type="hidden" id="dropoff_city" name="dropoff">
                <input type="hidden" id="distance_input" name="distance">
                

                <div class="input-container">
                    <label for="date">Date:</label>
                    <input type="date" id="date" name="date" required>
                </div>

                <div class="input-container">
                    <label for="time">Time:</label>
                    <input type="time" id="time" name="time" required>
                </div>

                <button type="submit">Search Cabs</button>
            </form>
        </div>
    </section>

    <!-- Available Cabs -->
    <section id="available-cabs">
        <h2>Available Cabs</h2>
        <div id="cabList" class="cab-container"></div>
    </section>

</body>

<script>
    var pickupMap = L.map('pickup_map').setView([23.0225, 72.5714], 10);
    var dropoffMap = L.map('dropoff_map').setView([23.0225, 72.5714], 10);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(pickupMap);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(dropoffMap);

    var pickupMarker, dropoffMarker;
    var pickupCoords, dropoffCoords;

    function reverseGeocode(lat, lon, elementId, inputId) {
        fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}`)
            .then(response => response.json())
            .then(data => {
                let location = data.address.city || data.address.town || data.address.village || "Unknown";
                document.getElementById(elementId).innerText = `${location}`;
                document.getElementById(inputId).value = `${location}`;
            })
            .catch(error => console.error("Geocode error:", error));
    }

    function calculateDistance(lat1, lon1, lat2, lon2) {
        const R = 6371; // Radius of Earth in km
        const dLat = (lat2 - lat1) * Math.PI / 180;
        const dLon = (lon2 - lon1) * Math.PI / 180;
        const a = Math.sin(dLat/2) * Math.sin(dLat/2) +
                  Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
                  Math.sin(dLon/2) * Math.sin(dLon/2);
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
        return (R * c).toFixed(2); // Distance in km
    }

    pickupMap.on('click', function(e) {
    if (pickupMarker) pickupMap.removeLayer(pickupMarker);
    pickupMarker = L.marker(e.latlng).addTo(pickupMap).bindPopup("Pickup").openPopup();
    pickupCoords = e.latlng;
    reverseGeocode(e.latlng.lat, e.latlng.lng, 'pickup_location', 'pickup_city');

    if (pickupCoords && dropoffCoords) {
        let distance = calculateDistance(pickupCoords.lat, pickupCoords.lng, dropoffCoords.lat, dropoffCoords.lng);
        document.getElementById("distance_input").value = distance;
        document.getElementById("distance").innerText = distance + " km";
    }
});

dropoffMap.on('click', function(e) {
    if (dropoffMarker) dropoffMap.removeLayer(dropoffMarker);
    dropoffMarker = L.marker(e.latlng).addTo(dropoffMap).bindPopup("Drop-off").openPopup();
    dropoffCoords = e.latlng;
    reverseGeocode(e.latlng.lat, e.latlng.lng, 'dropoff_location', 'dropoff_city');

    if (pickupCoords && dropoffCoords) {
        let distance = calculateDistance(pickupCoords.lat, pickupCoords.lng, dropoffCoords.lat, dropoffCoords.lng);
        document.getElementById("distance_input").value = distance;
        document.getElementById("distance").innerText = distance + " km";
    }
});

    document.getElementById("cabSearchForm").addEventListener("submit", function(e) {
        e.preventDefault();
        let formData = new FormData(this);
        fetch("search_cabs.php", {
            method: "POST",
            body: formData,
        })
        .then(response => response.text())
        .then(data => {
            document.getElementById("cabList").innerHTML = data;
        })
        .catch(error => console.error("Error:", error));
    });
</script>

</html>
