<?php include 'db.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rashmi Cabs - Book Your Taxi</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="js/script.js" defer></script>
</head>
<body>

    <!-- Popup Banner on Page Load -->
    <div id="popupBanner">
        <p>Looking for a Taxi? <button onclick="closePopup()">Book Now</button></p>
    </div>

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
        <div class="menu-toggle">
            <i class="fas fa-bars"></i>
        </div>
    </nav>

    <section class="carousel">
        <div class="carousel-container">
            <div class="slides">
                <img src="images/Banner1.jpg" alt="Taxi Service">
                <img src="images/Banner2.png" alt="Cab Ride">
                <img src="images/Banner3.jpg" alt="Comfortable Taxi">
            </div>
        </div>
        <!-- Navigation Arrows -->
        <button class="prev" onclick="moveSlide(-1)">&#10094;</button>
        <button class="next" onclick="moveSlide(1)">&#10095;</button>
    </section>


    <!-- Search Available Cabs -->
    <section id="search-cabs">
        <h2>Find Your Cab</h2>
        <div class="tab-container">
            <button class="tab-btn active" onclick="showTab('oneway')">One-Way Trip</button>
            <button class="tab-btn" onclick="showTab('roundtrip')">Round Trip</button>
        </div>

        <div id="oneway" class="tab-content active">
            <form action="search_cabs.php" method="post">
                <label>Pickup Location:</label>
                <input type="text" name="pickup" required placeholder="Enter pickup location">

                <label>Drop-off Location:</label>
                <input type="text" name="dropoff" required placeholder="Enter drop-off location">

                <label>Date:</label>
                <input type="date" name="date" required>

                <label>Time:</label>
                <input type="time" name="time" required>

                <button type="submit">Search Cabs</button>
            </form>
        </div>

        <div id="roundtrip" class="tab-content">
            <form action="search_cabs.php" method="post">
                <label>Pickup Location:</label>
                <input type="text" name="pickup" required>

                <label>Drop-off Location:</label>
                <input type="text" name="dropoff" required>

                <label>Pickup Date:</label>
                <input type="date" name="date" required>

                <label>Pickup Time:</label>
                <input type="time" name="time" required>

                <label>Return Date:</label>
                <input type="date" name="return_date" required>

                <label>Return Time:</label>
                <input type="time" name="return_time" required>

                <button type="submit">Search Cabs</button>
            </form>
        </div>
    </section>

    <!-- About Us -->
    <section id="about-us">
        <h2>About Rashmi Cabs</h2>
        <p>Providing safe and affordable taxi services for over 10 years.</p>
    </section>

    <!-- Connect With Us -->
    <section id="connect">
        <h2>Connect With Us</h2>
        <p>Follow us on social media:</p>
        <div class="social-icons">
            <a href="#"><i class="fab fa-facebook"></i></a>
            <a href="#"><i class="fab fa-twitter"></i></a>
            <a href="#"><i class="fab fa-instagram"></i></a>
        </div>
    </section>

    <!-- Why Us -->
    <section id="why-us">
        <h2>Why Choose Us?</h2>
        <ul>
            <li>✔ Affordable pricing</li>
            <li>✔ Safe and hygienic cabs</li>
            <li>✔ 24/7 customer support</li>
        </ul>
    </section>

    <!-- Suggested Famous Places -->
    <section id="places">
        <h2>Explore These Famous Places</h2>
        <div class="place">
            <img src="images/place1.jpg" alt="Famous Place">
            <p>Taj Mahal</p>
        </div>
        <div class="place">
            <img src="images/place2.jpg" alt="Famous Place">
            <p>Gateway of India</p>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <h2>Contact Us</h2>
        <p>📍 Address: XYZ Street, City, India</p>
        <p>📞 Phone: +91 1234567890</p>
        <p>📧 Email: info@rashmicabs.com</p>
    </footer>

</body>
</html>
