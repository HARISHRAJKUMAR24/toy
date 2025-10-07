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
                <h2 class="text-xl sm:text-2xl md:text-2xl lg:text-2xl font-bold text-gray-800 mb-1">Your Favorite
                    Items</h2>
                <p class="text-sm sm:text-base md:text-lg text-gray-600 max-w-2xl mb-4">
                    Quick grab! These products are waiting for you to bring them home.
                </p>


                <div class="col-span-12 p-5 bg-white rounded-lg lg:col-span-8">
                    <div class="grid grid-cols-2 gap-5 lg:grid-cols-3 sm:grid-cols-3">
                        <?php

                        $products = getWishlists();
                        foreach ($products as $key => $product) {
                            echo getProductHtml($product['product_id']);
                        }
                        
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- My Wishlist Container End -->

    <!-- Footer Start -->
    <footer class="bg-pink-50 relative overflow-hidden py-10">
        <div class="container mx-auto px-6 flex flex-col md:flex-row md:justify-between md:items-start gap-10">

            <!-- Logo & Small Address -->
            <div class="flex flex-col gap-3 md:w-1/3">
                <div class="flex items-center gap-2">
                    <img src="https://img.icons8.com/color/48/toy-train.png" alt="Logo" class="h-10 w-10">
                    <span class="font-extrabold text-xl text-pink-600">ToyShop</span>
                </div>
                <p class="text-gray-600 text-sm mt-2">
                    1Milestone Technology Solution Pvt Ltd<br>
                    123 Business Street, City<br>
                    Pin: 560001 | GSTIN: 29ABCDE1234F1Z5
                </p>
            </div>

            <!-- Quick Links -->
            <div class="flex flex-col gap-2 md:w-1/3">
                <h3 class="font-semibold text-gray-800">Quick Links</h3>
                <ul class="space-y-1 text-gray-600 text-sm">
                    <li><a href="#" class="hover:text-pink-500 transition">Terms & Conditions</a></li>
                    <li><a href="#" class="hover:text-pink-500 transition">Shipping Policy</a></li>
                    <li><a href="#" class="hover:text-pink-500 transition">Track Order</a></li>
                    <li><a href="#" class="hover:text-pink-500 transition">Blogs</a></li>
                </ul>
            </div>

            <!-- Social Icons -->
            <div class="flex flex-col gap-3 md:w-1/3">
                <h3 class="font-semibold text-gray-800">Follow Us</h3>
                <div class="flex gap-3">
                    <a href="#"
                        class="w-10 h-10 flex items-center justify-center bg-pink-100 rounded-full hover:bg-pink-200 transition">
                        <i class='bx bxl-facebook text-pink-500 text-lg'></i>
                    </a>
                    <a href="#"
                        class="w-10 h-10 flex items-center justify-center bg-pink-100 rounded-full hover:bg-pink-200 transition">
                        <i class='bx bxl-instagram text-pink-500 text-lg'></i>
                    </a>
                    <a href="#"
                        class="w-10 h-10 flex items-center justify-center bg-pink-100 rounded-full hover:bg-pink-200 transition">
                        <i class='bx bxl-twitter text-pink-500 text-lg'></i>
                    </a>
                    <a href="#"
                        class="w-10 h-10 flex items-center justify-center bg-pink-100 rounded-full hover:bg-pink-200 transition">
                        <i class='bx bxl-linkedin text-pink-500 text-lg'></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Disclaimer Section -->
        <div class="mt-8 px-6">
            <h3 class="text-gray-800 font-semibold text-sm mb-2">Disclaimer:</h3>
            <p class="text-gray-500 text-xs">
                Ztorespot.com, a brand of 1Milestone Technology Solution Pvt Ltd, is not liable for product sales. We
                provide a DIY platform connecting Merchants & Buyers. All transactions are the responsibility of
                respective parties. Exercise caution.
            </p>
        </div>

        <!-- Decorative floating shapes -->
        <div class="absolute -top-10 -left-10 w-40 h-40 bg-pink-100 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-10 -right-10 w-40 h-40 bg-yellow-100 rounded-full blur-3xl pointer-events-none">
        </div>
    </footer>
    <!-- Footer End -->

    <?php include_once __DIR__ . "/includes/footer_link.php"; ?>
    <!--JS File Include -->
    <script src="<?= APP_URL ?>themes/theme9/js/script.js"></script>
    <script src="<?= APP_URL ?>shop/javascripts/cart.js"></script>

</body>

</html>