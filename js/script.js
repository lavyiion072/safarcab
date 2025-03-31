document.querySelector(".menu-toggle").addEventListener("click", () => {
    document.querySelector(".nav-links").classList.toggle("active");
});

function showTab(tab) {
    // Remove "active" class from all tab contents
    document.querySelectorAll(".tab-content").forEach(t => t.classList.remove("active"));

    // Add "active" class to the selected tab
    document.getElementById(tab).classList.add("active");

    // Remove "active" class from all buttons
    document.querySelectorAll(".tab-btn").forEach(btn => btn.classList.remove("active"));

    // Add "active" class to the clicked button
    document.querySelector(`[onclick="showTab('${tab}')"]`).classList.add("active");
}


function closePopup() {
    document.getElementById("popupBanner").style.display = "none";
}

document.addEventListener("DOMContentLoaded", () => {
    let slideIndex = 0;
    const slides = document.querySelector(".slides");
    const totalSlides = document.querySelectorAll(".slides img").length;

    function moveSlide(step) {
        slideIndex += step;
        if (slideIndex < 0) slideIndex = totalSlides - 1;
        if (slideIndex >= totalSlides) slideIndex = 0;
        updateSlide();
    }

    function autoSlide() {
        moveSlide(1);
    }

    function updateSlide() {
        slides.style.transform = `translateX(-${slideIndex * 100}%)`;
    }

    // Auto-slide every 4 seconds
    setInterval(autoSlide, 4000);

    // Initial call to set up slide position
    updateSlide();

    // Event Listeners for arrows
    document.querySelector(".prev").addEventListener("click", () => moveSlide(-1));
    document.querySelector(".next").addEventListener("click", () => moveSlide(1));

});

document.addEventListener("DOMContentLoaded", function () {
    document.querySelector("form").addEventListener("submit", function (event) {
        let errors = [];
        
        // Fetch values
        let firstName = document.getElementById("first_name").value.trim();
        let lastName = document.getElementById("last_name").value.trim();
        let phone = document.getElementById("phone").value.trim();
        let email = document.getElementById("email").value.trim();
        let city = document.getElementById("city").value.trim();
        let state = document.getElementById("state").value.trim();
        let pincode = document.getElementById("pincode").value.trim();

        // Name validation
        if (firstName === "" || lastName === "") errors.push("Name is required.");
        
        // Mobile validation (Indian number format)
        if (!/^[6-9]\d{9}$/.test(phone)) errors.push("Invalid mobile number. Must be 10 digits.");
        
        // Email validation
        if (!/^\S+@\S+\.\S+$/.test(email)) errors.push("Invalid email format.");
        
        // Pincode validation (6 digits)
        if (!/^\d{6}$/.test(pincode)) errors.push("Invalid pincode.");

        // Display errors or allow submission
        if (errors.length > 0) {
            event.preventDefault();
            alert(errors.join("\n"));
        }
    });
});

