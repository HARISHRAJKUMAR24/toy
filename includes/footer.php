        <!-- Footer Start-->
        <footer class="bg-pink-50 relative overflow-hidden py-10">
            <div class="container mx-auto px-6 flex flex-col md:flex-row md:justify-between md:items-start gap-10">

                <!-- Logo & Small Address -->
                <div class="flex flex-col gap-3 md:w-1/3">
                    <div class="flex items-center gap-2">
                        <?php if (getSettings("logo")): ?>
                            <img src="<?= UPLOADS_URL . getSettings("logo") ?>" alt="Logo" class="h-10 w-10 object-contain">
                        <?php else: ?>
                            <img src="https://img.icons8.com/color/48/toy-train.png" alt="Logo" class="h-10 w-10">
                        <?php endif; ?>
                        <span class="font-extrabold text-xl text-pink-600"><?= $storeName ?></span>
                    </div>
                    <p class="text-gray-600 text-sm mt-2">
                        <?= $storeName ?><br>
                        <?= getSettings("address") ?><br>
                        <?php if (getSettings("gst_number")): ?>
                            GSTIN: <?= getSettings("gst_number") ?><br>
                        <?php endif; ?>
                        <?php if (getSettings("fssai_number")): ?>
                            FSSAI: <?= getSettings("fssai_number") ?>
                        <?php endif; ?>
                    </p>
                </div>

                <!-- Quick Links (Second Column, Heading Centered, 2 Columns, Small Gaps) -->
                <div class="flex flex-col md:w-1/3">
                    <h3 class="font-semibold text-gray-800  mb-2">Quick Links</h3>

                    <ul class="grid grid-cols-2 text-gray-600 text-sm">


                        <?php
                        $pages = getPages();
                        if ($pages->rowCount()):
                            foreach ($pages as $page):
                        ?>
                                <li>
                                    <a href="<?= $storeUrl . "pages/" . $page['slug'] ?>" class="hover:text-pink-500 transition">
                                        <?= $page['name'] ?>
                                    </a>
                                </li>
                        <?php
                            endforeach;
                        endif;
                        ?>

                        <li class="my-0.5"><a href="<?= $storeUrl ?>profile" class="hover:text-pink-500 transition">Profile</a></li>
                        <li class="my-0.5"><a href="<?= $storeUrl ?>delivery-areas" class="hover:text-pink-500 transition">Delivery Areas</a></li>
                        <li class="my-0.5"><a href="<?= $storeUrl ?>cart" class="hover:text-pink-500 transition">Cart</a></li>
                        <li class="my-0.5"><a href="<?= $storeUrl ?>track-order" class="hover:text-pink-500 transition">Track Order</a></li>
                        <li class="my-0.5"><a href="<?= $storeUrl ?>wishlists" class="hover:text-pink-500 transition">Wishlists</a></li>
                        <li class="my-0.5"><a href="<?= $storeUrl ?>blog" class="hover:text-pink-500 transition">Blogs</a></li>
                    </ul>
                </div>

                <!-- Social Icons -->
                <?php
                // Check if at least one social media link exists
                $hasSocialLinks = getSettings("facebook") || getSettings("instagram") || getSettings("twitter") || getSettings("linkedin") || getSettings("youtube") || getSettings("pinterest") || getSettings("sharechat");

                if ($hasSocialLinks): ?>
                    <div class="flex flex-col gap-3 md:w-1/3">
                        <h3 class="font-semibold text-gray-800">Follow Us</h3>
                        <div class="flex gap-3 justify-center md:justify-start">
                            <?php if (getSettings("facebook")): ?>
                                <a href="<?= getSettings("facebook") ?>" target="_blank" class="w-10 h-10 flex items-center justify-center bg-pink-100 rounded-full hover:bg-pink-200 transition">
                                    <i class='bx bxl-facebook text-pink-500 text-lg'></i>
                                </a>
                            <?php endif; ?>
                            <?php if (getSettings("instagram")): ?>
                                <a href="<?= getSettings("instagram") ?>" target="_blank" class="w-10 h-10 flex items-center justify-center bg-pink-100 rounded-full hover:bg-pink-200 transition">
                                    <i class='bx bxl-instagram text-pink-500 text-lg'></i>
                                </a>
                            <?php endif; ?>
                            <?php if (getSettings("twitter")): ?>
                                <a href="<?= getSettings("twitter") ?>" target="_blank" class="w-10 h-10 flex items-center justify-center bg-pink-100 rounded-full hover:bg-pink-200 transition">
                                    <i class='bx bxl-twitter text-pink-500 text-lg'></i>
                                </a>
                            <?php endif; ?>
                            <?php if (getSettings("linkedin")): ?>
                                <a href="<?= getSettings("linkedin") ?>" target="_blank" class="w-10 h-10 flex items-center justify-center bg-pink-100 rounded-full hover:bg-pink-200 transition">
                                    <i class='bx bxl-linkedin text-pink-500 text-lg'></i>
                                </a>
                            <?php endif; ?>
                            <?php if (getSettings("youtube")): ?>
                                <a href="<?= getSettings("youtube") ?>" target="_blank" class="w-10 h-10 flex items-center justify-center bg-pink-100 rounded-full hover:bg-pink-200 transition">
                                    <i class='bx bxl-youtube text-pink-500 text-lg'></i>
                                </a>
                            <?php endif; ?>
                            <?php if (getSettings("pinterest")): ?>
                                <a href="<?= getSettings("pinterest") ?>" target="_blank" class="w-10 h-10 flex items-center justify-center bg-pink-100 rounded-full hover:bg-pink-200 transition">
                                    <i class='bx bxl-pinterest text-pink-500 text-lg'></i>
                                </a>
                            <?php endif; ?>
                            <?php if (getSettings("sharechat")): ?>
                                <a href="<?= getSettings("sharechat") ?>" target="_blank" class="w-10 h-10 flex items-center justify-center bg-pink-100 rounded-full hover:bg-pink-200 transition">
                                    <img src="<?= APP_URL ?>assets/img/sharechat.webp" alt="ShareChat" class="w-5 h-5">
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>


            </div>

            <!-- Disclaimer Section (Centered) -->
            <div class="mt-8 px-6 text-center">
                <h3 class="text-gray-800 font-semibold text-sm mb-2">Disclaimer:</h3>
                <p class="text-gray-500 text-xs mx-auto">
                    <?php if (getData("disclaimer", "settings") && !$isCustomDomain): ?>
                        <?= getData("disclaimer", "settings") ?>
                    <?php else: ?>
                        Ztorespot.com, a brand of <?= $storeName ?>, is not liable for product sales. We provide a DIY platform connecting Merchants & Buyers. All transactions are the responsibility of respective parties. Exercise caution.
                    <?php endif; ?>
                </p>
            </div>

            <!-- Decorative floating shapes -->
            <div class="absolute -top-10 -left-10 w-40 h-40 bg-pink-100 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-10 -right-10 w-40 h-40 bg-yellow-100 rounded-full blur-3xl pointer-events-none"></div>
        </footer>
        <!-- Footer End-->
        <script>
            $(document).on("click", ".searchBtn", function(e) {
                e.preventDefault();
                console.log('ssss');
                const searchInput = $(".searchInput");
                const searchCategory = $(".searchCategory");
                let url = '';
                console.log('searchCategory ' + searchCategory.val());
                if (searchCategory.val() == "undefined") {
                    url = '<?= $storeUrl ?>search/' + searchInput.val();
                } else {
                    url = '<?= $storeUrl ?>search/' + searchInput.val() + "?category=" + searchCategory.val();
                }
                if (searchInput.val() !== "") window.location.href = url;
            });
        </script>
        <!--JS File Include -->

        <!--This File For my Customise Js For my Theme 9-->
        <script src="<?= APP_URL ?>themes/theme9/js/script.js"></script>

        <!--This File For Cart Functions For Theme 9-->
        <script src="<?= APP_URL ?>themes/theme9/ajax/common-cart.js"></script>

        <!--This File For Wishlist-->
        <script src="<?= APP_URL ?>themes/theme9/ajax/common-wishlist.js"></script>

        <!--This File For Wishlist-->
        <script src="<?= APP_URL ?>assets/js/global.js"></script>
        <script src="<?= APP_URL ?>assets/js/theme3/app.js"></script>




        <!--This File For Checkout -->
        <script src="<?= APP_URL ?>assets/js/theme3/checkout.js"></script>
        <script src="<?= APP_URL ?>shop/javascripts/checkout.js"></script>


        <!-- Datatable JS -->
        <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
        <script src="<?= APP_URL ?>shop/javascripts/orders.js"></script>


        <script>
            $(document).on("click", ".searchBtn", function(e) {
                e.preventDefault();
                console.log('ssss');
                const searchInput = $(".searchInput");
                const searchCategory = $(".searchCategory");
                let url = '';
                console.log('searchCategory ' + searchCategory.val());
                if (searchCategory.val() == "undefined") {
                    url = '<?= $storeUrl ?>search/' + searchInput.val();
                } else {
                    url = '<?= $storeUrl ?>search/' + searchInput.val() + "?category=" + searchCategory.val();
                }
                if (searchInput.val() !== "") window.location.href = url;
            });
        </script>