<!-- Footer Start-->
<?php
$primary = getData('color', 'seller_settings', "(seller_id='$sellerId' AND store_id='$storeId')") ?? '#ff007f';
function hexToRgba($hex, $opacity = 0.08)
{
    $hex = str_replace('#', '', $hex);
    if (strlen($hex) == 3) $hex = "$hex[0]$hex[0]$hex[1]$hex[1]$hex[2]$hex[2]";
    $r = hexdec(substr($hex, 0, 2));
    $g = hexdec(substr($hex, 2, 2));
    $b = hexdec(substr($hex, 4, 2));
    return "rgba($r, $g, $b, $opacity)";
}
?>
<footer class="relative overflow-hidden py-10"
    style="background-color: <?= hexToRgba($primary, 0.1) ?>;">

    <div class="container mx-auto px-6 flex flex-col md:flex-row md:justify-between md:items-start gap-10">

        <!-- Logo & Small Address -->
        <div class="flex flex-col gap-3 md:w-1/3">
            <div class="flex items-center gap-2">
                <?php if (getSettings("logo")): ?>
                    <img src="<?= UPLOADS_URL . getSettings("logo") ?>" alt="Logo" class="h-10 w-10 object-contain">
                <?php else: ?>
                    <img src="https://img.icons8.com/color/48/toy-train.png" alt="Logo" class="h-10 w-10">
                <?php endif; ?>
                <span class="font-extrabold text-xl" style="color: var(--primary);"><?= $storeName ?></span>
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
            <h3 class="font-semibold text-gray-800 mb-2">Quick Links</h3>

            <ul class="grid grid-cols-2 text-gray-600 text-sm">
                <?php
                $pages = getPages();
                if ($pages->rowCount()):
                    foreach ($pages as $page):
                ?>
                        <li class="my-0.5">
                            <a href="<?= $storeUrl . "pages/" . $page['slug'] ?>"
                                class="transition duration-300"
                                style="--hover-color: <?= htmlspecialchars(getData("hover_color", "seller_settings", "(seller_id='$sellerId' AND store_id='$storeId')") ?? '#ec4899') ?>;"
                                onmouseover="this.style.color='var(--hover-color)'"
                                onmouseout="this.style.color=''">
                                <?= $page['name'] ?>
                            </a>
                        </li>
                <?php
                    endforeach;
                endif;
                ?>

                <li class="my-0.5">
                    <a href="<?= $storeUrl ?>profile"
                        class="transition duration-300"
                        style="--hover-color: <?= htmlspecialchars(getData("hover_color", "seller_settings", "(seller_id='$sellerId' AND store_id='$storeId')") ?? '#ec4899') ?>;"
                        onmouseover="this.style.color='var(--hover-color)'"
                        onmouseout="this.style.color=''">Profile</a>
                </li>
                <li class="my-0.5">
                    <a href="<?= $storeUrl ?>delivery-areas"
                        class="transition duration-300"
                        style="--hover-color: <?= htmlspecialchars(getData("hover_color", "seller_settings", "(seller_id='$sellerId' AND store_id='$storeId')") ?? '#ec4899') ?>;"
                        onmouseover="this.style.color='var(--hover-color)'"
                        onmouseout="this.style.color=''">Delivery Areas</a>
                </li>
                <li class="my-0.5">
                    <a href="<?= $storeUrl ?>cart"
                        class="transition duration-300"
                        style="--hover-color: <?= htmlspecialchars(getData("hover_color", "seller_settings", "(seller_id='$sellerId' AND store_id='$storeId')") ?? '#ec4899') ?>;"
                        onmouseover="this.style.color='var(--hover-color)'"
                        onmouseout="this.style.color=''">Cart</a>
                </li>
                <li class="my-0.5">
                    <a href="<?= $storeUrl ?>track-order"
                        class="transition duration-300"
                        style="--hover-color: <?= htmlspecialchars(getData("hover_color", "seller_settings", "(seller_id='$sellerId' AND store_id='$storeId')") ?? '#ec4899') ?>;"
                        onmouseover="this.style.color='var(--hover-color)'"
                        onmouseout="this.style.color=''">Track Order</a>
                </li>
                <li class="my-0.5">
                    <a href="<?= $storeUrl ?>wishlists"
                        class="transition duration-300"
                        style="--hover-color: <?= htmlspecialchars(getData("hover_color", "seller_settings", "(seller_id='$sellerId' AND store_id='$storeId')") ?? '#ec4899') ?>;"
                        onmouseover="this.style.color='var(--hover-color)'"
                        onmouseout="this.style.color=''">Wishlists</a>
                </li>
                <li class="my-0.5">
                    <a href="<?= $storeUrl ?>blog"
                        class="transition duration-300"
                        style="--hover-color: <?= htmlspecialchars(getData("hover_color", "seller_settings", "(seller_id='$sellerId' AND store_id='$storeId')") ?? '#ec4899') ?>;"
                        onmouseover="this.style.color='var(--hover-color)'"
                        onmouseout="this.style.color=''">Blogs</a>
                </li>
            </ul>
        </div>

        <!-- Social Icons - UNTOUCHED as requested -->
        <?php
        // Check if at least one social media link exists
        $hasSocialLinks = getSettings("facebook") || getSettings("instagram") || getSettings("twitter") || getSettings("linkedin") || getSettings("youtube") || getSettings("pinterest") || getSettings("sharechat");

        if ($hasSocialLinks): ?>
            <div class="flex flex-col gap-3 md:w-1/3">
                <h3 class="font-semibold text-gray-800">Follow Us</h3>
                <div class="flex gap-3 justify-center md:justify-start">
                    <?php if (getSettings("facebook")): ?>
                        <a href="<?= getSettings("facebook") ?>" target="_blank" class="w-10 h-10 flex items-center justify-center bg-hover rounded-full hover:bg-primary-500 transition">
                            <i class='bx bxl-facebook text-white text-lg'></i>
                        </a>
                    <?php endif; ?>
                    <?php if (getSettings("instagram")): ?>
                        <a href="<?= getSettings("instagram") ?>" target="_blank" class="w-10 h-10 flex items-center justify-center bg-hover rounded-full hover:bg-primary-500 transition">
                            <i class='bx bxl-instagram text-white text-lg'></i>
                        </a>
                    <?php endif; ?>
                    <?php if (getSettings("twitter")): ?>
                        <a href="<?= getSettings("twitter") ?>" target="_blank" class="w-10 h-10 flex items-center justify-center bg-hover rounded-full hover:bg-primary-500 transition">
                            <i class='bx bxl-twitter text-white text-lg'></i>
                        </a>
                    <?php endif; ?>
                    <?php if (getSettings("linkedin")): ?>
                        <a href="<?= getSettings("linkedin") ?>" target="_blank" class="w-10 h-10 flex items-center justify-center bg-hover rounded-full hover:bg-primary-500 transition">
                            <i class='bx bxl-linkedin text-white text-lg'></i>
                        </a>
                    <?php endif; ?>
                    <?php if (getSettings("youtube")): ?>
                        <a href="<?= getSettings("youtube") ?>" target="_blank" class="w-10 h-10 flex items-center justify-center bg-hover rounded-full hover:bg-primary-500 transition">
                            <i class='bx bxl-youtube text-white text-lg'></i>
                        </a>
                    <?php endif; ?>
                    <?php if (getSettings("pinterest")): ?>
                        <a href="<?= getSettings("pinterest") ?>" target="_blank" class="w-10 h-10 flex items-center justify-center bg-hover rounded-full hover:bg-primary-500 transition">
                            <i class='bx bxl-pinterest text-white text-lg'></i>
                        </a>
                    <?php endif; ?>
                    <?php if (getSettings("sharechat")): ?>
                        <a href="<?= getSettings("sharechat") ?>" target="_blank" class="w-10 h-10 flex items-center justify-center bg-hover rounded-full hover:bg-primary-500 transition">
                            <img src="<?= APP_URL ?>assets/img/sharechat.webp" alt="ShareChat" class="w-5 h-5">
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>

    </div>

    <!-- Copyright © Section -->
    <?php
    $primary = getData('color', 'seller_settings', "(seller_id='$sellerId' AND store_id='$storeId')") ?? '#ff007f';
    $hoverColor = getData('hover_color', 'seller_settings', "(seller_id='$sellerId' AND store_id='$storeId')") ?? $primary;
    ?>
    <div class="relative z-20 w-full mt-6 mb-4">
        <div class="w-full mx-auto">
            <p
                class="text-center font-medium py-2 sm:py-3 md:py-4 m-0 text-gray-800 text-xs sm:text-sm md:text-base leading-relaxed transition-all duration-300"
                style="background-color: <?= hexToRgba($hoverColor, 0.1) ?>;">
                Copyright © <?= date('Y') ?>, <?= htmlspecialchars($storeName) ?> All Rights Reserved.
                <br class="block sm:hidden">
                <span class="block sm:inline">
                    Powered by
                    <a
                        href="https://ztorespot.com/?utm_campaign=poweredby&utm_medium=ztorespot&utm_source=onlinestore&utm_tag=<?= urlencode($storeName) ?>"
                        target="_blank"
                        class="text-primary-500 hover:underline transition">
                        Ztorespot
                    </a>
                </span>
            </p>
        </div>
    </div>


    <!-- Disclaimer Section (Centered) -->
    <?php if (getData("disclaimer", "settings") && !$isCustomDomain): ?>
        <div class="mt-8 px-6 text-center">
            <h3 class="text-gray-800 font-semibold text-sm mb-2">Disclaimer :</h3>
            <p class="text-gray-500 text-xs mx-auto">
                <?= getData("disclaimer", "settings") ?>
            </p>
        </div>
    <?php endif; ?>


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