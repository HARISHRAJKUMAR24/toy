<?php include_once __DIR__ . "/includes/files_includes.php"; ?>


<!DOCTYPE html>
<html lang="en">

<head>
    <!--Php File Include For Head Links & Scripts-->
    <?php include_once __DIR__ . "/includes/head_links.php"; ?>
    <style>
        /*<==========> CSS Styles <==========>*/

        /*------------- Phone Number Input Field Full Width Fix -------------*/
        .iti {
            width: 100% !important;
        }
    </style>
</head>

<body class="font-sans bg-pink-50 min-h-screen">

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

                <a href="./cart.html" class="inline-block hover:text-pink-500 transition-all duration-300">
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


    <!-- Register Section Start -->
    <section class="flex items-center justify-center bg-pink-50 py-12 px-4">
        <div class="w-full max-w-md bg-white/70 backdrop-blur-md rounded-3xl shadow-lg p-6">

            <!-- Header -->
            <div class="text-center mb-6">
                <img src="https://img.icons8.com/color/48/toy-train.png" alt="Logo" class="mx-auto mb-2">
                <h2 class="text-2xl sm:text-3xl md:text-4xl lg:text-4xl font-bold text-pink-600">Sign Up</h2>
                <p class="text-gray-600 text-sm mt-1">Enter your details to continue</p>
            </div>

            <!-- Form -->
            <form id="form" class="space-y-4">
                <!-- Step 1 -->
                <div id="step1">
                    <!-- Name -->
                    <div class="mb-4">
                        <label for="name" class="block text-gray-700 font-medium mb-1">Name</label>
                        <input type="text" name="name" id="name" placeholder="Enter your name" required
                            class="w-full px-4 py-2 border rounded-xl focus:outline-none focus:ring-2 focus:ring-pink-400 transition">
                    </div>

                    <!-- Phone Number -->
                    <div class="mb-4">
                        <label for="phone" class="block text-gray-700 font-medium mb-1">Phone Number</label>
                        <input type="tel" name="phone[main]" id="phone" placeholder="Enter your phone" required
                            class="w-full px-4 py-2 border rounded-xl focus:outline-none focus:ring-2 focus:ring-pink-400 transition">
                    </div>


                    <!-- Email -->
                    <div class="mb-4">
                        <label for="email" class="block text-gray-700 font-medium mb-1">Email Address (optional)</label>
                        <input type="email" name="email" id="email" placeholder="Enter your email"
                            class="w-full px-4 py-2 border rounded-xl focus:outline-none focus:ring-2 focus:ring-pink-400 transition">
                    </div>

                    <!-- Password -->
                    <div class="mb-4">
                        <label for="password" class="block text-gray-700 font-medium mb-1">Password</label>
                        <input type="password" name="password" id="password" placeholder="Enter a password" required
                            class="w-full px-4 py-2 border rounded-xl focus:outline-none focus:ring-2 focus:ring-pink-400 transition">
                    </div>

                    <!-- Send OTP Button -->
                    <button type="button" id="sendOtp"
                        class="w-full bg-gradient-to-r from-pink-400 to-pink-600 text-white py-2 rounded-xl font-semibold shadow-lg hover:from-pink-500 hover:to-pink-700 transition-all">
                        SEND OTP
                    </button>
                </div>

                <!-- Step 2 -->
                <div id="step2" style="display:none;">
                    <div id="msg" class="p-3 rounded-lg bg-cyan-100 text-cyan-700 text-sm mb-4"></div>

                    <div>
                        <label for="otp" class="block text-gray-700 font-medium mb-1">Enter OTP</label>
                        <input type="number" name="otp" id="otp" placeholder="Enter OTP" required
                            class="w-full px-4 py-2 border rounded-xl focus:outline-none focus:ring-2 focus:ring-pink-400 transition">
                    </div>

                    <!-- Create Account Button -->
                    <button type="button" id="create"
                        class="w-full bg-gradient-to-r from-pink-400 to-pink-600 text-white py-2 rounded-xl font-semibold shadow-lg hover:from-pink-500 hover:to-pink-700 transition-all">
                        CREATE ACCOUNT
                    </button>
                </div>
            </form>

            <!-- Login Link -->
            <p class="text-center text-gray-600 text-sm mt-6">
                Already have an account?
                <a href="<?= $storeUrl ?>login<?= isset($_GET['step']) ? '?step' : '' ?>" class="text-pink-600 font-semibold hover:underline">Login</a>
            </p>

        </div>
    </section>
    <!-- Register Section End-->


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
                Ztorespot.com, a brand of 1Milestone Technology Solution Pvt Ltd, is not liable for product
                sales. We
                provide a DIY platform connecting Merchants & Buyers. All transactions are the responsibility of
                respective parties. Exercise caution.
            </p>
        </div>

        <!-- Decorative floating shapes -->
        <div class="absolute -top-10 -left-10 w-40 h-40 bg-pink-100 rounded-full blur-3xl pointer-events-none">
        </div>
        <div class="absolute -bottom-10 -right-10 w-40 h-40 bg-yellow-100 rounded-full blur-3xl pointer-events-none">
        </div>
    </footer>
    <!-- Footer End-->

    <!--JS File Include -->
    <script src="<?= APP_URL ?>themes/theme9/js/script.js"></script>
    <script src="<?= APP_URL ?>shop/javascripts/register.js"></script>

    <!-- Js Code For Automatically Take (+91) -->
    <script>
        const phoneInputField = document.querySelector("#phone");
        const phoneInput = window.intlTelInput(phoneInputField, {
            separateDialCode: true,
            onlyCountries: ['IN'],
            preferredCountries: ["<?= getSettings("country") ?>"],
            hiddenInput: "full",
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
        });
    </script>

</body>

</html>