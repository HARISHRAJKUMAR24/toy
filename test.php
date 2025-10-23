<?php include_once __DIR__ . "/includes/files_includes.php"; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include_once __DIR__ . "/includes/head_links.php"; ?>
    <style>
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
            
            @keyframes float {
                0%, 100% { transform: translateY(0px); }
                50% { transform: translateY(-10px); }
            }
            .animate-float {
                animation: float 3s ease-in-out infinite;
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

        /*------------- Enhanced Category Tabs -------------*/
        .tab-button {
            position: relative;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .tab-button::before {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 50%;
            width: 0;
            height: 3px;
            background: linear-gradient(135deg, #ec4899, #f97316);
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

        .tab-button.active .tab-img {
            border-color: #ec4899;
            box-shadow: 0 8px 25px rgba(236, 72, 153, 0.3);
            transform: scale(1.15) rotate(5deg);
        }

        .tab-button.active img {
            transform: scale(1.1);
        }

        .tab-button.active span {
            color: #ec4899;
            font-weight: 700;
            transform: scale(1.05);
            text-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        /*------------- Enhanced Loading States -------------*/
        .loading-pulse {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }

        /*------------- Glass Morphism Effects -------------*/
        .glass-effect {
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }

        /*------------- Floating Animation -------------*/
        .hover-lift:hover {
            transform: translateY(-8px);
        }

        /*------------- Gradient Text -------------*/
        .gradient-text {
            background: linear-gradient(135deg, #ec4899, #f97316);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /*------------- Smooth Shadow Transitions -------------*/
        .shadow-glow {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        .shadow-glow:hover {
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
    </style>
</head>

<body class="font-sans min-h-screen overflow-x-hidden bg-gradient-to-br from-gray-50 to-gray-100">

    <!-- Minimum Order Amount -->
    <div class="w-full bg-gradient-to-r from-pink-600 to-pink-500 text-white text-center py-2 text-sm font-semibold shadow-lg">
        <div class="container mx-auto px-4">
            <i class="fas fa-tag mr-2"></i>
            Minimum Order: ₹499
        </div>
    </div>

    <!-- Navigation -->
    <?php include_once __DIR__ . "/includes/navbar.php"; ?>

    <!-- Shop By Age Section -->
    <?php
    // Fetch advanced categories
    $advance_categories = [];
    for ($i = 1; $i <= 6; $i++) {
        $name = getData("advance_category_name_$i", "seller_banners", "seller_id = '$sellerId' AND store_id = '$storeId'");
        $link = getData("advance_category_link_$i", "seller_banners", "seller_id = '$sellerId' AND store_id = '$storeId'");
        $image = getData("advance_category_image_$i", "seller_banners", "seller_id = '$sellerId' AND store_id = '$storeId'");

        if (!empty($image)) {
            $advance_categories[] = [
                'name' => $name,
                'link' => $link,
                'image' => $image
            ];
        }
    }

    if (!empty($advance_categories)) :
    ?>
        <section class="py-16 bg-gradient-to-br from-white to-gray-50">
            <div class="max-w-7xl mx-auto px-4">
                <!-- Heading -->
                <?php $main_heading = getData("advance_category_main_heading", "seller_banners", "seller_id = '$sellerId' AND store_id = '$storeId'"); ?>
                <?php if (!empty($main_heading)) : ?>
                    <div class="text-center mb-12">
                        <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold text-gray-800 mb-4">
                            <?= htmlspecialchars($main_heading) ?>
                        </h2>
                        <div class="w-24 h-1 bg-gradient-to-r from-pink-500 to-orange-500 mx-auto rounded-full"></div>
                    </div>
                <?php endif; ?>

                <!-- Categories Grid -->
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-8 max-w-4xl mx-auto">
                    <?php foreach ($advance_categories as $index => $category) : 
                        $colors = [
                            ['from' => 'pink-400', 'to' => 'pink-600'],
                            ['from' => 'blue-400', 'to' => 'blue-600'],
                            ['from' => 'green-400', 'to' => 'green-600'],
                            ['from' => 'yellow-400', 'to' => 'yellow-600'],
                            ['from' => 'purple-400', 'to' => 'purple-600'],
                            ['from' => 'indigo-400', 'to' => 'indigo-600']
                        ];
                        $color = $colors[$index % count($colors)];
                    ?>
                        <div class="text-center group">
                            <div class="relative inline-block mb-3">
                                <!-- Animated Border -->
                                <div class="absolute inset-0 rounded-full bg-gradient-to-r from-<?= $color['from'] ?> to-<?= $color['to'] ?> animate-spin-slow opacity-75"></div>
                                <!-- Main Circle -->
                                <div class="relative w-20 h-20 rounded-full overflow-hidden shadow-lg bg-white group-hover:shadow-xl transition-all duration-500 mx-auto border-4 border-white">
                                    <?php if (!empty($category['link'])): ?>
                                        <a href="<?= $category['link'] ?>" class="block w-full h-full">
                                            <img src="<?= UPLOADS_URL . $category['image'] ?>" alt="<?= htmlspecialchars($category['name']) ?>" 
                                                 class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                                        </a>
                                    <?php else: ?>
                                        <img src="<?= UPLOADS_URL . $category['image'] ?>" alt="<?= htmlspecialchars($category['name']) ?>" 
                                             class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                                    <?php endif; ?>
                                </div>
                            </div>
                            <!-- Category Name -->
                            <?php if (!empty($category['name'])): ?>
                                <h3 class="text-sm font-semibold text-gray-700 group-hover:text-gray-900 transition-colors line-clamp-2">
                                    <?= htmlspecialchars($category['name']) ?>
                                </h3>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <!-- Product Categories Section -->
    <?php
    $stmt = getCategories();
    if ($stmt) {
        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $categories = array_reverse($categories);
        $categories = array_slice($categories, 0, 10);
    } else {
        $categories = [];
    }
    ?>

    <?php if (!empty($categories)) : ?>
        <section class="py-20 bg-gradient-to-b from-white to-gray-50">
            <div class="max-w-7xl mx-auto px-4">
                <!-- Section Header -->
                <div class="text-center mb-16">
                    <h2 class="text-4xl sm:text-5xl font-bold text-gray-800 mb-4">
                        Shop By <span class="gradient-text">Category</span>
                    </h2>
                    <p class="text-xl text-gray-600 max-w-2xl mx-auto leading-relaxed">
                        Discover our carefully curated collections tailored just for you
                    </p>
                    <div class="w-32 h-1 bg-gradient-to-r from-pink-500 to-orange-500 mx-auto mt-6 rounded-full"></div>
                </div>

                <!-- Enhanced Category Tabs -->
                <div class="mb-16">
                    <div id="menu-tabs" class="flex overflow-x-auto hide-scrollbar gap-8 pb-6 px-4">
                        <?php foreach ($categories as $index => $category) :
                            $catImage = !empty($category['icon']) ? UPLOADS_URL . $category['icon'] : 'https://via.placeholder.com/400x160?text=No+Image';
                        ?>
                            <button class="tab-button flex flex-col items-center cursor-pointer flex-shrink-0 group"
                                data-category-id="<?= $category['id'] ?>">
                                <div class="tab-img w-24 h-24 rounded-2xl overflow-hidden border-4 border-white shadow-lg mb-4 group-hover:shadow-xl">
                                    <img src="<?= $catImage ?>" alt="<?= $category['name'] ?>" 
                                         class="w-full h-full object-cover transform group-hover:scale-110">
                                    <div class="absolute inset-0 bg-black opacity-0 group-hover:opacity-10 transition-opacity rounded-2xl"></div>
                                </div>
                                <span class="text-sm font-medium text-gray-600 group-hover:text-gray-800 text-center px-2">
                                    <?= $category['name'] ?>
                                </span>
                            </button>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Enhanced Product Display Area -->
                <div id="product-display-area" class="min-h-[500px]">
                    <!-- Initial State -->
                    <div class="text-center py-20">
                        <div class="w-32 h-32 rounded-full bg-gradient-to-br from-pink-100 to-pink-200 flex items-center justify-center mb-6 mx-auto shadow-lg">
                            <i class="fas fa-shopping-bag text-4xl gradient-text"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-3">Explore Categories</h3>
                        <p class="text-gray-500 text-lg max-w-md mx-auto">
                            Select a category above to discover amazing products
                        </p>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <!-- Enhanced JavaScript -->
    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const menuTabs = document.getElementById('menu-tabs');
        const tabs = Array.from(menuTabs.getElementsByClassName('tab-button'));
        const productDisplayArea = document.getElementById('product-display-area');

        // Enhanced tab activation
        function updateActiveTab(activeTab) {
            tabs.forEach(tab => {
                tab.classList.remove('active');
                tab.style.transform = 'scale(1)';
            });
            
            if (!activeTab) return;
            
            activeTab.classList.add('active');
            activeTab.style.transform = 'scale(1.05)';
            
            const categoryId = activeTab.dataset.categoryId;
            const categoryName = activeTab.querySelector('span').textContent;
            loadCategoryProducts(categoryId, categoryName);
        }

        // Enhanced center tab function
        function centerTab(tab) {
            if (!tab) return;
            const container = menuTabs;
            const containerWidth = container.clientWidth;
            const tabCenter = tab.offsetLeft + tab.offsetWidth / 2;
            const targetScroll = tabCenter - containerWidth / 2;
            
            container.scrollTo({
                left: targetScroll,
                behavior: 'smooth'
            });
            
            updateActiveTab(tab);
        }

        // Enhanced loading animation
        function showLoadingState(categoryName) {
            productDisplayArea.innerHTML = `
                <div class="text-center py-20">
                    <div class="inline-flex items-center justify-center mb-6">
                        <div class="animate-spin rounded-full h-16 w-16 border-b-2 border-pink-500"></div>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-3">Loading ${categoryName}</h3>
                    <p class="text-gray-500">Discovering amazing products for you...</p>
                </div>
            `;
        }

        // Enhanced product loading
        function loadCategoryProducts(categoryId, categoryName) {
            showLoadingState(categoryName);

            $.ajax({
                url: "shop/ajax/get-category-wise-product.php",
                type: "POST",
                data: {
                    page: 1,
                    category: categoryId,
                    min_price: '',
                    max_price: '',
                    q: ''
                },
                success: function(response) {
                    const trimmed = response.trim();
                    const hasRealProducts = trimmed && trimmed !== '' && 
                        (trimmed.includes('addToCartBtn') || trimmed.includes('product/') || 
                         trimmed.includes('₹') || (trimmed.includes('gap-5') && trimmed.includes('bg-white')));

                    if (hasRealProducts) {
                        const productCount = countRealProductsInHTML(trimmed);
                        const loadMoreButton = productCount >= 6 ? `
                            <div class="text-center mt-12">
                                <button onclick="loadMoreCategoryProducts('${categoryId}', '${categoryName}', 2)" 
                                        class="bg-gradient-to-r from-pink-500 to-orange-500 hover:from-pink-600 hover:to-orange-600 text-white px-8 py-4 rounded-full font-semibold shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                                    <i class="fas fa-arrow-down mr-2"></i>
                                    Load More Products
                                </button>
                            </div>
                        ` : '';

                        productDisplayArea.innerHTML = `
                            <div class="mb-12 text-center">
                                <h3 class="text-3xl font-bold text-gray-800 mb-3">${categoryName} Collection</h3>
                                <p class="text-gray-600 text-lg">${productCount}+ amazing products waiting for you</p>
                                <div class="w-24 h-1 bg-gradient-to-r from-pink-500 to-orange-500 mx-auto mt-4 rounded-full"></div>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                                ${trimmed}
                            </div>
                            ${loadMoreButton}
                        `;
                    } else {
                        productDisplayArea.innerHTML = `
                            <div class="text-center py-20">
                                <div class="w-32 h-32 rounded-full bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center mb-6 mx-auto shadow-lg">
                                    <i class="fas fa-search text-4xl text-gray-400"></i>
                                </div>
                                <h3 class="text-2xl font-bold text-gray-800 mb-3">No Products Found</h3>
                                <p class="text-gray-500 text-lg max-w-md mx-auto">
                                    We couldn't find any products in "${categoryName}" category yet.
                                </p>
                                <button onclick="location.reload()" 
                                        class="mt-6 bg-gradient-to-r from-gray-500 to-gray-600 hover:from-gray-600 hover:to-gray-700 text-white px-6 py-3 rounded-full font-semibold transition-all duration-300">
                                    Explore Other Categories
                                </button>
                            </div>
                        `;
                    }
                },
                error: function(xhr, status, error) {
                    productDisplayArea.innerHTML = `
                        <div class="text-center py-20">
                            <div class="w-32 h-32 rounded-full bg-gradient-to-br from-red-100 to-red-200 flex items-center justify-center mb-6 mx-auto shadow-lg">
                                <i class="fas fa-exclamation-triangle text-4xl text-red-500"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-800 mb-3">Oops! Something went wrong</h3>
                            <p class="text-gray-500 text-lg mb-6">We're having trouble loading products right now.</p>
                            <button onclick="loadCategoryProducts('${categoryId}', '${categoryName}')" 
                                    class="bg-gradient-to-r from-pink-500 to-orange-500 hover:from-pink-600 hover:to-orange-600 text-white px-6 py-3 rounded-full font-semibold transition-all duration-300">
                                <i class="fas fa-redo mr-2"></i>
                                Try Again
                            </button>
                        </div>
                    `;
                }
            });
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

        // Enhanced load more functionality
        window.loadMoreCategoryProducts = function(categoryId, categoryName, page) {
            const loadMoreBtn = document.querySelector('#product-display-area button');
            if (!loadMoreBtn) return;

            const originalHTML = loadMoreBtn.innerHTML;
            loadMoreBtn.innerHTML = '<i class="fas fa-spinner animate-spin mr-2"></i>Loading...';
            loadMoreBtn.disabled = true;

            $.ajax({
                url: "shop/ajax/get-category-wise-product.php",
                type: "POST",
                data: { page, category: categoryId, min_price: '', max_price: '', q: '' },
                success: function(response) {
                    const trimmed = response.trim();
                    const hasRealProducts = trimmed && trimmed !== '' && 
                        (trimmed.includes('addToCartBtn') || trimmed.includes('product/') || trimmed.includes('₹'));

                    if (hasRealProducts) {
                        const productsContainer = document.querySelector('#product-display-area .grid');
                        if (productsContainer) {
                            productsContainer.innerHTML += trimmed;
                            const productCount = countRealProductsInHTML(trimmed);
                            
                            if (productCount < 6) {
                                loadMoreBtn.style.display = 'none';
                            } else {
                                loadMoreBtn.innerHTML = originalHTML;
                                loadMoreBtn.disabled = false;
                                loadMoreBtn.setAttribute('onclick', `loadMoreCategoryProducts('${categoryId}', '${categoryName}', ${page + 1})`);
                            }
                        }
                    } else {
                        loadMoreBtn.innerHTML = '<i class="fas fa-check mr-2"></i>All Products Loaded';
                        setTimeout(() => loadMoreBtn.style.display = 'none', 2000);
                    }
                },
                error: function() {
                    loadMoreBtn.innerHTML = '<i class="fas fa-redo mr-2"></i>Try Again';
                    loadMoreBtn.disabled = false;
                }
            });
        }

        // Enhanced event listeners
        tabs.forEach(tab => {
            tab.addEventListener('click', (e) => {
                e.preventDefault();
                centerTab(tab);
            });
            
            // Hover effects
            tab.addEventListener('mouseenter', () => {
                if (!tab.classList.contains('active')) {
                    tab.style.transform = 'scale(1.02)';
                }
            });
            
            tab.addEventListener('mouseleave', () => {
                if (!tab.classList.contains('active')) {
                    tab.style.transform = 'scale(1)';
                }
            });
        });

        // Enhanced drag scrolling
        let isDown = false, startX, scrollLeft;
        menuTabs.addEventListener('mousedown', (e) => {
            isDown = true;
            menuTabs.style.cursor = 'grabbing';
            startX = e.pageX - menuTabs.offsetLeft;
            scrollLeft = menuTabs.scrollLeft;
        });

        menuTabs.addEventListener('mouseleave', () => isDown = false);
        menuTabs.addEventListener('mouseup', () => {
            isDown = false;
            menuTabs.style.cursor = 'grab';
        });

        menuTabs.addEventListener('mousemove', (e) => {
            if (!isDown) return;
            e.preventDefault();
            const x = e.pageX - menuTabs.offsetLeft;
            const walk = (x - startX) * 2;
            menuTabs.scrollLeft = scrollLeft - walk;
        });

        // Enhanced auto-centering
        let scrollTimeout;
        menuTabs.addEventListener('scroll', () => {
            if (scrollTimeout) clearTimeout(scrollTimeout);
            scrollTimeout = setTimeout(() => {
                const containerCenter = menuTabs.scrollLeft + menuTabs.clientWidth / 2;
                const closestTab = tabs.reduce((closest, tab) => {
                    const tabCenter = tab.offsetLeft + tab.offsetWidth / 2;
                    const distance = Math.abs(containerCenter - tabCenter);
                    return distance < closest.distance ? { tab, distance } : closest;
                }, { tab: tabs[0], distance: Infinity }).tab;
                
                centerTab(closestTab);
            }, 150);
        });

        // Initialize first tab
        if (tabs.length > 0) {
            setTimeout(() => centerTab(tabs[0]), 100);
        }
    });
    </script>

    <!-- Footer -->
    <?php include_once __DIR__ . "/includes/footer.php"; ?>

</body>
</html>