<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Wishlist - ToyShop</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="font-sans bg-pink-50 flex flex-col min-h-screen">

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



    <!-- Forgot Password Section Start-->
    <section class="flex items-center justify-center bg-pink-50 py-12 px-4">
        <div class="w-full max-w-md bg-white/70 backdrop-blur-md rounded-3xl shadow-lg p-6">

            <!-- Heading -->
            <div class="text-center mb-4">
                <img src="https://img.icons8.com/color/48/toy-train.png" alt="Logo" class="mx-auto mb-1">
                <h2 class="text-2xl sm:text-3xl md:text-4xl lg:text-4xl font-bold text-pink-600">Forgot Password?</h2>
                <p class="text-gray-600 text-sm mt-1">Enter your phone number to reset your password</p>
            </div>

            <!-- Form -->
            <form class="space-y-3">

                <!-- Phone Number Input -->
                <div>
                    <label for="phone" class="block text-gray-700 font-medium mb-1 text-sm">Phone Number</label>
                    <div class="flex">
                        <span
                            class="flex items-center gap-1 px-2 rounded-l-xl border border-r-0 border-gray-300 bg-gray-100 text-gray-700">
                            <img src="https://flagcdn.com/16x12/in.png" alt="India"
                                class="w-4 h-3 object-cover rounded-sm">
                            +91
                        </span>
                        <input type="tel" id="phone" placeholder="Enter your phone"
                            class="flex-1 px-2 py-1.5 border rounded-r-xl focus:outline-none focus:ring-2 focus:ring-pink-400 transition">
                    </div>
                </div>

                <!-- Send OTP Button -->
                <button type="submit"
                    class="w-full bg-gradient-to-r from-pink-400 to-pink-600 text-white py-2 rounded-xl font-semibold shadow-lg hover:from-pink-500 hover:to-pink-700 transition-all">
                    Send OTP
                </button>

            </form>

            <!-- Back to Login Link -->
            <p class="text-center text-gray-600 text-sm mt-4">
                Remembered your password?
                <a href="#" class="text-pink-600 font-semibold hover:underline">Login</a>
            </p>

        </div>
    </section>
    <!-- Forgot Password Section End-->

    <!--Footer File Includes that file has all JS Files includes links-->
    <?php include_once __DIR__ . "/includes/footer.php"; ?>

</body>

</html>