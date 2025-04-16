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
    <section id="search-cabs" class="search-cabs">
        <h2>Find Your Cab</h2>

        <!-- Tab Buttons -->
        <div class="tab-container">
            <button class="tab-btn active" onclick="showTab('oneway')">One-Way Trip</button>
            <button class="tab-btn" onclick="showTab('roundtrip')">Round Trip</button>
        </div>

        <!-- One-Way Trip Content -->
        <div id="oneway" class="tab-content active">
            <form method="post" class="cab-form">
                <input type="hidden" name="fare_type" value="oneway">
                <input type="hidden" class="pickup_city" name="pickup">
                <input type="hidden" class="dropoff_city" name="dropoff">
                <input type="hidden" class="distance_input" name="distance">

                <div class="form-row">
                    <!-- Pickup -->
                    <div class="input-container">
                        <label>Pickup:</label>
                        <select class="pickup-dropdown location-dropdown" required>
                            <option value="">Select Pickup Location</option>
                            <?php
                            include 'db.php';
                            $query = "SELECT city_name, state_name, lattitude, longitude FROM locations ORDER BY city_name ASC";
                            $result = mysqli_query($conn, $query);
                            while ($row = mysqli_fetch_assoc($result)) {
                                $city = $row['city_name'];
                                $lat = $row['lattitude'];
                                $lng = $row['longitude'];
                                echo "<option value='$city' data-lat='$lat' data-lng='$lng'>$city</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <!-- Drop -->
                    <div class="input-container">
                        <label>Drop-off:</label>
                        <select class="dropoff-dropdown location-dropdown" required>
                            <option value="">Select Drop-off Location</option>
                            <?php
                            mysqli_data_seek($result, 0);
                            while ($row = mysqli_fetch_assoc($result)) {
                                $city = $row['city_name'];
                                $lat = $row['lattitude'];
                                $lng = $row['longitude'];
                                echo "<option value='$city' data-lat='$lat' data-lng='$lng'>$city</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <!-- Date -->
                    <div class="input-container">
                        <label>Date:</label>
                        <input type="date" name="date" required>
                    </div>

                    <!-- Time -->
                    <div class="input-container">
                        <label>Time:</label>
                        <input type="time" name="time" required>
                    </div>
                </div>

                <div class="form-action">
                    <button type="submit" class="submit-btn">Search Cabs</button>
                </div>
            </form>

            <!-- Floating Taxi Icon -->
            <div class="floating-taxi">🚖</div>
        </div>

        <!-- Round Trip Content -->
        <div id="roundtrip" class="tab-content">
            <form method="post" class="cab-form">
                <input type="hidden" name="fare_type" value="roundtrip">
                <input type="hidden" class="pickup_city" name="pickup">
                <input type="hidden" class="dropoff_city" name="dropoff">
                <input type="hidden" class="distance_input" name="distance">

                <div class="form-row">
                    <!-- Pickup -->
                    <div class="input-container">
                        <label>Pickup:</label>
                        <select class="pickup-dropdown location-dropdown" required>
                            <option value="">Select Pickup Location</option>
                            <?php
                            include 'db.php';
                            $query = "SELECT city_name, state_name, lattitude, longitude FROM locations ORDER BY city_name ASC";
                            $result = mysqli_query($conn, $query);
                            while ($row = mysqli_fetch_assoc($result)) {
                                $city = $row['city_name'];
                                $lat = $row['lattitude'];
                                $lng = $row['longitude'];
                                echo "<option value='$city' data-lat='$lat' data-lng='$lng'>$city</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <!-- Drop -->
                    <div class="input-container">
                        <label>Drop-off:</label>
                        <select class="dropoff-dropdown location-dropdown" required>
                            <option value="">Select Drop-off Location</option>
                            <?php
                            mysqli_data_seek($result, 0);
                            while ($row = mysqli_fetch_assoc($result)) {
                                $city = $row['city_name'];
                                $lat = $row['lattitude'];
                                $lng = $row['longitude'];
                                echo "<option value='$city' data-lat='$lat' data-lng='$lng'>$city</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <!-- Pickup Date -->
                    <div class="input-container">
                        <label>Date:</label>
                        <input type="date" name="date" required>
                    </div>

                    <!-- Pickup Time -->
                    <div class="input-container">
                        <label>Time:</label>
                        <input type="time" name="time" required>
                    </div>

                    <!-- Return Date -->
                    <div class="input-container">
                        <label>Return Date:</label>
                        <input type="date" name="returndate" required>
                    </div>

                    <!-- Return Time -->
                    <div class="input-container">
                        <label>Return Time:</label>
                        <input type="time" name="returntime" required>
                    </div>
                </div>

                <div class="form-action">
                    <button type="submit" class="submit-btn">Search Cabs</button>
                </div>

                <!-- Floating Taxi -->
                <div class="floating-taxi">🚖</div>
            </form>
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
                        <img src="images/place/bhavnagar.jpg" class="img-fluid rounded" alt="Place">
                        <p class="mt-2 font-weight-bold">Place Near Bhavnagar</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="place-card text-center p-3">
                        <img src="images/place/kutchh.jpg" class="img-fluid rounded" alt="Place">
                        <p class="mt-2 font-weight-bold">Popular Place in Kutch</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="place-card text-center p-3">
                        <img src="images/place/dwarka.jpg" class="img-fluid rounded" alt="Place">
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
                                <h4>Glimpse Of Bhavnagar</h4>
                                <div class="cardImg">
                                    <img src="images/place/Bhavnagar.jpg" class="img-fluid rounded shadow cardImg" alt="Bhavnagar">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <p class="small">Exciting Place</p>
                                <h4>Historic Of Kutchh</h4>
                                <img src="images/place/kutchh.jpg" class="img-fluid rounded shadow cardImg" alt="Kutchh">
                            </div>
                            <div class="col-md-4">
                                <p class="small">Spiritual Places Of Gujarat</p>
                                <h4>Place in Dwarka</h4>
                                <img src="images/place/dwarka.jpg" class="img-fluid rounded shadow cardImg" alt="Dwarka">
                            </div>
                        </div>
                    </div>

                    <div class="carousel-item">
                        <div class="row text-center">
                            <div class="col-md-4">
                                <p class="small">Nature Friendly Places</p>
                                <h4>Adventurous Saputara</h4>
                                <img src="images/place/saputara.jpg" class="img-fluid rounded shadow cardImg" alt="Saputara">
                            </div>
                            <div class="col-md-4">
                                <p class="small">Leadership</p>
                                <h4>Statue Of Unity</h4>
                                <img src="images/place/statueofunity.jpeg" class="img-fluid rounded shadow cardImg"  alt="Statue Of Unity">
                            </div>
                            <div class="col-md-4">
                                <p class="small">Religious Sites</p>
                                <h4>Place in Salangpur</h4>
                                <img src="images/place/salangpur.png" class="img-fluid rounded shadow cardImg" alt="Salangpur">
                            </div>
                        </div>
                    </div>

                    <div class="carousel-item">
                        <div class="row text-center">
                            <div class="col-md-4">
                                <p class="small">Nature Friendly Places</p>
                                <h4>Adventurous Saputara</h4>
                                <img src="images/place/saputara.jpg" class="img-fluid rounded shadow cardImg" alt="Saputara">
                            </div>
                            <div class="col-md-4">
                                <p class="small">Leadership</p>
                                <h4>Statue Of Unity</h4>
                                <img src="images/place/statueofunity.jpeg" class="img-fluid rounded shadow cardImg"  alt="Statue Of Unity">
                            </div>
                            <div class="col-md-4">
                                <p class="small">Religious Sites</p>
                                <h4>Place in Salangpur</h4>
                                <img src="images/place/salangpur.png" class="img-fluid rounded shadow cardImg" alt="Salangpur">
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
        function calculateDistance(lat1, lon1, lat2, lon2) {
            const R = 6371;
            const dLat = (lat2 - lat1) * Math.PI / 180;
            const dLon = (lon2 - lon1) * Math.PI / 180;
            const a = Math.sin(dLat / 2) ** 2 +
                Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
                Math.sin(dLon / 2) ** 2;
            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
            return (R * c).toFixed(2);
        }

        function attachListenersToTab(tabId) {
            const tab = document.getElementById(tabId);
            if (!tab) return;

            const pickupDropdown = tab.querySelector('.pickup-dropdown');
            const dropoffDropdown = tab.querySelector('.dropoff-dropdown');
            const pickupHidden = tab.querySelector('.pickup_city');
            const dropoffHidden = tab.querySelector('.dropoff_city');
            const distanceHidden = tab.querySelector('.distance_input');
            const pickupText = tab.querySelector('.pickup_location');
            const dropoffText = tab.querySelector('.dropoff_location');
            const distanceText = tab.querySelector('.distance_display');
            const form = tab.querySelector('.cab-form');

            function updateDistance() {
                const pickup = pickupDropdown.selectedOptions[0];
                const dropoff = dropoffDropdown.selectedOptions[0];

                if (!pickup || !dropoff || !pickup.value || !dropoff.value) return;

                const pickupLat = parseFloat(pickup.dataset.lat);
                const pickupLng = parseFloat(pickup.dataset.lng);
                const dropLat = parseFloat(dropoff.dataset.lat);
                const dropLng = parseFloat(dropoff.dataset.lng);

                if (!isNaN(pickupLat) && !isNaN(dropLat)) {
                    const distance = calculateDistance(pickupLat, pickupLng, dropLat, dropLng);

                    pickupHidden.value = pickup.value;
                    dropoffHidden.value = dropoff.value;
                    distanceHidden.value = distance;

                    pickupText.innerText = pickup.value;
                    dropoffText.innerText = dropoff.value;
                    distanceText.innerText = `${distance} km`;
                }
            }

            pickupDropdown.addEventListener('change', updateDistance);
            dropoffDropdown.addEventListener('change', updateDistance);

            form.addEventListener('submit', function (e) {
                e.preventDefault();

                if (!pickupDropdown.value || !dropoffDropdown.value) {
                    alert("Please select both pickup and drop-off locations!");
                    return;
                }

                const formData = new FormData(this);
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
        }

        document.addEventListener("DOMContentLoaded", function () {
            attachListenersToTab('oneway');
            attachListenersToTab('roundtrip');
        });

        function showTab(tabId) {
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.remove('active');
            });
            document.getElementById(tabId).classList.add('active');

            document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
            event.target.classList.add('active');
        }
    </script>


</body>
</html>
