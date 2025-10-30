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
            height: 400px;
            /* Desktop */
            max-height: 80vh;
        }

        @media (max-width: 768px) {
            #slider {
                height: 350px;
                /* Tablet */
                max-height: 60vh;
            }
        }

        @media (max-width: 640px) {
            #slider {
                height: 250px;
                /* Mobile */
                max-height: 40vh;
            }
        }

        #offer {
            height: 400px;
            /* Desktop */
            max-height: 80vh;
        }

        @media (max-width: 768px) {
            #offer {
                height: 350px;
                /* Tablet */
                max-height: 60vh;
            }
        }

        @media (max-width: 640px) {
            #offer {
                height: 250px;
                /* Mobile */
                max-height: 40vh;
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

        /*------------- Product Category CTA Button -------------*/
        .explore-btn {
            --primary: <?= htmlspecialchars(getData("color", "seller_settings", "(seller_id='$sellerId' AND store_id='$storeId')") ?? '#ff007f') ?>;
            --hover-color: <?= htmlspecialchars(getData("hover_color", "seller_settings", "(seller_id='$sellerId' AND store_id='$storeId')") ?? '#ec4899') ?>;
            background: linear-gradient(to right,
                    var(--primary),
                    color-mix(in srgb, var(--primary) 70%, #ec4899),
                    color-mix(in srgb, var(--primary) 40%, #6366f1));
            transition: all 0.3s ease;
        }

        .explore-btn:hover {
            background: linear-gradient(to right,
                    var(--hover-color),
                    color-mix(in srgb, var(--hover-color) 70%, #ec4899),
                    color-mix(in srgb, var(--hover-color) 40%, #6366f1));
        }

        .explore-btn svg {
            color: white;
            transition: all 0.3s ease;
            border-color: white;
        }

        .explore-btn:hover svg {
            color: white;
            border-color: white;
        }

        /*------------- Go To Cart Sticky -------------*/
        @keyframes slideOutRightPrompt {
            0% {
                transform: translateX(120%);
                opacity: 0;
            }

            20%,
            80% {
                transform: translateX(0);
                opacity: 1;
            }

            100% {
                transform: translateX(120%);
                opacity: 0;
            }
        }

        .animate-slide-outgroup {
            animation: slideOutRightPrompt 10s ease-in-out infinite;
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
            animation: fadeIn 0.4s ease-out;
        }
    </style>

</head>

<body class="font-sans">

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

    <!--Php File Include For Nav Bar-->
    <?php include_once __DIR__ . "/includes/navbar.php"; ?>


    <!-- Header Slide Start -->
    <?php
    // Fetch banner images and links
    $banners = [];
    for ($i = 1; $i <= 4; $i++) {
        $column = "homepage_banner" . ($i > 1 ? "_$i" : "");
        $link_column = "homepage_banner_link" . ($i > 1 ? "_$i" : "");

        $image = getData($column, "seller_banners", "(seller_id = '$sellerId' AND store_id = '$storeId')");
        $link = getData($link_column, "seller_banners", "(seller_id = '$sellerId' AND store_id = '$storeId')");

        if (!empty($image)) {
            $banners[] = ['image' => $image, 'link' => $link];
        }
    }

    // Only render slider if there are banners
    if (!empty($banners)) :
    ?>
        <header id="slider" class="relative w-[95%] mx-auto my-4 flex items-center justify-center">
            <?php
            // Render banners
            foreach ($banners as $index => $banner) {
                $opacity = $index === 0 ? "opacity-100" : "opacity-0";
                echo '<div class="absolute inset-0 flex items-center justify-center ' . $opacity . ' transition-opacity duration-1000 slide">';
                if (!empty($banner['link'])) {
                    echo '<a href="' . $banner['link'] . '" target="_blank" class="block w-full h-full flex items-center justify-center">';
                    echo '<img src="' . UPLOADS_URL . $banner['image'] . '" 
                     class="max-w-full max-h-full w-auto h-auto rounded-2xl shadow-2xl" 
                     alt="Slide ' . ($index + 1) . '">';
                    echo '</a>';
                } else {
                    echo '<img src="' . UPLOADS_URL . $banner['image'] . '" 
                     class="max-w-full max-h-full w-auto h-auto rounded-2xl shadow-2xl" 
                     alt="Slide ' . ($index + 1) . '">';
                }
                echo '</div>';
            }
            ?>
            <div id="dots" class="absolute bottom-6 left-1/2 -translate-x-1/2 flex gap-3 z-20"></div>
        </header>
    <?php endif; ?>
    <!-- Header slide End  -->

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
        <section class="py-16 bg-gray-50 md:px-4 bg-white">
            <div class="container mx-auto md:max-w-none max-w-6xl px-4 md:px-20">
                <!-- Product Categories Section Heading -->
                <div class="text-center mb-8">
                    <h2 class="text-2xl sm:text-3xl md:text-4xl lg:text-4xl font-bold text-gray-800 mb-1">
                        Shop By Category
                    </h2>
                    <p class="text-base sm:text-lg md:text-xl text-gray-600 max-w-2xl mx-auto">
                        Take a quick look inside. Explore trending picks and discover what’s made just for you.
                    </p>
                </div>

                <!-- Categories Grid -->
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-3 lg:grid-cols-5 gap-4 gap-y-10 items-stretch">
                    <?php foreach ($categories as $category) :
                        $catImage = !empty($category['icon']) ? UPLOADS_URL . $category['icon'] : 'https://via.placeholder.com/400x160?text=No+Image';
                        $categoryUrl = $storeUrl . "category/" . $category['slug'];
                        $primary_color = getData("color", "seller_settings", "(seller_id='$sellerId' AND store_id='$storeId')") ?? '#ff007f';
                        $hover_color = getData("hover_color", "seller_settings", "(seller_id='$sellerId' AND store_id='$storeId')") ?? '#ec4899';
                    ?>
                        <a href="<?= $categoryUrl ?>" class="block">
                            <div class="group relative overflow-hidden rounded-xl bg-white transition-all duration-300 hover:-translate-y-1 cursor-pointer flex flex-col h-full"
                                style="
                                --primary: <?= htmlspecialchars($primary_color) ?>; 
                                --hover-color: <?= htmlspecialchars($hover_color) ?>; 
                                border: 2px solid color-mix(in srgb, var(--primary) 20%, transparent);
                                box-shadow: 0 4px 6px -1px color-mix(in srgb, var(--primary) 15%, transparent), 0 2px 4px -1px color-mix(in srgb, var(--primary) 10%, transparent);
                            "
                                onmouseover="this.style.boxShadow='0 10px 25px -3px color-mix(in srgb, var(--hover-color) 25%, transparent), 0 4px 6px -2px color-mix(in srgb, var(--hover-color) 15%, transparent)'; this.style.borderColor='color-mix(in srgb, var(--hover-color) 40%, transparent)'"
                                onmouseout="this.style.boxShadow='0 4px 6px -1px color-mix(in srgb, var(--primary) 15%, transparent), 0 2px 4px -1px color-mix(in srgb, var(--primary) 10%, transparent)'; this.style.borderColor='color-mix(in srgb, var(--primary) 20%, transparent)'">

                                <div class="relative overflow-hidden bg-white flex items-center justify-center h-40">
                                    <img
                                        src="<?= $catImage ?>"
                                        alt="<?= $category['name'] ?>"
                                        class="max-w-[80%] max-h-[80%] object-contain object-center transition-transform duration-500 group-hover:scale-105">
                                    <div class="absolute inset-0 bg-gradient-to-br from-transparent via-white/70 to-transparent -translate-x-full -translate-y-full group-hover:translate-x-full group-hover:translate-y-full transition-transform duration-700">
                                    </div>
                                </div>

                                <div class="p-3 flex-1 flex items-center justify-between transition-all duration-300"
                                    style="background: linear-gradient(135deg, color-mix(in srgb, var(--primary) 15%, white), color-mix(in srgb, var(--primary) 30%, white));"
                                    onmouseover="this.style.background='linear-gradient(135deg, color-mix(in srgb, var(--hover-color) 20%, white), color-mix(in srgb, var(--hover-color) 35%, white))'"
                                    onmouseout="this.style.background='linear-gradient(135deg, color-mix(in srgb, var(--primary) 15%, white), color-mix(in srgb, var(--primary) 30%, white))'">
                                    <h3 class="font-semibold text-gray-800 transition-colors duration-300 group-hover:text-gray-900">
                                        <?= $category['name'] ?>
                                    </h3>
                                    <svg class="w-6 h-6 sm:w-7 sm:h-7 justify-end rounded-full p-1 sm:p-2 bg-white ease-linear duration-300 rotate-45 group-hover:rotate-90 border transition-all duration-300"
                                        viewBox="0 0 16 19" xmlns="http://www.w3.org/2000/svg"
                                        style="color: white; border-color: var(--primary); background: var(--primary);"
                                        onmouseover="this.style.borderColor='var(--hover-color)'; this.style.background='var(--hover-color)'; this.style.color='white'"
                                        onmouseout="this.style.borderColor='var(--primary)'; this.style.background='var(--primary)'; this.style.color='white'">
                                        <path
                                            d="M7 18C7 18.5523 7.44772 19 8 19C8.55228 19 9 18.5523 9 18H7ZM8.70711 0.292893C8.31658 -0.0976311 7.68342 -0.0976311 7.29289 0.292893L0.928932 6.65685C0.538408 7.04738 0.538408 7.68054 0.928932 8.07107C1.31946 8.46159 1.95262 8.46159 2.34315 8.07107L8 2.41421L13.6569 8.07107C14.0474 8.46159 14.6805 8.46159 15.0711 8.07107C15.4616 7.68054 15.4616 7.04738 15.0711 6.65685L8.70711 0.292893ZM9 18L9 1H7L7 18H9Z"
                                            class="fill-current"></path>
                                    </svg>
                                </div>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>


                <div class="flex justify-center mt-8">
                    <a href="<?= $storeUrl ?>shop-all"
                        class="explore-btn flex justify-center gap-2 items-center mx-auto shadow-lg text-base sm:text-lg text-white hover:text-white lg:font-semibold isolation-auto border-transparent before:absolute before:w-full before:transition-all before:duration-700 before:hover:w-full before:-left-full before:hover:left-0 before:rounded-full before:bg-white/20 before:-z-10 before:hover:scale-150 before:hover:duration-700 relative z-10 px-14 py-2 sm:px-16 sm:py-3 overflow-hidden rounded-full group">
                        Explore
                        <svg class="w-7 h-7 sm:w-8 sm:h-8 justify-end rounded-full p-1 sm:p-2 bg-white/20 ease-linear duration-300 rotate-45 group-hover:rotate-90 border border-white group-hover:border-white group-hover:text-white transition-all duration-300"
                            viewBox="0 0 16 19" xmlns="http://www.w3.org/2000/svg"
                            style="color: white;">
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

    <!-- Latest Product Section Start-->

    <section class="py-16 bg-gray-50 md:px-4">
        <div class="container mx-auto md:max-w-none max-w-6xl px-4 md:px-20">

            <!-- Section Heading -->
            <div class="text-center mb-8">
                <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-800 mb-1">New Collections</h2>
                <p class="text-base sm:text-lg md:text-xl text-gray-600 max-w-2xl mx-auto">
                    Explore what’s trending with fresh styles and endless inspiration.
                </p>
            </div>

            <!-- Product Grid -->
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4 gap-y-10 items-stretch">
                <?php
                $products = getProducts(); // Fetch all products
                $counter = 0;

                foreach ($products as $product) {
                    if ($counter >= 10) break; // Stop after 10 products
                    echo getProductHtml($product["id"], "group relative bg-white rounded-lg overflow-hidden shadow hover:shadow-lg transition duration-300 flex flex-col");
                    $counter++;
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
        $img = getData($imgColumn, "seller_banners", "(seller_id = '$sellerId' AND store_id = '$storeId')");
        if (!empty($img)) {
            $offerSlides[] = $img;
        }
    }

    // Only render section if there are images
    if (!empty($offerSlides)):
    ?>
        <section class="py-8 bg-pink-50">
            <div class="container mx-auto max-w-6xl px-4">

                <!-- Special Offer Heading -->
                <div class="text-center mb-6">
                    <h3 class="text-2xl sm:text-3xl md:text-3xl lg:text-4xl font-bold text-gray-800 mb-1">Special Offers</h3>
                    <p class="text-base sm:text-lg md:text-lg text-gray-600 max-w-2xl mx-auto">Big savings for a limited time. Explore today's best deals and save more.</p>
                </div>

                <!-- FIXED: Reduced height for better responsiveness -->
                <div id="offerWrapper" class="relative w-[95%] mx-auto my-4 h-[250px] sm:h-[300px] md:h-[350px]">
                    <div id="offerTrack" class="relative w-full h-full">
                        <?php foreach ($offerSlides as $index => $slideImg): ?>
                            <div class="absolute inset-0 flex items-center justify-center transition-opacity duration-1000 offer-slide <?= $index === 0 ? 'opacity-100 z-10' : 'opacity-0 z-0' ?>">
                                <a href="<?= $storeUrl ?>shop-all" class="block w-full h-full flex items-center justify-center">
                                    <img src="<?= UPLOADS_URL . $slideImg ?>" alt="Offer <?= $index + 1 ?>"
                                        class="max-w-full max-h-full w-auto h-auto rounded-2xl shadow-2xl object-contain">
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Dots indicator -->
                    <div id="offerDots" class="absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-3 z-20"></div>
                </div>

                <!-- Buttons below slider -->
                <?php
                $primary_color = getData("color", "seller_settings", "(seller_id='$sellerId' AND store_id='$storeId')") ?? '#ff007f';
                $hover_color = getData("hover_color", "seller_settings", "(seller_id='$sellerId' AND store_id='$storeId')") ?? '#ec4899';
                ?>

                <div class="flex justify-center gap-4 mt-4 px-2">
                    <!-- Prev -->
                    <button id="prevOffer"
                        class="w-10 h-10 flex items-center justify-center rounded-full text-white shadow-lg backdrop-blur-md border border-white/30 transition-all duration-300"
                        style="background: linear-gradient(135deg, <?= htmlspecialchars($primary_color) ?> 0%, <?= htmlspecialchars($hover_color) ?> 100%);"
                        onmouseover="this.style.background='linear-gradient(135deg, <?= htmlspecialchars($hover_color) ?> 0%, <?= htmlspecialchars($primary_color) ?> 100%)'; this.style.transform='scale(1.1)'; this.style.boxShadow='0 8px 20px rgba(0,0,0,0.2)';"
                        onmouseout="this.style.background='linear-gradient(135deg, <?= htmlspecialchars($primary_color) ?> 0%, <?= htmlspecialchars($hover_color) ?> 100%)'; this.style.transform='scale(1)'; this.style.boxShadow='0 4px 10px rgba(0,0,0,0.1)';">
                        <i class='bx bx-chevron-left text-lg'></i>
                    </button>

                    <!-- Play/Pause -->
                    <button id="toggleAutoplay"
                        class="w-10 h-10 flex items-center justify-center rounded-full text-white shadow-lg backdrop-blur-md border border-white/30 transition-all duration-300"
                        style="background: linear-gradient(135deg, <?= htmlspecialchars($primary_color) ?> 0%, <?= htmlspecialchars($hover_color) ?> 100%);"
                        onmouseover="this.style.background='linear-gradient(135deg, <?= htmlspecialchars($hover_color) ?> 0%, <?= htmlspecialchars($primary_color) ?> 100%)'; this.style.transform='scale(1.1)'; this.style.boxShadow='0 8px 20px rgba(0,0,0,0.2)';"
                        onmouseout="this.style.background='linear-gradient(135deg, <?= htmlspecialchars($primary_color) ?> 0%, <?= htmlspecialchars($hover_color) ?> 100%)'; this.style.transform='scale(1)'; this.style.boxShadow='0 4px 10px rgba(0,0,0,0.1)';">
                        <i class='bx bx-pause text-lg'></i>
                    </button>

                    <!-- Next -->
                    <button id="nextOffer"
                        class="w-10 h-10 flex items-center justify-center rounded-full text-white shadow-lg backdrop-blur-md border border-white/30 transition-all duration-300"
                        style="background: linear-gradient(135deg, <?= htmlspecialchars($primary_color) ?> 0%, <?= htmlspecialchars($hover_color) ?> 100%);"
                        onmouseover="this.style.background='linear-gradient(135deg, <?= htmlspecialchars($hover_color) ?> 0%, <?= htmlspecialchars($primary_color) ?> 100%)'; this.style.transform='scale(1.1)'; this.style.boxShadow='0 8px 20px rgba(0,0,0,0.2)';"
                        onmouseout="this.style.background='linear-gradient(135deg, <?= htmlspecialchars($primary_color) ?> 0%, <?= htmlspecialchars($hover_color) ?> 100%)'; this.style.transform='scale(1)'; this.style.boxShadow='0 4px 10px rgba(0,0,0,0.1)';">
                        <i class='bx bx-chevron-right text-lg'></i>
                    </button>
                </div>

            </div>
        </section>
    <?php endif; ?>
    <!-- Special Offer Section End -->


    <!-- Random Product Section Start-->

    <section class="py-16 bg-gray-50 md:px-4">
        <div class="container mx-auto md:max-w-none max-w-6xl px-4 md:px-20">

            <!-- Section Heading -->
            <div class="text-center mb-8">
                <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-800 mb-1">Popular Products</h2>
                <p class="text-base sm:text-lg md:text-xl text-gray-600 max-w-2xl mx-auto">
                    Explore our best selling products from top brands
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

    <!--Why Shop With Us Start-->
    <section class="bg-white py-20">
        <div class="max-w-6xl mx-auto px-4 text-center">
            <!--Why Shop With Us Heading-->
            <h2 class="text-2xl sm:text-3xl md:text-4xl lg:text-4xl font-bold text-gray-800 mb-1">Why Shop With <span
                    class="text-hover">Us</span></h2>
            <p class="text-base sm:text-lg md:text-xl text-gray-600 max-w-2xl mx-auto mb-8">We bring you quality products with honest service and an easy shopping experience.</p>

            <!-- Cards Grid-->
            <div
                class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-[repeat(auto-fit,minmax(250px,1fr))] gap-8 justify-center">

                <!-- Card 1 -->
                <div class="bg-sky-500/50 p-6 rounded-3xl shadow-lg transform transition-transform duration-300 hover:-translate-y-4 hover:scale-105
       w-full max-w-xs sm:max-w-sm md:max-w-md mx-auto">
                    <?php $img1 = getData("featured_image_1", "seller_banners", "(seller_id = '$sellerId' AND store_id = '$storeId')"); ?>
                    <img src="<?= !empty($img1)
                                    ? UPLOADS_URL . $img1
                                    : APP_URL . 'assets/image/theme_9_fd.jpg' ?>"
                        alt="Fast Delivery" class="mx-auto w-24 h-24 object-cover rounded-full mb-5 shadow-md">

                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Fast Delivery</h3>
                    <p class="text-gray-500 text-sm">Get your orders delivered quickly with our reliable shipping
                        partners.</p>
                </div>

                <!-- Card 2 -->
                <div class=" bg-yellow-200 p-6 rounded-3xl shadow-lg transform transition-transform duration-300 hover:-translate-y-4 hover:scale-105
       w-full max-w-xs sm:max-w-sm md:max-w-md mx-auto">
                    <?php $img2 = getData("featured_image_2", "seller_banners", "(seller_id = '$sellerId' AND store_id = '$storeId')"); ?>
                    <img src="<?= !empty($img1)
                                    ? UPLOADS_URL . $img1
                                    : APP_URL . 'assets/image/theme_9_s&s.jpg' ?>"
                        alt="Fast Delivery" class="mx-auto w-24 h-24 object-cover rounded-full mb-5 shadow-md">

                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Safe & Secure</h3>
                    <p class="text-gray-500 text-sm">Get your orders delivered quickly with our reliable shipping
                        partners.</p>
                </div>

                <!-- Card 3 -->
                <div class="bg-cyan-100 p-6 rounded-3xl shadow-lg transform transition-transform duration-300 hover:-translate-y-4 hover:scale-105
       w-full max-w-xs sm:max-w-sm md:max-w-md mx-auto">
                    <?php $img3 = getData("featured_image_3", "seller_banners", "(seller_id = '$sellerId' AND store_id = '$storeId')"); ?>
                    <img src="<?= !empty($img1)
                                    ? UPLOADS_URL . $img1
                                    : APP_URL . 'assets/image/theme_9_hc.jpg' ?>"
                        alt="Fast Delivery" class="mx-auto w-24 h-24 object-cover rounded-full mb-5 shadow-md">
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">100 + Happy Customers</h3>
                    <p class="text-gray-500 text-sm">Get your orders delivered quickly with our reliable shipping
                        partners.</p>
                </div>

            </div>
        </div>
    </section>
    <!--Why Shop With Us End-->


    <!-- Video Commerce Section Start -->
    <!-- <section class="py-16 px-4 bg-gray-50">
        <div class="container mx-auto"> -->
    <!-- Video Commerce Heading-->
    <!-- <div class="text-center mb-8">
                <h2 class="text-2xl sm:text-3xl md:text-4xl lg:text-4xl font-bold text-gray-800 mb-1">
                    Shop with Videos
                </h2>
                <p class="text-base sm:text-lg md:text-xl text-gray-600 max-w-2xl mx-auto">
                    Explore our diverse collection of toys for all ages and interests
                </p>

            </div> -->
    <!-- Video Commerce Grid-->
    <!-- <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6"> -->
    <!--Video - 1 -->
    <!-- <div class="video-card relative w-full h-[250px] sm:h-[300px] md:h-[350px] bg-gray-200 rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition cursor-pointer"
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
                </div> -->

    <!--Video - 1 -->
    <!-- <div class="video-card relative w-full h-[250px] sm:h-[300px] md:h-[350px] bg-gray-200 rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition cursor-pointer"
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
    </section> -->
    <!-- Video Commerce Section End -->

    <!-- Video Popup Start-->
    <!-- <div id="videoModal" class="hidden fixed inset-0 bg-black/70 flex items-center justify-center z-50"> -->

    <!-- Premium 3D Close Button fixed top-right -->
    <!-- <button id="closeModal"
            class="fixed top-5 right-5 w-14 h-14 rounded-full bg-gradient-to-br from-red-600 to-red-500 shadow-2xl flex items-center justify-center text-white text-3xl font-bold leading-none hover:from-red-700 hover:to-red-600 active:scale-95 transition-transform z-50"
            title="Close">
            <span class="-translate-y-0.5 inline-block">&times;</span>
        </button> -->

    <!-- Modal Content -->
    <!-- <div
            class="backdrop-blur-xl bg-white/90 w-11/12 md:w-4/5 lg:w-3/5 rounded-2xl shadow-2xl overflow-hidden flex flex-col md:flex-row max-h-[90vh] animate-fadeIn"> -->

    <!-- Left: Video -->
    <!-- <div class="w-full md:w-3/5 h-[200px] sm:h-[300px] md:h-auto bg-black flex items-center justify-center">
                <iframe id="videoFrame" src="" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen
                    class="w-full h-full rounded-lg"></iframe>
            </div> -->

    <!-- Right: Product Info -->
    <!-- <div class="w-full md:w-2/5 p-6 flex flex-col justify-between">
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

    </div> -->
    <!-- Video Popup Start End-->


    <!-- About Section Start -->
    <?php
    // Fetch data
    $aboutContent = $sellerId ? getData("about_content", "homepage_settings", "(seller_id = '$sellerId' AND store_id = '$storeId')") : '';
    $aboutImage = $sellerId ? getData("about_image", "homepage_settings", "(seller_id = '$sellerId' AND store_id = '$storeId')") : '';
    $color = getData("color", "seller_settings", "(seller_id = '$sellerId' AND store_id = '$storeId')");
    ?>

    <?php if (!empty($aboutContent) || !empty($aboutImage)) : ?>
        <section
            class="py-16 px-4 bg-gradient-to-r from-[var(--primary)] via-white to-[var(--primary)] opacity-70"
            style="--primary: <?= htmlspecialchars($color ?? '#ff007f') ?>;">



            <div class="container mx-auto flex flex-col md:flex-row items-center gap-6
            <?= empty($aboutImage) ? 'justify-center text-center' : '' ?>">

                <!-- Left: Image -->
                <?php if (!empty($aboutImage)) : ?>
                    <div class="<?= !empty($aboutContent) ? 'w-full md:w-1/2' : 'w-full flex justify-center' ?>">
                        <div class="relative rounded-2xl shadow-2xl overflow-hidden 
                        w-11/12 sm:w-10/12 md:w-4/5 lg:w-4/5 
                        h-64 sm:h-80 md:h-64 lg:h-80 
                        aspect-[16/9]">
                            <img src="<?= UPLOADS_URL . $aboutImage ?>"
                                alt="About Us"
                                class="w-full h-full object-cover object-center">
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Right: Text Content -->
                <?php if (!empty($aboutContent)) : ?>
                    <div class="<?= !empty($aboutImage) ? 'w-full md:w-1/2' : 'w-full' ?> flex flex-col justify-center">
                        <h2 class="text-2xl sm:text-3xl md:text-4xl lg:text-4xl font-bold text-black mb-2
                        <?= empty($aboutImage) ? 'text-center' : 'text-left md:text-left' ?>">
                            About <?= $storeName ?? 'Our Brand' ?>
                        </h2>
                        <p class="text-base sm:text-lg md:text-xl text-black max-w-2xl mx-auto
                        <?= empty($aboutImage) ? 'text-center' : 'md:mx-0 text-left' ?>
                        leading-relaxed">
                            <?= htmlspecialchars($aboutContent) ?>
                        </p>
                    </div>
                <?php endif; ?>

            </div>
        </section>
    <?php endif; ?>

    <!-- About Section End -->


    <!--Footer File Includes that file has all JS Files includes links-->
    <?php include_once __DIR__ . "/includes/footer.php"; ?>
    <!-- Floating Right-Side Man / Cart Prompt -->
    <a href="<?= $storeUrl ?>cart" class="group">
        <div id="cartPrompt" class="fixed right-0 bottom-32 sm:bottom-40 z-50 flex items-center gap-2 pr-2 animate-slide-outgroup cursor-pointer">

            <!-- Character or Icon -->
            <div class="relative">
                <img src="<?= APP_URL ?>assets/image/home_cart_gif.gif"
                    alt="Cart Icon"
                    class="w-24 h-24 sm:w-28 sm:h-28 md:w-32 md:h-32 lg:w-36 lg:h-36 
                  object-contain transition-transform duration-300 group-hover:scale-110">
            </div>

            <!-- Speech Bubble -->
            <div class="bg-primary-500 text-white font-semibold text-sm sm:text-base px-4 py-2 rounded-l-full shadow-lg hidden group-hover:flex items-center gap-2 animate-fadeIn">
                Go to Cart
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="2" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M5 12h14M12 5l7 7-7 7" />
                </svg>
            </div>

        </div>
    </a>



</body>

</html>