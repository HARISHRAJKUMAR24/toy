// Burger toggle
const menuBtn = document.getElementById("menu-btn");
const mobileMenu = document.getElementById("mobileMenu");
const menuOverlay = document.getElementById("menu-overlay");
const closeMenu = document.getElementById("close-menu");

function toggleMenu() {
    menuBtn.classList.toggle("active");
    mobileMenu.classList.toggle("!right-0");
    menuOverlay.classList.toggle("opacity-100");
    menuOverlay.classList.toggle("visible");
    document.body.style.overflow = mobileMenu.classList.contains("!right-0") ? "hidden" : "";
}

menuBtn.addEventListener("click", toggleMenu);
closeMenu.addEventListener("click", toggleMenu);
menuOverlay.addEventListener("click", toggleMenu);

// Mobile dropdown
document.querySelectorAll(".mobile-dropdown button").forEach(btn => {
    btn.addEventListener("click", () => {
        btn.nextElementSibling.classList.toggle("max-h-0");
        btn.nextElementSibling.classList.toggle("max-h-48");
    });
});

// Slider
const slides = document.querySelectorAll(".slide");
const dotsContainer = document.getElementById("dots");
let index = 0;
let slideInterval;
const duration = 4000;

slides.forEach((_, i) => {
    const dot = document.createElement("div");
    dot.className =
        "w-3 h-3 rounded-full bg-white/60 cursor-pointer relative overflow-hidden";
    dot.innerHTML = "<div class='progress absolute bottom-0 left-0 h-full w-0 bg-white'></div>";
    dot.addEventListener("click", () => {
        showSlide(i);
        resetInterval();
    });
    dotsContainer.appendChild(dot);
});
const dots = document.querySelectorAll("#dots .w-3");

function showSlide(i) {
    slides.forEach((s, j) => {
        s.classList.toggle("opacity-100", j === i);
        s.classList.toggle("z-10", j === i);
        s.classList.toggle("opacity-0", j !== i);
    });
    dots.forEach((d, j) => {
        d.classList.toggle("bg-pink-500", j === i);
        const progress = d.querySelector(".progress");
        progress.style.width = j === i ? "100%" : "0";
        progress.style.transitionDuration = j === i ? duration + "ms" : "0ms";
    });
    index = i;
}

function nextSlide() {
    showSlide((index + 1) % slides.length);
}

function resetInterval() {
    clearInterval(slideInterval);
    slideInterval = setInterval(nextSlide, duration);
}

showSlide(0);
resetInterval();

// Add animation to category items when they come into view
document.addEventListener('DOMContentLoaded', function () {
    const categoryItems = document.querySelectorAll('.group');

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = "1";
                entry.target.style.transform = "translateY(0)";
            }
        });
    }, { threshold: 0.1 });

    categoryItems.forEach(item => {
        item.style.opacity = "0";
        item.style.transform = "translateY(20px)";
        item.style.transition = "opacity 0.5s ease, transform 0.5s ease";
        observer.observe(item);
    });

    // Add click effect to category items
    categoryItems.forEach(item => {
        item.addEventListener('click', function () {
            this.style.transform = 'scale(0.98)';
            setTimeout(() => {
                this.style.transform = '';
            }, 200);

            // You can add navigation logic here
            console.log('Category clicked:', this.querySelector('h3').textContent);
        });
    });
});

