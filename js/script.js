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

        // Update on resize
        window.addEventListener('resize', () => location.reload());
    }

    // ===============================
    // BURGER MENU (Mobile Nav)
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

        menuBtn.addEventListener("click", toggleMenu);
        closeMenu.addEventListener("click", toggleMenu);
        menuOverlay.addEventListener("click", toggleMenu);
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
    // SLIDER
    // ===============================
    const slides = document.querySelectorAll(".slide");
    const dotsContainer = document.getElementById("dots");
    if (slides.length > 0 && dotsContainer) {
        let index = 0;
        let slideInterval;
        const duration = 4000;

        slides.forEach((_, i) => {
            const dot = document.createElement("div");
            dot.className = "w-3 h-3 rounded-full bg-white/60 cursor-pointer relative overflow-hidden";
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
    }

    // ===============================
    // CATEGORY ITEMS ANIMATION
    // ===============================
    const categoryItems = document.querySelectorAll('.group');
    if (categoryItems.length > 0) {
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

            item.addEventListener('click', function () {
                this.style.transform = 'scale(0.98)';
                setTimeout(() => {
                    this.style.transform = '';
                }, 200);
                console.log('Category clicked:', this.querySelector('h3')?.textContent);
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
        const autoplayInterval = 3000;
        let autoplay = true;
        let autoplayTimer = null;

        function showSlide(i) {
            index = ((i % slideCount) + slideCount) % slideCount;
            offerSlides.forEach((slide, idx) => {
                if (idx === index) {
                    slide.style.opacity = '1';
                    slide.style.transform = 'scale(1.05)';
                    slide.style.zIndex = '10';
                } else {
                    slide.style.opacity = '0';
                    slide.style.transform = 'scale(0.95)';
                    slide.style.zIndex = '1';
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
});



//------------------------js For Video-Com pop up---------------------------------------

document.addEventListener("DOMContentLoaded", () => {
    const videoCards = document.querySelectorAll(".video-card");
    const videoModal = document.getElementById("videoModal");
    const videoFrame = document.getElementById("videoFrame");
    const closeModal = document.getElementById("closeModal");

    const productName = document.getElementById("productName");
    const productPrice = document.getElementById("productPrice");

    // Thumbnail click
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
});




//--------------------------------------------------------------------------
// ---------- Tab Scroll + Zoom + Section Sync ----------
(function () {
    const menuTabs = document.getElementById('menu-tabs');
    const tabs = Array.from(menuTabs.children);
    const sections = document.querySelectorAll('.menu-section');

    let isDragging = false, wasDragging = false, startX = 0, scrollLeft = 0, scrollAnimationId = null;

    function init() {
        centerTab(tabs[0], false);
        setupListeners();
    }

    function setupListeners() {
        menuTabs.addEventListener('mousedown', dragStart);
        menuTabs.addEventListener('mousemove', dragMove);
        menuTabs.addEventListener('mouseup', dragEnd);
        menuTabs.addEventListener('mouseleave', dragEnd);
        menuTabs.addEventListener('click', tabClick);
        menuTabs.addEventListener('scroll', () => requestAnimationFrame(updateZoom));
    }

    function centerTab(tab, animate = true) {
        if (!tab || !tab.dataset.section) return;
        if (scrollAnimationId) cancelAnimationFrame(scrollAnimationId);

        const containerWidth = menuTabs.clientWidth;
        const tabWidth = tab.offsetWidth;
        const tabOffset = tab.offsetLeft;
        const currentScroll = menuTabs.scrollLeft;
        const maxScroll = menuTabs.scrollWidth - containerWidth;

        let targetScroll = tabOffset - (containerWidth / 2) + (tabWidth / 2);
        targetScroll = Math.max(0, Math.min(targetScroll, maxScroll));

        if (animate) {
            const startTime = performance.now();
            const duration = 300;
            const distance = targetScroll - currentScroll;

            function animateScroll(timestamp) {
                const elapsed = timestamp - startTime;
                const progress = Math.min(elapsed / duration, 1);
                menuTabs.scrollLeft = currentScroll + distance * easeOutQuad(progress);

                if (progress < 1) {
                    scrollAnimationId = requestAnimationFrame(animateScroll);
                } else {
                    updateActiveTab();
                }
            }

            scrollAnimationId = requestAnimationFrame(animateScroll);
        } else {
            menuTabs.scrollLeft = targetScroll;
            updateActiveTab();
        }
    }

    function updateActiveTab() {
        const containerCenter = menuTabs.getBoundingClientRect().left + menuTabs.clientWidth / 2;
        let closestTab = null, minDistance = Infinity;

        tabs.forEach(tab => {
            const rect = tab.getBoundingClientRect();
            const tabCenter = rect.left + rect.width / 2;
            const distance = Math.abs(containerCenter - tabCenter);
            tab.classList.remove('zoomed');

            if (distance < minDistance) {
                minDistance = distance;
                closestTab = tab;
            }
        });

        if (closestTab) {
            closestTab.classList.add('zoomed');
            showSection(closestTab.dataset.section);
        }
    }

    function showSection(sectionId) {
        sections.forEach(sec => {
            sec.style.display = sec.id === sectionId ? 'block' : 'none';
        });
    }

    function easeOutQuad(t) {
        return t * (2 - t);
    }

    function dragStart(e) {
        isDragging = true; wasDragging = false;
        startX = e.pageX - menuTabs.offsetLeft;
        scrollLeft = menuTabs.scrollLeft;
        if (scrollAnimationId) cancelAnimationFrame(scrollAnimationId);
    }

    function dragMove(e) {
        if (!isDragging) return;
        wasDragging = true;
        const x = e.pageX - menuTabs.offsetLeft;
        menuTabs.scrollLeft = scrollLeft - (x - startX) * 1.5;
    }

    function dragEnd() {
        isDragging = false;
        if (wasDragging) setTimeout(updateActiveTab, 100);
    }

    function tabClick(e) {
        if (wasDragging) { wasDragging = false; return; }
        const clickedTab = e.target.closest('.tab-button');
        if (clickedTab && clickedTab.dataset.section) centerTab(clickedTab);
    }

    // Zoom effect based on scroll center
    function updateZoom() {
        const containerRect = menuTabs.getBoundingClientRect();
        const containerCenter = containerRect.left + containerRect.width / 2;

        tabs.forEach(btn => {
            const rect = btn.getBoundingClientRect();
            const btnCenter = rect.left + rect.width / 2;
            const distance = Math.abs(containerCenter - btnCenter);
            const maxDistance = containerRect.width / 2;
            const t = Math.max(0, 1 - distance / maxDistance);
            const scale = 1 + t * 0.25;
            const zIndex = Math.round(1 + t * 10);

            btn.style.transform = `scale(${scale})`;
            btn.style.zIndex = zIndex;
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();


