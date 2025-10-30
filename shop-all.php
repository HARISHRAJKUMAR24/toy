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
                    <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-800 mb-1 text-center mb-6">
                        <?= htmlspecialchars($main_heading) ?>
                    </h2>
                <?php endif; ?>

                <!-- Scroll Container - FIXED: Centered but scrollable -->
                <div class="overflow-x-auto pb-4 hide-scrollbar mt-4">
                    <div class="flex flex-nowrap gap-8 md:gap-10 justify-center min-w-max px-4 md:px-8 lg:px-12">
                        <!-- ADDED: justify-center for centering but with min-w-max for overflow -->

                        <?php
                        // Array of beautiful random colors for variety
                        $random_colors = [
                            '#FF6B6B',
                            '#4ECDC4',
                            '#45B7D1',
                            '#96CEB4',
                            '#FFEAA7',
                            '#DDA0DD',
                            '#98D8C8',
                            '#F7DC6F',
                            '#BB8FCE',
                            '#85C1E9',
                            '#F8C471',
                            '#82E0AA',
                            '#F1948A',
                            '#85C1E9',
                            '#D7BDE2',
                            '#A9DFBF',
                            '#F9E79F',
                            '#D2B4DE',
                            '#AED6F1',
                            '#F5B7B1',
                            '#76D7C4',
                            '#F7DC6F',
                            '#BB8FCE',
                            '#85C1E9',
                            '#F8C471'
                        ];

                        foreach ($advance_categories as $index => $category) :
                            // Get random colors for each category
                            $border_color = $random_colors[$index % count($random_colors)];
                            $label_color = $random_colors[($index + 5) % count($random_colors)]; // Different color for label
                        ?>
                            <div class="flex-shrink-0">
                                <div class="relative w-36 h-36 flex flex-col items-center">
                                    <!-- Spinning border with random color - ORIGINAL STYLE -->
                                    <div class="absolute top-0 inset-x-0 w-32 h-32 rounded-full border-4 border-dashed animate-spin-slow opacity-90 transition-opacity duration-300 mx-auto"
                                        style="border-color: <?= htmlspecialchars($border_color) ?>;"></div>
                                    <!-- Image circle - ORIGINAL STYLE -->
                                    <div class="relative w-28 h-28 rounded-full overflow-hidden shadow-lg mx-auto top-2 bg-white flex items-center justify-center border-2 border-gray-300 transition-all duration-300">
                                        <?php if (!empty($category['link'])): ?>
                                            <a href="<?= $category['link'] ?>" target="_blank" class="block w-full h-full flex items-center justify-center">
                                                <img src="<?= UPLOADS_URL . $category['image'] ?>"
                                                    alt="<?= htmlspecialchars($category['name']) ?>"
                                                    class="w-full h-full object-cover object-center">
                                            </a>
                                        <?php else: ?>
                                            <img src="<?= UPLOADS_URL . $category['image'] ?>"
                                                alt="<?= htmlspecialchars($category['name']) ?>"
                                                class="w-full h-full object-cover object-center">
                                        <?php endif; ?>
                                    </div>
                                    <!-- Category Name - ORIGINAL POSITION but FLEXIBLE WIDTH -->
                                    <?php if (!empty($category['name'])): ?>
                                        <div class="absolute bottom-0 left-1/2 transform -translate-x-1/2 px-3 py-1.5 text-white text-sm font-semibold rounded-md shadow-lg text-center break-words w-full max-w-[140px] border border-white/30 opacity-95"
                                            style="background-color: <?= htmlspecialchars($label_color) ?>;">
                                            <?= htmlspecialchars($category['name']) ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>

                    </div>
                </div>
            </div>
        </section>

        <style>
            /*------------- Shop By Age Bg Animation Taken From DB  -------------*/
            .animate-gradient-x {
                background: linear-gradient(-45deg,
                        color-mix(in srgb, <?= htmlspecialchars($primary_color) ?> 35%, white),
                        color-mix(in srgb, <?= htmlspecialchars($hover_color) ?> 32%, white),
                        color-mix(in srgb, <?= htmlspecialchars($primary_color) ?> 30%, white),
                        color-mix(in srgb, <?= htmlspecialchars($hover_color) ?> 28%, white));
                background-size: 400% 400%;
                animation: gradient 15s ease infinite;
                /* Slower animation */
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
                        rgba(255, 255, 255, 0.9),
                        /* Increased opacity */
                        transparent);
                animation: shimmer 4s infinite;
                /* Slower shimmer */
                opacity: 0.2;
                /* Increased opacity */
            }

            @keyframes gradient {
                0% {
                    background-position: 0% 50%;
                }

                25% {
                    background-position: 50% 100%;
                }

                50% {
                    background-position: 100% 50%;
                }

                75% {
                    background-position: 50% 0%;
                }

                100% {
                    background-position: 0% 50%;
                }
            }

            @keyframes shimmer {
                0% {
                    left: -100%;
                }

                50% {
                    left: 100%;
                }

                100% {
                    left: 100%;
                }
            }

            /* Enhanced spin animation */
            @keyframes spin-slow {
                from {
                    transform: rotate(0deg);
                }

                to {
                    transform: rotate(360deg);
                }
            }

            /* Only keep the essential animations */
            .animate-spin-slow {
                animation: spin-slow 25s linear infinite;
            }

            @keyframes spin-slow {
                from {
                    transform: rotate(0deg);
                }

                to {
                    transform: rotate(360deg);
                }
            }

            /* Keep the gradient animation only */
            .animate-gradient-x {
                background: linear-gradient(-45deg,
                        color-mix(in srgb, <?= htmlspecialchars($primary_color) ?> 35%, white),
                        color-mix(in srgb, <?= htmlspecialchars($hover_color) ?> 32%, white),
                        color-mix(in srgb, <?= htmlspecialchars($primary_color) ?> 30%, white),
                        color-mix(in srgb, <?= htmlspecialchars($hover_color) ?> 28%, white));
                background-size: 400% 400%;
                animation: gradient 15s ease infinite;
            }
        </style>

    <?php endif; ?>
    <!--Shop By Age End-->
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
                        Explore what’s new, what’s now and what’s right for you.
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
                        <!-- <div class="text-center py-16">
                            <div class="w-24 h-24 rounded-full flex items-center justify-center mb-4 mx-auto"
                                style="background-color: color-mix(in srgb, var(--primary) 20%, white);">
                                <i class="fas fa-shopping-bag text-3xl" style="color: var(--primary);"></i>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-800 mb-2">Select a Category</h3>
                            <p class="text-gray-500 mb-6 max-w-md mx-auto">Click on any category above to view products</p>
                        </div> -->
                    </div>
                </div>
            </div>
        </section>
        <!--Product Category End -->
    <?php endif; ?>

    <!-- Random Product Section Start-->

    <section class="py-16 bg-gray-50 md:px-4">
        <div class="container mx-auto md:max-w-none max-w-6xl px-4 md:px-20">

            <!-- Section Heading -->
            <div class="text-center mb-8">
                <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-800 mb-1">Best Selling</h2>
                <p class="text-base sm:text-lg md:text-xl text-gray-600 max-w-2xl mx-auto">
                    Explore our latest and most exciting products
                </p>
            </div>

            <!-- Product Grid -->
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4 gap-y-10 items-stretch">
                <?php
                // Random products - Limit to 10
                $productsStmt = getProducts();   // This is PDOStatement
                $products = $productsStmt->fetchAll(PDO::FETCH_ASSOC); // Convert to array

                shuffle($products); // Randomize the array

                $counter = 0;
                foreach ($products as $product) {
                    if ($counter >= 10) break; // Stop after 10 products
                    echo getProductHtml(
                        $product["id"],
                        "group relative bg-white rounded-lg overflow-hidden shadow hover:shadow-lg transition duration-300 flex flex-col"
                    );
                    $counter++;
                }
                ?>
            </div>
        </div>
    </section>

    <!-- Random Product Section End -->

    <!-- Enhanced JavaScript -->
    <script>
        // Custom toast function
        function showCustomToast(message, type) {
            // Remove any existing toasts
            const existingToasts = document.querySelectorAll('.custom-product-toast');
            existingToasts.forEach(toast => toast.remove());

            // Create toast element
            const toast = document.createElement('div');
            toast.className = 'custom-product-toast fixed top-4 right-4 z-50 transform transition-all duration-500 ease-in-out translate-x-full opacity-0';
            toast.innerHTML = `
            <div style="background-color: var(--primary-color) !important; color: white !important; border-color: var(--primary-dark) !important;" 
                 class="px-4 py-3 rounded-lg shadow-lg border-l-4 flex items-center gap-3">
                <i class='bx ${type === 'success' ? 'bx-check-circle' : 'bx-error-circle'} text-xl'></i>
                <span class="font-semibold">${message}</span>
            </div>
        `;

            // Add to page
            document.body.appendChild(toast);

            // Animate in from right to left
            setTimeout(() => {
                toast.classList.remove('translate-x-full', 'opacity-0');
                toast.classList.add('translate-x-0', 'opacity-100');
            }, 10);

            // Auto remove after 3 seconds with reverse animation
            setTimeout(() => {
                toast.classList.remove('translate-x-0', 'opacity-100');
                toast.classList.add('translate-x-full', 'opacity-0');

                // Remove from DOM after animation completes
                setTimeout(() => {
                    if (toast.parentNode) {
                        toast.remove();
                    }
                }, 500);
            }, 3000);
        }

        // Update cart counts function
        function updateCartCounts() {
            $.ajax({
                url: 'shop/ajax/get-product-count-and-price.php',
                success: function(result) {
                    try {
                        const response = JSON.parse(result);
                        // Update cart counts in the UI
                        $('.cartItemsCount').text(response.itemsCount || '0');
                        $('.cartItemsCountWithTxt').text((response.itemsCount || '0') + " Item");
                        $('.cartPrice').text(response.price || '0');
                    } catch (e) {
                        console.warn('Could not update cart counts:', e);
                    }
                }
            });
        }

        // Function to initialize product components for AJAX-loaded content
        function initializeProductComponents() {
            // Remove existing variant select event listeners by replacing elements
            document.querySelectorAll('.variantSelect').forEach(select => {
                const newSelect = select.cloneNode(true);
                select.parentNode.replaceChild(newSelect, select);
            });

            // Initialize variant selects
            document.querySelectorAll('.variantSelect').forEach(select => {
                select.addEventListener('change', function() {
                    const selected = this.options[this.selectedIndex];
                    const card = this.closest('.group');
                    const addBtn = card.querySelector('.customAddToCartBtn');

                    const img = selected.dataset.image;
                    const price = selected.dataset.price;
                    const mrp = selected.dataset.mrp;
                    const stock = Number(selected.dataset.stock) || 0;
                    const unlimited = Number(selected.dataset.unlimited) || 0;
                    const variantType = selected.dataset.variantType;
                    const variantValue = selected.value;
                    const isMain = selected.dataset.isMain === 'true';

                    const imageEl = card.querySelector('.productImage');
                    const priceEl = card.querySelector('.productPrice');
                    const mrpEl = card.querySelector('.productMrp');

                    // Update image and prices
                    if (imageEl && img) imageEl.src = img;
                    if (priceEl) priceEl.textContent = "<?= currencyToSymbol($storeCurrency) ?>" + Number(price).toLocaleString();

                    if (mrpEl) {
                        if (mrp && mrp > 0) {
                            mrpEl.textContent = "<?= currencyToSymbol($storeCurrency) ?>" + Number(mrp).toLocaleString();
                            mrpEl.style.display = 'inline';
                        } else {
                            mrpEl.style.display = 'none';
                        }
                    }

                    // Handle Add button
                    if (addBtn) {
                        const isOutOfStock = stock <= 0 && unlimited !== 1;
                        const hasAdvancedVariants = addBtn.dataset.hasAdvancedVariants === 'true';

                        // Clear previous variant data
                        addBtn.dataset.variant = "";
                        addBtn.dataset.advancedvariant = "";

                        // Set the correct data attributes based on variant type
                        if (variantType === 'main') {
                            addBtn.dataset.variant = "";
                            addBtn.dataset.advancedvariant = "";
                        } else if (variantType === 'advanced') {
                            addBtn.dataset.advancedvariant = variantValue;
                            addBtn.dataset.variant = "";
                        } else {
                            addBtn.dataset.variant = variantValue;
                            addBtn.dataset.advancedvariant = "";
                        }

                        // FIXED RULE: If product has advanced variants, main product is ALWAYS disabled
                        if (hasAdvancedVariants && isMain) {
                            addBtn.disabled = true;
                            addBtn.innerHTML = '<span class="mr-1 text-sm md:text-base"></span> Select';
                            addBtn.classList.remove('bg-primary-500', 'text-white');
                            addBtn.classList.add('bg-gray-300', 'cursor-not-allowed', 'text-gray-500');
                        } else if (hasAdvancedVariants && !isMain) {
                            if (isOutOfStock) {
                                addBtn.disabled = true;
                                addBtn.innerHTML = '<span class="mr-1 text-sm md:text-base"></span> Sold Out';
                                addBtn.classList.remove('bg-primary-500', 'text-white');
                                addBtn.classList.add('bg-gray-100', 'cursor-not-allowed', 'text-gray-400');
                            } else {
                                addBtn.disabled = false;
                                addBtn.innerHTML = '<span class="mr-1 text-sm md:text-base"></span> Add';
                                addBtn.classList.remove(
                                    'bg-gray-100', 'cursor-not-allowed', 'text-gray-400',
                                    'bg-gray-300', 'text-gray-500'
                                );
                                addBtn.classList.add('bg-primary-500', 'text-white');
                            }
                        } else {
                            if (isOutOfStock) {
                                addBtn.disabled = true;
                                addBtn.innerHTML = '<span class="mr-1 text-sm md:text-base"></span> Sold Out';
                                addBtn.classList.remove('bg-primary-500', 'text-white');
                                addBtn.classList.add('bg-gray-100', 'cursor-not-allowed', 'text-gray-400');
                            } else {
                                addBtn.disabled = false;
                                addBtn.innerHTML = '<span class="mr-1 text-sm md:text-base"></span> Add';
                                addBtn.classList.remove(
                                    'bg-gray-100', 'cursor-not-allowed', 'text-gray-400',
                                    'bg-gray-300', 'text-gray-500'
                                );
                                addBtn.classList.add('bg-primary-500', 'text-white');
                            }
                        }
                    }
                });
            });
        }

        // FIXED: Single event listener for add to cart buttons - NO DUPLICATES
        let addToCartHandler = function(e) {
            // Only handle clicks on actual add to cart buttons
            const addToCartBtn = e.target.closest('.customAddToCartBtn');
            if (!addToCartBtn) return;

            // Prevent default and stop propagation immediately
            e.preventDefault();
            e.stopImmediatePropagation();

            // Check if already processing
            if (addToCartBtn.disabled) return;

            const product_id = addToCartBtn.dataset.id;
            const variant = addToCartBtn.dataset.variant || "";
            const advanced_variant = addToCartBtn.dataset.advancedvariant || "";

            // Add loading state
            const originalText = addToCartBtn.innerHTML;
            addToCartBtn.disabled = true;
            addToCartBtn.innerHTML = '<span class="mr-1">⏳</span> Adding...';

            $.ajax({
                url: 'shop/ajax/add-to-cart.php',
                type: 'POST',
                data: {
                    product_id: product_id,
                    variant: variant,
                    advanced_variant: advanced_variant
                },
                success: function(result) {
                    addToCartBtn.disabled = false;
                    addToCartBtn.innerHTML = originalText;

                    let response;
                    try {
                        response = JSON.parse(result);
                    } catch (e) {
                        if (result.includes('success') || result.includes('Success')) {
                            response = {
                                success: true,
                                message: "Product added to cart successfully!"
                            };
                        } else {
                            response = {
                                success: false,
                                message: "Failed to add product to cart."
                            };
                        }
                    }

                    if (response.success) {
                        showCustomToast(response.message || "Product added to cart successfully!", 'success');
                        updateCartCounts();
                        if (response.redirectUrl) {
                            window.location.href = response.redirectUrl;
                        }
                    } else {
                        const errorMessage = response.message || "";
                        const isDuplicateError =
                            errorMessage.includes('already') ||
                            errorMessage.includes('duplicate') ||
                            errorMessage.includes('exist') ||
                            errorMessage.includes('Added') ||
                            errorMessage.toLowerCase().includes('cart');

                        if (!isDuplicateError) {
                            showCustomToast(errorMessage || "Failed to add product to cart.", 'error');
                        } else {
                            updateCartCounts();
                        }
                    }
                },
                error: function(xhr, status, error) {
                    addToCartBtn.disabled = false;
                    addToCartBtn.innerHTML = originalText;
                    showCustomToast('Network error. Please try again.', 'error');
                    console.error('AJAX Error:', error);
                }
            });
        };

        // Remove any existing listener and add fresh one
        document.removeEventListener('click', addToCartHandler);
        document.addEventListener('click', addToCartHandler, true); // Use capture phase

        // FIXED: Shop By Category - No Double Loading
        document.addEventListener('DOMContentLoaded', () => {
            const menuTabs = document.getElementById('menu-tabs');
            const tabs = Array.from(menuTabs?.getElementsByClassName('tab-button') || []);
            const productDisplayArea = document.getElementById('product-display-area');

            if (!menuTabs || tabs.length === 0 || !productDisplayArea) return;

            let currentCategoryId = null;
            let isLoading = false;
            let currentAjaxRequest = null;

            // Highlight tab and show products
            function updateActiveTab(activeTab) {
                tabs.forEach(tab => tab.classList.remove('active'));
                if (!activeTab) return;
                activeTab.classList.add('active');

                // Load products for this category
                const categoryId = activeTab.dataset.categoryId;
                const categoryName = activeTab.querySelector('span').textContent;

                // Prevent loading same category again
                if (currentCategoryId === categoryId && !isLoading) {
                    return;
                }

                currentCategoryId = categoryId;
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
                const productElements = tempDiv.querySelectorAll('.gap-5, .customAddToCartBtn, [class*="group"]');
                return Array.from(productElements).filter(el =>
                    el.innerHTML.includes('product/') ||
                    el.innerHTML.includes('₹') ||
                    el.innerHTML.includes('customAddToCartBtn')
                ).length;
            }

            // Load products for a category - FIXED with duplicate prevention
            function loadCategoryProducts(categoryId, categoryName) {
                // Cancel previous request if still loading
                if (currentAjaxRequest) {
                    currentAjaxRequest.abort();
                }

                isLoading = true;

                // Show loading state
                productDisplayArea.innerHTML = `
                <div class="text-center py-16">
                    <div class="inline-block rounded-full h-8 w-8 border-b-2 mx-auto" style="border-color: var(--primary); animation: spin 1s linear infinite;"></div>
                    <p class="mt-4 text-gray-600 font-medium">Loading ${categoryName} products...</p>
                </div>
            `;

                // AJAX call to get products
                currentAjaxRequest = $.ajax({
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
                        isLoading = false;
                        currentAjaxRequest = null;
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

                            // Initialize components for AJAX-loaded products
                            setTimeout(initializeProductComponents, 100);
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
                        isLoading = false;
                        currentAjaxRequest = null;

                        // Don't show error if request was aborted
                        if (status !== 'abort') {
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
                    }
                });
            }

            // FIXED: Single click handler with event delegation - NO DUPLICATES
            menuTabs.addEventListener('click', (e) => {
                const tab = e.target.closest('.tab-button');
                if (tab) {
                    centerTab(tab);
                }
            });

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