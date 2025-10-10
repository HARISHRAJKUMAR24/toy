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

    <?php if (!empty(getSettings("minimum_order_amount"))) : ?>
        <div class="w-full bg-pink-600 text-white text-center py-1 text-sm font-semibold">
            Minimum Order: <?= currencyToSymbol($storeCurrency) . getSettings("minimum_order_amount") ?>
        </div>
    <?php endif; ?>

    <?php include_once __DIR__ . "/includes/navbar.php"; ?>

    <?php
    if (!isset($_GET['slug'])) redirect($storeUrl);
    $slug = $_GET['slug'];

    // Fetch product
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
    $total_stocks = $product['total_stocks'] ?? 0;
    $unit_type = $product['unit_type'] ?? 'pcs';
    $maxQty = ($unlimited_stock == 1) ? "Unlimited" : (int)$total_stocks;

    $initialVariantId = isset($_GET['variation']) && $_GET['variation'] != '' && $_GET['variation'] !== 'main' ? $_GET['variation'] : null;

    $db->prepare("UPDATE seller_products SET visitors=visitors+1 WHERE id=?")->execute([$id]);
    $visitors = $product['visitors'] + 1;

    // Fetch variants
    $basicVariants = readData("*", "seller_product_variants", "product_id='$product_id'");

    // Cart variants
    $cartVariantsQuery = readData("other", "customer_cart", "customer_id='$cookie_id' AND product_id='$id'");
    $cartVariants = $cartVariantsQuery->fetchAll(PDO::FETCH_COLUMN);
    $cartVariants = array_map(fn($v) => ($v == "" || $v === null) ? 'main' : $v, $cartVariants);

    $inCartInitial = $initialVariantId === null ? in_array('main', $cartVariants) : in_array($initialVariantId, $cartVariants);

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

    // Wishlist check
    $wishlistExists = false;
    if (isLoggedIn()) {
        $wishlistQuery = readData("*", "wishlist", "customer_id='$cookie_id' AND product_id='$id'");
        $wishlistExists = $wishlistQuery && $wishlistQuery->rowCount() > 0;
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

                                <?php while ($bv = $basicVariants->fetch()):
                                    $variantLabel = $bv['variation'] ?? $bv['variant'] ?? ($bv['name'] ?? "Variant " . $bv['id']);
                                    $variantId = $bv['id'];
                                    $vStock = $variantStocksDisplay[$variantId];
                                    $isInCart = in_array($variantId, $cartVariants);
                                ?>
                                    <button class="variant-btn px-3 py-1 border rounded-lg text-sm hover:bg-pink-100 <?= $initialVariantId == $variantId ? 'ring-2 ring-pink-400' : '' ?>"
                                        data-variant-id="<?= $variantId ?>"
                                        data-variant-image="<?= UPLOADS_URL . ($bv['image'] ?? $image) ?>"
                                        data-variant-name="<?= htmlspecialchars($variantLabel) ?>"
                                        data-price="<?= $bv['price'] ?>"
                                        data-mrp="<?= $bv['mrp_price'] ?>"
                                        data-stock="<?= $vStock ?>"
                                        data-in-cart="<?= $isInCart ? 1 : 0 ?>">
                                        <?= htmlspecialchars($variantLabel) ?>
                                    </button>
                                <?php endwhile; ?>
                            </div>
                        <?php endif; ?>

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

                        <p class="text-xs text-gray-400 mt-1">Viewed <?= (int)$visitors ?> times</p>

                        <!-- Add to Cart -->
                        <div class="flex flex-wrap gap-4 mb-6 items-center mt-4">
                            <?php
                            $isOutOfStock = ($total_stocks <= 0 && $unlimited_stock != 1);
                            $disableAdd = $inCartInitial || $isOutOfStock;
                            $btnClass = $disableAdd
                                ? 'bg-gray-300 cursor-not-allowed'
                                : 'bg-gradient-to-r from-pink-400 to-pink-600 hover:from-pink-500 hover:to-pink-700';
                            $btnText = $inCartInitial ? 'Already in Cart' : ($isOutOfStock ? 'Out of Stock' : 'Add to Cart');
                            ?>
                            <button id="addCartBtn" class="px-5 py-2 rounded-lg <?= $btnClass ?> text-white font-semibold shadow-lg transition transform hover:scale-105 addToCartBtn text-sm sm:text-base <?= $inCartInitial ? 'hidden' : '' ?>"
                                data-id="<?= $id ?>"
                                data-variant="<?= $initialVariantId ?? '' ?>"
                                <?= $disableAdd ? 'disabled' : '' ?>>
                                <?= $btnText ?>
                            </button>

                            <a id="viewCartBtn" href="<?= $storeUrl ?>cart" class="flex items-center px-4 py-2 rounded-lg bg-yellow-400 text-white font-semibold shadow hover:bg-yellow-500 transition transform hover:scale-105 text-sm sm:text-base <?= $inCartInitial ? '' : 'hidden' ?>">
                                <i class="fas fa-shopping-cart mr-2"></i> View Cart
                            </a>

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

    <!-- Report Modal Start -->
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
    <!-- Report Modal End -->

    <!-- Latest Product Section Start-->
    <section class="py-16 px-4 bg-gray-50">
        <div class="container mx-auto">

            <!-- Section Heading -->
            <div class="text-center mb-8">
                <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-800 mb-1">New Collections</h2>
                <p class="text-base sm:text-lg md:text-xl text-gray-600 max-w-2xl mx-auto">
                    Explore our latest and most exciting products
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
    <!-- Footer End-->

    <!-- SingleProduct View Section End-->

    <?php include_once __DIR__ . "/includes/footer_link.php"; ?>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const variantButtons = document.querySelectorAll('.variant-btn');
            const mainImage = document.getElementById('mainProductImage');
            const priceEl = document.querySelector('.productPrice');
            const mrpEl = document.querySelector('.productMrp');
            const stockEl = document.getElementById('stockDisplay');
            const addBtn = document.getElementById('addCartBtn');
            const viewBtn = document.getElementById('viewCartBtn');
            const variantNameEl = document.getElementById('variantName');

            const productKey = "selectedVariant_<?= $id ?>";

            function selectVariant(btn) {
                variantButtons.forEach(b => b.classList.remove('ring-2', 'ring-pink-400'));
                btn.classList.add('ring-2', 'ring-pink-400');

                const variantId = btn.dataset.variantId === 'main' ? '' : btn.dataset.variantId;
                const variantImage = btn.dataset.variantImage;
                const variantPrice = parseFloat(btn.dataset.price);
                const variantMrp = parseFloat(btn.dataset.mrp);
                const stockText = btn.dataset.stock;
                const inCart = btn.dataset.inCart == 1;
                const variantName = btn.dataset.variantName;

                if (variantImage) mainImage.src = variantImage;
                if (priceEl) priceEl.textContent = "<?= currencyToSymbol($storeCurrency) ?>" + variantPrice.toLocaleString();
                if (mrpEl) mrpEl.textContent = (variantMrp && variantMrp > variantPrice) ? "<?= currencyToSymbol($storeCurrency) ?>" + variantMrp.toLocaleString() : '';
                if (stockEl) {
                    stockEl.textContent = stockText;
                    if (stockText.toLowerCase().includes('unlimited') || parseInt(stockText) > 0) {
                        stockEl.classList.remove('text-red-500');
                        stockEl.classList.add('text-green-500');
                    } else {
                        stockEl.classList.remove('text-green-500');
                        stockEl.classList.add('text-red-500');
                    }
                }

                if (variantNameEl) variantNameEl.textContent = variantName;

                if (addBtn && viewBtn) {
                    addBtn.dataset.variant = variantId;
                    const isOutOfStock = stockText.toLowerCase().includes('0') || stockText.toLowerCase().includes('out of stock');

                    if (inCart) {
                        addBtn.classList.add('hidden');
                        viewBtn.classList.remove('hidden');
                    } else if (isOutOfStock) {
                        addBtn.disabled = true;
                        addBtn.textContent = 'Out of Stock';
                        addBtn.classList.remove('hidden');
                        addBtn.classList.add('bg-gray-300', 'cursor-not-allowed');
                        addBtn.classList.remove('bg-gradient-to-r', 'from-pink-400', 'to-pink-600');
                        viewBtn.classList.add('hidden');
                    } else {
                        addBtn.disabled = false;
                        addBtn.textContent = 'Add to Cart';
                        addBtn.classList.remove('bg-gray-300', 'cursor-not-allowed');
                        addBtn.classList.add('bg-gradient-to-r', 'from-pink-400', 'to-pink-600');
                        addBtn.classList.remove('hidden');
                        viewBtn.classList.add('hidden');
                    }
                }

                localStorage.setItem(productKey, btn.dataset.variantId);
            }

            // Load saved variant
            const savedVariantId = localStorage.getItem(productKey);
            if (savedVariantId) {
                variantButtons.forEach(btn => {
                    if (btn.dataset.variantId === savedVariantId) selectVariant(btn);
                });
            } else {
                selectVariant(variantButtons[0]);
            }

            variantButtons.forEach(btn => btn.addEventListener('click', () => selectVariant(btn)));

            addBtn.addEventListener('click', function() {
                const productId = this.dataset.id;
                const variantId = this.dataset.variant;

                fetch('add_to_cart.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: `id=${productId}&variant=${variantId}`
                    })
                    .then(res => res.text())
                    .then(() => location.reload())
                    .catch(err => console.error(err));
            });
        });
    </script>

</body>

</html>