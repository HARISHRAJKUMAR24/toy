document.addEventListener("DOMContentLoaded", () => {
    // ===============================
    // NAVBAR DROPDOWN
    // ===============================
    function isDesktop() {
        return window.matchMedia("(min-width: 1024px)").matches; // lg breakpoint
    }

    const shopToggles = document.querySelectorAll('.shop-toggle');
    if (shopToggles.length > 0) {
        shopToggles.forEach(btn => {
            const menu = btn.nextElementSibling;
            const icon = btn.querySelector('i');
            if (!menu) return;

            function openMenu() {
                menu.classList.add('opacity-100', 'pointer-events-auto', 'translate-y-0');
                if (icon) icon.classList.add('rotate-180');
            }

            function closeMenu() {
                menu.classList.remove('opacity-100', 'pointer-events-auto', 'translate-y-0');
                if (icon) icon.classList.remove('rotate-180');
            }

            function toggleMenu(e) {
                e.preventDefault();
                menu.classList.toggle('opacity-100');
                menu.classList.toggle('pointer-events-auto');
                menu.classList.toggle('translate-y-0');
                if (icon) icon.classList.toggle('rotate-180'); // ✅ icon rotates mobile/tablet
            }

            if (isDesktop()) {
                btn.addEventListener('mouseenter', openMenu);
                btn.addEventListener('mouseleave', closeMenu);
                menu.addEventListener('mouseenter', openMenu);
                menu.addEventListener('mouseleave', closeMenu);
            } else {
                btn.addEventListener('click', toggleMenu);
            }
        });

        // ✅ FIXED: Remove auto-reload on resize
        window.addEventListener('resize', () => {
            // Optional: Add resize handling logic here if needed
            console.log('Window resized - dropdown behaviors maintained');
        });
    }

    // ===============================
    // BURGER MENU (Mobile Nav) - UPDATED WITH AUTO-CLOSE
    // ===============================
    const menuBtn = document.getElementById("menu-btn");
    const mobileMenu = document.getElementById("mobileMenu");
    const menuOverlay = document.getElementById("menu-overlay");
    const closeMenu = document.getElementById("close-menu");

    if (menuBtn && mobileMenu && menuOverlay && closeMenu) {
        function toggleMenu() {
            menuBtn.classList.toggle("active");
            mobileMenu.classList.toggle("!right-0");
            menuOverlay.classList.toggle("opacity-100");
            menuOverlay.classList.toggle("visible");
            document.body.style.overflow = mobileMenu.classList.contains("!right-0") ? "hidden" : "";
        }

        function closeMobileMenu() {
            menuBtn.classList.remove("active");
            mobileMenu.classList.remove("!right-0");
            menuOverlay.classList.remove("opacity-100", "visible");
            document.body.style.overflow = "";
        }

        menuBtn.addEventListener("click", toggleMenu);
        closeMenu.addEventListener("click", closeMobileMenu);
        menuOverlay.addEventListener("click", closeMobileMenu);

        // AUTO-CLOSE MOBILE MENU WHEN NAV LINKS ARE CLICKED
        const mobileNavLinks = mobileMenu.querySelectorAll('a');
        mobileNavLinks.forEach(link => {
            link.addEventListener('click', (e) => {
                // Don't close for dropdown toggles
                if (link.parentElement.classList.contains('mobile-dropdown') ||
                    link.classList.contains('shop-toggle')) {
                    return;
                }

                // Don't close for search buttons
                if (link.classList.contains('searchBtn2')) {
                    return;
                }

                // Close mobile menu for regular navigation links
                setTimeout(closeMobileMenu, 100);
            });
        });

        // Handle About link specifically
        const aboutLinks = document.querySelectorAll('.about-nav-link, a[href="#about-section"]');
        aboutLinks.forEach(link => {
            link.addEventListener('click', (e) => {
                if (mobileMenu.classList.contains('!right-0')) {
                    closeMobileMenu();
                }
            });
        });
    }

    // ===============================
    // MOBILE SIDEBAR DROPDOWN
    // ===============================
    const mobileDropdowns = document.querySelectorAll(".mobile-dropdown button");
    if (mobileDropdowns.length > 0) {
        mobileDropdowns.forEach(btn => {
            btn.addEventListener("click", () => {
                btn.nextElementSibling.classList.toggle("max-h-0");
                btn.nextElementSibling.classList.toggle("max-h-48");

                const icon = btn.querySelector('i');
                if (icon) icon.classList.toggle("rotate-180"); // ✅ icon rotates in sidebar too
            });
        });
    }

    // ===============================
    // OFFER SECTION CAROUSEL 
    // ===============================
    const offerSlides = document.querySelectorAll('#offerTrack > div');
    const prevBtn = document.getElementById('prevOffer');
    const nextBtn = document.getElementById('nextOffer');
    const toggleBtn = document.getElementById('toggleAutoplay');

    if (offerSlides.length > 0 && prevBtn && nextBtn && toggleBtn) {
        let index = 0;
        const slideCount = offerSlides.length;
        const autoplayInterval = 3000; // Timing control
        let autoplay = true;
        let autoplayTimer = null;

        function showSlide(i) {
            index = ((i % slideCount) + slideCount) % slideCount;
            offerSlides.forEach((slide, idx) => {
                if (idx === index) {
                    // Use CSS classes instead of inline styles
                    slide.classList.remove('opacity-0', 'z-0');
                    slide.classList.add('opacity-100', 'z-10', 'scale-105');
                } else {
                    slide.classList.remove('opacity-100', 'z-10', 'scale-105');
                    slide.classList.add('opacity-0', 'z-0');
                }
            });
        }

        function startAutoplay() {
            stopAutoplay();
            autoplayTimer = setInterval(() => showSlide(index + 1), autoplayInterval);
        }

        function stopAutoplay() {
            if (autoplayTimer) clearInterval(autoplayTimer);
            autoplayTimer = null;
        }

        prevBtn.addEventListener('click', () => { showSlide(index - 1); resetAutoplay(); });
        nextBtn.addEventListener('click', () => { showSlide(index + 1); resetAutoplay(); });
        toggleBtn.addEventListener('click', () => {
            if (autoplay) {
                stopAutoplay();
                toggleBtn.innerHTML = "<i class='bx bx-play text-xl'></i>";
                autoplay = false;
            } else {
                startAutoplay();
                toggleBtn.innerHTML = "<i class='bx bx-pause text-xl'></i>";
                autoplay = true;
            }
        });

        function resetAutoplay() { stopAutoplay(); startAutoplay(); }

        showSlide(0);
        startAutoplay();
    }

    // ===============================
    // Video-Com pop up
    // ===============================
    const videoCards = document.querySelectorAll(".video-card");
    const videoModal = document.getElementById("videoModal");
    const videoFrame = document.getElementById("videoFrame");
    const closeModal = document.getElementById("closeModal");

    const productName = document.getElementById("productName");
    const productPrice = document.getElementById("productPrice");

    // Thumbnail click
    if (videoCards.length > 0 && videoModal && videoFrame) {
        videoCards.forEach((card) => {
            card.addEventListener("click", () => {
                const videoUrl = card.getAttribute("data-video") || "https://www.youtube.com/embed/tgbNymZ7vqY";
                const name = card.getAttribute("data-name") || "Sample Product";
                const price = card.getAttribute("data-price") || "₹999";

                videoFrame.src = videoUrl + "?autoplay=1";
                productName.textContent = name;
                productPrice.textContent = price;

                videoModal.classList.remove("hidden");
            });
        });

        // Close modal
        closeModal.addEventListener("click", (e) => {
            e.stopPropagation();
            videoModal.classList.add("hidden");
            videoFrame.src = "";
        });

        // Close when clicking outside
        videoModal.addEventListener("click", (e) => {
            if (e.target === videoModal) {
                videoModal.classList.add("hidden");
                videoFrame.src = "";
            }
        });
    }

    // ===============================
    // product category
    // ===============================
    const menuTabs = document.getElementById('menu-tabs');
    if (menuTabs) {
        const tabs = Array.from(menuTabs.getElementsByClassName('tab-button'));
        const sections = document.querySelectorAll('.menu-section');

        // Highlight tab and show section
        function updateActiveTab(activeTab) {
            tabs.forEach(tab => tab.classList.remove('active'));
            if (!activeTab) return;
            activeTab.classList.add('active');
            sections.forEach(sec => sec.classList.toggle('hidden', sec.id !== activeTab.dataset.section));
        }

        // Center a tab
        function centerTab(tab) {
            if (!tab) return;
            const containerWidth = menuTabs.clientWidth;
            const tabCenter = tab.offsetLeft + tab.offsetWidth / 2;
            let targetScroll = tabCenter - containerWidth / 2;
            menuTabs.scrollTo({ left: targetScroll, behavior: 'smooth' });
            updateActiveTab(tab);
        }

        // Click to center
        tabs.forEach(tab => tab.addEventListener('click', () => centerTab(tab)));

        // Drag scrolling
        let isDown = false, startX, scrollLeft;
        menuTabs.addEventListener('mousedown', e => {
            isDown = true;
            menuTabs.classList.add('cursor-grabbing');
            startX = e.pageX - menuTabs.offsetLeft;
            scrollLeft = menuTabs.scrollLeft;
        });
        menuTabs.addEventListener('mouseleave', () => isDown = false);
        menuTabs.addEventListener('mouseup', () => isDown = false);
        menuTabs.addEventListener('mousemove', e => {
            if (!isDown) return;
            e.preventDefault();
            const x = e.pageX - menuTabs.offsetLeft;
            const walk = (x - startX) * 2;
            menuTabs.scrollLeft = scrollLeft - walk;
        });

        // Snap closest tab after scroll
        let scrollTimeout;
        menuTabs.addEventListener('scroll', () => {
            if (scrollTimeout) clearTimeout(scrollTimeout);
            scrollTimeout = setTimeout(() => {
                const containerCenter = menuTabs.scrollLeft + menuTabs.clientWidth / 2;
                let closestTab = tabs[0];
                let minDistance = Infinity;
                tabs.forEach(tab => {
                    const tabCenter = tab.offsetLeft + tab.offsetWidth / 2;
                    const distance = Math.abs(containerCenter - tabCenter);
                    if (distance < minDistance) { minDistance = distance; closestTab = tab; }
                });
                centerTab(closestTab);
            }, 100);
        });

        // Initialize first tab
        centerTab(tabs[0]);
    }

    // ===============================================
    // product Image View For Thumbail To Main Image 
    // ===============================================
    const mainImage = document.getElementById('mainProductImage');
    const thumbnails = document.querySelectorAll('.thumbnail');

    if (mainImage && thumbnails.length > 0) {
        thumbnails.forEach(thumbnail => {
            thumbnail.addEventListener('click', () => {
                // Change main image
                mainImage.src = thumbnail.src;

                // Remove border from all thumbnails
                thumbnails.forEach(img => img.classList.remove('border-pink-500'));
                thumbnails.forEach(img => img.classList.add('border-gray-200'));

                // Highlight selected thumbnail
                thumbnail.classList.add('border-pink-500');
                thumbnail.classList.remove('border-gray-200');
            });
        });
    }

    // ===============================================
    // Report Product Form Pop Up 
    // ===============================================
    const reportBtn = document.querySelector('.report-btn');
    const reportModal = document.getElementById('reportModal');
    const closeReportModal = document.getElementById('closeReportModal');
    const reportForm = document.getElementById('reportForm');

    if (reportBtn && reportModal && closeReportModal && reportForm) {
        // Open Modal
        reportBtn.addEventListener('click', () => {
            reportModal.classList.remove('opacity-0', 'invisible');
            reportModal.classList.add('opacity-100', 'visible');
        });

        // Close Modal
        closeReportModal.addEventListener('click', () => {
            reportModal.classList.add('opacity-0', 'invisible');
            reportModal.classList.remove('opacity-100', 'visible');
        });

        // Submit Form
        reportForm.addEventListener('submit', (e) => {
            e.preventDefault();
            alert('Report submitted successfully!');
            reportModal.classList.add('opacity-0', 'invisible');
            reportModal.classList.remove('opacity-100', 'visible');
            reportForm.reset();
        });

        // Close modal on clicking outside
        reportModal.addEventListener('click', (e) => {
            if (e.target === reportModal) {
                reportModal.classList.add('opacity-0', 'invisible');
                reportModal.classList.remove('opacity-100', 'visible');
            }
        });
    }

    // ===============================
    // SEARCH FUNCTIONALITY - ADDED TO PREVENT CONFLICTS
    // ===============================
    // Desktop Search
    const searchBtn = document.querySelector('.searchBtn');
    const searchInput = document.querySelector('.searchInput');
    if (searchBtn && searchInput) {
        searchBtn.addEventListener('click', (e) => {
            e.preventDefault();
            let url = '<?= $storeUrl ?>search/' + searchInput.value;
            if (searchInput.value !== "") window.location.href = url;
        });

        searchInput.addEventListener('keypress', (e) => {
            if (e.which === 13) {
                e.preventDefault();
                let url = '<?= $storeUrl ?>search/' + searchInput.value;
                if (searchInput.value !== "") window.location.href = url;
            }
        });
    }

    // Mobile Search Overlay
    const searchToggle = document.getElementById("mobileSearchToggle");
    const searchOverlay = document.getElementById("mobileSearchOverlay");
    const searchClose = document.getElementById("mobileSearchClose");
    const searchInputMobile = document.querySelector(".searchInputMobile");

    if (searchToggle && searchOverlay && searchClose && searchInputMobile) {
        // Open search overlay (slide down)
        searchToggle.addEventListener("click", () => {
            searchOverlay.classList.remove("hidden");
            setTimeout(() => {
                searchOverlay.classList.remove("-translate-y-full");
                if (searchInputMobile) searchInputMobile.focus();
            }, 10);
        });

        // Close search overlay (slide up)
        searchClose.addEventListener("click", () => {
            searchOverlay.classList.add("-translate-y-full");
            setTimeout(() => {
                searchOverlay.classList.add("hidden");
                if (searchInputMobile) searchInputMobile.value = "";
            }, 500);
        });

        // Close search overlay when clicking outside
        searchOverlay.addEventListener('click', function (e) {
            if (e.target === this) {
                searchOverlay.classList.add("-translate-y-full");
                setTimeout(() => {
                    searchOverlay.classList.add("hidden");
                    if (searchInputMobile) searchInputMobile.value = "";
                }, 500);
            }
        });

        // Enter key for mobile search
        searchInputMobile.addEventListener('keypress', (e) => {
            if (e.which === 13) {
                e.preventDefault();
                let url = '<?= $storeUrl ?>search/' + searchInputMobile.value;
                if (searchInputMobile.value !== "") window.location.href = url;
            }
        });
    }
});