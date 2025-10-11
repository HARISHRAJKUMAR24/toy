<?php include_once __DIR__ . "/includes/files_includes.php"; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!--Php File Include For Head Links & Scripts-->
    <?php include_once __DIR__ . "/includes/head_links.php"; ?>
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
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl sm:text-3xl md:text-4xl lg:text-4xl font-bold text-gray-800 mb-4 text-center">My Wishlist
        </h1>

        <!--Wish List 2 Main Container Left & Right-->
        <div class="flex flex-col md:flex-row gap-8">

            <!-- Left Side: Profile Section -->
            <div class="w-full md:w-1/4">
                <div class="bg-white/70 backdrop-blur-[12px] border border-white/50 rounded-2xl p-6 shadow-lg">
                    <div class="flex flex-col items-center mb-6">
                        <div class="relative mb-4">
                            <img src="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?ixlib=rb-4.0.3&auto=format&fit=crop&w=200&q=80"
                                alt="User Profile" class="w-24 h-24 rounded-full border-4 border-white/50 object-cover">
                            <div
                                class="absolute bottom-0 right-0 w-8 h-8 bg-pink-500 rounded-full flex items-center justify-center border-2 border-white">
                                <i class='bx bx-edit text-white text-sm'></i>
                            </div>
                        </div>
                        <h2 class="text-xl font-semibold text-gray-800">Rahul Sharma</h2>
                        <p class="text-gray-600 text-sm">rahul@example.com</p>
                    </div>

                    <div class="space-y-4">
                        <a href="#"
                            class="flex items-center gap-3 p-3 rounded-xl text-gray-700 hover:bg-pink-100 hover:text-pink-600 transition">
                            <i class='bx bx-user-circle text-xl'></i>
                            <span>My Profile</span>
                        </a>
                        <a href="#"
                            class="flex items-center gap-3 p-3 rounded-xl text-gray-700 hover:bg-pink-100 hover:text-pink-600 transition">
                            <i class='bx bx-package text-xl'></i>
                            <span>My Orders</span>
                        </a>
                        <a href="#" class="flex items-center gap-3 p-3 rounded-xl bg-pink-100 text-pink-600 transition">
                            <i class='bx bx-heart text-xl'></i>
                            <span>Wishlists</span>
                        </a>
                        <a href="#"
                            class="flex items-center gap-3 p-3 rounded-xl text-gray-700 hover:bg-pink-100 hover:text-pink-600 transition">
                            <i class='bx bx-log-out text-xl'></i>
                            <span>Logout</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Right Side: Wishlist Products -->
            <div class="w-full md:w-3/4">
                <h2 class="text-xl sm:text-2xl font-bold text-gray-800 mb-1">Your Favorite Items</h2>
                <p class="text-sm sm:text-base md:text-lg text-gray-600 max-w-2xl mb-4">
                    Quick grab! These products are waiting for you to bring them home.
                </p>

                <div class="p-5 bg-white rounded-lg w-full min-h-[60vh] flex items-center justify-center">
                    <?php
                    $productsStmt = getWishlists();
                    $products = $productsStmt->fetchAll(PDO::FETCH_ASSOC);

                    if (!empty($products)) {
                        echo '<div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-3 gap-5 w-full">';
                        foreach ($products as $product) {
                            echo getProductHtml($product['product_id']);
                        }
                        echo '</div>';
                    } else {
                    ?>
                        <!-- Empty Wishlist (Centered & Responsive) -->
                        <div class="flex flex-col items-center justify-center text-center px-4 py-10">
                            <img
                                src="<?= APP_URL ?>assets/image/empty-wishlist.png"
                                alt="Empty Wishlist"
                                class="opacity-80 w-[100px] sm:w-[100px] md:w-[120px] lg:w-[150px] mb-6 object-contain">

                            <h3 class="text-lg sm:text-xl md:text-2xl font-bold text-gray-800 mb-3">
                                Your Wishlist is Empty
                            </h3>

                            <p class="text-gray-400 text-sm sm:text-base md:text-lg leading-relaxed max-w-md mb-6">
                                Looks like you haven't added any products yet.
                            </p>

                            <a href="<?= $storeUrl ?>"
                                class="inline-flex items-center gap-2 px-6 py-3 bg-pink-500 hover:bg-rose-600 
                           text-white font-semibold rounded-full transition transform hover:scale-105 shadow-lg">
                                <i class="fa-solid fa-shop text-base"></i>
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