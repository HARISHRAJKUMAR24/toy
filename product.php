<?php include_once __DIR__ . "/includes/files_includes.php"; ?>
<?php
// -------------------------
// Get Random Products image Function
// -------------------------
function getRandomProductsBySeller($seller_id, $store_id, $limit = 3)
{
    global $db;
    $limit = (int)$limit; // ensure it's an integer

    $stmt = $db->prepare("
        SELECT * 
        FROM seller_products 
        WHERE seller_id = ? AND store_id = ?
        ORDER BY RAND() 
        LIMIT $limit
    ");

    $stmt->execute([$seller_id, $store_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include_once __DIR__ . "/includes/head_links.php"; ?>
    <style>
        /* Responsive main product image */
        #mainProductImage {
            width: 100%;
            max-height: 60vh;
            min-height: 250px;
            object-fit: contain;
        }

        @media (max-width: 768px) {
            #mainProductImage {
                max-height: 40vh;
            }
        }

        @media (max-width: 480px) {
            #mainProductImage {
                max-height: 30vh;
            }
        }

        /* Toast Animation */
        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes slideOutRight {
            from {
                transform: translateX(0);
                opacity: 1;
            }

            to {
                transform: translateX(100%);
                opacity: 0;
            }
        }

        .toast-slide-in {
            animation: slideInRight 0.5s ease-out forwards;
        }

        .toast-slide-out {
            animation: slideOutRight 0.5s ease-in forwards;
        }
    </style>
</head>

<body class="font-sans bg-pink-50 min-h-screen">

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

    <?php
    if (!isset($_GET['slug'])) redirect($storeUrl);
    $slug = $_GET['slug'];

    // Fetch product
    $productQuery = $db->prepare("
    SELECT * 
    FROM seller_products 
    WHERE slug = ? 
      AND seller_id = ? 
      AND store_id = ? 
      AND status = 1 
      AND (
            visibility = 'publish' 
            OR (visibility = 'schedule' AND schedule_date <= NOW())
          )
");
    $productQuery->execute([$slug, $sellerId, $storeId]);

    $product = $productQuery->fetch(PDO::FETCH_ASSOC);
    if (!$product) redirect($storeUrl);

    $id = $product['id'];
    $product_id = $product['product_id'];
    $name = $product['name'];
    $variation = $product['variation'];
    $price = $product['price'];
    $mrp_price = $product['mrp_price'];
    $description = $product['description'];
    $image = $product['image'];
    $unlimited_stock = $product['unlimited_stock'];
    $total_stocks = $product['total_stocks'] ?? 0;
    $unit_type = $product['unit_type'] ?? 'pcs';
    $maxQty = ($unlimited_stock == 1) ? "Unlimited" : (int)$total_stocks;

    $initialVariantId = isset($_GET['variation']) && $_GET['variation'] != '' && $_GET['variation'] !== 'main' ? $_GET['variation'] : null;

    $db->prepare("UPDATE seller_products SET visitors=visitors+1 WHERE id=?")->execute([$id]);
    $visitors = $product['visitors'] + 1;

    // Fetch variants

    // Check if advanced variants exist
    $advancedVariantsCheck = readData("*", "seller_product_advanced_variants", "product_id='$product_id'");
    if ($advancedVariantsCheck && $advancedVariantsCheck->rowCount() > 0) {
        // Use advanced variants
        $basicVariants = readData("*", "seller_product_advanced_variants", "product_id='$product_id'");
        $isAdvanced = true;
    } else {
        // Fallback to basic variants
        $basicVariants = readData("*", "seller_product_variants", "product_id='$product_id'");
        $isAdvanced = false;
    }

    // Cart variants - Fix to track both main and variant products
    $cartVariantsQuery = $db->prepare("SELECT other, advanced_variant FROM customer_cart WHERE customer_id=? AND product_id=?");
    $cartVariantsQuery->execute([$cookie_id, $id]);
    $cartItems = $cartVariantsQuery->fetchAll(PDO::FETCH_ASSOC);

    $cartVariants = [];
    foreach ($cartItems as $item) {
        if (!empty($item['advanced_variant'])) {
            $cartVariants[] = $item['advanced_variant'];
        } else if (!empty($item['other'])) {
            $cartVariants[] = $item['other'];
        } else {
            $cartVariants[] = 'main';
        }
    }

    // Determine if initial variant is in cart
    $inCartInitial = false;
    if ($initialVariantId === null) {
        $inCartInitial = in_array('main', $cartVariants);
    } else {
        $inCartInitial = in_array($initialVariantId, $cartVariants);
    }

    // Stock for main product
    if ($unlimited_stock == 1) {
        $mainStockDisplay = "Unlimited stock";
    } else {
        if ($unit_type == "kg") $mainStockDisplay = ((int)$total_stocks / 1000) . " kg";
        else if ($unit_type == "litre") $mainStockDisplay = ((int)$total_stocks / 1000) . " litre";
        else if ($unit_type == "meter") $mainStockDisplay = (int)$total_stocks * 0.3048 . " meter";
        else $mainStockDisplay = (int)$total_stocks . " " . $unit_type;
    }

    // Variant stocks
    $variantStocksDisplay = [];
    if ($basicVariants && $basicVariants->rowCount() > 0) {
        $basicVariants->execute();
        while ($bv = $basicVariants->fetch()) {
            if (($bv['unlimited_stock'] ?? 0) == 1) {
                $variantStocksDisplay[$bv['id']] = "Unlimited stock";
            } else {
                $vUnit = $bv['unit_type'] ?? $unit_type;
                $vStock = (int)($bv['stock'] ?? 0);
                $variantStocksDisplay[$bv['id']] = "$vStock $vUnit";
            }
        }
    }

    // Additional images
    $additionalImages = [];
    $data = readData("*", "seller_product_additional_images", "product_id='$product_id'");
    while ($row = $data->fetch()) $additionalImages[] = UPLOADS_URL . $row['image'];
    ?>

    <!-- SingleProduct View Section Start-->
    <section class="py-12 bg-gray-100">
        <div class="max-w-7xl mx-auto px-4">
            <div class="bg-white rounded-2xl shadow-xl transform transition hover:shadow-2xl duration-300 p-6 lg:p-8">
                <div class="flex flex-col lg:flex-row gap-8">

                    <!-- Images -->
                    <div class="flex flex-col lg:flex-row gap-4 justify-center items-start flex-[0.55]">
                        <div id="thumbnailContainer" class="flex lg:flex-col gap-3 max-h-[360px] overflow-x-auto lg:overflow-y-auto order-2 lg:order-1">
                            <img src="<?= UPLOADS_URL . $image ?>" class="thumbnail w-16 h-16 object-cover rounded-lg cursor-pointer border-2 border-pink-500 transition" onclick="document.getElementById('mainProductImage').src=this.src">
                            <?php foreach ($additionalImages as $img): ?>
                                <img src="<?= $img ?>" class="thumbnail w-16 h-16 object-cover rounded-lg cursor-pointer border-2 border-gray-200 transition" onclick="document.getElementById('mainProductImage').src=this.src">
                            <?php endforeach; ?>
                        </div>
                        <div class="flex justify-center items-center w-full lg:w-full max-w-full rounded-lg overflow-hidden shadow-md order-1 lg:order-2">
                            <img id="mainProductImage" src="<?= UPLOADS_URL . $image ?>" alt="<?= htmlspecialchars($name) ?>" class="transition-transform duration-300 hover:scale-105">
                        </div>
                    </div>

                    <!-- Info -->
                    <div class="flex-1 flex flex-col flex-[0.45]">
                        <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-800 mb-2"><?= htmlspecialchars($name) ?></h1>
                        <p id="variantName" class="text-base sm:text-lg md:text-xl text-gray-600 mb-4"><?= htmlspecialchars($variation) ?></p>

                        <!-- Variant Buttons -->
                        <?php if ($basicVariants && $basicVariants->rowCount() > 0): ?>
                            <div class="flex flex-wrap gap-2 mb-4">
                                <?php $basicVariants->execute(); ?>
                                <!-- Main Product Button -->
                                <button class="variant-btn px-3 py-1 border rounded-lg text-sm hover:bg-pink-100 <?= $initialVariantId === null ? 'ring-2 ring-pink-400' : '' ?>"
                                    data-variant-id="main"
                                    data-variant-image="<?= UPLOADS_URL . $image ?>"
                                    data-variant-name="<?= htmlspecialchars(!empty($variation) ? $variation : $name) ?>"
                                    data-price="<?= $price ?>"
                                    data-mrp="<?= $mrp_price ?>"
                                    data-stock="<?= $mainStockDisplay ?>"
                                    data-in-cart="<?= in_array('main', $cartVariants) ? 1 : 0 ?>">
                                    <?= htmlspecialchars(!empty($variation) ? $variation : $name) ?>
                                </button>

                                <?php while ($bv = $basicVariants->fetch()): ?>
                                    <?php
                                    $variantId = $bv['id'];
                                    $isInCart = in_array($variantId, $cartVariants);

                                    // Stock text
                                    $vStock = ($bv['unlimited_stock'] ?? 0) == 1 ? "Unlimited stock" : (($bv['stock'] ?? 0) . " " . ($bv['unit_type'] ?? $unit_type));

                                    if ($isAdvanced) {
                                        // Advanced variant: size + color
                                        $size = $bv['size'] ?? '';
                                        $colorId = $bv['color'] ?? '';
                                        $colorName = getData("color_name", "product_colors", "id='$colorId'");
                                        $colorCode = getData("color_code", "product_colors", "id='$colorId'") ?? '#ccc';

                                        $variantLabel = $size ? "Size: $size" : '';
                                    } else {
                                        // Basic variant
                                        $variantLabel = $bv['variation'] ?? $bv['variant'] ?? ($bv['name'] ?? "Variant " . $variantId);
                                        $colorCode = null; // No color for basic variant
                                    }
                                    ?>
                                    <button class="variant-btn flex items-center gap-1 px-2 py-1 border rounded-lg hover:ring-2 hover:ring-pink-400 <?= $initialVariantId == $variantId ? 'ring-2 ring-pink-400' : '' ?>"
                                        data-variant-id="<?= $variantId ?>"
                                        data-variant-image="<?= UPLOADS_URL . ($bv['image'] ?? $image) ?>"
                                        data-variant-name="<?= htmlspecialchars($variantLabel) ?>"
                                        data-price="<?= $bv['price'] ?>"
                                        data-mrp="<?= $bv['mrp_price'] ?>"
                                        data-stock="<?= $vStock ?>"
                                        data-in-cart="<?= $isInCart ? 1 : 0 ?>">

                                        <?php if ($colorCode): ?>
                                            <!-- Color square -->
                                            <span class="w-4 h-4 rounded border" style="background-color: <?= $colorCode ?>;"></span>
                                        <?php endif; ?>

                                        <?php if ($variantLabel): ?>
                                            <span class="text-sm"><?= htmlspecialchars($variantLabel) ?></span>
                                        <?php endif; ?>
                                    </button>
                                <?php endwhile; ?>
                            </div>
                        <?php endif; ?>

                        <div class="mt-2">
                            <div id="productRatingUI" class="Rating flex items-center gap-2">
                                <?php
                                $ratingData = readData("AVG(rating) as avg_rating, COUNT(*) as total_ratings", "product_ratings", "product_id='$id'");
                                $ratingRow = $ratingData->fetch();
                                $avgRating = round($ratingRow['avg_rating'] ?? 0, 1);
                                $totalRatings = $ratingRow['total_ratings'] ?? 0;
                                ?>
                                <div class="flex gap-1">
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <span class="star cursor-pointer text-xl <?= $i <= round($avgRating) ? 'text-yellow-400' : 'text-gray-400' ?>" data-value="<?= $i ?>">&#9733;</span>
                                    <?php endfor; ?>
                                </div>
                                <span id="ratingInfo" class="text-sm text-gray-600">(<?= $avgRating ?> / 5, <?= $totalRatings ?> ratings)</span>
                            </div>
                        </div>

                        <!-- Price -->
                        <div class="flex items-center gap-3 mb-6">
                            <span class="text-2xl font-bold text-pink-600 productPrice"><?= currencyToSymbol($storeCurrency) . $price ?></span>
                            <?php if ($mrp_price): ?>
                                <span class="text-gray-400 line-through productMrp"><?= currencyToSymbol($storeCurrency) . $mrp_price ?></span>
                            <?php endif; ?>
                        </div>

                        <!-- Stock Display -->
                        <p id="stockDisplay" class="text-sm font-semibold mt-1 <?= ($total_stocks <= 5 && $unlimited_stock != 1) ? 'text-red-500' : 'text-green-500' ?>">
                            <?= $mainStockDisplay ?>
                        </p>

                        <p class="text-xs text-gray-400 mt-1">
                            <span class="text-red-500 animate-pulse [animation-duration:2.5s]">❤️</span>
                            Viewed <?= (int)$visitors ?> times
                        </p>

                        <!-- Product Description - ADD THIS SECTION -->
                        <?php if (!empty($description)): ?>
                            <div class="mt-6 mb-6">
                                <h3 class="text-lg font-semibold text-gray-800 mb-3">Product Description</h3>
                                <div class="space-y-3 text-base text-gray-600 leading-relaxed">
                                    <?= $description ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- Add to Cart -->
                        <div class="flex flex-wrap gap-4 mb-6 items-center mt-4">
                            <?php
                            $isOutOfStock = ($total_stocks <= 0 && $unlimited_stock != 1);
                            $disableAdd = $inCartInitial || $isOutOfStock;
                            $btnClass = $disableAdd
                                ? 'bg-gray-300 cursor-not-allowed'
                                : 'bg-primary-500 hover:from-pink-500 hover:to-pink-700';
                            $btnText = $inCartInitial ? 'Already in Cart' : ($isOutOfStock ? 'Sold Out' : 'Add to Cart');
                            ?>
                            <button id="addToCartBtn" class="px-5 py-2 rounded-lg <?= $btnClass ?> text-white font-semibold shadow-lg transition transform hover:scale-105 addToCartBtn text-sm sm:text-base <?= $inCartInitial ? 'hidden' : '' ?>"
                                data-id="<?= $id ?>"
                                data-variant="<?= $initialVariantId ?? '' ?>"
                                <?= $disableAdd ? 'disabled' : '' ?>>
                                <?= $btnText ?>
                            </button>

                            <a id="viewCartBtn" href="<?= $storeUrl ?>cart" class="flex items-center px-4 py-2 rounded-lg bg-hover text-white font-semibold shadow hover:bg-primary-500 transition transform hover:scale-105 text-sm sm:text-base <?= $inCartInitial ? '' : 'hidden' ?>">
                                <i class="fas fa-shopping-cart mr-2"></i> View Cart
                            </a>

                            <?php
                            // Ensure $variantId exists
                            $variantId = $variantId ?? ''; // fallback to empty string if not defined

                            // Wishlist Button - Medium size, normal flow
                            if (isLoggedIn()) {
                                $inWishlist = getData("id", "customer_wishlists", "customer_id='$customerId' AND product_id='$id' AND other=''") ? true : false;

                                $btnBg   = $inWishlist ? "bg-white" : "bg-gray-500";
                                $btnText = $inWishlist ? "text-rose-500" : "text-white";
                                $title   = $inWishlist ? "Remove from Wishlist" : "Add to Wishlist";

                                echo '<button 
        id="wishlistBtn" 
        data-id="' . $id . '" 
        data-variant="' . $variantId . '" 
        class="w-8 h-8 sm:w-9 sm:h-9 flex items-center justify-center rounded-lg shadow-md transition transform hover:scale-110 handleWishlist ' . $btnBg . '" 
        title="' . $title . '">
        <i class="fa-solid fa-heart text-sm sm:text-base ' . $btnText . '"></i>
    </button>';
                            } else {
                                // Not logged in → redirect to login
                                echo '<a href="' . $storeUrl . 'wishlists" 
       class="w-8 h-8 sm:w-9 sm:h-9 flex items-center justify-center rounded-lg shadow-md transition transform hover:scale-110 bg-gray-200" 
       title="Login to add wishlist">
       <i class="fa-solid fa-heart text-sm sm:text-base text-gray-500"></i>
    </a>';
                            }
                            ?>

                            <!-- Report Button -->
                            <button type="button" id="reportThisProduct" class="px-3 py-2 sm:px-4 sm:py-2 md:px-4 md:py-2 rounded-lg bg-red-500 text-white shadow hover:bg-red-600 transition transform hover:scale-105 flex items-center justify-center text-sm sm:text-base">
                                <i class="fas fa-flag"></i>
                            </button>
                        </div>

                        <?php
                        $seller_id = $product['seller_id'];
                        $store_id  = $product['store_id']; // assuming your product array has store_id

                        // Fetch 3 random products from the same seller and store
                        $randomProducts = getRandomProductsBySeller($seller_id, $store_id, 3);


                        if ($randomProducts && count($randomProducts) > 0) {
                            echo '<div class="mt-6 border-t pt-4 md:mt-8 md:border-t-0 md:pt-0 md:bg-gradient-to-br md:from-purple-50 md:via-pink-50 md:to-blue-50 md:rounded-2xl md:shadow-lg md:p-6 md:border md:border-gray-200">
            <h3 class="mt-2 text-lg font-semibold text-gray-800 mb-3 md:text-xl md:mb-4">Customers Also Bought</h3>
            <div class="grid grid-cols-3 gap-3">';

                            // Array of background colors
                            $bgColors = ['bg-pink-100', 'bg-yellow-100', 'bg-green-100', 'bg-blue-100', 'bg-purple-100'];

                            foreach ($randomProducts as $index => $rp) {
                                $img = UPLOADS_URL . $rp['image'];
                                $slug = $rp['slug'];

                                // Pick a color from the array (cycle if more products than colors)
                                $bgClass = $bgColors[$index % count($bgColors)];

                                echo '<a href="' . $storeUrl . 'product/' . $slug . '" class="block rounded-lg shadow-sm hover:shadow-md transition ' . $bgClass . ' p-2 flex items-center justify-center">  
                <img src="' . $img . '" alt="' . htmlspecialchars($rp['name']) . '" class="w-full h-24 object-cover rounded-xl"> 
              </a>';
                            }

                            echo '</div></div>';
                        }

                        ?>

                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Report Modal / Content -->
    <div id="reportProductContent" class="fixed inset-0 bg-black/50 flex items-center justify-center opacity-0 invisible transition-opacity duration-300 z-50 p-4">
        <div class="bg-white rounded-xl w-full max-w-xs md:max-w-md lg:max-w-sm p-6 relative shadow-lg">
            <!-- Close button -->
            <button id="closeReportProductContent" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 text-2xl">&times;</button>

            <div class="text-center mb-6">
                <div class="text-4xl mb-2">😢</div>
                <h2 class="text-2xl font-bold text-gray-800">Report This Product</h2>
                <p class="text-gray-600 mt-1 text-sm">Please let us know why you want to report it</p>
            </div>

            <!-- Pre-built Form -->
            <form id="reportForm" class="flex flex-col gap-4" method="post">
                <input type="hidden" name="product_id" value="<?= $id ?>">

                <input type="text" name="name" placeholder="Enter your name" required
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-pink-400 outline-none"
                    value="<?= customer('name') ?>">

                <input type="email" name="email" placeholder="Enter your email" required
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-pink-400 outline-none"
                    value="<?= customer('email') ?>">

                <textarea name="reason" placeholder="Enter reason" rows="3" required
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-pink-400 outline-none resize-none"></textarea>

                <button type="submit" class="px-6 py-3 bg-primary-500 text-white font-semibold rounded-lg shadow hover:bg-primary-600 transition transform hover:scale-105">
                    Send
                </button>
            </form>
        </div>
    </div>

    <!-- Latest Product Section Start-->
    <section class="py-16 bg-gray-50 md:px-4">
        <div class="container mx-auto md:max-w-none max-w-6xl px-4 md:px-20">

            <!-- Section Heading -->
            <div class="text-center mb-8">
                <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-800 mb-1">New Collections</h2>
                <p class="text-base sm:text-lg md:text-xl text-gray-600 max-w-2xl mx-auto">
                   Fresh collections just in explore new arrivals designed
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

    <!--Footer File Includes that file has all JS Files includes links-->
    <?php include_once __DIR__ . "/includes/footer.php"; ?>

    <script>
        // Custom toast function with smooth right-to-left animation
        function showCustomToast(message, type) {
            // Remove any existing toasts
            const existingToasts = document.querySelectorAll('.custom-product-toast');
            existingToasts.forEach(toast => toast.remove());

            // Create toast element
            const toast = document.createElement('div');
            toast.className = 'custom-product-toast fixed top-4 right-4 z-50';
            toast.innerHTML = `
                <div style="background-color: var(--primary-color) !important; color: white !important; border-color: var(--primary-dark) !important;" 
                     class="px-4 py-3 rounded-lg shadow-lg border-l-4 flex items-center gap-3">
                    <i class='bx ${type === 'success' ? 'bx-check-circle' : 'bx-error-circle'} text-xl'></i>
                    <span class="font-semibold">${message}</span>
                </div>
            `;

            // Add to page
            document.body.appendChild(toast);

            // Add slide in animation
            const toastContent = toast.querySelector('div');
            toastContent.classList.add('toast-slide-in');

            // Auto remove after 3 seconds with slide out animation
            setTimeout(() => {
                toastContent.classList.remove('toast-slide-in');
                toastContent.classList.add('toast-slide-out');

                // Remove from DOM after animation completes
                setTimeout(() => {
                    if (toast.parentNode) {
                        toast.remove();
                    }
                }, 500);
            }, 3000);
        }

        document.addEventListener('DOMContentLoaded', function() {
            const variantButtons = document.querySelectorAll('.variant-btn');
            const mainImage = document.getElementById('mainProductImage');
            const priceEl = document.querySelector('.productPrice');
            const mrpEl = document.querySelector('.productMrp');
            const stockEl = document.getElementById('stockDisplay');
            const addBtn = document.getElementById('addToCartBtn');
            const viewBtn = document.getElementById('viewCartBtn');
            const variantNameEl = document.getElementById('variantName');

            const productKey = "selectedVariant_<?= $id ?>";
            const isAdvanced = <?= $isAdvanced ? 'true' : 'false' ?>;

            // Store current selected variant info
            let currentVariantId = '';
            let currentVariantType = ''; // 'main', 'basic', or 'advanced'

            function selectVariant(btn) {
                // Highlight selected variant
                variantButtons.forEach(b => b.classList.remove('ring-2', 'ring-pink-400'));
                btn.classList.add('ring-2', 'ring-pink-400');

                const variantId = btn.dataset.variantId;
                const variantImage = btn.dataset.variantImage;
                const variantPrice = parseFloat(btn.dataset.price);
                const variantMrp = parseFloat(btn.dataset.mrp);
                const stockText = btn.dataset.stock;
                const inCart = btn.dataset.inCart == 1;
                const variantName = btn.dataset.variantName;

                // Update current variant info
                currentVariantId = variantId;
                if (variantId === 'main') {
                    currentVariantType = 'main';
                } else {
                    currentVariantType = isAdvanced ? 'advanced' : 'basic';
                }

                // Update image
                if (variantImage) mainImage.src = variantImage;

                // Update price
                if (priceEl) priceEl.textContent = "<?= currencyToSymbol($storeCurrency) ?>" + variantPrice.toLocaleString();
                if (mrpEl) mrpEl.textContent = (variantMrp && variantMrp > variantPrice) ? "<?= currencyToSymbol($storeCurrency) ?>" + variantMrp.toLocaleString() : '';

                // Update stock
                if (stockEl) {
                    stockEl.textContent = stockText;

                    // Determine numeric stock
                    let stockNumber = parseInt(stockText);
                    if (stockText.toLowerCase().includes('unlimited')) stockNumber = Infinity;

                    if (stockNumber > 0) {
                        stockEl.classList.remove('text-red-500');
                        stockEl.classList.add('text-green-500');
                    } else {
                        stockEl.classList.remove('text-green-500');
                        stockEl.classList.add('text-red-500');
                    }
                }

                // Update variant name
                if (variantNameEl) variantNameEl.textContent = variantName;

                // Update Add to Cart / Out of Stock button
                if (addBtn && viewBtn) {
                    // Clear all variant data first
                    addBtn.dataset.variant = '';
                    addBtn.dataset.advancedVariant = '';

                    // Set the correct data attributes based on variant type
                    if (currentVariantType === 'main') {
                        // Main product - no variants
                        addBtn.dataset.variant = '';
                        addBtn.dataset.advancedVariant = '';
                    } else if (currentVariantType === 'advanced') {
                        // Advanced variant
                        addBtn.dataset.advancedVariant = currentVariantId;
                        addBtn.dataset.variant = '';
                    } else {
                        // Basic variant
                        addBtn.dataset.variant = currentVariantId;
                        addBtn.dataset.advancedVariant = '';
                    }

                    let stockNumber = parseInt(stockText);
                    if (stockText.toLowerCase().includes('unlimited')) stockNumber = Infinity;
                    const isOutOfStock = stockNumber < 1;

                    // Check if main variant is selected but advanced variants exist
                    const isMainWithAdvanced = (currentVariantType === 'main' && isAdvanced);

                    if (inCart) {
                        addBtn.classList.add('hidden');
                        viewBtn.classList.remove('hidden');
                        addBtn.disabled = true;
                    } else if (isMainWithAdvanced) {
                        // Disable add to cart and show "Select Color and Size" message
                        addBtn.disabled = true;
                        addBtn.textContent = 'Select Color and Size';
                        addBtn.classList.remove('bg-primary-500', 'hover:from-pink-500', 'hover:to-pink-700');
                        addBtn.classList.add('bg-gray-300', 'cursor-not-allowed');
                        viewBtn.classList.add('hidden');
                        addBtn.classList.remove('hidden');
                    } else if (isOutOfStock) {
                        addBtn.disabled = true;
                        addBtn.textContent = 'Sold Out';
                        addBtn.classList.remove('bg-primary-500', 'hover:to-pink-700');
                        addBtn.classList.add('bg-gray-300', 'cursor-not-allowed');
                        viewBtn.classList.add('hidden');
                        addBtn.classList.remove('hidden');
                    } else {
                        addBtn.disabled = false;
                        addBtn.textContent = 'Add to Cart';
                        addBtn.classList.add('bg-primary-500', 'hover:from-pink-500', 'hover:to-pink-700');
                        addBtn.classList.remove('bg-gray-300', 'cursor-not-allowed');
                        viewBtn.classList.add('hidden');
                        addBtn.classList.remove('hidden');
                    }
                }

                // Save selected variant
                localStorage.setItem(productKey, btn.dataset.variantId);
            }

            // Load saved variant - Check URL parameter first, then localStorage
            const urlParams = new URLSearchParams(window.location.search);
            const urlVariant = urlParams.get('variation');

            let savedVariantId = null;

            // Priority 1: URL parameter
            if (urlVariant && urlVariant !== 'main') {
                savedVariantId = urlVariant;
            }
            // Priority 2: localStorage
            else {
                savedVariantId = localStorage.getItem(productKey);
            }

            if (savedVariantId) {
                let found = false;
                variantButtons.forEach(btn => {
                    if (btn.dataset.variantId === savedVariantId) {
                        selectVariant(btn);
                        found = true;
                    }
                });

                // If saved variant not found, select first available
                if (!found && variantButtons.length > 0) {
                    selectVariant(variantButtons[0]);
                }
            } else {
                // Select the first variant button (main product)
                if (variantButtons.length > 0) {
                    selectVariant(variantButtons[0]);
                }
            }

            // Add click event to variant buttons
            variantButtons.forEach(btn => btn.addEventListener('click', () => selectVariant(btn)));

            // Add to cart - Use the same approach as common-cart.js
            addBtn.addEventListener('click', function() {
                // Don't proceed if button is disabled (for main variant with advanced variants)
                if (this.disabled) {
                    return;
                }

                const element = $(this);
                const product_id = element.data("id");

                // Get variant data based on current selection
                let variant = '';
                let advanced_variant = '';

                if (currentVariantType === 'main') {
                    variant = '';
                    advanced_variant = '';
                } else if (currentVariantType === 'advanced') {
                    variant = '';
                    advanced_variant = currentVariantId;
                } else {
                    variant = currentVariantId;
                    advanced_variant = '';
                }

                console.log('Adding to cart - Product:', product_id, 'Variant Type:', currentVariantType, 'Variant ID:', currentVariantId, 'Variant:', variant, 'Advanced Variant:', advanced_variant);

                // Show loading state
                const originalText = this.innerHTML;
                const originalState = this.disabled;
                this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Adding...';
                this.disabled = true;

                $.ajax({
                    url: "shop/ajax/add-to-cart.php",
                    type: "POST",
                    data: {
                        product_id: product_id,
                        variant: variant,
                        advanced_variant: advanced_variant
                    },
                    success: function(result) {
                        console.log('addToCartBtn result:', result);

                        // Reset button state
                        addBtn.innerHTML = originalText;
                        addBtn.disabled = originalState;

                        try {
                            const response = result && JSON.parse(result);

                            if (response) {
                                if (response.success) {
                                    // Update UI to show "View Cart" button
                                    addBtn.classList.add('hidden');
                                    viewBtn.classList.remove('hidden');

                                    // Update the current variant button to show it's in cart
                                    variantButtons.forEach(btn => {
                                        if (btn.dataset.variantId === currentVariantId) {
                                            btn.dataset.inCart = '1';
                                        }
                                    });

                                    // Show success message using custom toast
                                    showCustomToast(response.message || "Product added to cart successfully!", 'success');

                                    // Update cart counters
                                    if (typeof getProductCountAndPrice === 'function') {
                                        getProductCountAndPrice();
                                    }
                                    if (typeof getCartData === 'function') {
                                        getCartData();
                                    }
                                } else {
                                    // Check if it's a "duplicate product" error - don't show toast for these
                                    const errorMessage = response.message || "";
                                    const isDuplicateError =
                                        errorMessage.includes('already') ||
                                        errorMessage.includes('duplicate') ||
                                        errorMessage.includes('exist') ||
                                        errorMessage.includes('Added') ||
                                        errorMessage.toLowerCase().includes('cart');

                                    // Only show error toast for non-duplicate errors
                                    if (!isDuplicateError) {
                                        showCustomToast(errorMessage || "Failed to add product to cart.", 'error');
                                    } else {
                                        // For duplicate adds, just update cart counts silently
                                        if (typeof getProductCountAndPrice === 'function') {
                                            getProductCountAndPrice();
                                        }
                                    }
                                }
                            }
                        } catch (e) {
                            console.error('Error parsing response:', e);
                            showCustomToast('Error adding to cart', 'error');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', error);
                        // Reset button state
                        addBtn.innerHTML = originalText;
                        addBtn.disabled = originalState;
                        showCustomToast('Network error occurred', 'error');
                    }
                });
            });

            // Function to check cart status for all variants on page load
            function checkCartStatusForVariants() {
                $.ajax({
                    url: "shop/ajax/get-cart-variants.php",
                    type: "POST",
                    data: {
                        product_id: <?= $id ?>
                    },
                    success: function(result) {
                        try {
                            const response = JSON.parse(result);
                            if (response.success && response.cartItems) {
                                // Update variant buttons based on cart status
                                variantButtons.forEach(btn => {
                                    const variantId = btn.dataset.variantId;
                                    const isInCart = response.cartItems.includes(variantId) ||
                                        (variantId === 'main' && response.cartItems.includes('main'));

                                    btn.dataset.inCart = isInCart ? '1' : '0';

                                    // If current variant is in cart, update UI
                                    if (variantId === currentVariantId && isInCart) {
                                        addBtn.classList.add('hidden');
                                        viewBtn.classList.remove('hidden');
                                        addBtn.disabled = true;
                                    }
                                });
                            }
                        } catch (e) {
                            console.error('Error parsing cart variants:', e);
                        }
                    }
                });
            }

            // Check cart status on page load
            checkCartStatusForVariants();
        });

        $(document).ready(function() {
            const productId = <?= $id ?>;
            const stars = $('#productRatingUI .star');
            const ratingInfo = $('#ratingInfo');

            stars.on('click', function() {
                const rating = $(this).data('value');

                // Update UI immediately
                stars.each(function(idx) {
                    $(this).toggleClass('text-yellow-400', idx < rating);
                    $(this).toggleClass('text-gray-400', idx >= rating);
                });

                // Auto-post rating using pre-built function
                $.post("shop/ajax/rate-product.php", {
                    product_id: productId,
                    rating: rating
                }, function(res) {
                    if (res.success) {
                        ratingInfo.text(` ${res.avg_rating} / 5, ${res.total_ratings} ratings`);
                        showCustomToast("Rating submitted successfully!", 'success');
                    } else {
                        showCustomToast(res.message || "Failed to submit rating", 'error');
                    }
                }, 'json');
            });
        });

        // Open modal
        document.getElementById('reportThisProduct').addEventListener('click', function() {
            const modal = document.getElementById('reportProductContent');
            modal.classList.remove('opacity-0', 'invisible');
            modal.classList.add('opacity-100', 'visible');
        });

        // Close modal
        document.getElementById('closeReportProductContent').addEventListener('click', function() {
            const modal = document.getElementById('reportProductContent');
            modal.classList.add('opacity-0', 'invisible');
            modal.classList.remove('opacity-100', 'visible');
        });

        // Close modal on click outside content
        document.getElementById('reportProductContent').addEventListener('click', function(e) {
            if (e.target === this) {
                this.classList.add('opacity-0', 'invisible');
                this.classList.remove('opacity-100', 'visible');
            }
        });

        // AJAX Report Form Submission
        $("#reportForm").on("submit", function(e) {
            e.preventDefault();
            const formData = new FormData(this);

            $.ajax({
                url: "shop/ajax/report-product.php",
                type: "POST",
                contentType: false,
                processData: false,
                data: formData,
                success: function(result) {
                    let response = null;
                    try {
                        response = JSON.parse(result);
                    } catch (err) {
                        console.error("Invalid JSON:", result);
                        return;
                    }

                    if (response) {
                        if (response.success) {
                            // Close modal and show success toast
                            $("#reportProductContent").fadeOut();
                            $("#reportForm")[0].reset();
                            showCustomToast("Report sent successfully!", 'success');
                        } else {
                            showCustomToast(response.message || "Failed to send report", 'error');
                        }
                    }
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error:", error);
                    showCustomToast('Network error occurred', 'error');
                }
            });
        });
    </script>

</body>

</html>