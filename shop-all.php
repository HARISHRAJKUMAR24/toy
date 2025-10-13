<?php include_once __DIR__ . "/includes/files_includes.php"; ?>


<!DOCTYPE html>
<html lang="en">

<head>
    <?php include_once __DIR__ . "/includes/head_links.php"; ?>
    <style>
        /*<==========> CSS Styles <==========>*/

        /*------------- Spin Animation For Shob By age Iamge Border -------------*/
        @layer utilities {
            .animate-spin-slow {
                animation: spin 18s linear infinite;
            }
        }

        /*------------- Hide Left Right Scrool Bar -------------*/
        .scroll-container::-webkit-scrollbar {
            display: none;
            /* Chrome, Safari */
        }

        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        /*------------- Product Category Title Zoom Style -------------*/
        .tab-button span {
            display: inline-block;
            transition: all 0.5s ease;
        }

        /*------------- Product Category Image Zoom Style -------------*/
        .tab-img {
            transition: all 0.5s ease;
        }

        /*------------- Product Category Button Image Zoom Style -------------*/
        .tab-button img {
            transition: all 0.5s ease;
        }

        /*------------- Product Category Button & Image Active Style -------------*/
        .tab-button.active .tab-img {
            border-color: #ec4899;
            box-shadow: 0 4px 15px rgba(236, 72, 153, 0.4);
            transform: scale(1.1);
        }

        .tab-button.active img {
            transform: scale(1.1);
        }

        .tab-button.active span {
            color: #ec4899;
            font-weight: bold;
            transform: scale(1.1);
        }
    </style>

</head>

<body class=" font-sans min-h-screen overflow-x-hidden">

    <!-- Minimum Order Amount Start-->
    <div class="w-full bg-pink-600 text-white text-center py-1 text-sm font-semibold">
        Minimum Order: ₹499
    </div>
    <!-- Minimum Order Amount End-->

    <!--Php File Include For Nav Bar-->
    <?php include_once __DIR__ . "/includes/navbar.php"; ?>


    <!--Shop By Age Start-->
    <?php
    // Fetch advanced categories
    $advance_categories = [];
    for ($i = 1; $i <= 6; $i++) {
        $name = getData("advance_category_name_$i", "seller_banners", "seller_id = '$sellerId'");
        $link = getData("advance_category_link_$i", "seller_banners", "seller_id = '$sellerId'");
        $image = getData("advance_category_image_$i", "seller_banners", "seller_id = '$sellerId'");

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
        <section class="py-12 bg-gray-50">
            <div class="max-w-6xl mx-auto px-4 ">
                <!--Heading-->
                <?php $main_heading = getData("advance_category_main_heading", "seller_banners", "seller_id = '$sellerId'"); ?>
                <?php if (!empty($main_heading)) : ?>
                    <h2 class="text-2xl sm:text-3xl md:text-4xl lg:text-4xl font-bold text-gray-800 mb-6 text-center mb-8">
                        <?= htmlspecialchars($main_heading) ?>
                    </h2>
                <?php endif; ?>

                <!-- Scroll Container / Centered Flex -->
                <div class="scroll-container overflow-x-auto pb-4 px-4 md:px-6 lg:px-0 -mx-4 lg:mx-0">
                    <div class="flex flex-wrap justify-center gap-6 md:gap-8">

                        <?php foreach ($advance_categories as $index => $category) :
                            // Color for border animation (cycle through colors)
                            $border_colors = ['pink-400', 'blue-400', 'green-400', 'yellow-400', 'purple-400', 'pink-600'];
                            $bg_colors = ['pink-500', 'blue-500', 'green-500', 'yellow-500', 'purple-500', 'pink-600'];
                            $color_index = $index % count($border_colors);
                        ?>
                            <div class="relative w-32 h-32 flex-shrink-0">
                                <!-- Spinning border -->
                                <div class="absolute inset-0 rounded-full border-4 border-dashed border-<?= $border_colors[$color_index] ?> animate-spin-slow"></div>
                                <!-- Image circle -->
                                <div class="relative w-28 h-28 rounded-full overflow-hidden shadow-lg mx-auto top-2 bg-gray-200 flex items-center justify-center">
                                    <?php if (!empty($category['link'])): ?>
                                        <a href="<?= $category['link'] ?>" target="_blank">
                                            <img src="<?= UPLOADS_URL . $category['image'] ?>" alt="<?= htmlspecialchars($category['name']) ?>" class="w-full h-full object-cover">
                                        </a>
                                    <?php else: ?>
                                        <img src="<?= UPLOADS_URL . $category['image'] ?>" alt="<?= htmlspecialchars($category['name']) ?>" class="w-full h-full object-cover">
                                    <?php endif; ?>
                                </div>
                                <!-- Category Name Box -->
                                <?php if (!empty($category['name'])): ?>
                                    <div class="absolute -bottom-3 left-1/2 transform -translate-x-1/2 px-2 py-0.5 bg-<?= $bg_colors[$color_index] ?> text-white text-sm font-semibold rounded-md shadow-md text-center break-words max-w-[90%] border border-white/30">
                                        <?= htmlspecialchars($category['name']) ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>

                    </div>
                </div>
            </div>
        </section>
        <!--Shop By Age End-->

    <?php endif; ?>

    <!--Shop By Age End-->





    <!--Product Category Start -->
    <div class="py-16 px-4 bg-gray-50">
        <!-- Heading -->
        <div class="text-center mb-8">
            <h2 class="text-2xl sm:text-3xl md:text-4xl lg:text-4xl font-bold text-gray-800 mb-1">
                Shop By Category
            </h2>
            <p class="text-base sm:text-lg md:text-xl text-gray-600 max-w-2xl mx-auto">
                Explore our diverse collection of toys for all ages and interests
            </p>

        </div>

        <!-- Scrollable Tabs -->
        <div id="menu-tabs"
            class="flex overflow-x-auto snap-x snap-proximity gap-6 py-3 whitespace-nowrap hide-scrollbar cursor-grab px-[50%]">
            <button class="tab-button flex flex-col items-center cursor-pointer" data-section="section1">
                <div class="tab-img w-20 h-20 rounded-full overflow-hidden border-2 border-gray-200">
                    <img src="./images/board.jpe" alt="Indo-Chinese" class="w-full h-full object-cover rounded-full">
                </div>
                <span class="mt-2 text-sm font-medium text-gray-700">Indo-Chinese</span>
            </button>

            <button class="tab-button flex flex-col items-center cursor-pointer" data-section="section2">
                <div class="tab-img w-20 h-20 rounded-full overflow-hidden border-2 border-gray-200">
                    <img src="./images/thai.jpg" alt="Thai" class="w-full h-full object-cover rounded-full">
                </div>
                <span class="mt-2 text-sm font-medium text-gray-700">Thai Starters</span>
            </button>

            <button class="tab-button flex flex-col items-center cursor-pointer" data-section="section3">
                <div class="tab-img w-20 h-20 rounded-full overflow-hidden border-2 border-gray-200">
                    <img src="./images/harmony.jpg" alt="Harmony" class="w-full h-full object-cover rounded-full">
                </div>
                <span class="mt-2 text-sm font-medium text-gray-700">Harmony</span>
            </button>

            <button class="tab-button flex flex-col items-center cursor-pointer" data-section="section4">
                <div class="tab-img w-20 h-20 rounded-full overflow-hidden border-2 border-gray-200">
                    <img src="./images/heritage.jpg" alt="Heritage" class="w-full h-full object-cover rounded-full">
                </div>
                <span class="mt-2 text-sm font-medium text-gray-700">Heritage</span>
            </button>

            <button class="tab-button flex flex-col items-center cursor-pointer" data-section="section5">
                <div class="tab-img w-20 h-20 rounded-full overflow-hidden border-2 border-gray-200">
                    <img src="./images/soya.jpg" alt="Soya Chaap" class="w-full h-full object-cover rounded-full">
                </div>
                <span class="mt-2 text-sm font-medium text-gray-700">Soya Chaap</span>
            </button>
        </div>

        <!-- Product List Sections -->
        <div class="container mx-auto overflow-hidden">

            <!-- Section 1 -->
            <div class="menu-section hidden grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 gap-y-10 items-stretch"
                id="section1">
                <!-- Product 1 -->
                <div
                    class="group relative bg-white rounded-lg overflow-hidden shadow hover:shadow-lg transition duration-300">
                    <div class="relative">
                        <img src="./images/board.jpe" alt="Product name"
                            class="w-full h-64 sm:h-72 md:h-64 lg:h-60 object-cover transition-transform duration-500 group-hover:scale-105">

                        <!-- Flexible Ribbon Badge -->
                        <div class="absolute top-2 left-2 flex flex-col items-center justify-center min-w-[3.5rem] px-2 py-1 bg-gradient-to-b from-red-600 to-red-800 text-white rounded transform rotate-[-15deg] shadow-lg border-2 border-red-300 border-opacity-50"
                            style="text-shadow: 0 1px 2px rgba(0,0,0,0.3);">
                            <span class="text-[10px] sm:text-xs font-bold uppercase">SAVE</span>
                            <span class="text-lg font-black leading-none">20%</span>
                            <div class="absolute -bottom-1 w-4/5 h-1 bg-red-900 rounded-b-lg opacity-80"></div>
                        </div>

                        <!-- Wishlist Button -->
                        <button class="absolute top-2 right-2 w-10 h-10 flex items-center justify-center 
           bg-white/95 hover:bg-pink-100 text-pink-600 rounded-full shadow-lg 
           transition transform hover:scale-110">
                            <i class="fa-solid fa-heart"></i>
                        </button>

                    </div>

                    <!-- Product Info -->
                    <div class="p-4 flex flex-col">
                        <h3
                            class="text-base sm:text-lg md:text-lg lg:text-xl font-semibold text-gray-800 group-hover:text-pink-600 transition-colors mb-1">
                            Product with Ribbon
                        </h3>

                        <!-- Star Ratings -->
                        <div class="flex items-center mb-2 text-yellow-400">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-half"></i>
                            <span class="ml-2 text-xs sm:text-sm md:text-sm text-gray-500">(5 reviews)</span>
                        </div>

                        <div class="flex items-center justify-between mt-auto">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:space-x-2">
                                <span class="text-sm sm:text-base md:text-lg font-bold">₹15,999</span>
                                <span class="text-sm sm:text-sm text-gray-400 line-through">₹19,999</span>
                            </div>


                            <!-- Add To Cart Button -->
                            <button class="relative overflow-hidden bg-gradient-to-r from-pink-200 to-pink-300 
                                   text-pink-700 px-3 py-1 rounded-md shadow transition-all duration-500 
                                   bg-[length:200%_100%] bg-left hover:bg-right sm:px-4 sm:py-1.5 md:px-5 md:py-2">
                                Add
                            </button>

                        </div>
                    </div>
                </div>

                <!-- Product 2 -->
                <div
                    class="group relative bg-white rounded-lg overflow-hidden shadow hover:shadow-lg transition duration-300">
                    <div class="relative">
                        <img src="./images/board.jpe" alt="Product name"
                            class="w-full h-64 sm:h-72 md:h-64 lg:h-60 object-cover transition-transform duration-500 group-hover:scale-105">

                        <!-- Flexible Ribbon Badge -->
                        <div class="absolute top-2 left-2 flex flex-col items-center justify-center min-w-[3.5rem] px-2 py-1 bg-gradient-to-b from-red-600 to-red-800 text-white rounded transform rotate-[-15deg] shadow-lg border-2 border-red-300 border-opacity-50"
                            style="text-shadow: 0 1px 2px rgba(0,0,0,0.3);">
                            <span class="text-[10px] sm:text-xs font-bold uppercase">SAVE</span>
                            <span class="text-lg font-black leading-none">20%</span>
                            <div class="absolute -bottom-1 w-4/5 h-1 bg-red-900 rounded-b-lg opacity-80"></div>
                        </div>

                        <!-- Wishlist Button -->
                        <button class="absolute top-2 right-2 w-10 h-10 flex items-center justify-center 
           bg-white/95 hover:bg-pink-100 text-pink-600 rounded-full shadow-lg 
           transition transform hover:scale-110">
                            <i class="fa-solid fa-heart"></i>
                        </button>

                    </div>

                    <!-- Product Info -->
                    <div class="p-4 flex flex-col">
                        <h3
                            class="text-base sm:text-lg md:text-lg lg:text-xl font-semibold text-gray-800 group-hover:text-pink-600 transition-colors mb-1">
                            Product with Ribbon
                        </h3>

                        <!-- Star Ratings -->
                        <div class="flex items-center mb-2 text-yellow-400">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-half"></i>
                            <span class="ml-2 text-xs sm:text-sm md:text-sm text-gray-500">(5 reviews)</span>
                        </div>

                        <div class="flex items-center justify-between mt-auto">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:space-x-2">
                                <span class="text-sm sm:text-base md:text-lg font-bold">₹15,999</span>
                                <span class="text-sm sm:text-sm text-gray-400 line-through">₹19,999</span>
                            </div>


                            <!-- Add To Cart Button -->
                            <button class="relative overflow-hidden bg-gradient-to-r from-pink-200 to-pink-300 
                                   text-pink-700 px-3 py-1 rounded-md shadow transition-all duration-500 
                                   bg-[length:200%_100%] bg-left hover:bg-right sm:px-4 sm:py-1.5 md:px-5 md:py-2">
                                Add
                            </button>

                        </div>
                    </div>
                </div>

                <!-- Product 3 -->
                <div
                    class="group relative bg-white rounded-lg overflow-hidden shadow hover:shadow-lg transition duration-300">
                    <div class="relative">
                        <img src="./images/board.jpe" alt="Product name"
                            class="w-full h-64 sm:h-72 md:h-64 lg:h-60 object-cover transition-transform duration-500 group-hover:scale-105">

                        <!-- Flexible Ribbon Badge-->
                        <div class="absolute top-2 left-2 flex flex-col items-center justify-center min-w-[3.5rem] px-2 py-1 bg-gradient-to-b from-red-600 to-red-800 text-white rounded transform rotate-[-15deg] shadow-lg border-2 border-red-300 border-opacity-50"
                            style="text-shadow: 0 1px 2px rgba(0,0,0,0.3);">
                            <span class="text-[10px] sm:text-xs font-bold uppercase">SAVE</span>
                            <span class="text-lg font-black leading-none">20%</span>
                            <div class="absolute -bottom-1 w-4/5 h-1 bg-red-900 rounded-b-lg opacity-80"></div>
                        </div>

                        <!-- Wishlist Button -->
                        <button class="absolute top-2 right-2 w-10 h-10 flex items-center justify-center 
           bg-white/95 hover:bg-pink-100 text-pink-600 rounded-full shadow-lg 
           transition transform hover:scale-110">
                            <i class="fa-solid fa-heart"></i>
                        </button>

                    </div>

                    <!-- Product Info -->
                    <div class="p-4 flex flex-col">
                        <h3
                            class="text-base sm:text-lg md:text-lg lg:text-xl font-semibold text-gray-800 group-hover:text-pink-600 transition-colors mb-1">
                            Product with Ribbon
                        </h3>

                        <!-- Star Ratings -->
                        <div class="flex items-center mb-2 text-yellow-400">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-half"></i>
                            <span class="ml-2 text-xs sm:text-sm md:text-sm text-gray-500">(5 reviews)</span>
                        </div>

                        <div class="flex items-center justify-between mt-auto">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:space-x-2">
                                <span class="text-sm sm:text-base md:text-lg font-bold">₹15,999</span>
                                <span class="text-sm sm:text-sm text-gray-400 line-through">₹19,999</span>
                            </div>


                            <!-- Add To Cart Button -->
                            <button class="relative overflow-hidden bg-gradient-to-r from-pink-200 to-pink-300 
                                   text-pink-700 px-3 py-1 rounded-md shadow transition-all duration-500 
                                   bg-[length:200%_100%] bg-left hover:bg-right sm:px-4 sm:py-1.5 md:px-5 md:py-2">
                                Add
                            </button>

                        </div>
                    </div>
                </div>

                <!-- Product 4 -->
                <div
                    class="group relative bg-white rounded-lg overflow-hidden shadow hover:shadow-lg transition duration-300">
                    <div class="relative">
                        <img src="./images/board.jpe" alt="Product name"
                            class="w-full h-64 sm:h-72 md:h-64 lg:h-60 object-cover transition-transform duration-500 group-hover:scale-105">

                        <!-- Flexible Ribbon Badge (unchanged) -->
                        <div class="absolute top-2 left-2 flex flex-col items-center justify-center min-w-[3.5rem] px-2 py-1 bg-gradient-to-b from-red-600 to-red-800 text-white rounded transform rotate-[-15deg] shadow-lg border-2 border-red-300 border-opacity-50"
                            style="text-shadow: 0 1px 2px rgba(0,0,0,0.3);">
                            <span class="text-[10px] sm:text-xs font-bold uppercase">SAVE</span>
                            <span class="text-lg font-black leading-none">20%</span>
                            <div class="absolute -bottom-1 w-4/5 h-1 bg-red-900 rounded-b-lg opacity-80"></div>
                        </div>

                        <!-- Wishlist Button -->
                        <button class="absolute top-2 right-2 w-10 h-10 flex items-center justify-center 
           bg-white/95 hover:bg-pink-100 text-pink-600 rounded-full shadow-lg 
           transition transform hover:scale-110">
                            <i class="fa-solid fa-heart"></i>
                        </button>

                    </div>

                    <!-- Product Info -->
                    <div class="p-4 flex flex-col">
                        <h3
                            class="text-base sm:text-lg md:text-lg lg:text-xl font-semibold text-gray-800 group-hover:text-pink-600 transition-colors mb-1">
                            Product with Ribbon
                        </h3>

                        <!-- Star Ratings -->
                        <div class="flex items-center mb-2 text-yellow-400">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-half"></i>
                            <span class="ml-2 text-xs sm:text-sm md:text-sm text-gray-500">(5 reviews)</span>
                        </div>

                        <div class="flex items-center justify-between mt-auto">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:space-x-2">
                                <span class="text-sm sm:text-base md:text-lg font-bold">₹15,999</span>
                                <span class="text-sm sm:text-sm text-gray-400 line-through">₹19,999</span>
                            </div>


                            <!-- Add To Cart Button -->
                            <button class="relative overflow-hidden bg-gradient-to-r from-pink-200 to-pink-300 
                                   text-pink-700 px-3 py-1 rounded-md shadow transition-all duration-500 
                                   bg-[length:200%_100%] bg-left hover:bg-right sm:px-4 sm:py-1.5 md:px-5 md:py-2">
                                Add
                            </button>

                        </div>
                    </div>
                </div>

                <!-- Product 5 -->
                <div
                    class="group relative bg-white rounded-lg overflow-hidden shadow hover:shadow-lg transition duration-300">
                    <div class="relative">
                        <img src="./images/board.jpe" alt="Product name"
                            class="w-full h-64 sm:h-72 md:h-64 lg:h-60 object-cover transition-transform duration-500 group-hover:scale-105">

                        <!-- Flexible Ribbon Badge (unchanged) -->
                        <div class="absolute top-2 left-2 flex flex-col items-center justify-center min-w-[3.5rem] px-2 py-1 bg-gradient-to-b from-red-600 to-red-800 text-white rounded transform rotate-[-15deg] shadow-lg border-2 border-red-300 border-opacity-50"
                            style="text-shadow: 0 1px 2px rgba(0,0,0,0.3);">
                            <span class="text-[10px] sm:text-xs font-bold uppercase">SAVE</span>
                            <span class="text-lg font-black leading-none">20%</span>
                            <div class="absolute -bottom-1 w-4/5 h-1 bg-red-900 rounded-b-lg opacity-80"></div>
                        </div>

                        <!-- Wishlist Button -->
                        <button class="absolute top-2 right-2 w-10 h-10 flex items-center justify-center 
           bg-white/95 hover:bg-pink-100 text-pink-600 rounded-full shadow-lg 
           transition transform hover:scale-110">
                            <i class="fa-solid fa-heart"></i>
                        </button>

                    </div>

                    <!-- Product Info -->
                    <div class="p-4 flex flex-col">
                        <h3
                            class="text-base sm:text-lg md:text-lg lg:text-xl font-semibold text-gray-800 group-hover:text-pink-600 transition-colors mb-1">
                            Product with Ribbon
                        </h3>

                        <!-- Star Ratings -->
                        <div class="flex items-center mb-2 text-yellow-400">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-half"></i>
                            <span class="ml-2 text-xs sm:text-sm md:text-sm text-gray-500">(5 reviews)</span>
                        </div>

                        <div class="flex items-center justify-between mt-auto">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:space-x-2">
                                <span class="text-sm sm:text-base md:text-lg font-bold">₹15,999</span>
                                <span class="text-sm sm:text-sm text-gray-400 line-through">₹19,999</span>
                            </div>


                            <!-- Add To Cart Button -->
                            <button class="relative overflow-hidden bg-gradient-to-r from-pink-200 to-pink-300 
                                   text-pink-700 px-3 py-1 rounded-md shadow transition-all duration-500 
                                   bg-[length:200%_100%] bg-left hover:bg-right sm:px-4 sm:py-1.5 md:px-5 md:py-2">
                                Add
                            </button>

                        </div>
                    </div>
                </div>

                <!-- Add more product cards for Section 1 here -->
            </div>

            <!-- Section 2 -->
            <div class="menu-section hidden pt-6 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6"
                id="section2">
                <!-- Product 3 -->
                <div
                    class="group relative bg-white rounded-lg overflow-hidden shadow hover:shadow-lg transition duration-300">
                    <div class="relative">
                        <img src="./images/board.jpe" alt="Product name"
                            class="w-full h-64 sm:h-72 md:h-64 lg:h-60 object-cover transition-transform duration-500 group-hover:scale-105">

                        <!-- Flexible Ribbon Badge -->
                        <div class="absolute top-2 left-2 flex flex-col items-center justify-center min-w-[3.5rem] px-2 py-1 bg-gradient-to-b from-red-600 to-red-800 text-white rounded transform rotate-[-15deg] shadow-lg border-2 border-red-300 border-opacity-50"
                            style="text-shadow: 0 1px 2px rgba(0,0,0,0.3);">
                            <span class="text-[10px] sm:text-xs font-bold uppercase">SAVE</span>
                            <span class="text-lg font-black leading-none">20%</span>
                            <div class="absolute -bottom-1 w-4/5 h-1 bg-red-900 rounded-b-lg opacity-80"></div>
                        </div>

                        <!-- Wishlist Button -->
                        <button class="absolute top-2 right-2 w-10 h-10 flex items-center justify-center 
           bg-white/95 hover:bg-pink-100 text-pink-600 rounded-full shadow-lg 
           transition transform hover:scale-110">
                            <i class="fa-solid fa-heart"></i>
                        </button>

                    </div>

                    <!-- Product Info -->
                    <div class="p-4 flex flex-col">
                        <h3
                            class="text-base sm:text-lg md:text-lg lg:text-xl font-semibold text-gray-800 group-hover:text-pink-600 transition-colors mb-1">
                            Product with Ribbon
                        </h3>

                        <!-- Star Ratings -->
                        <div class="flex items-center mb-2 text-yellow-400">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-half"></i>
                            <span class="ml-2 text-xs sm:text-sm md:text-sm text-gray-500">(5 reviews)</span>
                        </div>

                        <div class="flex items-center justify-between mt-auto">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:space-x-2">
                                <span class="text-sm sm:text-base md:text-lg font-bold">₹15,999</span>
                                <span class="text-sm sm:text-sm text-gray-400 line-through">₹19,999</span>
                            </div>


                            <!-- Add To Cart Button -->
                            <button class="relative overflow-hidden bg-gradient-to-r from-pink-200 to-pink-300 
                                   text-pink-700 px-3 py-1 rounded-md shadow transition-all duration-500 
                                   bg-[length:200%_100%] bg-left hover:bg-right sm:px-4 sm:py-1.5 md:px-5 md:py-2">
                                Add
                            </button>

                        </div>
                    </div>
                </div>

                <!-- Product 4 -->
                <div
                    class="group relative bg-white rounded-lg overflow-hidden shadow hover:shadow-lg transition duration-300">
                    <div class="relative">
                        <img src="./images/board.jpe" alt="Product name"
                            class="w-full h-64 sm:h-72 md:h-64 lg:h-60 object-cover transition-transform duration-500 group-hover:scale-105">

                        <!-- Flexible Ribbon Badge -->
                        <div class="absolute top-2 left-2 flex flex-col items-center justify-center min-w-[3.5rem] px-2 py-1 bg-gradient-to-b from-red-600 to-red-800 text-white rounded transform rotate-[-15deg] shadow-lg border-2 border-red-300 border-opacity-50"
                            style="text-shadow: 0 1px 2px rgba(0,0,0,0.3);">
                            <span class="text-[10px] sm:text-xs font-bold uppercase">SAVE</span>
                            <span class="text-lg font-black leading-none">20%</span>
                            <div class="absolute -bottom-1 w-4/5 h-1 bg-red-900 rounded-b-lg opacity-80"></div>
                        </div>

                        <!-- Wishlist Button -->
                        <button class="absolute top-2 right-2 w-10 h-10 flex items-center justify-center 
           bg-white/95 hover:bg-pink-100 text-pink-600 rounded-full shadow-lg 
           transition transform hover:scale-110">
                            <i class="fa-solid fa-heart"></i>
                        </button>

                    </div>

                    <!-- Product Info -->
                    <div class="p-4 flex flex-col">
                        <h3
                            class="text-base sm:text-lg md:text-lg lg:text-xl font-semibold text-gray-800 group-hover:text-pink-600 transition-colors mb-1">
                            Product with Ribbon
                        </h3>

                        <!-- Star Ratings -->
                        <div class="flex items-center mb-2 text-yellow-400">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-half"></i>
                            <span class="ml-2 text-xs sm:text-sm md:text-sm text-gray-500">(5 reviews)</span>
                        </div>

                        <div class="flex items-center justify-between mt-auto">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:space-x-2">
                                <span class="text-sm sm:text-base md:text-lg font-bold">₹15,999</span>
                                <span class="text-sm sm:text-sm text-gray-400 line-through">₹19,999</span>
                            </div>


                            <!-- Add To Cart Button -->
                            <button class="relative overflow-hidden bg-gradient-to-r from-pink-200 to-pink-300 
                                   text-pink-700 px-3 py-1 rounded-md shadow transition-all duration-500 
                                   bg-[length:200%_100%] bg-left hover:bg-right sm:px-4 sm:py-1.5 md:px-5 md:py-2">
                                Add
                            </button>

                        </div>
                    </div>
                </div>

                <!-- Product 5 -->
                <div
                    class="group relative bg-white rounded-lg overflow-hidden shadow hover:shadow-lg transition duration-300">
                    <div class="relative">
                        <img src="./images/board.jpe" alt="Product name"
                            class="w-full h-64 sm:h-72 md:h-64 lg:h-60 object-cover transition-transform duration-500 group-hover:scale-105">

                        <!-- Flexible Ribbon Badge -->
                        <div class="absolute top-2 left-2 flex flex-col items-center justify-center min-w-[3.5rem] px-2 py-1 bg-gradient-to-b from-red-600 to-red-800 text-white rounded transform rotate-[-15deg] shadow-lg border-2 border-red-300 border-opacity-50"
                            style="text-shadow: 0 1px 2px rgba(0,0,0,0.3);">
                            <span class="text-[10px] sm:text-xs font-bold uppercase">SAVE</span>
                            <span class="text-lg font-black leading-none">20%</span>
                            <div class="absolute -bottom-1 w-4/5 h-1 bg-red-900 rounded-b-lg opacity-80"></div>
                        </div>

                        <!-- Wishlist Button -->
                        <button class="absolute top-2 right-2 w-10 h-10 flex items-center justify-center 
           bg-white/95 hover:bg-pink-100 text-pink-600 rounded-full shadow-lg 
           transition transform hover:scale-110">
                            <i class="fa-solid fa-heart"></i>
                        </button>

                    </div>

                    <!-- Product Info -->
                    <div class="p-4 flex flex-col">
                        <h3
                            class="text-base sm:text-lg md:text-lg lg:text-xl font-semibold text-gray-800 group-hover:text-pink-600 transition-colors mb-1">
                            Product with Ribbon
                        </h3>

                        <!-- Star Ratings -->
                        <div class="flex items-center mb-2 text-yellow-400">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-half"></i>
                            <span class="ml-2 text-xs sm:text-sm md:text-sm text-gray-500">(5 reviews)</span>
                        </div>

                        <div class="flex items-center justify-between mt-auto">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:space-x-2">
                                <span class="text-sm sm:text-base md:text-lg font-bold">₹15,999</span>
                                <span class="text-sm sm:text-sm text-gray-400 line-through">₹19,999</span>
                            </div>


                            <!-- Add To Cart Button -->
                            <button class="relative overflow-hidden bg-gradient-to-r from-pink-200 to-pink-300 
                                   text-pink-700 px-3 py-1 rounded-md shadow transition-all duration-500 
                                   bg-[length:200%_100%] bg-left hover:bg-right sm:px-4 sm:py-1.5 md:px-5 md:py-2">
                                Add
                            </button>

                        </div>
                    </div>
                </div>
            </div>

            <!-- Section 3, 4, 5 -->
            <!-- Repeat same structure for other sections with their own products -->
        </div>

    </div>
    <!--Product Category End -->

    <!--Footer File Includes that file has all JS Files includes links-->
    <?php include_once __DIR__ . "/includes/footer.php"; ?>

</body>

</html>