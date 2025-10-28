<?php include_once __DIR__ . "/includes/files_includes.php"; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include_once __DIR__ . "/includes/head_links.php"; ?>
    <style>
        :root {
            --primary: <?= htmlspecialchars(getData("color", "seller_settings", "(seller_id='$sellerId' AND store_id='$storeId')") ?? '#ff007f') ?>;
        }

        .category-scroll {
            scroll-behavior: smooth;
            scrollbar-width: none;
            -ms-overflow-style: none;
        }

        .category-scroll::-webkit-scrollbar {
            display: none;
        }

        .category-card {
            transition: all 0.3s ease;
        }

        .category-card:hover {
            transform: translateY(-2px);
        }

        .active-category-card {
            background: linear-gradient(135deg, var(--primary), #f59e0b);
            color: white;
        }

        .active-category-card .category-name {
            color: white;
            font-weight: 600;
        }

        .active-category-card .category-icon {
            background: rgba(255, 255, 255, 0.2) !important;
        }

        .sort-dropdown select:focus {
            outline: none;
            box-shadow: 0 0 0 2px var(--primary);
            border-color: var(--primary);
        }

        /* Utilities */
        .line-clamp-2 {
            display: -webkit-box;
            display: -moz-box;
            display: box;
            -webkit-line-clamp: 2;
            -moz-line-clamp: 2;
            line-clamp: 2;
            -webkit-box-orient: vertical;
            -moz-box-orient: vertical;
            box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Fallback for browsers that don't support line-clamp */
        @supports not (-webkit-line-clamp: 2) {
            .line-clamp-2 {
                max-height: 3em;
                line-height: 1.5em;
            }
        }
    </style>
</head>

<body class="font-sans bg-gray-50 min-h-screen" style="--primary: <?= htmlspecialchars(getData('color', 'seller_settings', "(seller_id='$sellerId' AND store_id='$storeId')") ?? '#ff007f') ?>;">

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

    <?php
    if (isset($_GET['q'])) {
        $q = $_GET['q'];
    } else {
        redirect($storeUrl);
    }

    $count = getProducts(array("count" => true, "q" => $q));
    foreach ($count as $key => $value) {
        $count = $value[0];
    }

    if (isset($_GET['category'])) {
        $category = $_GET['category'];
    } else {
        $category = '';
    }

    // Get search results
    $search_products_stmt = getProducts(array("q" => $q, "category" => $category));
    $search_products = $search_products_stmt->fetchAll(PDO::FETCH_ASSOC);
    $search_products_count = count($search_products);

    // Categories for navigation
    $categories = getCategories([
        "add_to_menu" => 1,
        "parent_category" => " ",
    ]);
    ?>

    <!-- Search Header -->
    <div class="py-6 text-white"
        style="background: linear-gradient(to right, var(--primary), #f472b6);">
        <div class="container mx-auto px-4">
            <div class="flex items-center gap-4 md:justify-center md:text-center">
                <div class="bg-white/20 p-3 rounded-xl backdrop-blur-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold">Search Results</h1>
                    <p class="opacity-90 mt-1 text-sm">
                        <?php
                        if ($search_products_count > 0) {
                            echo $search_products_count . " products found for \"" . htmlspecialchars($q) . "\"";
                        } else {
                            echo "No products found for \"" . htmlspecialchars($q) . "\"";
                        }
                        ?>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Category Navigation -->
    <?php if (!empty($categories) && $categories->rowCount()): ?>
        <section class="py-4 bg-white border-b shadow-sm">
            <div class="container mx-auto px-4">
                <div id="categoriesScroll" class="category-scroll flex gap-4 overflow-x-auto px-2 py-1">
                    <?php foreach ($categories as $cat): ?>
                        <a href="<?= $storeUrl . "category/" . $cat['slug'] ?>"
                            class="category-card flex-shrink-0 flex flex-col items-center text-center w-20 p-2 rounded-lg">
                            <div class="w-12 h-12 rounded-full mb-2 flex items-center justify-center shadow-sm category-icon"
                                style="background: linear-gradient(to bottom right, var(--primary), #f472b6);">
                                <?php if (!empty($cat['icon'])): ?>
                                    <img src="<?= UPLOADS_URL . $cat['icon'] ?>"
                                        alt="<?= $cat['name'] ?>"
                                        class="w-8 h-8 object-contain rounded-full"
                                        onerror="this.style.display='none'; this.parentNode.innerHTML='<?= strtoupper(substr($cat['name'], 0, 1)) ?>';">
                                <?php else: ?>
                                    <span class="text-white font-bold"><?= strtoupper(substr($cat['name'], 0, 1)) ?></span>
                                <?php endif; ?>
                            </div>
                            <span class="text-xs font-medium text-gray-700 truncate w-full category-name">
                                <?= htmlspecialchars($cat['name']) ?>
                            </span>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <!-- Main Content -->
    <div class="py-8">
        <div class="!px-5 lg:container">
            <div class="flex flex-col gap-6 lg:flex-row">
                <!-- Left Sidebar -->
                <div class="lg:w-[20%] font-questrial">
                    <div class="flex flex-col gap-5">
                        <!-- Price Range Filter -->
                        <div class="bg-white rounded-md p-5">
                            <h3 class="pb-5 mb-5 text-xl font-bold border-b">Price Range</h3>
                            <form id="priceForm">
                                <div class="flex items-center justify-between gap-5">
                                    <input type="number" name="min_price"
                                        value="<?= isset($_GET['min_price']) ? $_GET['min_price'] : '' ?>"
                                        class="w-full px-3 py-2 text-sm font-[400] bg-gray-100 rounded-md"
                                        placeholder="Min (<?= currencyToSymbol($storeCurrency) ?>)">
                                    <input type="number" name="max_price"
                                        value="<?= isset($_GET['max_price']) ? $_GET['max_price'] : '' ?>"
                                        class="w-full px-3 py-2 text-sm font-[400] bg-gray-100 rounded-md"
                                        placeholder="Max (<?= currencyToSymbol($storeCurrency) ?>)">
                                </div>
                                <button type="submit" class="flex items-center gap-2 px-3 py-2 text-sm font-[400] text-white transition rounded-lg bg-primary-500 hover:opacity-90 w-full mt-5 justify-center">
                                    Apply <i class='text-lg bx bxs-check-circle'></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Right Products Section -->
                <div class="lg:w-[80%]">
                    <!-- Sorting Dropdown -->
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
                        <div class="text-center sm:text-left w-full sm:w-auto order-2 sm:order-1">
                            <h2 class="text-xl font-bold text-gray-800">Search Results for "<?= htmlspecialchars($q) ?>"</h2>
                        </div>
                        <div class="sort-dropdown relative w-auto flex justify-end order-1 sm:order-2">
                            <select id="sortSelect" class="pl-8 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:border-transparent bg-white cursor-pointer appearance-none"
                                style="--tw-ring-color: var(--primary);">
                                <option value="default">Sort By</option>
                                <option value="low-high">Price: Low to High</option>
                                <option value="high-low">Price: High to Low</option>
                                <option value="latest">Latest First</option>
                                <option value="oldest">Oldest First</option>
                            </select>
                            <i class="bi bi-funnel absolute left-2 top-1/2 transform -translate-y-1/2 text-gray-500 text-sm pointer-events-none"></i>
                        </div>
                    </div>

                    <!-- Products Grid -->
                    <div class="grid xl:grid-cols-4 lg:grid-cols-3 xs:grid-cols-2 sm:gap-3 gap-2" id="content">
                        <?php if (!empty($search_products)): ?>
                            <?php foreach ($search_products as $product): ?>
                                <?= getProductHtml($product['id']) ?>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <!-- Empty State -->
                            <div class="col-span-full text-center py-12">
                                <div class="max-w-lg w-full p-10 text-center mx-auto">
                                    <div class="flex justify-center mb-6">
                                        <div class="w-24 h-24 sm:w-32 sm:h-32 rounded-full flex items-center justify-center"
                                            style="background-color: color-mix(in srgb, var(--primary) 20%, white);">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke-width="1.5"
                                                class="w-14 h-14 sm:w-20 sm:h-20"
                                                style="stroke: var(--primary);">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                            </svg>
                                        </div>
                                    </div>

                                    <h2 class="text-2xl sm:text-3xl font-semibold text-gray-900 mb-3">
                                        No Products Found
                                    </h2>
                                    <p class="text-gray-500 text-base sm:text-lg mb-6">
                                        We couldn't find any products matching "<?= htmlspecialchars($q) ?>"
                                    </p>

                                    <a href="<?= $storeUrl ?>"
                                        class="inline-block px-6 py-3 text-white font-medium rounded-lg hover:opacity-90 transition"
                                        style="background-color: var(--primary);">
                                        Back to Store
                                    </a>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include_once __DIR__ . "/includes/footer.php"; ?>

    <script>
        // Get search parameters
        const urlParams = new URLSearchParams(window.location.search);
        const minPrice = urlParams.get('min_price') || '';
        const maxPrice = urlParams.get('max_price') || '';
        const searchQuery = "<?= $q ?>";

        // Price Form Submission
        document.getElementById('priceForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const min = document.querySelector('input[name="min_price"]').value;
            const max = document.querySelector('input[name="max_price"]').value;

            if (min && max && Number(min) > Number(max)) {
                alert('Min price cannot be greater than max price');
                return;
            }

            const url = new URL(window.location.href);
            if (min) url.searchParams.set('min_price', min);
            else url.searchParams.delete('min_price');

            if (max) url.searchParams.set('max_price', max);
            else url.searchParams.delete('max_price');

            window.location.href = url.toString();
        });

        // Sorting functionality
        document.getElementById('sortSelect').addEventListener('change', function() {
            const sortValue = this.value;
            sortProducts(sortValue);
        });

        // Function to sort products based on selected option
        function sortProducts(sortType) {
            const productsContainer = document.getElementById('content');
            if (!productsContainer) return;

            const products = Array.from(productsContainer.querySelectorAll('.group'));

            switch (sortType) {
                case 'low-high':
                    products.sort((a, b) => getProductPrice(a) - getProductPrice(b));
                    break;
                case 'high-low':
                    products.sort((a, b) => getProductPrice(b) - getProductPrice(a));
                    break;
                case 'latest':
                    products.sort((a, b) => getProductId(b) - getProductId(a));
                    break;
                case 'oldest':
                    products.sort((a, b) => getProductId(a) - getProductId(b));
                    break;
                default:
                    return; // No sorting for default
            }

            // Clear container and append sorted products
            productsContainer.innerHTML = '';
            products.forEach(product => {
                productsContainer.appendChild(product);
            });
        }

        // Helper function to extract price from product element
        function getProductPrice(productElement) {
            const priceSelectors = [
                '.productPrice',
                '.text-lg.font-bold',
                '.text-pink-600',
                '[class*="price"]',
                '.text-xl.font-bold'
            ];

            let price = 0;

            for (const selector of priceSelectors) {
                const priceElement = productElement.querySelector(selector);
                if (priceElement) {
                    const priceText = priceElement.textContent || priceElement.innerText;
                    const priceMatch = priceText.match(/(\d+\.?\d*)/);
                    if (priceMatch) {
                        price = parseFloat(priceMatch[1]);
                        break;
                    }
                }
            }

            return price;
        }

        // Helper function to extract product ID (for latest/oldest sorting)
        function getProductId(productElement) {
            // Try to get ID from data attributes
            const idAttr = productElement.getAttribute('data-product-id');
            if (idAttr) return parseInt(idAttr);

            // Try to find product ID in the add to cart button
            const addBtn = productElement.querySelector('.addToCartBtn');
            if (addBtn && addBtn.dataset.productId) {
                return parseInt(addBtn.dataset.productId);
            }

            // Try to get ID from the product link
            const productLink = productElement.querySelector('a[href*="product"]');
            if (productLink) {
                const href = productLink.getAttribute('href');
                const idMatch = href.match(/product\/(\d+)/);
                if (idMatch) return parseInt(idMatch[1]);
            }

            // Fallback: use timestamp or random number
            return Date.now() + Math.random();
        }

        // Function to filter products by price range
        function filterProductsByPrice() {
            if (!minPrice && !maxPrice) return;

            const min = minPrice ? parseFloat(minPrice) : 0;
            const max = maxPrice ? parseFloat(maxPrice) : Number.MAX_SAFE_INTEGER;

            const productsContainer = document.getElementById('content');
            if (!productsContainer) return;

            const products = productsContainer.querySelectorAll('.group');
            let visibleCount = 0;

            products.forEach(product => {
                const productPrice = getProductPrice(product);
                const shouldShow = productPrice >= min && productPrice <= max;
                product.style.display = shouldShow ? '' : 'none';
                if (shouldShow) visibleCount++;
            });

            // Show message if no products match filter
            showFilterMessage(visibleCount);
        }

        // Show message when filtering results
        function showFilterMessage(visibleCount) {
            let existingMessage = document.getElementById('filterMessage');
            if (existingMessage) existingMessage.remove();

            if (minPrice || maxPrice) {
                const message = document.createElement('div');
                message.id = 'filterMessage';
                message.className = 'mb-4 p-3 rounded-lg';
                message.style.backgroundColor = 'color-mix(in srgb, var(--primary) 10%, white)';
                message.style.border = '1px solid color-mix(in srgb, var(--primary) 30%, transparent)';

                let messageText = `Showing ${visibleCount} products`;
                if (minPrice && maxPrice) {
                    messageText += ` between ${currencyToSymbol('<?= $storeCurrency ?>')}${minPrice} and ${currencyToSymbol('<?= $storeCurrency ?>')}${maxPrice}`;
                } else if (minPrice) {
                    messageText += ` above ${currencyToSymbol('<?= $storeCurrency ?>')}${minPrice}`;
                } else if (maxPrice) {
                    messageText += ` below ${currencyToSymbol('<?= $storeCurrency ?>')}${maxPrice}`;
                }

                message.innerHTML = `
                    <p class="text-sm" style="color: var(--primary);">
                        ${messageText}
                        <button onclick="clearPriceFilter()" class="ml-2 underline text-xs hover:opacity-80"
                                style="color: var(--primary);">
                            Clear filter
                        </button>
                    </p>
                `;

                const productsSection = document.querySelector('.lg\\:w-\\[80\\%\\]');
                const sortingDiv = productsSection.querySelector('.flex.justify-between');
                sortingDiv.parentNode.insertBefore(message, sortingDiv.nextSibling);
            }
        }

        // Clear price filter
        function clearPriceFilter() {
            const url = new URL(window.location.href);
            url.searchParams.delete('min_price');
            url.searchParams.delete('max_price');
            window.location.href = url.toString();
        }

        // Currency symbol helper
        function currencyToSymbol(currency) {
            const symbols = {
                'USD': '$',
                'EUR': '€',
                'GBP': '£',
                'INR': '₹'
            };
            return symbols[currency] || currency;
        }

        // Center active category in navigation
        function centerActiveCategory() {
            const categoriesScroll = document.getElementById('categoriesScroll');
            const activeCategory = categoriesScroll.querySelector('.active-category-card');

            if (activeCategory && categoriesScroll) {
                const scrollLeft = activeCategory.offsetLeft - (categoriesScroll.offsetWidth / 2) + (activeCategory.offsetWidth / 2);
                categoriesScroll.scrollTo({
                    left: scrollLeft,
                    behavior: 'smooth'
                });
            }
        }

        // Initialize when page loads
        document.addEventListener('DOMContentLoaded', function() {
            // Apply price filtering if min/max prices are set
            if (minPrice || maxPrice) {
                filterProductsByPrice();
            }

            // Center the active category in navigation
            centerActiveCategory();
        });
    </script>

</body>

</html>