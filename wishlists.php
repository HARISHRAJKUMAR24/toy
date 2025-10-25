<?php include_once __DIR__ . "/includes/files_includes.php"; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!--Php File Include For Head Links & Scripts-->
    <?php include_once __DIR__ . "/includes/head_links.php"; ?>
    <style>
        /* Mobile & Tablet: 2 products per row */
        .wishlist-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
            width: 100%;
        }
        
        /* Desktop: Normal grid (3-4 products per row) */
        @media (min-width: 1024px) {
            .wishlist-grid {
                grid-template-columns: repeat(3, 1fr);
                gap: 1.5rem;
            }
        }
        
        /* Large Desktop: 4 products per row */
        @media (min-width: 1280px) {
            .wishlist-grid {
                grid-template-columns: repeat(4, 1fr);
            }
        }
        
        /* Mobile optimization */
        @media (max-width: 640px) {
            .wishlist-grid {
                gap: 0.75rem;
            }
        }
        
        /* Ensure product cards have consistent height */
        .product-card {
            height: 100%;
            display: flex;
            flex-direction: column;
        }
    </style>
</head>

<body class="bg-pink-50 font-sans min-h-screen">

    <!-- Minimum Order Amount Start-->
    <?php if (!empty(getSettings("minimum_order_amount"))) : ?>
        <div class="w-full bg-pink-600 text-white text-center py-1 text-sm font-semibold">
            Minimum Order: <?= currencyToSymbol($storeCurrency) . getSettings("minimum_order_amount") ?>
        </div>
    <?php endif; ?>
    <!-- Minimum Order Amount End-->

    <!--Php File Include For Nav Bar-->
    <?php include_once __DIR__ . "/includes/navbar.php"; ?>

    <!-- My Wishlist Container Start-->
    <div class="container mx-auto px-3 sm:px-6 lg:px-8 py-6">
        <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-800 mb-4 text-center">My Wishlist</h1>

        <!--Wish List 2 Main Container Left & Right-->
        <div class="flex flex-col lg:flex-row gap-6">

            <!-- Left Sidebar -->
            <div class="w-full lg:w-1/3 xl:w-1/4">
                <div class="bg-white/70 backdrop-blur-md border border-white/50 rounded-2xl p-5 shadow-lg">
                    <!-- Profile Info -->
                    <div class="flex flex-col items-center mb-6">
                        <div class="relative mb-4">
                            <img id="previewImage"
                                src="<?= !empty(customer('photo')) ? UPLOADS_URL . customer('photo') : 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?auto=format&fit=crop&w=200&q=80' ?>"
                                alt="User Profile"
                                class="w-24 h-24 rounded-full border-4 border-white/50 object-cover transition-all duration-300 shadow-sm">
                            <label for="photo"
                                class="absolute bottom-0 right-0 w-8 h-8 bg-pink-500 rounded-full flex items-center justify-center border-2 border-white cursor-pointer hover:bg-pink-600 transition"
                                onclick="window.location.href='<?= $storeUrl ?>profile'">
                                <i class='bx bx-edit text-white text-sm'></i>
                            </label>
                        </div>
                        <h2 class="text-xl font-semibold text-gray-800"><?= customer("name") ?></h2>
                        <p class="text-gray-600 text-sm"><?= customer("email") ?></p>
                    </div>

                    <!-- Sidebar Links -->
                    <div class="space-y-3 w-full">
                        <a href="<?= $storeUrl ?>profile"
                            class="flex items-center gap-3 p-3 rounded-xl transition <?= $page == 'profile.php' ? 'bg-indigo-100 text-indigo-500' : 'bg-gray-100 text-gray-700 hover:bg-pink-100 hover:text-pink-600' ?>">
                            <span class="bg-white border transition w-[44px] h-[44px] flex items-center justify-center rounded-full text-xl">
                                <i class='bx bx-user'></i>
                            </span>
                            <span class="font-medium">My Profile</span>
                        </a>

                        <a href="<?= $storeUrl ?>orders"
                            class="flex items-center gap-3 p-3 rounded-xl transition <?= $page == 'orders.php' ? 'bg-orange-100 text-orange-500' : 'bg-gray-100 text-gray-700 hover:bg-pink-100 hover:text-pink-600' ?>">
                            <span class="bg-white border transition w-[44px] h-[44px] flex items-center justify-center rounded-full text-xl">
                                <i class='bx bx-package'></i>
                            </span>
                            <span class="font-medium">My Orders</span>
                        </a>

                        <a href="<?= $storeUrl ?>wishlists"
                            class="flex items-center gap-3 p-3 rounded-xl transition <?= $page == 'wishlists.php' ? 'bg-pink-100 text-pink-500' : 'bg-gray-100 text-gray-700 hover:bg-pink-100 hover:text-pink-600' ?>">
                            <span class="bg-white border transition w-[44px] h-[44px] flex items-center justify-center rounded-full text-xl">
                                <i class='bx bx-heart'></i>
                            </span>
                            <span class="font-medium">Wishlists</span>
                        </a>

                        <a href="<?= $storeUrl ?>logout"
                            class="flex items-center gap-3 p-3 rounded-xl transition bg-gray-100 text-gray-700 hover:bg-red-100 hover:text-red-500">
                            <span class="bg-white border transition w-[44px] h-[44px] flex items-center justify-center rounded-full text-xl">
                                <i class='bx bx-log-out'></i>
                            </span>
                            <span class="font-medium">Logout</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Right Side: Wishlist Products -->
            <div class="w-full lg:w-2/3 xl:w-3/4">
                <p class="text-sm sm:text-base text-gray-600 mb-4">
                    Quick grab! These products are waiting for you to bring them home.
                </p>

                <div class="p-3 sm:p-4 bg-white rounded-xl w-full min-h-[60vh]">
                    <?php
                    $productsStmt = getWishlists();
                    $products = $productsStmt->fetchAll(PDO::FETCH_ASSOC);

                    if (!empty($products)) {
                        echo '<div class="wishlist-grid">';
                        foreach ($products as $product) {
                            echo '<div class="product-card">';
                            echo getProductHtml($product['product_id'], "h-full bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300 border border-gray-100");
                            echo '</div>';
                        }
                        echo '</div>';
                    } else {
                    ?>
                        <!-- Empty Wishlist -->
                        <div class="flex flex-col items-center justify-center text-center px-4 py-16 w-full">
                            <img
                                src="<?= APP_URL ?>assets/image/empty-wishlist.png"
                                alt="Empty Wishlist"
                                class="opacity-80 w-24 sm:w-28 md:w-32 mb-6 object-contain">

                            <h3 class="text-lg sm:text-xl font-bold text-gray-800 mb-3">
                                Your Wishlist is Empty
                            </h3>

                            <p class="text-gray-400 text-sm sm:text-base leading-relaxed max-w-sm mb-6">
                                Looks like you haven't added any products yet.
                            </p>

                            <a href="<?= $storeUrl ?>"
                                class="inline-flex items-center gap-2 px-5 py-2.5 bg-pink-500 hover:bg-rose-600 
                           text-white font-medium rounded-full transition transform hover:scale-105 shadow">
                                <i class="fa-solid fa-shop text-sm"></i>
                                <span>Go to Shop</span>
                            </a>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>

        </div>
    </div>
    <!-- My Wishlist Container End -->

    <!--Footer File Includes that file has all JS Files includes links-->
    <?php include_once __DIR__ . "/includes/footer.php"; ?>
</body>

</html>