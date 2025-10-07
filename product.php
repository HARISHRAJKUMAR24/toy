<?php include_once __DIR__ . "/includes/files_includes.php"; ?>

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
    </style>
</head>

<body class="font-sans bg-pink-50 min-h-screen">

    <!-- Minimum Order Amount -->
    <?php if (!empty(getSettings("minimum_order_amount"))) : ?>
        <div class="w-full bg-pink-600 text-white text-center py-1 text-sm font-semibold">
            Minimum Order: <?= currencyToSymbol($storeCurrency) . getSettings("minimum_order_amount") ?>
        </div>
    <?php endif; ?>

    <!-- Nav Bar -->
    <?php include_once __DIR__ . "/includes/navbar.php"; ?>

    <?php
    if (isset($_GET['slug']) && getData("id", "seller_products", "slug = '{$_GET['slug']}' AND (visibility = 'publish' OR (visibility = 'schedule' AND schedule_date <= NOW())) AND seller_id = '$sellerId' AND status = 1")) {

        $slug = $_GET['slug'];
        $id = getData("id", "seller_products", "slug = '{$slug}' AND seller_id = '$sellerId'");
        $product_id = getData("product_id", "seller_products", "slug = '{$slug}' AND seller_id = '$sellerId'");
        $name = getData("name", "seller_products", "slug = '{$slug}' AND seller_id = '$sellerId'");
        $variation = getData("variation", "seller_products", "slug = '{$slug}' AND seller_id = '$sellerId'");
        $price = getData("price", "seller_products", "slug = '{$slug}' AND seller_id = '$sellerId'");
        $special_price = getData("special_price", "seller_products", "slug = '{$slug}' AND seller_id = '$sellerId'");
        $mrp_price = getData("mrp_price", "seller_products", "slug = '{$slug}' AND seller_id = '$sellerId'");
        $description = getData("description", "seller_products", "slug = '{$slug}' AND seller_id = '$sellerId'");
        $image = getData("image", "seller_products", "slug = '{$slug}' AND seller_id = '$sellerId'");
        $unit = getData("unit", "seller_products", "slug = '{$slug}' AND seller_id = '$sellerId'");
        $unit_type = getData("unit_type", "seller_products", "slug = '{$slug}' AND seller_id = '$sellerId'");
        $sku = getData("sku", "seller_products", "slug = '{$slug}' AND seller_id = '$sellerId'");

        $unlimited_stock = getData("unlimited_stock", "seller_products", "slug = '{$slug}' AND seller_id = '$sellerId'");
        $total_stocks = getData("total_stocks", "seller_products", "slug = '{$slug}' AND seller_id = '$sellerId'");
        $stock_unit = getData("stock_unit", "seller_products", "slug = '{$slug}' AND seller_id = '$sellerId'");
        $maxQty = ($unlimited_stock == 1) ? "Unlimited" : (int)$total_stocks;

        $variantId = isset($_GET['variation']) ? $_GET['variation'] : '';

        // Increment visitors
        $db->prepare("UPDATE seller_products SET visitors = visitors+1 WHERE id = :id")->execute(['id' => $id]);
        $visitors = getData("visitors", "seller_products", "id = '$id'");

        // Ratings
        $stmt = $db->prepare("SELECT AVG(rating) AS average_rating FROM product_ratings WHERE product_id = ?");
        $stmt->execute([$id]);
        $averageRating = ($stmt->rowCount() > 0) ? $stmt->fetch(PDO::FETCH_ASSOC)['average_rating'] : 0;

        // Variants
        $variantsData = readData("*", "seller_product_advanced_variants", "product_id = '$product_id'");
        $basicVariants = readData("*", "seller_product_variants", "product_id = '$product_id'");

        // Wishlist
        $wishlistExists = isLoggedIn() && getData("id", "customer_wishlists", "customer_id = '$customerId' AND product_id = '$id' AND other = ''");

        // Cart
        $cartVariants = readData("other", "customer_cart", "customer_id = '$cookie_id' AND product_id = '$id'")->fetchAll(PDO::FETCH_COLUMN);
        $inCartInitial = in_array($variantId, $cartVariants);

        // Prepare advanced variants array for JS
        $variantsDataArr = [];
        while ($v = $variantsData->fetch(PDO::FETCH_ASSOC)) $variantsDataArr[] = $v;

    } else {
        redirect($storeUrl);
    }
    ?>

    <!-- Product Section -->
    <section class="py-12 bg-gray-100">
        <div class="max-w-7xl mx-auto px-4">
            <div class="bg-white rounded-2xl shadow-xl transform transition hover:shadow-2xl duration-300 p-6 lg:p-8">
                <div class="flex flex-col lg:flex-row gap-8">

                    <!-- Images -->
                    <div class="flex flex-col lg:flex-row gap-4 justify-center items-start flex-[0.55]">
                        <div id="thumbnailContainer" class="flex lg:flex-col gap-3 max-h-[360px] overflow-x-auto lg:overflow-y-auto order-2 lg:order-1">
                            <?php
                            $html = '<img src="' . UPLOADS_URL . $image . '" class="thumbnail w-16 h-16 object-cover rounded-lg cursor-pointer border-2 border-pink-500 transition" onclick="document.getElementById(\'mainProductImage\').src=this.src">';
                            $data = readData("*", "seller_product_additional_images", "product_id = '$product_id'");
                            while ($row = $data->fetch()) {
                                $html .= '<img src="' . UPLOADS_URL . $row['image'] . '" class="thumbnail w-16 h-16 object-cover rounded-lg cursor-pointer border-2 border-gray-200 transition" onclick="document.getElementById(\'mainProductImage\').src=this.src">';
                            }
                            echo $html;
                            ?>
                        </div>
                        <div class="flex justify-center items-center w-full lg:w-full max-w-full rounded-lg overflow-hidden shadow-md order-1 lg:order-2">
                            <img id="mainProductImage" src="<?= UPLOADS_URL . $image ?>" alt="<?= htmlspecialchars($name) ?>" class="transition-transform duration-300 hover:scale-105">
                        </div>
                    </div>

                    <!-- Product Info -->
                    <div class="flex-1 flex flex-col flex-[0.45]">
                        <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-800 mb-2"><?= htmlspecialchars($name) ?></h1>
                        <p class="text-base sm:text-lg md:text-xl text-gray-600 mb-4"><?= htmlspecialchars($variation) ?></p>

                        <!-- Basic Variants -->
                        <?php if ($basicVariants && $basicVariants->rowCount() > 0) : ?>
                            <div class="flex gap-2 mb-4 overflow-x-auto">
                                <?php
                                $mainVariantLabel = !empty($variation) ? $variation : $name;
                                ?>
                                <button class="variant-btn px-3 py-1 border rounded-lg text-sm hover:bg-pink-100 ring-2 ring-pink-400"
                                    data-variant-id="main"
                                    data-image="<?= UPLOADS_URL . $image ?>"
                                    data-price="<?= $price ?>">
                                    <?= htmlspecialchars($mainVariantLabel) ?>
                                </button>

                                <?php while ($bv = $basicVariants->fetch()) : ?>
                                    <?php $variantLabel = $bv['variation'] ?? $bv['variant'] ?? ($bv['name'] ?? "Variant " . $bv['id']); ?>
                                    <button class="variant-btn px-3 py-1 border rounded-lg text-sm hover:bg-pink-100"
                                        data-variant-id="<?= $bv['id'] ?>"
                                        data-image="<?= UPLOADS_URL . ($bv['image'] ?? $image) ?>"
                                        data-price="<?= $bv['price'] ?? $price ?>">
                                        <?= htmlspecialchars($variantLabel) ?>
                                    </button>
                                <?php endwhile; ?>
                            </div>
                        <?php endif; ?>

                        <!-- Advanced Variants -->
                        <?php if (count($variantsDataArr) > 0): ?>
                            <div class="flex gap-2 sm:gap-3 mt-2 mb-4 flex-wrap">
                                <?php foreach($variantsDataArr as $v):
                                    $variantImage = !empty($v['image']) ? UPLOADS_URL.$v['image'] : UPLOADS_URL.$image;
                                    $variantPrice = $v['price'] ?? $price;
                                ?>
                                <button class="adv-variant-btn px-3 py-1 sm:px-4 sm:py-2 text-sm sm:text-base font-semibold rounded-lg border hover:bg-pink-50 transition"
                                    data-variant-id="<?= $v['id'] ?>"
                                    data-image="<?= $variantImage ?>"
                                    data-price="<?= $variantPrice ?>">
                                    <?= htmlspecialchars($v['variation'] ?? strtoupper($v['color'] ?? $v['size'] ?? $v['id'])) ?>
                                </button>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                        <!-- Price & Stock -->
                        <div class="flex items-center gap-3 mb-6">
                            <span id="productPrice" class="text-2xl font-bold text-pink-600"><?= currencyToSymbol($storeCurrency) . $price ?></span>
                            <?php if ($mrp_price) : ?>
                                <span id="productMRP" class="text-gray-400 line-through"><?= currencyToSymbol($storeCurrency) . $mrp_price ?></span>
                            <?php endif; ?>
                        </div>

                        <p id="stock" class="font-semibold mt-2 <?= ($maxQty !== "Unlimited" && ((int)$maxQty) <= 5) ? 'text-red-500' : 'text-green-500' ?>">
                            <?= ($maxQty === "Unlimited") ? "Unlimited stock" : (((int)$maxQty <= 0) ? "Out of Stock" : ((int)$maxQty . " left")) ?>
                        </p>

                        <p class="text-xs text-gray-400 mt-1">Viewed <?= (int)$visitors ?> times</p>

                        <!-- Add to Cart & Wishlist & Report -->
                        <div class="flex flex-wrap gap-4 mb-6 items-center mt-4">
                            <?php
                            $disableAdd = (($maxQty !== "Unlimited" && (int)$maxQty <= 0) || $inCartInitial);
                            $btnClass = $disableAdd ? 'bg-gray-300 cursor-not-allowed' : 'bg-gradient-to-r from-pink-400 to-pink-600 hover:from-pink-500 hover:to-pink-700';
                            ?>
                            <button id="addToCartBtn" class="px-5 py-2 rounded-lg <?= $btnClass ?> text-white font-semibold shadow-lg transition transform hover:scale-105 text-sm sm:text-base"
                                data-id="<?= $id ?>" data-variant="<?= $variantId ?>" data-redirectUrl="<?= $storeUrl ?>cart" <?= $disableAdd ? 'disabled' : '' ?>>
                                <?= ($maxQty !== "Unlimited" && (int)$maxQty <= 0) ? 'Out of Stock' : ($inCartInitial ? 'Already in Cart' : 'Add to Cart') ?>
                            </button>

                            <?php if (isLoggedIn()) : ?>
                                <button id="wishlistBtn" data-id="<?= $id ?>" class="wishlistBtn px-3 py-2 rounded-lg border <?= $wishlistExists ? 'bg-rose-500 text-white' : 'bg-white text-pink-500' ?> font-semibold shadow hover:bg-pink-50 transition text-sm sm:text-base">
                                    <i class="<?= $wishlistExists ? 'fas' : 'far' ?> fa-heart"></i>
                                </button>
                            <?php else: ?>
                                <a href="<?= $storeUrl ?>login" class="px-3 py-2 rounded-lg border bg-white text-pink-500 font-semibold shadow hover:bg-pink-50 transition text-sm sm:text-base">
                                    <i class="far fa-heart"></i>
                                </a>
                            <?php endif; ?>

                            <button id="reportBtn" class="report-btn px-3 py-2 sm:px-4 sm:py-2 md:px-4 md:py-2 rounded-lg bg-red-500 text-white shadow hover:bg-red-600 transition transform hover:scale-105 flex items-center justify-center text-sm sm:text-base">
                                <i class="fas fa-flag"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Report Modal -->
    <div id="reportModal" class="fixed inset-0 bg-black/50 flex items-center justify-center opacity-0 invisible transition-opacity duration-300 z-50 p-4">
        <div class="bg-white rounded-xl w-full max-w-xs md:max-w-md lg:max-w-sm p-6 relative shadow-lg">
            <button id="closeReportModal" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
            <div class="text-center mb-6">
                <div class="text-4xl mb-2">😢</div>
                <h2 class="text-2xl font-bold text-gray-800">Report This Product</h2>
                <p class="text-gray-600 mt-1 text-sm">Please let us know why you want to report it</p>
            </div>
            <form id="reportForm" class="flex flex-col gap-4">
                <input type="text" placeholder="Your Name" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-pink-400 outline-none">
                <input type="email" placeholder="Your Email" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-pink-400 outline-none">
                <textarea placeholder="Reason" rows="3" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-pink-400 outline-none resize-none"></textarea>
                <button type="submit" class="px-6 py-3 bg-gradient-to-r from-red-400 to-red-600 text-white font-semibold rounded-lg shadow hover:from-red-500 hover:to-red-700 transition transform hover:scale-105">
                    Submit Report
                </button>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <?php include_once __DIR__ . "/includes/footer_link.php"; ?>

<script>
const cartVariants = <?= json_encode($cartVariants) ?>;
const maxQty = <?= ($maxQty === "Unlimited") ? -1 : (int)$maxQty ?>;
const unlimitedStock = <?= ($unlimited_stock == 1) ? 1 : 0 ?>;
const currencySymbol = '<?= currencyToSymbol($storeCurrency) ?>';
const addToCartBtn = document.getElementById('addToCartBtn');
const productPrice = document.getElementById('productPrice');

// Basic Variant Click
document.querySelectorAll('.variant-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        document.querySelectorAll('.variant-btn').forEach(x => x.classList.remove('ring-2','ring-pink-400'));
        this.classList.add('ring-2','ring-pink-400');

        const img = this.dataset.image;
        const price = this.dataset.price;
        const variantId = this.dataset.variantId;

        if(img) document.getElementById('mainProductImage').src = img;
        if(price) productPrice.textContent = currencySymbol + price;
        addToCartBtn.dataset.variant = variantId;

        // Handle add-to-cart button state
        if((maxQty <= 0 && !unlimitedStock) || cartVariants.includes(variantId)) {
            addToCartBtn.textContent = cartVariants.includes(variantId) ? 'Already in Cart' : 'Out of Stock';
            addToCartBtn.disabled = true;
            addToCartBtn.classList.remove('bg-gradient-to-r','from-pink-400','to-pink-600','hover:from-pink-500','hover:to-pink-700');
            addToCartBtn.classList.add('bg-gray-300','cursor-not-allowed');
        } else {
            addToCartBtn.textContent = 'Add to Cart';
            addToCartBtn.disabled = false;
            addToCartBtn.classList.remove('bg-gray-300','cursor-not-allowed');
            addToCartBtn.classList.add('bg-gradient-to-r','from-pink-400','to-pink-600','hover:from-pink-500','hover:to-pink-700');
        }
    });
});

// Advanced Variant Click
document.querySelectorAll('.adv-variant-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        document.querySelectorAll('.adv-variant-btn').forEach(x => x.classList.remove('ring-2','ring-pink-400'));
        this.classList.add('ring-2','ring-pink-400');

        const img = this.dataset.image;
        const price = this.dataset.price;
        const variantId = this.dataset.variantId;

        if(img) document.getElementById('mainProductImage').src = img;
        if(price) productPrice.textContent = currencySymbol + price;
        addToCartBtn.dataset.variant = variantId;

        if((maxQty <= 0 && !unlimitedStock) || cartVariants.includes(variantId)) {
            addToCartBtn.textContent = cartVariants.includes(variantId) ? 'Already in Cart' : 'Out of Stock';
            addToCartBtn.disabled = true;
            addToCartBtn.classList.remove('bg-gradient-to-r','from-pink-400','to-pink-600','hover:from-pink-500','hover:to-pink-700');
            addToCartBtn.classList.add('bg-gray-300','cursor-not-allowed');
        } else {
            addToCartBtn.textContent = 'Add to Cart';
            addToCartBtn.disabled = false;
            addToCartBtn.classList.remove('bg-gray-300','cursor-not-allowed');
            addToCartBtn.classList.add('bg-gradient-to-r','from-pink-400','to-pink-600','hover:from-pink-500','hover:to-pink-700');
        }
    });
});

// Wishlist
const wishlistBtn = document.getElementById('wishlistBtn');
wishlistBtn?.addEventListener('click', () => {
    const productId = wishlistBtn.dataset.id;
    fetch(`<?= $storeUrl ?>ajax/wishlist.php`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `product_id=${productId}`
    }).then(res => res.json()).then(data => {
        if (data.status === 'added') {
            wishlistBtn.classList.add('bg-rose-500','text-white');
            wishlistBtn.querySelector('i').classList.replace('far','fas');
        } else {
            wishlistBtn.classList.remove('bg-rose-500','text-white');
            wishlistBtn.querySelector('i').classList.replace('fas','far');
        }
    });
});

// Report modal
const reportBtn = document.getElementById('reportBtn');
const reportModal = document.getElementById('reportModal');
const closeReportModal = document.getElementById('closeReportModal');

reportBtn?.addEventListener('click', () => reportModal.classList.remove('opacity-0','invisible'));
closeReportModal?.addEventListener('click', () => reportModal.classList.add('opacity-0','invisible'));
</script>

</body>
</html>

<?php
function getContrastYIQ($hexcolor) {
    $hexcolor = str_replace("#", "", $hexcolor);
    $r = hexdec(substr($hexcolor,0,2));
    $g = hexdec(substr($hexcolor,2,2));
    $b = hexdec(substr($hexcolor,4,2));
    $yiq = (($r*299)+($g*587)+($b*114))/1000;
    return ($yiq >= 128) ? '#000000' : '#FFFFFF';
}
?>
