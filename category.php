<?php
include_once __DIR__ . "/includes/files_includes.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include_once __DIR__ . "/includes/head_links.php"; ?>
    <style>
        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .cursor-grabbing {
            cursor: grabbing;
        }

        .tab-button.active .tab-img {
            border-color: #ec4899;
            box-shadow: 0 0 0 3px rgba(236, 72, 153, 0.2);
        }

        .tab-button.active span {
            color: #ec4899;
            font-weight: 600;
        }
    </style>
</head>

<body class="font-sans bg-gray-50">
    <!-- Minimum Order Amount Start-->
    <?php if (!empty(getSettings("minimum_order_amount"))) : ?>
        <div class="w-full bg-pink-600 text-white text-center py-1 text-sm font-semibold">
            Minimum Order: <?= currencyToSymbol($storeCurrency) . getSettings("minimum_order_amount") ?>
        </div>
    <?php endif; ?>
    <!-- Minimum Order Amount End-->

    <!--Php File Include For Nav Bar-->
    <?php include_once __DIR__ . "/includes/navbar.php"; ?>

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
        <div class="py-16 px-4 bg-gray-50">
            <!-- Heading -->
            <div class="text-center mb-8">
                <h2 class="text-2xl sm:text-3xl md:text-4xl lg:text-4xl font-bold text-gray-800 mb-1">
                    Shop By Category
                </h2>
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
                        <div class="tab-img w-20 h-20 rounded-full overflow-hidden border-2 border-gray-200">
                            <img src="<?= $catImage ?>" alt="<?= $category['name'] ?>" class="w-full h-full object-cover rounded-full">
                        </div>
                        <span class="mt-2 text-sm font-medium text-gray-700"><?= $category['name'] ?></span>
                    </button>
                <?php endforeach; ?>
            </div>

            <!-- Product Display Area -->
            <div class="container mx-auto overflow-hidden mt-8">
                <!-- This is where products will be shown when category is clicked -->
                <div id="product-display-area" class="min-h-[400px]">
                    <!-- Default message - will be replaced when category is clicked -->
                    <div class="text-center py-16">
                        <div class="w-24 h-24 rounded-full bg-pink-100 flex items-center justify-center mb-4 mx-auto">
                            <i class="fas fa-shopping-bag text-pink-600 text-3xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">Select a Category</h3>
                        <p class="text-gray-500 mb-6 max-w-md mx-auto">Click on any category above to view products</p>
                    </div>
                </div>
            </div>
        </div>
        <!--Product Category End -->
    <?php endif; ?>

    <script>
        // ===============================
        // product category
        // ===============================

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

            // Load products for a category
            function loadCategoryProducts(categoryId, categoryName) {
                // Show loading state
                productDisplayArea.innerHTML = `
                <div class="text-center py-16">
                    <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-pink-600"></div>
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
                            productDisplayArea.innerHTML = `
                            <div class="mb-6">
                                <h3 class="text-2xl font-bold text-gray-800 text-center">${categoryName} Products</h3>
                                <p class="text-gray-600 text-center mt-2">Discover amazing products in ${categoryName} category</p>
                            </div>
                            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4 gap-y-6 items-stretch">
                                ${trimmed}
                            </div>
                            <div class="text-center mt-8">
                                <button onclick="loadMoreCategoryProducts('${categoryId}', '${categoryName}', 2)" 
                                        class="bg-pink-500 hover:bg-pink-600 text-white px-8 py-3 rounded-lg font-medium transition">
                                    Load More Products
                                </button>
                            </div>
                        `;
                        } else {
                            productDisplayArea.innerHTML = `
                            <div class="text-center py-16">
                                <div class="w-24 h-24 rounded-full bg-pink-100 flex items-center justify-center mb-4 mx-auto">
                                    <i class="fas fa-shopping-bag text-pink-600 text-3xl"></i>
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
                            <div class="w-24 h-24 rounded-full bg-red-100 flex items-center justify-center mb-4 mx-auto">
                                <i class="fas fa-exclamation-triangle text-red-600 text-3xl"></i>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-800 mb-2">Error Loading Products</h3>
                            <p class="text-gray-500 mb-6 max-w-md mx-auto">Unable to load products. Please try again.</p>
                        </div>
                    `;
                    }
                });
            }

            // Load more products for a category
            window.loadMoreCategoryProducts = function(categoryId, categoryName, page) {
                const loadMoreBtn = document.querySelector('#product-display-area button');
                const originalText = loadMoreBtn.innerHTML;

                // Show loading on button
                loadMoreBtn.innerHTML = '<div class="inline-block animate-spin rounded-full h-4 w-4 border-b-2 border-white mr-2"></div> Loading...';
                loadMoreBtn.disabled = true;

                $.ajax({
                    url: "shop/ajax/get-category-wise-product.php",
                    type: "POST",
                    data: {
                        page: page,
                        category: categoryId,
                        min_price: '',
                        max_price: '',
                        q: ''
                    },
                    success: function(response) {
                        const trimmed = response.trim();

                        if (trimmed && trimmed !== '') {
                            // Append new products
                            const productsContainer = document.querySelector('#product-display-area .grid');
                            productsContainer.innerHTML += trimmed;

                            // Update load more button for next page
                            loadMoreBtn.innerHTML = originalText;
                            loadMoreBtn.disabled = false;
                            loadMoreBtn.setAttribute('onclick', `loadMoreCategoryProducts('${categoryId}', '${categoryName}', ${page + 1})`);
                        } else {
                            // No more products
                            loadMoreBtn.innerHTML = 'No More Products';
                            loadMoreBtn.disabled = true;
                            loadMoreBtn.classList.remove('bg-pink-500', 'hover:bg-pink-600');
                            loadMoreBtn.classList.add('bg-gray-400', 'cursor-not-allowed');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error loading more products:', error);
                        loadMoreBtn.innerHTML = 'Error - Try Again';
                        loadMoreBtn.disabled = false;
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
    </script>

    <?php include_once __DIR__ . "/includes/footer.php"; ?>
</body>

</html>