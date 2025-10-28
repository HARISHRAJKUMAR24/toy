<?php include_once __DIR__ . "/includes/files_includes.php"; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include_once __DIR__ . "/includes/head_links.php"; ?>
    <style>
        :root {
            --primary: <?= htmlspecialchars(getData("color", "seller_settings", "(seller_id='$sellerId' AND store_id='$storeId')") ?? '#ff007f') ?>;
        }

        /*<==========> Enhanced CSS Styles <==========>*/

        /*------------- Smooth Animations -------------*/
        * {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /*------------- Spin Animation For Shop By Age Image Border -------------*/
        @layer utilities {
            .animate-spin-slow {
                animation: spin 18s linear infinite;
            }
        }

        /*------------- Hide Scroll Bars -------------*/
        .scroll-container::-webkit-scrollbar,
        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        /*------------- Product Category Styles -------------*/
        .tab-button {
            position: relative;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            margin-top: 10px;
        }

        .tab-button::before {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 50%;
            width: 0;
            height: 3px;
            background: linear-gradient(135deg, var(--primary), #f97316);
            border-radius: 2px;
            transform: translateX(-50%);
            transition: width 0.3s ease;
        }

        .tab-button.active::before {
            width: 40px;
        }

        .tab-img {
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .tab-button span {
            display: inline-block;
            transition: all 0.5s ease;
        }

        .tab-button img {
            transition: all 0.5s ease;
        }

        /*------------- Product Category Active Styles -------------*/
        .tab-button.active .tab-img {
            border-color: var(--primary);
            box-shadow: 0 8px 25px color-mix(in srgb, var(--primary) 30%, transparent);
            transform: scale(1.08) rotate(5deg);
        }

        .tab-button.active img {
            transform: scale(1.05);
        }

        .tab-button.active span {
            color: var(--primary);
            font-weight: 700;
            transform: scale(1.03);
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        /*------------- Gradient Text -------------*/
        .gradient-text {
            background: linear-gradient(135deg, var(--primary), #f97316);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /*------------- Product Display Container Margins -------------*/
        .product-display-container {
            margin-top: 2rem;
            margin-bottom: 2rem;
        }
    </style>
</head>

<body class="font-sans min-h-screen overflow-x-hidden bg-gradient-to-br from-gray-50 to-gray-100" style="--primary: <?= htmlspecialchars(getData('color', 'seller_settings', "(seller_id='$sellerId' AND store_id='$storeId')") ?? '#ff007f') ?>;">
    <!-- Minimum Order Amount Start-->
    <?php if (!empty(getSettings("minimum_order_amount"))) : ?>
        <?php
        $primary_color = getData("color", "seller_settings", "(seller_id='$sellerId' AND store_id='$storeId')") ?? '#ff007f';
        $hover_color = getData("hover_color", "seller_settings", "(seller_id='$sellerId' AND store_id='$storeId')") ?? '#ec4899';
        ?>
        <div class="w-full text-white text-center py-1.5 sm:py-2 md:py-2.5 lg:py-2 text-sm sm:text-base md:text-lg lg:text-base font-semibold transition-all duration-500 ease-out cursor-pointer"
            style="background: linear-gradient(90deg, color-mix(in srgb, <?= htmlspecialchars($primary_color) ?> 95%, transparent) 0%, color-mix(in srgb, <?= htmlspecialchars($hover_color) ?> 90%, transparent) 100%);"
            onmouseover="this.style.background='linear-gradient(90deg, color-mix(in srgb, <?= htmlspecialchars($hover_color) ?> 98%, transparent) 0%, color-mix(in srgb, <?= htmlspecialchars($primary_color) ?> 95%, transparent) 100%)'; this.style.transform='scale(1.01) translateY(-1px)'; this.style.boxShadow='0 4px 12px rgba(0,0,0,0.15)';"
            onmouseout="this.style.background='linear-gradient(90deg, color-mix(in srgb, <?= htmlspecialchars($primary_color) ?> 95%, transparent) 0%, color-mix(in srgb, <?= htmlspecialchars($hover_color) ?> 90%, transparent) 100%)'; this.style.transform='scale(1) translateY(0)'; this.style.boxShadow='none';">
            Minimum Order: <?= currencyToSymbol($storeCurrency) . ' ' . getSettings("minimum_order_amount") ?>
        </div>
    <?php endif; ?>
    <!-- Minimum Order Amount End-->

    <!-- Navigation -->
    <?php include_once __DIR__ . "/includes/navbar.php"; ?>

    <!--Shop By Age Start-->
    <?php
    // Fetch advanced categories
    $advance_categories = [];
    for ($i = 1; $i <= 6; $i++) {
        $name = getData("advance_category_name_$i", "seller_banners", "seller_id = '$sellerId' AND store_id = '$storeId'");
        $link = getData("advance_category_link_$i", "seller_banners", "seller_id = '$sellerId' AND store_id = '$storeId'");
        $image = getData("advance_category_image_$i", "seller_banners", "seller_id = '$sellerId' AND store_id = '$storeId'");

        if (!empty($image)) { // Require only image
            $advance_categories[] = [
                'name' => $name, // Can be empty
                'link' => $link,
                'image' => $image
            ];
        }
    }

    // Only show section if there is at least 1 image
    if (!empty($advance_categories)) :
    ?>

        <!--Shop By Age Start-->
        <section class="py-12 animate-gradient-x">
            <div class="max-w-6xl mx-auto px-4">
                <!--Heading - SAME SIZE AS SHOP BY CATEGORY -->
                <?php
                $main_heading = getData("advance_category_main_heading", "seller_banners", "seller_id = '$sellerId' AND store_id = '$storeId'");
                $primary_color = getData("color", "seller_settings", "(seller_id='$sellerId' AND store_id='$storeId')") ?? '#ff007f';
                $hover_color = getData("hover_color", "seller_settings", "(seller_id='$sellerId' AND store_id='$storeId')") ?? '#ec4899';
                ?>
                <?php if (!empty($main_heading)) : ?>
                    <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-800 mb-1 text-center">
                        <?= htmlspecialchars($main_heading) ?>
                    </h2>
                    <p class="text-base sm:text-lg md:text-xl text-gray-600 max-w-2xl mx-auto text-center mb-4">
                        Discover our carefully curated collections tailored just for you
                    </p>
                <?php endif; ?>

                <!-- Scroll Container - FIXED: Center on desktop, scroll on mobile -->
                <div class="scroll-container overflow-x-auto pb-4 px-4 md:px-6 lg:px-0 -mx-4 lg:mx-0 hide-scrollbar">
                    <div class="flex flex-nowrap justify-center lg:justify-center gap-6 md:gap-8 min-w-min">
                        <!-- CHANGED: justify-center on all screens -->

                        <?php foreach ($advance_categories as $index => $category) :
                            // Use dynamic colors from database instead of fixed colors
                            $border_color = $index % 2 == 0 ? $primary_color : $hover_color;
                            $bg_color = $index % 2 == 0 ? $hover_color : $primary_color;
                        ?>
                            <div class="relative w-32 h-32 flex-shrink-0 group">
                                <!-- Spinning border with dynamic color and increased opacity -->
                                <div class="absolute inset-0 rounded-full border-4 border-dashed animate-spin-slow opacity-80 group-hover:opacity-100 transition-opacity duration-300"
                                    style="border-color: <?= htmlspecialchars($border_color) ?>;"></div>
                                <!-- Image circle -->
                                <div class="relative w-28 h-28 rounded-full overflow-hidden shadow-lg mx-auto top-2 bg-white flex items-center justify-center border-2 border-gray-300 group-hover:shadow-xl transition-all duration-300">
                                    <?php if (!empty($category['link'])): ?>
                                        <a href="<?= $category['link'] ?>" target="_blank" class="block w-full h-full flex items-center justify-center">
                                            <img src="<?= UPLOADS_URL . $category['image'] ?>"
                                                alt="<?= htmlspecialchars($category['name']) ?>"
                                                class="w-full h-full object-cover object-center transition-transform duration-300 group-hover:scale-110">
                                        </a>
                                    <?php else: ?>
                                        <img src="<?= UPLOADS_URL . $category['image'] ?>"
                                            alt="<?= htmlspecialchars($category['name']) ?>"
                                            class="w-full h-full object-cover object-center transition-transform duration-300 group-hover:scale-110">
                                    <?php endif; ?>
                                </div>
                                <!-- Category Name Box with dynamic background color and increased opacity -->
                                <?php if (!empty($category['name'])): ?>
                                    <div class="absolute -bottom-3 left-1/2 transform -translate-x-1/2 px-2 py-0.5 text-white text-sm font-semibold rounded-md shadow-lg text-center break-words max-w-[90%] border border-white/30 transition-all duration-300 hover:scale-105 opacity-95 group-hover:opacity-100"
                                        style="background-color: <?= htmlspecialchars($bg_color) ?>;"
                                        onmouseover="this.style.backgroundColor='<?= htmlspecialchars($primary_color) ?>'; this.style.opacity='1'"
                                        onmouseout="this.style.backgroundColor='<?= htmlspecialchars($bg_color) ?>'; this.style.opacity='0.95'">
                                        <?= htmlspecialchars($category['name']) ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>

                    </div>
                </div>
            </div>
        </section>

        <style>
            .animate-gradient-x {
                background: linear-gradient(-45deg,
                        color-mix(in srgb, <?= htmlspecialchars($primary_color) ?> 25%, white),
                        /* Increased from 15% */
                        color-mix(in srgb, <?= htmlspecialchars($hover_color) ?> 22%, white),
                        /* Increased from 12% */
                        color-mix(in srgb, <?= htmlspecialchars($primary_color) ?> 20%, white),
                        /* Increased from 10% */
                        color-mix(in srgb, <?= htmlspecialchars($hover_color) ?> 18%, white)
                        /* Increased from 8% */
                    );
                background-size: 400% 400%;
                animation: gradient 8s ease infinite;
                position: relative;
                overflow: hidden;
            }

            .animate-gradient-x::before {
                content: '';
                position: absolute;
                top: 0;
                left: -100%;
                width: 100%;
                height: 100%;
                background: linear-gradient(90deg,
                        transparent,
                        rgba(255, 255, 255, 0.6),
                        /* Increased from 0.4 */
                        transparent);
                animation: shimmer 3s infinite;
                opacity: 0.7;
                /* Added opacity for better blending */
            }

            @keyframes gradient {
                0% {
                    background-position: 0% 50%;
                }

                50% {
                    background-position: 100% 50%;
                }

                100% {
                    background-position: 0% 50%;
                }
            }

            @keyframes shimmer {
                0% {
                    left: -100%;
                }

                100% {
                    left: 100%;
                }
            }

            /* Enhanced spin animation with dynamic colors */
            @keyframes spin-slow {
                from {
                    transform: rotate(0deg);
                }

                to {
                    transform: rotate(360deg);
                }
            }

            .animate-spin-slow {
                animation: spin-slow 18s linear infinite;
            }

            /* Hover effects for the entire section with increased opacity */
            .animate-gradient-x:hover {
                background: linear-gradient(-45deg,
                        color-mix(in srgb, <?= htmlspecialchars($hover_color) ?> 28%, white),
                        /* Increased from 18% */
                        color-mix(in srgb, <?= htmlspecialchars($primary_color) ?> 25%, white),
                        /* Increased from 15% */
                        color-mix(in srgb, <?= htmlspecialchars($hover_color) ?> 22%, white),
                        /* Increased from 12% */
                        color-mix(in srgb, <?= htmlspecialchars($primary_color) ?> 20%, white)
                        /* Increased from 10% */
                    );
                background-size: 400% 400%;
            }

            /* Enhanced hover effects for individual category items */
            .group:hover .animate-spin-slow {
                opacity: 1;
                border-width: 5px;
                /* Slightly thicker border on hover */
            }

            /* Ensure images fill the circle properly */
            .relative.w-28.h-28 img {
                min-width: 100%;
                min-height: 100%;
                transition: transform 0.3s ease;
            }

            /* Enhanced shadow effects */
            .relative.w-28.h-28 {
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
                /* Added shadow to image container */
            }

            .relative.w-28.h-28:hover {
                box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
                /* Enhanced shadow on hover */
            }

            /* Enhanced scroll container - hide scrollbar on desktop */
            .scroll-container {
                cursor: grab;
            }

            .scroll-container:active {
                cursor: grabbing;
            }

            /* Hide overflow and scrollbar on desktop */
            @media (min-width: 1024px) {
                .scroll-container {
                    overflow: hidden !important;
                }
            }

            /* Show scrolling on mobile */
            @media (max-width: 1023px) {
                .scroll-container {
                    overflow-x: auto !important;
                }
            }
        </style>
        <!--Shop By Age End-->
        <!--Shop By Age End-->

    <?php endif; ?>
    <!--Shop By Age End-->


    <?php
    // Product Category with new UI/UX Style
    $stmt = getCategories(); // pre-built function returning PDOStatement or false

    if ($stmt) {
        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC); // fetch as array
        $categories = array_reverse($categories);        // newest first
        $categories = array_slice($categories, 0, 10);   // limit to 10
    } else {
        $categories = [];
    }
    ?>

    <?php if (!empty($categories)) : ?>
        <!--Product Category Start -->
        <!-- UPDATED: Applied same padding as New Collections section -->
        <section class="py-16 bg-gray-50 md:px-4">
            <div class="container mx-auto md:max-w-none max-w-6xl px-4 md:px-20">

                <!-- Heading - UPDATED: Same structure as New Collections -->
                <div class="text-center mb-8">
                    <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-800 mb-1">Shop By Category</h2>
                    <p class="text-base sm:text-lg md:text-xl text-gray-600 max-w-2xl mx-auto">
                        Explore our diverse collection of products for all your needs
                    </p>
                </div>

                <!-- Scrollable Tabs -->
                <div id="menu-tabs"
                    class="flex overflow-x-auto snap-x snap-proximity gap-6 py-3 whitespace-nowrap hide-scrollbar cursor-grab px-[50%]">
                    <?php foreach ($categories as $index => $category) :
                        $catImage = !empty($category['icon']) ? UPLOADS_URL . $category['icon'] : 'https://via.placeholder.com/400x160?text=No+Image';
                    ?>
                        <button class="tab-button flex flex-col items-center cursor-pointer"
                            data-section="section<?= $index + 1 ?>"
                            data-category-id="<?= $category['id'] ?>">
                            <div class="tab-img w-24 h-24 rounded-2xl overflow-hidden border-4 border-white shadow-lg mb-4 group-hover:shadow-xl">
                                <img src="<?= $catImage ?>" alt="<?= $category['name'] ?>" class="w-full h-full object-cover transform group-hover:scale-105">
                            </div>
                            <span class="mt-2 text-sm font-medium text-gray-700"><?= $category['name'] ?></span>
                        </button>
                    <?php endforeach; ?>
                </div>

                <!-- Product Display Area - UPDATED: Same padding structure -->
                <div class="mt-12">
                    <!-- This is where products will be shown when category is clicked -->
                    <div id="product-display-area">
                        <!-- Default message - will be replaced when category is clicked -->
                        <div class="text-center py-16">
                            <div class="w-24 h-24 rounded-full flex items-center justify-center mb-4 mx-auto"
                                style="background-color: color-mix(in srgb, var(--primary) 20%, white);">
                                <i class="fas fa-shopping-bag text-3xl" style="color: var(--primary);"></i>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-800 mb-2">Select a Category</h3>
                            <p class="text-gray-500 mb-6 max-w-md mx-auto">Click on any category above to view products</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--Product Category End -->
    <?php endif; ?>

    <!-- Enhanced JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const menuTabs = document.getElementById('menu-tabs');
            const tabs = Array.from(menuTabs.getElementsByClassName('tab-button'));
            const productDisplayArea = document.getElementById('product-display-area');

            // Highlight tab and show products
            function updateActiveTab(activeTab) {
                tabs.forEach(tab => tab.classList.remove('active'));
                if (!activeTab) return;
                activeTab.classList.add('active');

                // Load products for this category
                const categoryId = activeTab.dataset.categoryId;
                const categoryName = activeTab.querySelector('span').textContent;
                loadCategoryProducts(categoryId, categoryName);
            }

            // Center a tab
            function centerTab(tab) {
                if (!tab) return;
                const containerWidth = menuTabs.clientWidth;
                const tabCenter = tab.offsetLeft + tab.offsetWidth / 2;
                let targetScroll = tabCenter - containerWidth / 2;
                menuTabs.scrollTo({
                    left: targetScroll,
                    behavior: 'smooth'
                });
                updateActiveTab(tab);
            }

            // Enhanced product counting
            function countRealProductsInHTML(html) {
                const tempDiv = document.createElement('div');
                tempDiv.innerHTML = html;
                const productElements = tempDiv.querySelectorAll('.gap-5, .addToCartBtn, [class*="group"]');
                return Array.from(productElements).filter(el =>
                    el.innerHTML.includes('product/') ||
                    el.innerHTML.includes('₹') ||
                    el.innerHTML.includes('addToCartBtn')
                ).length;
            }

            // Load products for a category
            function loadCategoryProducts(categoryId, categoryName) {
                // Show loading state
                productDisplayArea.innerHTML = `
                <div class="text-center py-16">
                    <div class="inline-block rounded-full h-8 w-8 border-b-2 mx-auto" style="border-color: var(--primary); animation: spin 1s linear infinite;"></div>
                    <p class="mt-4 text-gray-600 font-medium">Loading ${categoryName} products...</p>
                </div>
            `;

                // AJAX call to get products using your existing file
                $.ajax({
                    url: "shop/ajax/get-category-wise-product.php",
                    type: "POST",
                    data: {
                        page: 1, // Start from page 1
                        category: categoryId,
                        min_price: '',
                        max_price: '',
                        q: ''
                    },
                    success: function(response) {
                        const trimmed = response.trim();

                        if (trimmed && trimmed !== '') {
                            const productCount = countRealProductsInHTML(trimmed);

                            productDisplayArea.innerHTML = `
                            <div class="mb-6">
                                <h3 class="text-2xl font-bold text-gray-800 text-center">${categoryName} Products</h3>
                                <p class="text-gray-600 text-center mt-2">${productCount}+ amazing products waiting for you</p>
                            </div>
                            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4 gap-y-6 items-stretch">
                                ${trimmed}
                            </div>
                        `;
                        } else {
                            productDisplayArea.innerHTML = `
                            <div class="text-center py-16">
                                <div class="w-24 h-24 rounded-full flex items-center justify-center mb-4 mx-auto"
                                     style="background-color: color-mix(in srgb, var(--primary) 20%, white);">
                                    <i class="fas fa-shopping-bag text-3xl" style="color: var(--primary);"></i>
                                </div>
                                <h3 class="text-xl font-semibold text-gray-800 mb-2">No Products Found</h3>
                                <p class="text-gray-500 mb-6 max-w-md mx-auto">No products available in ${categoryName} category</p>
                            </div>
                        `;
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error loading products:', error);
                        productDisplayArea.innerHTML = `
                        <div class="text-center py-16">
                            <div class="w-24 h-24 rounded-full flex items-center justify-center mb-4 mx-auto"
                                 style="background-color: color-mix(in srgb, #ef4444 20%, white);">
                                <i class="fas fa-exclamation-triangle text-3xl" style="color: #ef4444;"></i>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-800 mb-2">Error Loading Products</h3>
                            <p class="text-gray-500 mb-6 max-w-md mx-auto">Unable to load products. Please try again.</p>
                        </div>
                    `;
                    }
                });
            }

            // Click to center and load products
            tabs.forEach(tab => tab.addEventListener('click', () => centerTab(tab)));

            // Drag scrolling
            let isDown = false,
                startX, scrollLeft;
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
                        if (distance < minDistance) {
                            minDistance = distance;
                            closestTab = tab;
                        }
                    });
                    centerTab(closestTab);
                }, 100);
            });

            // Initialize first tab on page load
            if (tabs.length > 0) {
                centerTab(tabs[0]);
            }
        });
        // Enhanced scrolling for Shop By Age section
        document.addEventListener('DOMContentLoaded', function() {
            const shopByAgeContainer = document.querySelector('.scroll-container');

            if (shopByAgeContainer) {
                let isDown = false;
                let startX;
                let scrollLeft;

                shopByAgeContainer.addEventListener('mousedown', (e) => {
                    isDown = true;
                    shopByAgeContainer.classList.add('cursor-grabbing');
                    startX = e.pageX - shopByAgeContainer.offsetLeft;
                    scrollLeft = shopByAgeContainer.scrollLeft;
                });

                shopByAgeContainer.addEventListener('mouseleave', () => {
                    isDown = false;
                    shopByAgeContainer.classList.remove('cursor-grabbing');
                });

                shopByAgeContainer.addEventListener('mouseup', () => {
                    isDown = false;
                    shopByAgeContainer.classList.remove('cursor-grabbing');
                });

                shopByAgeContainer.addEventListener('mousemove', (e) => {
                    if (!isDown) return;
                    e.preventDefault();
                    const x = e.pageX - shopByAgeContainer.offsetLeft;
                    const walk = (x - startX) * 2; // Scroll-fast
                    shopByAgeContainer.scrollLeft = scrollLeft - walk;
                });

                // Touch support for mobile
                shopByAgeContainer.addEventListener('touchstart', (e) => {
                    isDown = true;
                    startX = e.touches[0].pageX - shopByAgeContainer.offsetLeft;
                    scrollLeft = shopByAgeContainer.scrollLeft;
                });

                shopByAgeContainer.addEventListener('touchend', () => {
                    isDown = false;
                });

                shopByAgeContainer.addEventListener('touchmove', (e) => {
                    if (!isDown) return;
                    const x = e.touches[0].pageX - shopByAgeContainer.offsetLeft;
                    const walk = (x - startX) * 2;
                    shopByAgeContainer.scrollLeft = scrollLeft - walk;
                });
            }
        });
    </script>

    <!-- Footer -->
    <?php include_once __DIR__ . "/includes/footer.php"; ?>

</body>

</html>