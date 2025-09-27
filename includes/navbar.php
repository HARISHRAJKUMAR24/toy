    <!-- Navbar Start -->
    <nav class="sticky top-0 w-full z-50 bg-white/20 backdrop-blur-lg border-b border-white/30 transition duration-300">
        <div class="container mx-auto flex items-center justify-between px-4 py-3">
            <!-- Left: Logo -->
            <div class="flex items-center gap-2">
                <a class="no-underline block" href="<?= $storeUrl ?>">
                    <?php if (getSettings("logo")) : ?>
                        <img src="<?= UPLOADS_URL . getSettings("logo") ?>" alt="Logo" class="h-10 w-auto">
                    <?php else : ?>
                        <div class="flex items-center gap-2">
                            <div class="w-10 h-10 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 text-white rounded-full flex items-center justify-center uppercase">
                                <?= substr($storeName, 0, 1) ?>
                            </div>
                            <span class="font-extrabold text-xl text-pink-600"><?= $storeName ?></span>
                        </div>
                    <?php endif; ?>
                </a>
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

                        <?php
                        $categories = getCategories();
                        foreach ($categories as $category) : ?>
                            <li>
                                <a href="<?= $storeUrl ?>shop?category=<?= $category['id'] ?>"
                                    class="block py-1 px-2 hover:text-pink-500">
                                    <?= $category['name'] ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
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

                <a href="./wishlist.html" class="inline-block hover:text-pink-500 transition-all duration-300">
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

            <!-- Mobile logo -->
            <div class="flex justify-between items-center mb-8">
                <a href="<?= $storeUrl ?>" class="flex items-center gap-2 no-underline">
                    <?php if (getSettings("logo")) : ?>
                        <img src="<?= UPLOADS_URL . getSettings("logo") ?>" alt="Logo" class="h-8 w-auto">
                    <?php else : ?>
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 text-white rounded-full flex items-center justify-center uppercase">
                                <?= substr($storeName, 0, 1) ?>
                            </div>
                            <span class="font-extrabold text-lg text-pink-600"><?= $storeName ?></span>
                        </div>
                    <?php endif; ?>
                </a>

                <div id="close-menu" class="text-2xl text-gray-700 cursor-pointer">
                    <i class='bx bx-x'></i>
                </div>
            </div>


            <ul class="flex flex-col gap-6 font-medium text-gray-700">
                <li><a href="#" class="text-lg py-2 block hover:text-pink-500 transition-all duration-300">Home</a></li>

                <!-- Shop All Dropdown For Mobile -->
                <li class="mobile-dropdown">
                    <button
                        class="text-lg py-2 w-full text-left flex justify-between items-center hover:text-pink-500 transition-all duration-300">
                        <span>Shop All</span>
                        <i class="bx bx-chevron-down transition-transform duration-300"></i>
                    </button>

                    <!-- Dropdown Menu -->
                    <ul
                        class="pl-4 mt-2 max-h-0 overflow-hidden overflow-y-auto transition-all duration-300 flex flex-col gap-1">
                        <li>
                            <a href="<?= $storeUrl ?>shop?category="
                                class="block py-2 text-gray-600 hover:text-pink-500 transition-all duration-300">
                                All Categories
                            </a>
                        </li>

                        <?php
                        $categories = getCategories();
                        foreach ($categories as $category) : ?>
                            <li>
                                <a href="<?= $storeUrl ?>shop?category=<?= $category['id'] ?>"
                                    class="block py-2 text-gray-600 hover:text-pink-500 transition-all duration-300">
                                    <?= $category['name'] ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
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