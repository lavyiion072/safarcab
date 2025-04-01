<?php include 'db.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Safar Cabs - Book Your Taxi</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js" defer></script>
    <style>
        .hidden { display: none; }
    </style>
</head>
<body>
    <?php include('header.php'); ?>

    <!-- Navbar -->
    <!-- <nav>
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
    </nav> -->
    
    <!-- Banner Carousel -->
    <section class="carousel">
        <div class="carousel-container">
            <div class="slides">
                <img src="images/Banner1.jpg" alt="Taxi Service">
            </div>
        </div>
    </section>

    <!-- Header Section -->
    <header class="header-section text-center py-4">
        <h1>We are present in 75+ Cities</h1>
        <p>Providing OneWayCab services on 521+ Routes in Gujarat.</p>
    </header>

    <!-- Search Available Cabs -->
    <!-- Search Available Cabs -->
    <section id="search-cabs" class="search-cabs">
        <h2>Find Your Cab</h2>

        <!-- Tab Buttons -->
        <div class="tab-container">
            <button class="tab-btn active" onclick="showTab('oneway')">One-Way Trip</button>
            <button class="tab-btn" onclick="showTab('roundtrip')">Round Trip</button>
        </div>

        <!-- One-Way Trip Content -->
        <div id="oneway" class="tab-content active">
            <div class="location-container">
                <!-- Pickup Selection -->
                <div class="input-container">
                    <label for="pickup_dropdown">Pickup Location:</label>
                    <select id="pickup_dropdown" class="location-dropdown">
                        <option value="">Select Pickup Location</option>
                    </select>
                </div>
                <div id="pickup_map_container" class="map-container hidden">
                    <h3>Select Pickup Location</h3>
                    <div id="pickup_map" class="map"></div>
                </div>

                <!-- Drop-off Selection -->
                <div class="input-container">
                    <label for="dropoff_dropdown">Drop-off Location:</label>
                    <select id="dropoff_dropdown" class="location-dropdown">
                        <option value="">Select Drop-off Location</option>
                    </select>
                </div>
                <div id="dropoff_map_container" class="map-container hidden">
                    <h3>Select Drop-off Location</h3>
                    <div id="dropoff_map" class="map"></div>
                </div>
                <form id="cabSearchForm" method="post" class="cab-form">
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

                    <button type="submit" class="submit-btn">Search Cabs</button>
                </form>
                <!-- Fare Details -->
                <div class="fare-details">
                    <h3>Fare Details</h3>
                    <p><strong>Pickup: </strong><span id="pickup_location">Not Set</span></p>
                    <p><strong>DropOff: </strong><span id="dropoff_location">Not Set</span></p>
                    <p><strong>Distance: </strong><span id="distance">0 km</span></p>
                </div>
            </div>
        </div>
    </section>


    <!-- Available Cabs -->
    <section id="available-cabs">
        <h2>Available Cabs</h2>
        <div id="cabList" class="cab-container"></div>
    </section>
    <section class="container my-7">
        <div class="card whatsapp">
            <div class="icon">
            </div>
            <h3>Chat With Us</h3>
            <p>On WhatsApp</p>
        </div>
        <div class="card app-store">
            <div class="icon">
            </div>
            <h3>Apple Store</h3>
            <p>Download From</p>
        </div>
        <div class="card google-play">
            <div class="icon">
            </div>
            <h3>Google Play</h3>
            <p>Download From</p>
        </div>
    </section>

    <!-- Popular Places -->
    <section class="container my-4" style="display:none ">
        <div class="container">
            <h2 class="text-center mb-4">Visit Popular Places</h2>
            <div class="row">
                <div class="col-md-4">
                    <div class="place-card text-center p-3">
                        <img src="images/place1.jpg" class="img-fluid rounded" alt="Place">
                        <p class="mt-2 font-weight-bold">Place Near Bhavnagar</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="place-card text-center p-3">
                        <img src="images/place2.jpg" class="img-fluid rounded" alt="Place">
                        <p class="mt-2 font-weight-bold">Popular Place in Gujarat</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="place-card text-center p-3">
                        <img src="images/place3.jpg" class="img-fluid rounded" alt="Place">
                        <p class="mt-2 font-weight-bold">Explore More Places</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="why-rashmi">
        <div class="container">
            <h2>Why Safar Cabs?</h2>
            <div class="row">
                <div class="col-md-2 col-6 feature-box">
                    <i class="fas fa-thumbs-up fa-3x text-warning"></i>
                    <p>Complimentary</p>
                </div>
                <div class="col-md-2 col-6 feature-box">
                    <i class="fas fa-file-invoice-dollar fa-3x text-warning"></i>

                    <p>Transparent Billing</p>
                </div>
                <div class="col-md-2 col-6 feature-box">
                    <i class="fas fa-clock fa-3x text-warning"></i>

                    <p>On Time Service</p>
                </div>
                <div class="col-md-2 col-6 feature-box">
                    <i class="fas fa-headset fa-3x text-warning"></i>

                    <p>24/7 Helpline</p>
                </div>
                <div class="col-md-2 col-6 feature-box">
                    <i class="fas fa-user-tie fa-3x text-warning"></i>

                    <p>Courteous Driver</p>
                </div>
                <div class="col-md-2 col-6 feature-box">
                    <i class="fas fa-car fa-3x text-warning"></i>

                    <p>Clean Car</p>
                </div>
            </div>
        </div>
    </section>
    <div class="bottom-wave"></div>

    <!-- New Section: Discover More Places -->
    <section class="discover-more bg-warning p-5">
        <div class="container">
            <div class="text-center mb-4">
                <p class="small text-uppercase">More Places</p>
                <h2 class="fw-bold">Discover More Places</h2>
            </div>

            <div id="discoverCarousel" class="carousel slide" data-bs-ride="carousel">
                <!-- Indicators -->
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#discoverCarousel" data-bs-slide-to="0" class="active"></button>
                    <button type="button" data-bs-target="#discoverCarousel" data-bs-slide-to="1"></button>
                    <button type="button" data-bs-target="#discoverCarousel" data-bs-slide-to="2"></button>
                </div>

                <!-- Carousel Items -->
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="row text-center">
                            <div class="col-md-4">
                                <p class="small">In Gujarat</p>
                                <h4>Place in Ahmedabad test</h4>
                                <div class="cardImg">
                                    <img src="images/Gallary/img2.jpg" class="img-fluid rounded shadow cardImg" alt="Gir Forest">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <p class="small">Near Ahmedabad</p>
                                <h4>Place Near Ahmedabad</h4>
                                <img src="images/Gallary/img3.jpg" class="img-fluid rounded shadow cardImg" alt="Gir Forest">
                            </div>
                            <div class="col-md-4">
                                <p class="small">Popular Places</p>
                                <h4>Place in Dwarka</h4>
                                <img src="images/Gallary/img4.jpg" class="img-fluid rounded shadow cardImg" alt="Gir Forest">
                            </div>
                        </div>
                    </div>

                    <div class="carousel-item">
                        <div class="row text-center">
                            <div class="col-md-4">
                                <p class="small">Historical Places</p>
                                <h4>Place in Somnath</h4>
                                <img src="images/Gallary/img5.jpg" class="img-fluid rounded shadow cardImg" alt="Gir Forest">
                            </div>
                            <div class="col-md-4">
                                <p class="small">Near Rajkot</p>
                                <h4>Place Near Rajkot</h4>
                                <img src="images/Gallary/img2.jpg" class="img-fluid rounded shadow cardImg"  alt="Gir Forest">
                            </div>
                            <div class="col-md-4">
                                <p class="small">Religious Sites</p>
                                <h4>Place in Palitana</h4>
                                <img src="images/Gallary/img3.jpg" class="img-fluid rounded shadow cardImg" alt="Gir Forest">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Carousel Controls -->
                <button class="carousel-control-prev" type="button" data-bs-target="#discoverCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#discoverCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </button>
            </div>
        </div>
    </section>
    <section class="stats-section container my-5">
        <div class="row g-4" >
            <div class="col-sm-3">
                <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Special title treatment</h5>
                    <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Special title treatment</h5>
                    <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Special title treatment</h5>
                    <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Special title treatment</h5>
                    <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                </div>
                </div>
            </div>
        </div> 
    </section>

     <!-- Footer -->
     <?php include 'footer.php'; ?>

    <!--Start of Tawk.to Script-->
    <script type="text/javascript">
        var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
        (function(){
        var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
        s1.async=true;
        s1.src='https://embed.tawk.to/67ea75fb9ce708190d878609/1inltpnua';
        s1.charset='UTF-8';
        s1.setAttribute('crossorigin','*');
        s0.parentNode.insertBefore(s1,s0);
        })();
    </script>
    <!--End of Tawk.to Script-->

    <script>
        // Initialize Maps
        var pickupMap = L.map('pickup_map').setView([23.0225, 72.5714], 10);
        var dropoffMap = L.map('dropoff_map').setView([23.0225, 72.5714], 10);

        // Add OpenStreetMap tiles
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(pickupMap);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(dropoffMap);

        // Global Variables
        var pickupMarker = null, dropoffMarker = null;
        var pickupCoords = null, dropoffCoords = null;

        function reverseGeocode(lat, lon, elementId, inputId, dropdownId) {
            fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}`)
                .then(response => response.json())
                .then(data => {
                    let location = data.address.city || data.address.town || data.address.village || "Unknown";
                    document.getElementById(elementId).innerText = location;
                    document.getElementById(inputId).value = location;
                    
                    // Update dropdown text with selected city
                    let dropdown = document.getElementById(dropdownId);
                    dropdown.innerHTML = `<option value="${location}" selected>${location}</option>`;
                })
                .catch(error => {
                    console.error("Geocode error:", error);
                    document.getElementById(elementId).innerText = "Location Not Found";
                });
        }

        function calculateDistance(lat1, lon1, lat2, lon2) {
            const R = 6371;
            const dLat = (lat2 - lat1) * Math.PI / 180;
            const dLon = (lon2 - lon1) * Math.PI / 180;
            const a = Math.sin(dLat/2) * Math.sin(dLat/2) +
                    Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
                    Math.sin(dLon/2) * Math.sin(dLon/2);
            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
            return (R * c).toFixed(2);
        }

        function updateDistance() {
            if (pickupCoords && dropoffCoords) {
                let distance = calculateDistance(pickupCoords.lat, pickupCoords.lng, dropoffCoords.lat, dropoffCoords.lng);
                document.getElementById("distance_input").value = distance;
                document.getElementById("distance").innerText = distance + " km";
            }
        }

        function setupMapClick(map, markerRef, coordsRef, locationId, inputId, dropdownId, isPickup) {
            map.on('click', function(e) {
                if (markerRef) map.removeLayer(markerRef);
                markerRef = L.marker(e.latlng, { draggable: true }).addTo(map).bindPopup("Selected Location").openPopup();
                
                // Update Global Variables
                if (isPickup) {
                    pickupCoords = e.latlng;
                    pickupMarker = markerRef;
                } else {
                    dropoffCoords = e.latlng;
                    dropoffMarker = markerRef;
                }

                reverseGeocode(e.latlng.lat, e.latlng.lng, locationId, inputId, dropdownId);

                markerRef.on('dragend', function(event) {
                    let newCoords = event.target.getLatLng();
                    
                    // Update Global Variables on Drag
                    if (isPickup) {
                        pickupCoords = newCoords;
                    } else {
                        dropoffCoords = newCoords;
                    }

                    reverseGeocode(newCoords.lat, newCoords.lng, locationId, inputId, dropdownId);
                    updateDistance();
                });

                updateDistance();
            });
        }

        // Set up Click Handlers for Maps
        setupMapClick(pickupMap, pickupMarker, pickupCoords, 'pickup_location', 'pickup_city', 'pickup_dropdown', true);
        setupMapClick(dropoffMap, dropoffMarker, dropoffCoords, 'dropoff_location', 'dropoff_city', 'dropoff_dropdown', false);

        // Toggle Map Visibility on Dropdown Click
        document.getElementById("pickup_dropdown").addEventListener("click", function() {
            document.getElementById("pickup_map_container").classList.toggle("hidden");
        });

        document.getElementById("dropoff_dropdown").addEventListener("click", function() {
            document.getElementById("dropoff_map_container").classList.toggle("hidden");
        });

        document.getElementById("cabSearchForm").addEventListener("submit", function(e) {
            e.preventDefault();

            if (!pickupCoords || !dropoffCoords) {
                alert("Please select both pickup and drop-off locations!");
                return;
            }

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
</body>
</html>
