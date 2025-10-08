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

    <!-- Minimum Order Amount Start-->
    <?php if (!empty(getSettings("minimum_order_amount"))) : ?>
        <div class="w-full bg-pink-600 text-white text-center py-1 text-sm font-semibold">
            Minimum Order: <?= currencyToSymbol($storeCurrency) . getSettings("minimum_order_amount") ?>
        </div>
    <?php endif; ?>
    <!-- Minimum Order Amount End-->

    <!-- Nav Bar -->
    <?php include_once __DIR__ . "/includes/navbar.php"; ?>

    <?php
    // Check product exists
    if (!isset($_GET['slug'])) redirect($storeUrl);
    $slug = $_GET['slug'];

    $productQuery = $db->prepare("SELECT * FROM seller_products WHERE slug=? AND seller_id=? AND status=1 AND (visibility='publish' OR (visibility='schedule' AND schedule_date<=NOW()))");
    $productQuery->execute([$slug, $sellerId]);
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
    $total_stocks = $product['total_stocks'];
    $maxQty = ($unlimited_stock == 1) ? "Unlimited" : (int)$total_stocks;

    $initialVariantId = isset($_GET['variation']) && $_GET['variation'] != '' && $_GET['variation'] !== 'main' ? $_GET['variation'] : null;

    // Update visitors
    $db->prepare("UPDATE seller_products SET visitors=visitors+1 WHERE id=?")->execute([$id]);
    $visitors = $product['visitors'] + 1;

    // Fetch variants
    $basicVariants = readData("*", "seller_product_variants", "product_id='$product_id'");

    // Cart variants
    $cartVariantsQuery = readData("other", "customer_cart", "customer_id='$cookie_id' AND product_id='$id'");
    $cartVariants = $cartVariantsQuery->fetchAll(PDO::FETCH_COLUMN);
    $cartVariants = array_map(function ($v) {
        return ($v == "" || $v === null) ? 'main' : $v;
    }, $cartVariants);

    $inCartInitial = $initialVariantId === null ? in_array('main', $cartVariants) : in_array($initialVariantId, $cartVariants);

    // Variant stocks
    $variantStocks = [];
    if ($basicVariants && $basicVariants->rowCount() > 0) {
        $basicVariants->execute();
        while ($bv = $basicVariants->fetch()) {
            $vStock = ($bv['unlimited_stock'] ?? 0) == 1 ? 'Unlimited' : (int)($bv['total_stocks'] ?? 0);
            $variantStocks[$bv['id']] = $vStock;
        }
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
                            $data = readData("*", "seller_product_additional_images", "product_id='$product_id'");
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

                    <!-- Info -->
                    <div class="flex-1 flex flex-col flex-[0.45]">
                        <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-800 mb-2"><?= htmlspecialchars($name) ?></h1>
                        <p class="text-base sm:text-lg md:text-xl text-gray-600 mb-4"><?= htmlspecialchars($variation) ?></p>

                        <!-- Variant Buttons -->
                        <?php if ($basicVariants && $basicVariants->rowCount() > 0): ?>
                            <div class="flex flex-wrap gap-2 mb-4">
                                <?php $basicVariants->execute(); ?>
                                <!-- Main variant -->
                                <button class="variant-btn px-3 py-1 border rounded-lg text-sm hover:bg-pink-100 <?= $initialVariantId === null ? 'ring-2 ring-pink-400' : '' ?>"
                                    data-variant-id="main"
                                    data-variant-image="<?= UPLOADS_URL . $image ?>"
                                    data-price="<?= $price ?>"
                                    data-mrp="<?= $mrp_price ?>"
                                    data-stock="<?= $maxQty ?>"
                                    data-in-cart="<?= in_array('main', $cartVariants) ? 1 : 0 ?>">
                                    <?= htmlspecialchars(!empty($variation) ? $variation : $name) ?>
                                </button>

                                <?php while ($bv = $basicVariants->fetch()):
                                    $variantLabel = $bv['variation'] ?? $bv['variant'] ?? ($bv['name'] ?? "Variant " . $bv['id']);
                                    $variantId = $bv['id'];
                                    $vStock = ($bv['unlimited_stock'] ?? 0) == 1 ? 'Unlimited' : (int)($bv['total_stocks'] ?? 0);
                                    $isInCart = in_array($variantId, $cartVariants);
                                ?>
                                    <button class="variant-btn px-3 py-1 border rounded-lg text-sm hover:bg-pink-100 <?= $initialVariantId == $variantId ? 'ring-2 ring-pink-400' : '' ?>"
                                        data-variant-id="<?= $variantId ?>"
                                        data-variant-image="<?= UPLOADS_URL . ($bv['image'] ?? $image) ?>"
                                        data-price="<?= $bv['price'] ?>"
                                        data-mrp="<?= $bv['mrp_price'] ?>"
                                        data-stock="<?= $vStock ?>"
                                        data-in-cart="<?= $isInCart ? 1 : 0 ?>">
                                        <?= htmlspecialchars($variantLabel) ?>
                                    </button>
                                <?php endwhile; ?>
                            </div>
                        <?php endif; ?>

                        <!-- Price & Stock -->
                        <div class="flex items-center gap-3 mb-6">
                            <span class="text-2xl font-bold text-pink-600 productPrice"><?= currencyToSymbol($storeCurrency) . $price ?></span>
                            <?php if ($mrp_price): ?>
                                <span class="text-gray-400 line-through productMrp"><?= currencyToSymbol($storeCurrency) . $mrp_price ?></span>
                            <?php endif; ?>
                        </div>

                        <p id="stock" class="font-semibold mt-2 <?= ($maxQty !== "Unlimited" && ((int)$maxQty) <= 5) ? 'text-red-500' : 'text-green-500' ?>">
                            <?= ($maxQty === "Unlimited") ? "Unlimited stock" : (((int)$maxQty <= 0) ? "Out of Stock" : ((int)$maxQty . " left")) ?>
                        </p>
                        <p class="text-xs text-gray-400 mt-1">Viewed <?= (int)$visitors ?> times</p>

                        <!-- Add to Cart -->
                        <div class="flex flex-wrap gap-4 mb-6 items-center mt-4">
                            <?php
                            $disableAdd = (($maxQty !== "Unlimited" && (int)$maxQty <= 0) || $inCartInitial);
                            $btnClass = $disableAdd ? 'bg-gray-300 cursor-not-allowed' : 'bg-gradient-to-r from-pink-400 to-pink-600 hover:from-pink-500 hover:to-pink-700';
                            ?>
                            <button class="px-5 py-2 rounded-lg <?= $btnClass ?> text-white font-semibold shadow-lg transition transform hover:scale-105 addToCartBtn text-sm sm:text-base"
                                data-id="<?= $id ?>"
                                data-variant="<?= $initialVariantId ?? '' ?>"
                                data-redirectUrl="<?= $storeUrl ?>cart"
                                <?= $disableAdd ? 'disabled' : '' ?>>
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
    <?php include_once __DIR__ . "/includes/footer_link.php"; ?>

    <script>
        const variantStocks = <?php echo json_encode($variantStocks); ?>;
        document.querySelectorAll('.variant-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.variant-btn').forEach(x => x.classList.remove('ring-2', 'ring-pink-400'));
                this.classList.add('ring-2', 'ring-pink-400');

                let variantId = this.dataset.variantId;
                const variantImage = this.dataset.variantImage;
                const variantPrice = this.dataset.price;
                const variantMrp = this.dataset.mrp;
                const stock = this.dataset.stock;
                const inCart = this.dataset.inCart == 1;
                variantId = variantId === 'main' ? '' : variantId;

                if (variantImage) document.getElementById('mainProductImage').src = variantImage;
                const priceEl = document.querySelector('.productPrice');
                const mrpEl = document.querySelector('.productMrp');
                if (priceEl) priceEl.textContent = "<?= currencyToSymbol($storeCurrency) ?>" + parseFloat(variantPrice).toLocaleString();
                if (mrpEl) mrpEl.textContent = (variantMrp && variantMrp > variantPrice) ? "<?= currencyToSymbol($storeCurrency) ?>" + parseFloat(variantMrp).toLocaleString() : '';

                const stockEl = document.getElementById('stock');
                if (stockEl) {
                    if (stock === 'Unlimited') {
                        stockEl.textContent = "Unlimited stock";
                        stockEl.className = "font-semibold mt-2 text-green-500";
                    } else if (parseInt(stock) <= 0) {
                        stockEl.textContent = "Out of Stock";
                        stockEl.className = "font-semibold mt-2 text-red-500";
                    } else {
                        stockEl.textContent = stock + " left";
                        stockEl.className = "font-semibold mt-2 " + (parseInt(stock) <= 5 ? 'text-red-500' : 'text-green-500');
                    }
                }

                const addBtn = document.querySelector('.addToCartBtn');
                if (addBtn) {
                    addBtn.dataset.variant = variantId;
                    const disableAdd = (stock !== 'Unlimited' && parseInt(stock) <= 0) || inCart;
                    addBtn.disabled = disableAdd;
                    addBtn.classList.toggle('bg-gray-300', disableAdd);
                    addBtn.classList.toggle('cursor-not-allowed', disableAdd);
                    addBtn.classList.toggle('bg-gradient-to-r', !disableAdd);
                    addBtn.classList.toggle('from-pink-400', !disableAdd);
                    addBtn.classList.toggle('to-pink-600', !disableAdd);
                    addBtn.textContent = disableAdd ? (inCart ? 'Already in Cart' : 'Out of Stock') : 'Add to Cart';
                }
            });
        });
    </script>

</body>

</html>