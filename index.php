<?php include_once __DIR__ . "/includes/files_includes.php"; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!--Php File Include For Head Links & Scripts-->
    <?php include_once __DIR__ . "/includes/head_links.php"; ?>
    <style>
        /*<==========> CSS Styles <==========>*/

        /*------------- Header Slide Images Height Fix -------------*/
        #slider {
            height: 50vh;
            /* Desktop */
        }

        @media (max-width: 768px) {
            #slider {
                height: 60vh;
                /* Tablet */
            }
        }

        @media (max-width: 640px) {
            #slider {
                height: 40vh;
                /* Mobile */
            }
        }

        /*------------- Video Commerce Section -------------*/
        @keyframes wave {
            0% {
                transform: scale(1);
                opacity: 0.6;
            }

            70% {
                transform: scale(2.2);
                opacity: 0;
            }

            100% {
                opacity: 0;
            }
        }

        .animate-wave {
            animation: wave 3s ease-out infinite;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .animate-fadeIn {
            animation: fadeIn 0.3s ease-out;
        }
    </style>
</head>

<body class="font-sans">

    <!-- Minimum Order Amount Start-->
    <?php if (!empty(getSettings("minimum_order_amount"))) : ?>
        <div class="w-full bg-pink-600 text-white text-center py-1 text-sm font-semibold">
            Minimum Order: <?= currencyToSymbol($storeCurrency) . getSettings("minimum_order_amount") ?>
        </div>
    <?php endif; ?>
    <!-- Minimum Order Amount End-->

    <!--Php File Include For Nav Bar-->
    <?php include_once __DIR__ . "/includes/navbar.php"; ?>


    <!-- Header Slide Start -->
    <?php
    // Fetch banner images and links
    $banners = [];
    for ($i = 1; $i <= 4; $i++) {
        $column = "homepage_banner" . ($i > 1 ? "_$i" : "");
        $link_column = "homepage_banner_link" . ($i > 1 ? "_$i" : "");

        $image = getData($column, "seller_banners", "(seller_id = '$sellerId')");
        $link = getData($link_column, "seller_banners", "(seller_id = '$sellerId')");

        if (!empty($image)) {
            $banners[] = ['image' => $image, 'link' => $link];
        }
    }

    // Only render slider if there are banners
    if (!empty($banners)) :
    ?>
        <header id="slider"
            class="relative w-[95%] h-[60vh] sm:[h:40vh] md:[h:60vh] mx-auto my-4 overflow-hidden rounded-2xl shadow-2xl">

            <?php
            // Render banners
            foreach ($banners as $index => $banner) {
                $opacity = $index === 0 ? "opacity-100" : "opacity-0"; // first slide visible
                echo '<div class="absolute inset-0 ' . $opacity . ' transition-opacity duration-1000 slide">';
                if (!empty($banner['link'])) {
                    echo '<a href="' . $banner['link'] . '" target="_blank">';
                    echo '<img src="' . UPLOADS_URL . $banner['image'] . '" class="w-full h-full object-cover rounded-2xl shadow-2xl" alt="Slide ' . ($index + 1) . '">';
                    echo '</a>';
                } else {
                    echo '<img src="' . UPLOADS_URL . $banner['image'] . '" class="w-full h-full object-cover rounded-2xl shadow-2xl" alt="Slide ' . ($index + 1) . '">';
                }
                echo '</div>';
            }
            ?>

            <div id="dots" class="absolute bottom-6 left-1/2 -translate-x-1/2 flex gap-3 z-20"></div>
        </header>
    <?php endif; ?>

    <!-- Header slide End  -->


    <!-- Product Categories Section Start-->

    <?php
    // Product Category gird Set & Upload Shwon In first
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
        <section class="py-16 px-4 bg-white">
            <div class="container mx-auto">
                <!-- Product Categories Section Heading -->
                <div class="text-center mb-8">
                    <h2 class="text-2xl sm:text-3xl md:text-4xl lg:text-4xl font-bold text-gray-800 mb-1">
                        Shop By Category
                    </h2>
                    <p class="text-base sm:text-lg md:text-xl text-gray-600 max-w-2xl mx-auto">
                        Explore our diverse collection of toys for all ages and interests
                    </p>
                </div>

                <!-- Categories Grid -->
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-3 lg:grid-cols-5 gap-4 gap-y-10 items-stretch">
                    <?php foreach ($categories as $category) :
                        $catImage = !empty($category['icon']) ? UPLOADS_URL . $category['icon'] : 'https://via.placeholder.com/400x160?text=No+Image';
                    ?>
                        <div
                            class="group relative overflow-hidden rounded-lg shadow-md transition-all duration-300 hover:shadow-xl hover:-translate-y-1 cursor-pointer flex flex-col h-full">
                            <div class="relative overflow-hidden">
                                <img src="<?= $catImage ?>" alt="<?= $category['name'] ?>"
                                    class="w-full h-40 object-cover transition-transform duration-500 group-hover:scale-105">
                                <div
                                    class="absolute inset-0 bg-gradient-to-br from-transparent via-white/70 to-transparent -translate-x-full -translate-y-full group-hover:translate-x-full group-hover:translate-y-full transition-transform duration-700">
                                </div>
                            </div>
                            <div
                                class="p-3 bg-gradient-to-br from-blue-200 to-indigo-300 flex-1 flex items-center justify-between">
                                <h3 class="font-semibold text-gray-800 group-hover:text-pink-600 transition-colors"><?= $category['name'] ?></h3>
                                <svg class="w-6 h-6 sm:w-7 sm:h-7 justify-end rounded-full p-1 sm:p-2 bg-transparent group-hover:bg-white text-white ease-linear duration-300 rotate-45 group-hover:rotate-90 border border-white group-hover:border-none group-hover:text-gray-700"
                                    viewBox="0 0 16 19" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M7 18C7 18.5523 7.44772 19 8 19C8.55228 19 9 18.5523 9 18H7ZM8.70711 0.292893C8.31658 -0.0976311 7.68342 -0.0976311 7.29289 0.292893L0.928932 6.65685C0.538408 7.04738 0.538408 7.68054 0.928932 8.07107C1.31946 8.46159 1.95262 8.46159 2.34315 8.07107L8 2.41421L13.6569 8.07107C14.0474 8.46159 14.6805 8.46159 15.0711 8.07107C15.4616 7.68054 15.4616 7.04738 15.0711 6.65685L8.70711 0.292893ZM9 18L9 1H7L7 18H9Z"
                                        class="fill-current"></path>
                                </svg>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- CTA Button -->
                <div class="flex justify-center mt-8">
                    <a href="<?= $storeUrl ?>shop-all"
                        class="flex justify-center gap-2 items-center mx-auto shadow-lg text-base sm:text-lg text-gray-800 hover:text-white bg-gradient-to-r from-pink-400 via-pink-500 to-indigo-400 lg:font-semibold isolation-auto border-transparent before:absolute before:w-full before:transition-all before:duration-700 before:hover:w-full before:-left-full before:hover:left-0 before:rounded-full before:bg-white/20 before:-z-10 before:hover:scale-150 before:hover:duration-700 relative z-10 px-14 py-2 sm:px-16 sm:py-3 overflow-hidden rounded-full group">
                        Explore
                        <svg class="w-7 h-7 sm:w-8 sm:h-8 justify-end rounded-full p-1 sm:p-2 bg-transparent group-hover:bg-white text-white ease-linear duration-300 rotate-45 group-hover:rotate-90 border border-white group-hover:border-none group-hover:text-gray-700"
                            viewBox="0 0 16 19" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M7 18C7 18.5523 7.44772 19 8 19C8.55228 19 9 18.5523 9 18H7ZM8.70711 0.292893C8.31658 -0.0976311 7.68342 -0.0976311 7.29289 0.292893L0.928932 6.65685C0.538408 7.04738 0.538408 7.68054 0.928932 8.07107C1.31946 8.46159 1.95262 8.46159 2.34315 8.07107L8 2.41421L13.6569 8.07107C14.0474 8.46159 14.6805 8.46159 15.0711 8.07107C15.4616 7.68054 15.4616 7.04738 15.0711 6.65685L8.70711 0.292893ZM9 18L9 1H7L7 18H9Z"
                                class="fill-current"></path>
                        </svg>
                    </a>
                </div>

            </div>
        </section>
    <?php endif; ?>
    <!-- Product Categories Section End-->


    <!--Latest Product Testing Start -->
    <?php
    // Fetch latest products
    $productsStmt = getProducts(['limit' => 10]);
    ?>

    <section class="py-16 px-4 bg-gray-50">
        <div class="container mx-auto">

            <!-- Section Heading -->
            <div class="text-center mb-8">
                <h2 class="text-2xl sm:text-3xl md:text-4xl lg:text-4xl font-bold text-gray-800 mb-1">
                    Latest Product Testing
                </h2>
                <p class="text-base sm:text-lg md:text-xl text-gray-600 max-w-2xl mx-auto">
                    Explore our latest collection of toys for all ages and interests
                </p>
            </div>

            <!-- Product Grid -->
            <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 gap-y-10 items-stretch">
                <?php while ($product = $productsStmt->fetch(PDO::FETCH_ASSOC)) :
                    $productId = $product['id'];
                    $name = $product['name'];
                    $image = $product['image'];
                    $price = $product['price'];
                    $mrp = $product['mrp_price'];
                    $badge = $product['badge'];
                    $savePercent = $mrp && $mrp > $price ? round((($mrp - $price) / $mrp) * 100) : 0;

                    // Advanced variants
                    $advancedStmt = getData("*", "seller_product_advanced_variants", "product_id = '$productId'");
                    $advancedVariants = $advancedStmt ? $advancedStmt->fetchAll(PDO::FETCH_ASSOC) : [];
                ?>
                    <div class="group relative bg-white rounded-lg overflow-hidden shadow hover:shadow-lg transition duration-300 flex flex-col">

                        <!-- Product Image + Badge + Wishlist -->
                        <div class="relative">
                            <img src="<?= UPLOADS_URL . $image ?>" alt="<?= htmlspecialchars($name) ?>"
                                class="w-full h-64 sm:h-72 md:h-64 lg:h-60 object-cover transition-transform duration-500 group-hover:scale-105">

                            <?php if ($badge || $savePercent > 0) : ?>
                                <div class="absolute top-2 left-2 flex flex-col items-center justify-center min-w-[3.5rem] px-2 py-1 
                                        bg-gradient-to-b from-red-600 to-red-800 text-white rounded transform rotate-[-15deg] 
                                        shadow-lg border-2 border-red-300 border-opacity-50 text-[10px] sm:text-xs font-bold uppercase"
                                    style="text-shadow: 0 1px 2px rgba(0,0,0,0.3);">
                                    <span><?= strtoupper($badge ?: 'SAVE') ?></span>
                                    <?php if ($savePercent > 0): ?>
                                        <span class="text-lg font-black leading-none"><?= $savePercent ?>%</span>
                                    <?php endif; ?>
                                    <div class="absolute -bottom-1 w-4/5 h-1 bg-red-900 rounded-b-lg opacity-80"></div>
                                </div>
                            <?php endif; ?>

                            <!-- Wishlist Button -->
                            <button class="absolute top-2 right-2 w-10 h-10 flex items-center justify-center 
                                       bg-white/95 hover:bg-pink-100 text-pink-600 rounded-full shadow-lg 
                                       transition transform hover:scale-110">
                                <i class="fa-solid fa-heart"></i>
                            </button>
                        </div>

                        <!-- Product Info -->
                        <div class="p-4 flex flex-col flex-grow">

                            <h3 class="text-base sm:text-lg md:text-lg lg:text-xl font-semibold text-gray-800 
                                   group-hover:text-pink-600 transition-colors mb-3">
                                <?= htmlspecialchars($name) ?>
                            </h3>

                            <!-- Variant Dropdown -->
                            <?php if (!empty($advancedVariants)) : ?>
                                <div class="mb-3">
                                    <label for="variantSelect-<?= $productId ?>" class="block text-sm font-medium text-gray-700 mb-1">
                                        Select Variant:
                                    </label>
                                    <div class="relative">
                                        <select id="variantSelect-<?= $productId ?>" class="block w-full appearance-none border border-gray-300 rounded-lg bg-white px-4 py-2 pr-10 text-gray-700 text-sm
                                           focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-pink-400 transition shadow-sm hover:shadow-md">
                                            <?php foreach ($advancedVariants as $variant): ?>
                                                <option value="<?= $variant['id'] ?>"
                                                    data-price="<?= htmlspecialchars($variant['price'] ?? $price) ?>"
                                                    data-mrp="<?= htmlspecialchars($variant['mrp_price'] ?? $mrp) ?>"
                                                    data-stock="<?= htmlspecialchars($variant['stock'] ?? 0) ?>">
                                                    <?= htmlspecialchars($variant['variant_name'] ?? $variant['name'] ?? 'Variant') ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-400">
                                            <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <!-- Price + Add to Cart -->
                            <div class="flex items-center justify-between mt-auto">
                                <div class="flex flex-col sm:flex-row sm:items-center sm:space-x-2">
                                    <span class="text-sm sm:text-base md:text-lg font-bold">₹<?= number_format($price) ?></span>
                                    <?php if ($mrp && $mrp > $price): ?>
                                        <span class="text-sm sm:text-sm text-gray-400 line-through">₹<?= number_format($mrp) ?></span>
                                    <?php endif; ?>
                                </div>

                                <button class="relative overflow-hidden bg-gradient-to-r from-pink-200 to-pink-300 
                                           text-pink-700 px-3 py-1 rounded-md shadow transition-all duration-500 
                                           bg-[length:200%_100%] bg-left hover:bg-right sm:px-4 sm:py-1.5 md:px-5 md:py-2">
                                    Add
                                </button>
                            </div>

                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </section>
    <!--Latest Product Section Testing End -->

    <!-- Latest Product Section Start-->

    <section class="py-16 px-4 bg-gray-50">
        <div class="container mx-auto">

            <!-- Section Heading -->
            <div class="text-center mb-8">
                <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-800 mb-1">New Collections</h2>
                <p class="text-base sm:text-lg md:text-xl text-gray-600 max-w-2xl mx-auto">
                    Explore our latest and most exciting products
                </p>
            </div>

            <!-- Product Grid -->
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4 gap-y-10 items-stretch">
                <?php
                $products = getProducts(); // Fetch all products
                foreach ($products as $product) {
                    echo getProductHtml($product["id"], "group relative bg-white rounded-lg overflow-hidden shadow hover:shadow-lg transition duration-300 flex flex-col");
                }
                ?>
            </div>
        </div>
    </section>

    <!--Latest Product Section End -->

    <!-- Special Offer Section Start -->
    <?php
    // Fetch max 2 offer images
    $offerSlides = [];
    for ($i = 1; $i <= 2; $i++) {
        $imgColumn = "offer_image_$i";
        $img = getData($imgColumn, "seller_banners", "(seller_id = '$sellerId')");
        if (!empty($img)) {
            $offerSlides[] = $img;
        }
    }

    // Only render section if there are images
    if (!empty($offerSlides)):
    ?>
        <section class="py-12 bg-pink-50">
            <div class="container mx-auto max-w-6xl px-4">

                <!-- Special Offer Heading -->
                <div class="text-center mb-8">
                    <h3 class="text-2xl sm:text-3xl md:text-4xl lg:text-4xl font-bold text-gray-800 mb-1">Special Offers</h3>
                    <p class="text-base sm:text-lg md:text-xl text-gray-600 max-w-2xl mx-auto">Grab the best deals before
                        they're gone!</p>
                </div>

                <!-- 3D fade slider wrapper -->
                <div id="offerWrapper" class="relative perspective-[1200px] w-full sm:w-[95%] mx-auto my-4
           h-[25vh] sm:h-[35vh] rounded-2xl overflow-hidden px-2">
                    <div id="offerTrack" class="relative w-full h-full">
                        <?php foreach ($offerSlides as $index => $slideImg): ?>
                            <div
                                class="absolute inset-0 rounded-2xl shadow-2xl overflow-hidden transform transition-all duration-1000 ease-in-out opacity-0 scale-95">
                                <a href="<?= $storeUrl ?>shop-all">
                                    <img src="<?= UPLOADS_URL . $slideImg ?>" alt="Offer <?= $index + 1 ?>"
                                        class="w-full h-full object-cover">
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Buttons below slider -->
                <div class="flex justify-center gap-4 mt-6 px-2">
                    <!-- Prev -->
                    <button id="prevOffer" class="w-10 h-10 flex items-center justify-center rounded-full 
             bg-gradient-to-br from-pink-400 to-purple-500 
             text-white shadow-lg backdrop-blur-md border border-white/30
             hover:scale-110 hover:shadow-xl hover:from-purple-500 hover:to-pink-400 
             transition-all duration-300">
                        <i class='bx bx-chevron-left text-lg'></i>
                    </button>

                    <!-- Play/Pause -->
                    <button id="toggleAutoplay" class="w-10 h-10 flex items-center justify-center rounded-full 
             bg-gradient-to-br from-blue-400 to-indigo-500 
             text-white shadow-lg backdrop-blur-md border border-white/30
             hover:scale-110 hover:shadow-xl hover:from-indigo-500 hover:to-blue-400 
             transition-all duration-300">
                        <i class='bx bx-pause text-lg'></i>
                    </button>

                    <!-- Next -->
                    <button id="nextOffer" class="w-10 h-10 flex items-center justify-center rounded-full 
             bg-gradient-to-br from-pink-400 to-purple-500 
             text-white shadow-lg backdrop-blur-md border border-white/30
             hover:scale-110 hover:shadow-xl hover:from-purple-500 hover:to-pink-400 
             transition-all duration-300">
                        <i class='bx bx-chevron-right text-lg'></i>
                    </button>
                </div>

            </div>
        </section>
    <?php endif; ?>
    <!-- Special Offer Section End -->


    <!-- Random Product Section Start-->
    <section class="py-16 px-4 bg-gray-50">
        <div class="container mx-auto">

            <!-- Section Heading -->
            <div class="text-center mb-8">
                <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-800 mb-1">New Collections</h2>
                <p class="text-base sm:text-lg md:text-xl text-gray-600 max-w-2xl mx-auto">
                    Explore our latest and most exciting products
                </p>
            </div>

            <!-- Product Grid -->
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4 gap-y-10 items-stretch">
                <?php
                $productsStmt = getProducts();   // This is PDOStatement
                $products = $productsStmt->fetchAll(PDO::FETCH_ASSOC); // Convert to array

                shuffle($products); // Now works fine

                foreach ($products as $product) {
                    echo getProductHtml(
                        $product["id"],
                        "group relative bg-white rounded-lg overflow-hidden shadow hover:shadow-lg transition duration-300 flex flex-col"
                    );
                }


                ?>
            </div>
        </div>
    </section>

    <!-- Random Product Section End -->

    <!--Why Shop With Us Start-->
    <section class="bg-white py-20">
        <div class="max-w-6xl mx-auto px-4 text-center">
            <!--Why Shop With Us Heading-->
            <h2 class="text-2xl sm:text-3xl md:text-4xl lg:text-4xl font-bold text-gray-800 mb-1">Why Shop With <span
                    class="text-pink-600">Us</span></h2>
            <p class="text-base sm:text-lg md:text-xl text-gray-600 max-w-2xl mx-auto mb-8">We offer the best products,
                quality service, and seamless shopping
                experience to make your life easier and fun!</p>

            <!-- Cards Grid-->
            <div
                class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-[repeat(auto-fit,minmax(250px,1fr))] gap-8 justify-center">

                <!-- Card 1 -->
                <div class="bg-gray-200 p-6 rounded-3xl shadow-lg transform transition-transform duration-300 hover:-translate-y-4 hover:scale-105
       w-full max-w-xs sm:max-w-sm md:max-w-md mx-auto">
                    <?php $img1 = getData("featured_image_1", "seller_banners", "(seller_id = '$sellerId')"); ?>
                    <img src="<?= !empty($img1) ? UPLOADS_URL . $img1 : 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR3yf-ZigU47H1qW8DLYCWi7C95rdFjjP9jFQ&s' ?>"
                        alt="Fast Delivery" class="mx-auto w-24 h-24 object-cover rounded-full mb-5 shadow-md">

                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Fast Delivery</h3>
                    <p class="text-gray-500 text-sm">Get your orders delivered quickly with our reliable shipping
                        partners.</p>
                </div>

                <!-- Card 2 -->
                <div class="bg-sky-500/50 p-6 rounded-3xl shadow-lg transform transition-transform duration-300 hover:-translate-y-4 hover:scale-105
       w-full max-w-xs sm:max-w-sm md:max-w-md mx-auto">
                    <?php $img2 = getData("featured_image_2", "seller_banners", "(seller_id = '$sellerId')"); ?>
                    <img src="<?= !empty($img2) ? UPLOADS_URL . $img2 : 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTImNf14UOHtFVN3T2-HELY9-dv3PkJOJPdiA&s' ?>"
                        alt="Fast Delivery" class="mx-auto w-24 h-24 object-cover rounded-full mb-5 shadow-md">

                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Fast Delivery</h3>
                    <p class="text-gray-500 text-sm">Get your orders delivered quickly with our reliable shipping
                        partners.</p>
                </div>

                <!-- Card 3 -->
                <div class="bg-cyan-100 p-6 rounded-3xl shadow-lg transform transition-transform duration-300 hover:-translate-y-4 hover:scale-105
       w-full max-w-xs sm:max-w-sm md:max-w-md mx-auto">
                    <?php $img3 = getData("featured_image_3", "seller_banners", "(seller_id = '$sellerId')"); ?>
                    <img src="<?= !empty($img3) ? UPLOADS_URL . $img3 : 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR3yf-ZigU47H1qW8DLYCWi7C95rdFjjP9jFQ&s' ?>"
                        alt="Fast Delivery" class="mx-auto w-24 h-24 object-cover rounded-full mb-5 shadow-md">

                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Fast Delivery</h3>
                    <p class="text-gray-500 text-sm">Get your orders delivered quickly with our reliable shipping
                        partners.</p>
                </div>

            </div>
        </div>
    </section>
    <!--Why Shop With Us End-->


    <!-- Video Commerce Section Start -->
    <section class="py-16 px-4 bg-gray-50">
        <div class="container mx-auto">
            <!-- Video Commerce Heading-->
            <div class="text-center mb-8">
                <h2 class="text-2xl sm:text-3xl md:text-4xl lg:text-4xl font-bold text-gray-800 mb-1">
                    Shop with Videos
                </h2>
                <p class="text-base sm:text-lg md:text-xl text-gray-600 max-w-2xl mx-auto">
                    Explore our diverse collection of toys for all ages and interests
                </p>

            </div>
            <!-- Video Commerce Grid-->
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6">
                <!--Video - 1 -->
                <div class="video-card relative w-full h-[250px] sm:h-[300px] md:h-[350px] bg-gray-200 rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition cursor-pointer"
                    data-video="https://www.youtube.com/embed/tgbNymZ7vqY" data-name="Premium Teddy Bear"
                    data-price="₹1,499">

                    <img src="https://i.pinimg.com/736x/ac/ae/0f/acae0f19de54e8af64cc169466a899d5.jpg" alt="Video 1"
                        class="w-full h-full object-cover">

                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="relative">
                            <span class="absolute h-16 w-16 rounded-full bg-red-500 opacity-40 animate-wave"></span>
                            <span
                                class="absolute h-16 w-16 rounded-full bg-red-500 opacity-35 animate-wave delay-[400ms]"></span>
                            <span
                                class="absolute h-16 w-16 rounded-full bg-red-500 opacity-30 animate-wave delay-[800ms]"></span>
                            <span
                                class="absolute h-16 w-16 rounded-full bg-red-500 opacity-25 animate-wave delay-[1200ms]"></span>
                            <span
                                class="absolute h-16 w-16 rounded-full bg-red-500 opacity-20 animate-wave delay-[1600ms]"></span>

                            <div
                                class="relative flex items-center justify-center h-16 w-16 rounded-full bg-red-600 text-white shadow-lg hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-play text-xl ml-1"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!--Video - 1 -->
                <div class="video-card relative w-full h-[250px] sm:h-[300px] md:h-[350px] bg-gray-200 rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition cursor-pointer"
                    data-video="https://www.youtube.com/embed/tgbNymZ7vqY" data-name="Premium Teddy Bear"
                    data-price="₹1,499">

                    <img src="https://i.pinimg.com/736x/ac/ae/0f/acae0f19de54e8af64cc169466a899d5.jpg" alt="Video 1"
                        class="w-full h-full object-cover">

                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="relative">
                            <span class="absolute h-16 w-16 rounded-full bg-red-500 opacity-40 animate-wave"></span>
                            <span
                                class="absolute h-16 w-16 rounded-full bg-red-500 opacity-35 animate-wave delay-[400ms]"></span>
                            <span
                                class="absolute h-16 w-16 rounded-full bg-red-500 opacity-30 animate-wave delay-[800ms]"></span>
                            <span
                                class="absolute h-16 w-16 rounded-full bg-red-500 opacity-25 animate-wave delay-[1200ms]"></span>
                            <span
                                class="absolute h-16 w-16 rounded-full bg-red-500 opacity-20 animate-wave delay-[1600ms]"></span>

                            <div
                                class="relative flex items-center justify-center h-16 w-16 rounded-full bg-red-600 text-white shadow-lg hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-play text-xl ml-1"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Video Commerce Section End -->

    <!-- Video Popup Start-->
    <div id="videoModal" class="hidden fixed inset-0 bg-black/70 flex items-center justify-center z-50">

        <!-- Premium 3D Close Button fixed top-right -->
        <button id="closeModal"
            class="fixed top-5 right-5 w-14 h-14 rounded-full bg-gradient-to-br from-red-600 to-red-500 shadow-2xl flex items-center justify-center text-white text-3xl font-bold leading-none hover:from-red-700 hover:to-red-600 active:scale-95 transition-transform z-50"
            title="Close">
            <span class="-translate-y-0.5 inline-block">&times;</span>
        </button>

        <!-- Modal Content -->
        <div
            class="backdrop-blur-xl bg-white/90 w-11/12 md:w-4/5 lg:w-3/5 rounded-2xl shadow-2xl overflow-hidden flex flex-col md:flex-row max-h-[90vh] animate-fadeIn">

            <!-- Left: Video -->
            <div class="w-full md:w-3/5 h-[200px] sm:h-[300px] md:h-auto bg-black flex items-center justify-center">
                <iframe id="videoFrame" src="" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen
                    class="w-full h-full rounded-lg"></iframe>
            </div>

            <!-- Right: Product Info -->
            <div class="w-full md:w-2/5 p-6 flex flex-col justify-between">
                <div>
                    <h3 id="productName" class="text-2xl font-bold text-gray-800">Product Name</h3>
                    <p id="productPrice" class="text-pink-600 text-xl font-semibold mt-2">₹0</p>

                    <div class="flex items-center gap-2 mt-2">
                        <span class="w-2.5 h-2.5 bg-green-500 rounded-full animate-pulse"></span>
                        <span class="text-sm text-gray-600 font-medium">In Stock</span>
                    </div>

                    <p class="text-gray-600 mt-4">
                        Order this product while watching the video. Limited time offer available!
                    </p>
                </div>

                <div class="mt-6 flex items-center gap-3">
                    <button
                        class="w-10 h-10 flex items-center justify-center bg-gray-200 rounded-lg text-lg font-bold hover:bg-gray-300 transition"
                        id="decreaseQty">-</button>
                    <span id="quantity" class="text-lg font-semibold">1</span>
                    <button
                        class="w-10 h-10 flex items-center justify-center bg-gray-200 rounded-lg text-lg font-bold hover:bg-gray-300 transition"
                        id="increaseQty">+</button>
                </div>

                <div class="mt-6 flex gap-3">
                    <button
                        class="flex-1 px-5 py-3 bg-pink-600 text-white rounded-lg shadow hover:bg-pink-700 transition">
                        Add to Cart
                    </button>
                    <button
                        class="flex-1 px-5 py-3 bg-gray-200 text-gray-700 rounded-lg shadow hover:bg-gray-300 transition">
                        Buy Now
                    </button>
                </div>
            </div>
        </div>

    </div>
    <!-- Video Popup Start End-->


    <!-- About Section Start -->
    <?php
    // Fetch data
    $aboutContent = $sellerId ? getData("about_content", "homepage_settings", "(seller_id = '$sellerId')") : '';
    $aboutImage = $sellerId ? getData("about_image", "homepage_settings", "(seller_id = '$sellerId')") : '';

    // Hide section if both are empty
    if (empty($aboutContent) && empty($aboutImage)) return;
    ?>
    <section class="py-16 px-4 bg-gray-50 bg-gradient-to-r from-pink-200 via-white to-pink-200">
        <div class="container mx-auto flex flex-col md:flex-row items-center gap-6
            <?= empty($aboutImage) ? 'justify-center text-center' : '' ?>">

            <!-- Left: Image -->
            <?php if (!empty($aboutImage)) : ?>
                <div class="<?= !empty($aboutContent) ? 'w-full md:w-1/2' : 'w-full flex justify-center' ?>">
                    <div class="relative rounded-2xl shadow-2xl overflow-hidden 
                    w-11/12 sm:w-10/12 md:w-4/5 lg:w-4/5  <!-- increased width on desktop -->
                    h-64 sm:h-80 md:h-64 lg:h-80  <!-- slightly taller for desktop -->
                    aspect-[16/9]">
                        <img src="<?= UPLOADS_URL . $aboutImage ?>" alt="About Us"
                            class="w-full h-full object-cover object-center">
                    </div>
                </div>
            <?php endif; ?>

            <!-- Right: Text Content -->
            <?php if (!empty($aboutContent)) : ?>
                <div class="<?= !empty($aboutImage) ? 'w-full md:w-1/2' : 'w-full' ?> flex flex-col justify-center">
                    <h2 class="text-2xl sm:text-3xl md:text-4xl lg:text-4xl font-bold text-gray-800 mb-2
                   <?= empty($aboutImage) ? 'text-center' : 'text-left md:text-left' ?>">
                        About <?= $storeName ?? 'Our Brand' ?>
                    </h2>
                    <p class="text-base sm:text-lg md:text-xl text-gray-600 max-w-2xl mx-auto
                  <?= empty($aboutImage) ? 'text-center' : 'md:mx-0 text-left' ?>
                  leading-relaxed">
                        <?= htmlspecialchars($aboutContent) ?>
                    </p>
                </div>
            <?php endif; ?>

        </div>
    </section>
    <!-- About Section End -->


    <!-- Footer Start-->
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
    <!-- Footer End-->

    <?php include_once __DIR__ . "/includes/footer_link.php"; ?>

</body>

</html>