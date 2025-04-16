<header>
<nav class="navbar navbar-expand-lg shadow-sm animate-navbar" style="background-color: #121212; position: fixed; top: 0; left: 0; width: 100%; z-index: 1000;">
    <div class="container py-2">
      <!-- Logo + Brand -->
      <a class="navbar-brand d-flex align-items-center" href="index.php">
        <img src="images/logo.png" alt="Safar Cabs" style="height: 45px;" class="me-2">
        <span class="fw-bold fs-4" style="color: #FFD700;">Safar Cabs</span>
      </a>

      <!-- Mobile Toggle Button -->
      <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Navbar Links -->
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto align-items-center">
          <li class="nav-item">
            <a class="nav-link nav-link-glow" href="index.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link nav-link-glow" href="about.php">About Us</a>
          </li>
          <li class="nav-item">
            <a class="nav-link nav-link-glow" href="contact.php">Contact</a>
          </li>
          <li class="nav-item">
            <a class="nav-link nav-link-glow" href="tariff-card.php">Tariff Card</a>
          </li>
          <li class="nav-item">
            <a class="nav-link nav-link-glow" href="gallery.php">Gallery</a>
          </li>
          <!-- CTA Button -->
          <li class="nav-item">
            <a class="btn-gold ms-3 rounded-pill px-4 py-2 fw-semibold" href="book-now.php">Book Now</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</header>
<script>
  window.addEventListener('DOMContentLoaded', () => {
    const navbar = document.querySelector('.animate-navbar');
    // Add the 'active' class after a short delay for smooth effect
    setTimeout(() => {
      navbar.classList.add('active');
    }, 100); // Delay in ms
  });
</script>

