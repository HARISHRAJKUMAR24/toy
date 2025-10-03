<?php include_once __DIR__ . "/includes/files_includes.php"; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!--Php File Include For Head Links & Scripts-->
    <?php include_once __DIR__ . "/includes/head_links.php"; ?>
</head>

<body class="font-sans bg-pink-50 min-h-screen">

    <!-- Minimum Order Amount Start-->
    <?php if (!empty(getSettings("minimum_order_amount"))) : ?>
        <div class="w-full bg-pink-600 text-white text-center py-1 text-sm font-semibold">
            Minimum Order: <?= currencyToSymbol($storeCurrency) . getSettings("minimum_order_amount") ?>
        </div>
    <?php endif; ?>
    <!-- Minimum Order Amount End-->

    <!--Php File Include For Nav Bar-->
    <?php include_once __DIR__ . "/includes/navbar.php"; ?>

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

    <!-- Your Cart Section Start-->
    <div class="py-12 bg-gray-50">
        <div class="max-w-6xl mx-auto px-4">
            <!-- Your Cart Section Heading -->
            <h2 class="text-2xl sm:text-3xl md:text-4xl lg:text-4xl font-bold text-gray-800 mb-2 text-center">Your Cart
            </h2>

            <!-- Flex Layout -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <!-- Left Side: Cart Items -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-gray-50 p-6 rounded-3xl shadow-lg space-y-4">

                        <!-- Example Cart Item - 1 -->
                        <div class="relative bg-white rounded-2xl shadow-md hover:shadow-xl transition p-4 flex gap-4">
                            <!-- Delete Button -->
                            <button
                                class="absolute top-3 right-3 border border-gray-300 px-2 py-1 rounded-md hover:border-red-600 hover:text-red-600 transition bg-white shadow-sm">
                                <i class="fas fa-trash-alt text-sm"></i>
                            </button>

                            <!-- Product Image -->
                            <img src="./images/board.jpe" alt="Product" class="w-24 h-24 object-cover rounded-xl">

                            <!-- Product Info -->
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-gray-800 hover:text-pink-600 transition">Super Fun
                                    Toy</h3>
                                <p class="text-gray-500 text-sm">Variant: Large</p>

                                <!-- Quantity & Price -->
                                <div class="mt-2 flex flex-wrap items-center gap-4">
                                    <div class="flex items-center border rounded-lg overflow-hidden">
                                        <button class="px-3 py-1 text-gray-600 hover:text-pink-600">-</button>
                                        <span class="px-3 py-1 text-gray-800 font-medium">1</span>
                                        <button class="px-3 py-1 text-gray-600 hover:text-pink-600">+</button>
                                    </div>

                                    <div>
                                        <div class="flex items-center gap-2">
                                            <span class="line-through text-gray-400 text-sm">₹21,999</span>
                                            <span class="font-bold text-lg text-gray-900">₹15,999</span>
                                        </div>
                                        <div
                                            class="flex items-center justify-between bg-pink-50 text-pink-600 rounded-lg px-3 py-1 mt-1 text-sm">
                                            <span class="flex items-center gap-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                                You saved
                                            </span>
                                            <span class="font-semibold">₹6,000</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- Example Cart Item - 2 -->
                        <div class="relative bg-white rounded-2xl shadow-md hover:shadow-xl transition p-4 flex gap-4">
                            <!-- Delete Button -->
                            <button
                                class="absolute top-3 right-3 border border-gray-300 px-2 py-1 rounded-md hover:border-red-600 hover:text-red-600 transition bg-white shadow-sm">
                                <i class="fas fa-trash-alt text-sm"></i>
                            </button>

                            <!-- Product Image -->
                            <img src="./images/board.jpe" alt="Product" class="w-24 h-24 object-cover rounded-xl">

                            <!-- Product Info -->
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-gray-800 hover:text-pink-600 transition">Super Fun
                                    Toy</h3>
                                <p class="text-gray-500 text-sm">Variant: Large</p>

                                <!-- Quantity & Price -->
                                <div class="mt-2 flex flex-wrap items-center gap-4">
                                    <div class="flex items-center border rounded-lg overflow-hidden">
                                        <button class="px-3 py-1 text-gray-600 hover:text-pink-600">-</button>
                                        <span class="px-3 py-1 text-gray-800 font-medium">1</span>
                                        <button class="px-3 py-1 text-gray-600 hover:text-pink-600">+</button>
                                    </div>

                                    <div>
                                        <div class="flex items-center gap-2">
                                            <span class="line-through text-gray-400 text-sm">₹21,999</span>
                                            <span class="font-bold text-lg text-gray-900">₹15,999</span>
                                        </div>
                                        <div
                                            class="flex items-center justify-between bg-pink-50 text-pink-600 rounded-lg px-3 py-1 mt-1 text-sm">
                                            <span class="flex items-center gap-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                                You saved
                                            </span>
                                            <span class="font-semibold">₹6,000</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Example Cart Item - 3 -->
                        <div class="relative bg-white rounded-2xl shadow-md hover:shadow-xl transition p-4 flex gap-4">
                            <!-- Delete Button -->
                            <button
                                class="absolute top-3 right-3 border border-gray-300 px-2 py-1 rounded-md hover:border-red-600 hover:text-red-600 transition bg-white shadow-sm">
                                <i class="fas fa-trash-alt text-sm"></i>
                            </button>

                            <!-- Product Image -->
                            <img src="./images/board.jpe" alt="Product" class="w-24 h-24 object-cover rounded-xl">

                            <!-- Product Info -->
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-gray-800 hover:text-pink-600 transition">Super Fun
                                    Toy</h3>
                                <p class="text-gray-500 text-sm">Variant: Large</p>

                                <!-- Quantity & Price -->
                                <div class="mt-2 flex flex-wrap items-center gap-4">
                                    <div class="flex items-center border rounded-lg overflow-hidden">
                                        <button class="px-3 py-1 text-gray-600 hover:text-pink-600">-</button>
                                        <span class="px-3 py-1 text-gray-800 font-medium">1</span>
                                        <button class="px-3 py-1 text-gray-600 hover:text-pink-600">+</button>
                                    </div>

                                    <div>
                                        <div class="flex items-center gap-2">
                                            <span class="line-through text-gray-400 text-sm">₹21,999</span>
                                            <span class="font-bold text-lg text-gray-900">₹15,999</span>
                                        </div>
                                        <div
                                            class="flex items-center justify-between bg-pink-50 text-pink-600 rounded-lg px-3 py-1 mt-1 text-sm">
                                            <span class="flex items-center gap-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                                You saved
                                            </span>
                                            <span class="font-semibold">₹6,000</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Example Cart Item - 4 -->
                        <div class="relative bg-white rounded-2xl shadow-md hover:shadow-xl transition p-4 flex gap-4">
                            <!-- Delete Button -->
                            <button
                                class="absolute top-3 right-3 border border-gray-300 px-2 py-1 rounded-md hover:border-red-600 hover:text-red-600 transition bg-white shadow-sm">
                                <i class="fas fa-trash-alt text-sm"></i>
                            </button>

                            <!-- Product Image -->
                            <img src="./images/board.jpe" alt="Product" class="w-24 h-24 object-cover rounded-xl">

                            <!-- Product Info -->
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-gray-800 hover:text-pink-600 transition">Super Fun
                                    Toy</h3>
                                <p class="text-gray-500 text-sm">Variant: Large</p>

                                <!-- Quantity & Price -->
                                <div class="mt-2 flex flex-wrap items-center gap-4">
                                    <div class="flex items-center border rounded-lg overflow-hidden">
                                        <button class="px-3 py-1 text-gray-600 hover:text-pink-600">-</button>
                                        <span class="px-3 py-1 text-gray-800 font-medium">1</span>
                                        <button class="px-3 py-1 text-gray-600 hover:text-pink-600">+</button>
                                    </div>

                                    <div>
                                        <div class="flex items-center gap-2">
                                            <span class="line-through text-gray-400 text-sm">₹21,999</span>
                                            <span class="font-bold text-lg text-gray-900">₹15,999</span>
                                        </div>
                                        <div
                                            class="flex items-center justify-between bg-pink-50 text-pink-600 rounded-lg px-3 py-1 mt-1 text-sm">
                                            <span class="flex items-center gap-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                                You saved
                                            </span>
                                            <span class="font-semibold">₹6,000</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Example Cart Item - 5 -->
                        <div class="relative bg-white rounded-2xl shadow-md hover:shadow-xl transition p-4 flex gap-4">
                            <!-- Delete Button -->
                            <button
                                class="absolute top-3 right-3 border border-gray-300 px-2 py-1 rounded-md hover:border-red-600 hover:text-red-600 transition bg-white shadow-sm">
                                <i class="fas fa-trash-alt text-sm"></i>
                            </button>

                            <!-- Product Image -->
                            <img src="./images/board.jpe" alt="Product" class="w-24 h-24 object-cover rounded-xl">

                            <!-- Product Info -->
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-gray-800 hover:text-pink-600 transition">Super Fun
                                    Toy</h3>
                                <p class="text-gray-500 text-sm">Variant: Large</p>

                                <!-- Quantity & Price -->
                                <div class="mt-2 flex flex-wrap items-center gap-4">
                                    <div class="flex items-center border rounded-lg overflow-hidden">
                                        <button class="px-3 py-1 text-gray-600 hover:text-pink-600">-</button>
                                        <span class="px-3 py-1 text-gray-800 font-medium">1</span>
                                        <button class="px-3 py-1 text-gray-600 hover:text-pink-600">+</button>
                                    </div>

                                    <div>
                                        <div class="flex items-center gap-2">
                                            <span class="line-through text-gray-400 text-sm">₹21,999</span>
                                            <span class="font-bold text-lg text-gray-900">₹15,999</span>
                                        </div>
                                        <div
                                            class="flex items-center justify-between bg-pink-50 text-pink-600 rounded-lg px-3 py-1 mt-1 text-sm">
                                            <span class="flex items-center gap-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                                You saved
                                            </span>
                                            <span class="font-semibold">₹6,000</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Example Cart Item - 6 -->
                        <div class="relative bg-white rounded-2xl shadow-md hover:shadow-xl transition p-4 flex gap-4">
                            <!-- Delete Button -->
                            <button
                                class="absolute top-3 right-3 border border-gray-300 px-2 py-1 rounded-md hover:border-red-600 hover:text-red-600 transition bg-white shadow-sm">
                                <i class="fas fa-trash-alt text-sm"></i>
                            </button>

                            <!-- Product Image -->
                            <img src="./images/board.jpe" alt="Product" class="w-24 h-24 object-cover rounded-xl">

                            <!-- Product Info -->
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-gray-800 hover:text-pink-600 transition">Super Fun
                                    Toy</h3>
                                <p class="text-gray-500 text-sm">Variant: Large</p>

                                <!-- Quantity & Price -->
                                <div class="mt-2 flex flex-wrap items-center gap-4">
                                    <div class="flex items-center border rounded-lg overflow-hidden">
                                        <button class="px-3 py-1 text-gray-600 hover:text-pink-600">-</button>
                                        <span class="px-3 py-1 text-gray-800 font-medium">1</span>
                                        <button class="px-3 py-1 text-gray-600 hover:text-pink-600">+</button>
                                    </div>

                                    <div>
                                        <div class="flex items-center gap-2">
                                            <span class="line-through text-gray-400 text-sm">₹21,999</span>
                                            <span class="font-bold text-lg text-gray-900">₹15,999</span>
                                        </div>
                                        <div
                                            class="flex items-center justify-between bg-pink-50 text-pink-600 rounded-lg px-3 py-1 mt-1 text-sm">
                                            <span class="flex items-center gap-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                                You saved
                                            </span>
                                            <span class="font-semibold">₹6,000</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Example Cart Item - 7 -->
                        <div class="relative bg-white rounded-2xl shadow-md hover:shadow-xl transition p-4 flex gap-4">
                            <!-- Delete Button -->
                            <button
                                class="absolute top-3 right-3 border border-gray-300 px-2 py-1 rounded-md hover:border-red-600 hover:text-red-600 transition bg-white shadow-sm">
                                <i class="fas fa-trash-alt text-sm"></i>
                            </button>

                            <!-- Product Image -->
                            <img src="./images/board.jpe" alt="Product" class="w-24 h-24 object-cover rounded-xl">

                            <!-- Product Info -->
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-gray-800 hover:text-pink-600 transition">Super Fun
                                    Toy</h3>
                                <p class="text-gray-500 text-sm">Variant: Large</p>

                                <!-- Quantity & Price -->
                                <div class="mt-2 flex flex-wrap items-center gap-4">
                                    <div class="flex items-center border rounded-lg overflow-hidden">
                                        <button class="px-3 py-1 text-gray-600 hover:text-pink-600">-</button>
                                        <span class="px-3 py-1 text-gray-800 font-medium">1</span>
                                        <button class="px-3 py-1 text-gray-600 hover:text-pink-600">+</button>
                                    </div>

                                    <div>
                                        <div class="flex items-center gap-2">
                                            <span class="line-through text-gray-400 text-sm">₹21,999</span>
                                            <span class="font-bold text-lg text-gray-900">₹15,999</span>
                                        </div>
                                        <div
                                            class="flex items-center justify-between bg-pink-50 text-pink-600 rounded-lg px-3 py-1 mt-1 text-sm">
                                            <span class="flex items-center gap-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                                You saved
                                            </span>
                                            <span class="font-semibold">₹6,000</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Side: Sticky Order Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white p-6 rounded-2xl shadow-xl hover:shadow-2xl transition sticky top-20">
                        <!-- Header -->
                        <h2 class="text-2xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                            <i class="fas fa-shopping-cart text-pink-600"></i> Summary
                        </h2>


                        <!-- Summary -->
                        <div class="space-y-2 mb-4">
                            <div class="flex justify-between text-gray-500">
                                <span>Subtotal</span>
                                <span>₹28,998</span>
                            </div>
                            <div class="flex justify-between text-gray-500">
                                <span>Tax</span>
                                <span>₹1,450</span>
                            </div>
                            <div class="flex justify-between text-gray-500">
                                <span>Shipping</span>
                                <span>₹250</span>
                            </div>
                            <div
                                class="border-t border-gray-200 pt-3 flex justify-between text-gray-800 font-bold text-lg">
                                <span>Total</span>
                                <span>₹30,698</span>
                            </div>
                        </div>

                        <!-- Promo Code -->
                        <div class="mb-6 bg-gray-50 border border-gray-200 rounded-xl p-4 shadow-sm">
                            <label class="block text-gray-700 mb-2 font-semibold">Have a promo code?</label>

                            <!-- Input + Button Row (always row style) -->
                            <div class="flex items-center gap-2">
                                <input type="text" placeholder="Enter code"
                                    class="flex-1 px-2.5 py-2 border rounded-lg text-sm focus:ring-2 focus:ring-pink-400 focus:outline-none">
                                <button
                                    class="px-4 py-2 bg-pink-500 text-white text-sm rounded-lg font-semibold hover:bg-pink-600 transition">
                                    Apply
                                </button>
                            </div>

                            <!-- Suggested Coupons -->
                            <div class="mt-3 flex flex-wrap gap-2">
                                <span
                                    class="flex items-center gap-1.5 bg-pink-50 text-pink-600 text-xs font-semibold px-3 py-1 rounded-full border border-pink-200">
                                    <!-- Glowing Dot -->
                                    <span
                                        class="w-2 h-2 rounded-full bg-pink-500 shadow-[0_0_8px_rgba(236,72,153,0.7)] animate-pulse"></span>
                                    SAVE200
                                </span>

                                <span
                                    class="flex items-center gap-1.5 bg-green-50 text-green-600 text-xs font-semibold px-3 py-1 rounded-full border border-green-200">
                                    <span
                                        class="w-2 h-2 rounded-full bg-green-500 shadow-[0_0_8px_rgba(34,197,94,0.7)] animate-pulse"></span>
                                    NEWUSER100
                                </span>

                                <span
                                    class="flex items-center gap-1.5 bg-blue-50 text-blue-600 text-xs font-semibold px-3 py-1 rounded-full border border-blue-200">
                                    <span
                                        class="w-2 h-2 rounded-full bg-blue-500 shadow-[0_0_8px_rgba(59,130,246,0.7)] animate-pulse"></span>
                                    FREESHIP
                                </span>
                            </div>

                        </div>

                        <!-- Payment Methods -->
                        <div class="mb-4">
                            <h3 class="text-gray-700 font-semibold mb-3">Pay with</h3>
                            <div class="flex flex-wrap gap-4">
                                <!-- Razorpay -->
                                <div
                                    class="w-14 h-14 rounded-full border flex items-center justify-center overflow-hidden bg-white hover:shadow-md cursor-pointer transition">
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/6/69/Razorpay_logo.png"
                                        alt="Razorpay" class="w-8 h-8 object-contain" />
                                </div>

                                <!-- PhonePe -->
                                <div
                                    class="w-14 h-14 rounded-full border flex items-center justify-center overflow-hidden bg-white hover:shadow-md cursor-pointer transition">
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/5/5e/PhonePe_Logo.png"
                                        alt="PhonePe" class="w-8 h-8 object-contain" />
                                </div>

                                <!-- UPI -->
                                <div
                                    class="w-14 h-14 rounded-full border flex items-center justify-center overflow-hidden bg-white hover:shadow-md cursor-pointer transition">
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/0/02/UPI_Logo.svg"
                                        alt="UPI" class="w-8 h-8 object-contain" />
                                </div>

                                <!-- Bank -->
                                <div
                                    class="w-14 h-14 rounded-full border flex items-center justify-center bg-white hover:shadow-md cursor-pointer transition">
                                    <i class="fas fa-university text-pink-600 text-xl"></i>
                                </div>
                            </div>
                        </div>


                        <!-- Checkout Button -->
                        <button
                            class="w-full py-3 rounded-xl font-semibold text-white bg-gradient-to-r from-pink-400 to-pink-600 hover:from-pink-500 hover:to-pink-700 shadow-lg transition">
                            Checkout Now
                        </button>

                        <!-- Security Note -->
                        <p class="mt-4 text-gray-500 flex items-center gap-2 text-sm">
                            <i class="fas fa-shield-alt text-pink-600"></i> 100% Secure Payment
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Your Cart Section End-->

    <!--  Footer -->
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
    <!--  Footer End -->

    <!--JS File Include -->
    <script src="<?= APP_URL ?>themes/theme9/js/script.js"></script>
    <script src="<?= APP_URL ?>shop/javascripts/cart.js"></script>

</body>

</html>