<!-- Navbar Start -->
<nav class="sticky top-0 w-full z-50 bg-white/20 backdrop-blur-lg border-b border-white/30 transition duration-300">
    <div class="container mx-auto flex items-center justify-between px-4 sm:px-6 md:px-10 lg:px-16 xl:px-20 py-3">
        <!-- Left: Logo -->
        <div class="flex items-center gap-2">
            <a class="no-underline block" href="<?= $storeUrl ?>">
                <?php if (getSettings("logo")) : ?>
                    <img src="<?= UPLOADS_URL . getSettings("logo") ?>" alt="Logo" class="h-8 sm:h-10 w-auto">
                <?php else : ?>
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 sm:w-10 sm:h-10 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 text-white rounded-full flex items-center justify-center uppercase text-sm sm:text-base">
                            <?= substr($storeName, 0, 1) ?>
                        </div>
                        <span class="font-extrabold text-lg sm:text-xl text-pink-600"><?= $storeName ?></span>
                    </div>
                <?php endif; ?>
            </a>
        </div>

        <!-- Center: Pages -->
        <ul class="hidden md:flex gap-6 lg:gap-8 font-medium text-gray-700 relative flex-wrap">
            <li>
                <a href="<?= $storeUrl ?>" class="hover:text-pink-500 transition-all duration-300">Home</a>
            </li>

            <!-- Shop All Dropdown -->
            <li class="relative">
                <button class="flex items-center gap-1 hover:text-pink-500 focus:outline-none shop-toggle">
                    <a href="<?= $storeUrl ?>shop-all"> <span>Shop All</span> </a>
                    <i class="bx bx-chevron-down transition-transform duration-300"></i>
                </button>

                <!-- Dropdown Menu -->
                <ul class="absolute top-full left-0 bg-white p-2 rounded-lg shadow-lg opacity-0 translate-y-2 pointer-events-none transition duration-300 flex flex-col gap-1 max-h-[60vh] overflow-y-auto shop-menu w-max">
                    <?php
                    $categories = getCategories();
                    foreach ($categories as $category) :
                        $categoryUrl = $storeUrl . "category/" . $category['slug']; // Create category URL same as reference
                    ?>
                        <li>
                            <a href="<?= $categoryUrl ?>"
                                class="block py-1 px-2 hover:text-pink-500 transition-colors duration-300">
                                <?= $category['name'] ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </li>

            <li>
                <a href="<?= $storeUrl ?>new-arrivals" class="hover:text-pink-500 transition-all duration-300">New Arrivals</a>
            </li>
        </ul>

        <!-- Right: Icons -->
        <div class="flex items-center gap-3 sm:gap-4">
            <!-- Desktop Search -->
            <div class="hidden md:flex items-center gap-5 w-full sm:w-[220px] md:w-[260px] lg:w-[300px]">
                <div class="lg:w-[435px] w-full relative" id="searchForDesktop">
                    <div class="relative">
                        <input type="text"
                            class="searchInput bg-white rounded-xl h-[52px] pl-3 pr-4 text-sm w-full placeholder-gray-500 border-2 border-pink-300 focus:border-pink-500 focus:ring-4 focus:ring-pink-100/50 transition-all duration-300 shadow-md"
                            placeholder="Search...">
                        <button type="button" class="searchBtn mgc_search_line text-2xl before:!text-primary-500 absolute top-[50%] right-[14px] -translate-y-[50%]"></button>
                    </div>
                </div>
            </div>

            <!-- Mobile Search Icon -->
            <div class="md:hidden">
                <button id="mobileSearchToggle" class="hover:text-pink-500 transition-all duration-300">
                    <i class='bx bx-search text-xl sm:text-2xl cursor-pointer'></i>
                </button>
            </div>

            <a href="<?= $storeUrl ?>profile" class="inline-block hover:text-pink-500 transition-all duration-300">
                <i class='bx bx-user text-xl sm:text-2xl cursor-pointer'></i>
            </a>

            <a href="<?= $storeUrl ?>wishlists" class="hover:bg-rose-500/20 transition w-9 h-9 sm:w-11 sm:h-11 flex items-center justify-center rounded-md relative">
                <i class='bx bx-heart text-xl sm:text-2xl cursor-pointer'></i>
                <span class="w-[16px] h-[16px] sm:w-[19px] sm:h-[19px] rounded-full bg-rose-500 text-white flex items-center justify-center text-[10px] sm:text-[12px] absolute -top-1 -right-1 font-medium wishlistItemsCount"></span>
            </a>

            <a href="<?= $storeUrl ?>cart" class="hover:bg-green-500/20 transition w-9 h-9 sm:w-11 sm:h-11 flex items-center justify-center rounded-md relative">
                <i class='bx bx-cart text-xl sm:text-2xl cursor-pointer'></i>
                <span class="w-[16px] h-[16px] sm:w-[19px] sm:h-[19px] rounded-full bg-green-500 text-white flex items-center justify-center text-[10px] sm:text-[12px] absolute -top-1 -right-1 font-medium cartItemsCount"></span>
            </a>

            <!-- Mobile Burger Icon-->
            <div id="menu-btn" class="relative w-6 h-4 cursor-pointer transition duration-300 z-[110] md:hidden">
                <span class="absolute top-0 left-0 h-[3px] w-full bg-pink-500 rounded transition duration-300"></span>
                <span class="absolute top-[7px] left-0 h-[3px] w-full bg-pink-500 rounded transition duration-300"></span>
                <span class="absolute top-[14px] left-0 h-[3px] w-full bg-pink-500 rounded transition duration-300"></span>
            </div>
        </div>
    </div>
</nav>
<!-- Navbar End -->

<!-- Mobile Search Overlay -->
<div id="mobileSearchOverlay" class="fixed inset-0 bg-gradient-to-br from-pink-50 via-white to-purple-50 z-[999] hidden transition-all duration-500 transform -translate-y-full">
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden">
        <!-- Decorative background elements -->
        <div class="absolute -top-24 -right-24 w-64 h-64 bg-pink-200 rounded-full opacity-20 blur-xl"></div>
        <div class="absolute -bottom-32 -left-32 w-80 h-80 bg-purple-200 rounded-full opacity-20 blur-xl"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-indigo-100 rounded-full opacity-10 blur-2xl"></div>
    </div>

    <div class="relative z-10 h-full flex flex-col">
        <!-- Header with close button -->
        <div class="flex justify-between items-center p-6 pt-12 border-b border-pink-100/50 bg-white/30 backdrop-blur-sm">
            <h2 class="text-xl font-bold text-gray-800">Search Products</h2>
            <button id="mobileSearchClose" class="p-2 rounded-full bg-white/80 backdrop-blur-sm shadow-lg hover:bg-pink-50 transition-all duration-300 group">
                <i class='bx bx-x text-2xl text-gray-600 group-hover:text-pink-500'></i>
            </button>
        </div>

        <!-- Search Content -->
        <div class="flex-1 flex flex-col items-center justify-center px-6 py-8">
            <!-- Search Input -->
            <div class="w-full max-w-md">
                <div class="relative">
                    <input type="text"
                        class="searchInputMobile w-full h-16 pl-6 pr-16 text-lg bg-white/90 backdrop-blur-sm rounded-2xl border-2 border-pink-300 focus:border-pink-500 focus:ring-4 focus:ring-pink-100/50 shadow-xl transition-all duration-300 placeholder-gray-500"
                        placeholder="What are you looking for?">
                    <button type="button" class="searchBtnMobile absolute right-3 top-1/2 transform -translate-y-1/2 text-pink-500 hover:text-pink-600 transition-colors">
                        <i class='bx bx-search text-xl'></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Mobile Overlay Start -->
<div id="menu-overlay" class="fixed inset-0 bg-black/50 z-[90] opacity-0 invisible transition duration-300"></div>
<!-- Mobile Overlay End-->

<!-- Mobile Menu Start-->
<div id="mobileMenu"
    class="fixed top-0 -right-full w-[90%] max-w-xs h-screen bg-white/95 backdrop-blur-md transition-all duration-300 z-[100] overflow-y-auto shadow-xl md:hidden">
    <div class="px-4 py-6">

        <!-- Mobile logo -->
        <div class="flex justify-between items-center mb-6">
            <a href="<?= $storeUrl ?>" class="flex items-center gap-2 no-underline">
                <?php if (getSettings("logo")) : ?>
                    <img src="<?= UPLOADS_URL . getSettings("logo") ?>" alt="Logo" class="h-7 w-auto">
                <?php else : ?>
                    <div class="flex items-center gap-2">
                        <div class="w-7 h-7 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 text-white rounded-full flex items-center justify-center uppercase text-sm">
                            <?= substr($storeName, 0, 1) ?>
                        </div>
                        <span class="font-extrabold text-base text-pink-600"><?= $storeName ?></span>
                    </div>
                <?php endif; ?>
            </a>

            <div id="close-menu" class="text-xl text-gray-700 cursor-pointer">
                <i class='bx bx-x'></i>
            </div>
        </div>

        <ul class="flex flex-col gap-4 font-medium text-gray-700">
            <li><a href="<?= $storeUrl ?>" class="text-base py-2 block hover:text-pink-500 transition-all duration-300">Home</a></li>

            <!-- Shop All Dropdown For Mobile -->
            <li class="mobile-dropdown">
                <button class="text-base py-2 w-full text-left flex justify-between items-center hover:text-pink-500 transition-all duration-300">
                    <span>Shop All</span>
                    <i class="bx bx-chevron-down transition-transform duration-300"></i>
                </button>

                <!-- Dropdown Menu -->
                <ul class="pl-3 mt-1 max-h-0 overflow-hidden overflow-y-auto transition-all duration-300 flex flex-col gap-1">
                    <li>
                        <a href="<?= $storeUrl ?>shop-all"
                            class="block py-1 text-gray-600 hover:text-pink-500 transition-all duration-300 text-sm">
                            All Categories
                        </a>
                    </li>

                    <?php
                    $categories = getCategories();
                    foreach ($categories as $category) :
                        $categoryUrl = $storeUrl . "category/" . $category['slug']; // Create category URL
                    ?>
                        <li>
                            <a href="<?= $categoryUrl ?>"
                                class="block py-1 text-gray-600 hover:text-pink-500 transition-all duration-300 text-sm">
                                <?= $category['name'] ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </li>
            <li><a href="<?= $storeUrl ?>new-arrivals" class="text-base py-2 block hover:text-pink-500 transition-all duration-300">New Arrivals</a></li>
            <li><a href="#" class="text-base py-2 block hover:text-pink-500 transition-all duration-300">About</a></li>
            <li><a href="#" class="text-base py-2 block hover:text-pink-500 transition-all duration-300">Contact</a></li>
        </ul>

        <!-- Search in Mobile Menu -->
        <div class="mt-6">
            <div class="relative">
                <input type="text"
                    class="searchInput2 w-full h-12 pl-4 pr-12 bg-white rounded-xl border-2 border-pink-300 focus:border-pink-500 focus:ring-4 focus:ring-pink-100/50 transition-all duration-300 shadow-md placeholder-gray-500"
                    placeholder="Search...">
                <button type="button" class="searchBtn2 absolute right-3 top-1/2 transform -translate-y-1/2 text-pink-500 hover:text-pink-600 transition-colors">
                    <i class='bx bx-search text-xl'></i>
                </button>
            </div>
        </div>

    </div>
</div>
<!-- Mobile Menu End -->

<script>
    $(document).ready(function() {
        // Search functionality for desktop
        $(document).on("click", ".searchBtn", function(e) {
            e.preventDefault();
            const searchInput = $(".searchInput");
            let url = '<?= $storeUrl ?>search/' + searchInput.val();

            if (searchInput.val() !== "") window.location.href = url;
        });

        // Search functionality for mobile overlay
        $(document).on("click", ".searchBtnMobile", function(e) {
            e.preventDefault();
            const searchInput = $(".searchInputMobile");
            let url = '<?= $storeUrl ?>search/' + searchInput.val();

            if (searchInput.val() !== "") {
                window.location.href = url;
            }
        });

        // Search functionality for mobile menu
        $(document).on("click", ".searchBtn2", function(e) {
            e.preventDefault();
            const searchInput = $(".searchInput2");
            let url = '<?= $storeUrl ?>search/' + searchInput.val();

            if (searchInput.val() !== "") window.location.href = url;
        });

        // Mobile search overlay functionality
        const searchToggle = document.getElementById("mobileSearchToggle");
        const searchOverlay = document.getElementById("mobileSearchOverlay");
        const searchClose = document.getElementById("mobileSearchClose");
        const searchInputMobile = document.querySelector(".searchInputMobile");

        if (searchToggle) {
            // Open search overlay (slide down)
            searchToggle.addEventListener("click", () => {
                searchOverlay.classList.remove("hidden");
                setTimeout(() => {
                    searchOverlay.classList.remove("-translate-y-full");
                    if (searchInputMobile) searchInputMobile.focus();
                }, 10);
            });
        }

        if (searchClose) {
            // Close search overlay (slide up)
            searchClose.addEventListener("click", () => {
                searchOverlay.classList.add("-translate-y-full");
                setTimeout(() => {
                    searchOverlay.classList.add("hidden");
                    if (searchInputMobile) searchInputMobile.value = "";
                }, 500); // Wait for animation
            });
        }

        // Close search overlay when clicking outside of content (optional)
        searchOverlay.addEventListener('click', function(e) {
            if (e.target === this) {
                searchOverlay.classList.add("-translate-y-full");
                setTimeout(() => {
                    searchOverlay.classList.add("hidden");
                    if (searchInputMobile) searchInputMobile.value = "";
                }, 500);
            }
        });

        // Enter key support for all search inputs
        $(".searchInput, .searchInputMobile, .searchInput2").on("keypress", function(e) {
            if (e.which === 13) {
                e.preventDefault();
                if ($(this).hasClass("searchInput")) {
                    $(".searchBtn").click();
                } else if ($(this).hasClass("searchInputMobile")) {
                    $(".searchBtnMobile").click();
                } else if ($(this).hasClass("searchInput2")) {
                    $(".searchBtn2").click();
                }
            }
        });
    });
</script>