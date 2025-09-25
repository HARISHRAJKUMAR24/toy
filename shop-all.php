<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile - ToyShop</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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

    <!-- Navbar Start -->
    <nav class="sticky top-0 w-full z-50 bg-white/20 backdrop-blur-lg border-b border-white/30 transition duration-300">
        <div class="container mx-auto flex items-center justify-between px-4 py-3">

            <!-- Left: Logo -->
            <div class="flex items-center">
                <img src="https://img.icons8.com/color/48/toy-train.png" alt="Logo" class="h-10 w-10 mr-2">
                <span class="font-extrabold text-xl text-pink-600">ToyShop</span>
            </div>

            <!-- Center: Pages -->
            <ul class="hidden md:flex gap-6 lg:gap-8 font-medium text-gray-700 relative flex-wrap">
                <li>
                    <a href="#" class="hover:text-pink-500 transition-all duration-300">Home</a>
                </li>

                <!-- Shop All Dropdown -->
                <li class="relative">
                    <button class="flex items-center gap-1 hover:text-pink-500 focus:outline-none shop-toggle">
                        <span>Shop All</span>
                        <i class="bx bx-chevron-down transition-transform duration-300"></i>
                    </button>

                    <!-- Dropdown Menu -->

                    <ul
                        class="absolute top-full left-0 bg-white p-2 rounded-lg shadow-lg opacity-0 translate-y-2 pointer-events-none transition duration-300 flex flex-col gap-1 max-h-[60vh] overflow-y-auto shop-menu w-max">
                        <li><a href="#" class="block py-1 px-2 hover:text-pink-500">Very Long Product Name
                                That Should Wrap</a></li>
                        <li><a href="#" class="block py-1 px-2 hover:text-pink-500 ">Games</a></li>
                        <li><a href="#" class="block py-1 px-2 hover:text-pink-500">Gift Items</a></li>
                    </ul>
                </li>


                <li>
                    <a href="#" class="hover:text-pink-500 transition-all duration-300">New Arrivals</a>
                </li>
            </ul>

            <!-- Right: Icons -->
            <div class="flex items-center gap-4">
                <div class="hidden md:flex items-center bg-white/30 rounded-full px-3 py-1">
                    <i class='bx bx-search text-lg text-gray-700'></i>
                    <input type="text" placeholder="Search..."
                        class="bg-transparent outline-none px-2 text-sm w-32 text-gray-700 placeholder:text-gray-700">
                </div>

                <a href="./allproduct.html" class="inline-block hover:text-pink-500 transition-all duration-300">
                    <i class='bx bx-user text-2xl cursor-pointer'></i>
                </a>
                <a href="./signup.html" class="inline-block hover:text-pink-500 transition-all duration-300">
                    <i class='bx bx-heart text-2xl cursor-pointer'></i>
                </a>
                <a href="./forgotpass.html" class="inline-block hover:text-pink-500 transition-all duration-300">
                    <i class='bx bx-cart text-2xl cursor-pointer'></i>
                </a>

                <!-- Mobile Burger Icon-->
                <div id="menu-btn" class="relative w-6 h-4 cursor-pointer transition duration-300 z-[110] md:hidden">
                    <span
                        class="absolute top-0 left-0 h-[3px] w-full bg-pink-500 rounded transition duration-300"></span>
                    <span
                        class="absolute top-[7px] left-0 h-[3px] w-full bg-pink-500 rounded transition duration-300"></span>
                    <span
                        class="absolute top-[14px] left-0 h-[3px] w-full bg-pink-500 rounded transition duration-300"></span>
                </div>
            </div>
        </div>
    </nav>
    <!-- Navbar End -->

    <!-- Mobile Overlay Start -->
    <div id="menu-overlay" class="fixed inset-0 bg-black/50 z-[90] opacity-0 invisible transition duration-300"></div>
    <!-- Mobile Overlay End-->

    <!-- Mobile Menu Start-->
    <div id="mobileMenu"
        class="fixed top-0 -right-full w-4/5 max-w-xs h-screen bg-white/95 backdrop-blur-md transition-all duration-300 z-[100] overflow-y-auto shadow-xl md:hidden">
        <div class="p-6">
            <div class="flex justify-between items-center mb-8">
                <div class="flex items-center">
                    <img src="https://img.icons8.com/color/48/toy-train.png" alt="Logo" class="h-8 w-8 mr-2">
                    <span class="font-extrabold text-lg text-pink-600">ToyShop</span>
                </div>
                <div id="close-menu" class="text-2xl text-gray-700 cursor-pointer">
                    <i class='bx bx-x'></i>
                </div>
            </div>

            <ul class="flex flex-col gap-6 font-medium text-gray-700">
                <li><a href="#" class="text-lg py-2 block hover:text-pink-500 transition-all duration-300">Home</a></li>

                <!-- Shop All Dropdown -->
                <li class="mobile-dropdown">
                    <button
                        class="text-lg py-2 w-full text-left flex justify-between items-center hover:text-pink-500 transition-all duration-300">
                        <span>Shop All</span>
                        <i class="bx bx-chevron-down transition-transform duration-300"></i>
                    </button>
                    <!-- Dropdown Menu -->
                    <ul
                        class="pl-4 mt-2 max-h-0 overflow-hidden overflow-y-auto transition-all duration-300 flex flex-col gap-1">
                        <li><a href="#"
                                class="block py-2 text-gray-600 hover:text-pink-500 transition-all duration-300">Very
                                Long Product Name That Should Wrap</a></li>
                        <li><a href="#"
                                class="block py-2 text-gray-600 hover:text-pink-500 transition-all duration-300">Games</a>
                        </li>
                        <li><a href="#"
                                class="block py-2 text-gray-600 hover:text-pink-500 transition-all duration-300">Gift
                                Items</a></li>

                    </ul>
                </li>


                <li><a href="#" class="text-lg py-2 block hover:text-pink-500 transition-all duration-300">About</a>
                </li>
                <li><a href="#" class="text-lg py-2 block hover:text-pink-500 transition-all duration-300">Contact</a>
                </li>
            </ul>
            <!--Search Tab-->
            <div class="mt-8 pt-6 border-t border-gray-200">
                <div class="flex items-center bg-white rounded-full px-4 py-2 shadow-sm">
                    <i class='bx bx-search text-lg text-gray-700'></i>
                    <input type="text" placeholder="Search..." class="bg-transparent outline-none px-2 text-sm w-full">
                </div>
                <!--Icons-->
                <div class="flex justify-around text-2xl py-6 text-gray-700">
                    <a href="#" class="p-2 rounded-full hover:bg-pink-100 transition-all duration-300"><i
                            class='bx bx-user'></i></a>
                    <a href="#" class="p-2 rounded-full hover:bg-pink-100 transition-all duration-300"><i
                            class='bx bx-heart'></i></a>
                    <a href="#" class="p-2 rounded-full hover:bg-pink-100 transition-all duration-300"><i
                            class='bx bx-cart'></i></a>
                </div>
            </div>
        </div>
    </div>
    <!-- Mobile Menu End -->


    <!--Shop By Age Start-->
    <section class="py-12 bg-gray-50">
        <div class="max-w-6xl mx-auto px-4">
            <!--Heading-->
            <h2 class="text-2xl sm:text-3xl md:text-4xl lg:text-4xl font-bold text-gray-800 mb-2 text-center">Shop by
                Age</h2>

            <!-- Scroll Container for Mobile/Tablet -->
            <div
                class="scroll-container flex gap-6 md:gap-8 overflow-x-auto pb-4 px-4 md:px-6 lg:px-0 lg:justify-center">
                <div class="flex gap-6 md:gap-8 lg:grid lg:grid-cols-6 justify-start min-w-max md:min-w-max lg:min-w-0">

                    <!-- Age Circle 1 -->
                    <div class="relative w-32 h-32 flex-shrink-0">
                        <div
                            class="absolute inset-0 rounded-full border-4 border-dashed border-pink-400 animate-spin-slow">
                        </div>
                        <div
                            class="relative w-28 h-28 rounded-full overflow-hidden shadow-lg mx-auto top-2 bg-gray-200 flex items-center justify-center">
                            <img src="./images/board.jpe" alt="0-12 Months" class="w-full h-full object-cover">
                        </div>

                        <div
                            class="absolute -bottom-3 left-1/2 transform -translate-x-1/2 px-3 py-1 bg-pink-500 text-white text-xs font-bold rounded-lg shadow-lg whitespace-nowrap">
                            0 - 12 Months
                        </div>
                    </div>

                    <!-- Age Circle 2 -->
                    <div class="relative w-32 h-32 flex-shrink-0">
                        <div
                            class="absolute inset-0 rounded-full border-4 border-dashed border-blue-400 animate-spin-slow">
                        </div>
                        <div
                            class="relative w-28 h-28 rounded-full overflow-hidden shadow-lg mx-auto top-2 bg-gray-200 flex items-center justify-center">
                            <img src="https://wallpaper-house.com/data/out/10/wallpaper2you_427142.jpg"
                                alt="0-12 Months" class="w-full h-full object-cover">
                        </div>
                        <div
                            class="absolute -bottom-3 left-1/2 transform -translate-x-1/2 px-3 py-1 bg-blue-500 text-white text-xs font-bold rounded-lg shadow-lg whitespace-nowrap">
                            1 - 3 Years
                        </div>
                    </div>

                    <!-- Age Circle 3 -->
                    <div class="relative w-32 h-32 flex-shrink-0">
                        <div
                            class="absolute inset-0 rounded-full border-4 border-dashed border-green-400 animate-spin-slow">
                        </div>
                        <div
                            class="relative w-28 h-28 rounded-full overflow-hidden shadow-lg mx-auto top-2 bg-gray-200 flex items-center justify-center">
                            <img src="./images/board.jpe" alt="0-12 Months" class="w-full h-full object-cover">
                        </div>
                        <div
                            class="absolute -bottom-3 left-1/2 transform -translate-x-1/2 px-3 py-1 bg-green-500 text-white text-xs font-bold rounded-lg shadow-lg whitespace-nowrap">
                            4 - 7 Years
                        </div>
                    </div>

                    <!-- Age Circle 4 -->
                    <div class="relative w-32 h-32 flex-shrink-0">
                        <div
                            class="absolute inset-0 rounded-full border-4 border-dashed border-yellow-400 animate-spin-slow">
                        </div>
                        <div
                            class="relative w-28 h-28 rounded-full overflow-hidden shadow-lg mx-auto top-2 bg-gray-200 flex items-center justify-center">
                            <img src="./images/board.jpe" alt="0-12 Months" class="w-full h-full object-cover">
                        </div>
                        <div
                            class="absolute -bottom-3 left-1/2 transform -translate-x-1/2 px-3 py-1 bg-yellow-500 text-white text-xs font-bold rounded-lg shadow-lg whitespace-nowrap">
                            4 - 7 Years
                        </div>
                    </div>

                    <!-- Age Circle 5 -->
                    <div class="relative w-32 h-32 flex-shrink-0">
                        <div
                            class="absolute inset-0 rounded-full border-4 border-dashed border-purple-400 animate-spin-slow">
                        </div>
                        <div
                            class="relative w-28 h-28 rounded-full overflow-hidden shadow-lg mx-auto top-2 bg-gray-200 flex items-center justify-center">
                            <img src="./images/board.jpe" alt="0-12 Months" class="w-full h-full object-cover">
                        </div>
                        <div
                            class="absolute -bottom-3 left-1/2 transform -translate-x-1/2 px-3 py-1 bg-purple-500 text-white text-xs font-bold rounded-lg shadow-lg whitespace-nowrap">
                            11 - 14 Years
                        </div>
                    </div>

                    <!-- Age Circle 6 -->
                    <div class="relative w-32 h-32 flex-shrink-0">
                        <div
                            class="absolute inset-0 rounded-full border-4 border-dashed border-pink-600 animate-spin-slow">
                        </div>
                        <div
                            class="relative w-28 h-28 rounded-full overflow-hidden shadow-lg mx-auto top-2 bg-gray-200 flex items-center justify-center">
                            <img src="./images/board.jpe" alt="0-12 Months" class="w-full h-full object-cover">
                        </div>
                        <div
                            class="absolute -bottom-3 left-1/2 transform -translate-x-1/2 px-3 py-1 bg-pink-600 text-white text-xs font-bold rounded-lg shadow-lg whitespace-nowrap">
                            14+ Years
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
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
    <!-- Footer End-->

    <!--JS File Include -->
    <script src="./js/script.js"></script>
</body>

</html>