
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



                        <!-- Add to Cart -->
                        <div class="flex flex-wrap gap-4 mb-6 items-center mt-4">
                            <?php
                            $isOutOfStock = ($total_stocks <= 0 && $unlimited_stock != 1);
                            $disableAdd = $inCartInitial || $isOutOfStock;
                            $btnClass = $disableAdd
                                ? 'bg-gray-300 cursor-not-allowed'
                                : 'bg-gradient-to-r from-pink-400 to-pink-600 hover:from-pink-500 hover:to-pink-700';
                            $btnText = $inCartInitial ? 'Already in Cart' : ($isOutOfStock ? 'Sold Out' : 'Add to Cart');
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

                            <!-- Report Button -->
                            <button type="button" id="reportThisProduct" class="px-3 py-2 sm:px-4 sm:py-2 md:px-4 md:py-2 rounded-lg bg-red-500 text-white shadow hover:bg-red-600 transition transform hover:scale-105 flex items-center justify-center text-sm sm:text-base">
                                <i class="fas fa-flag"></i>
                            </button>
                        </div>
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

    <!--Footer File Includes that file has all JS Files includes links-->
    <?php include_once __DIR__ . "/includes/footer.php"; ?>

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
                // Highlight selected variant
                variantButtons.forEach(b => b.classList.remove('ring-2', 'ring-pink-400'));
                btn.classList.add('ring-2', 'ring-pink-400');

                const variantId = btn.dataset.variantId === 'main' ? '' : btn.dataset.variantId;
                addBtn.dataset.variant = variantId;
                const variantImage = btn.dataset.variantImage;
                const variantPrice = parseFloat(btn.dataset.price);
                const variantMrp = parseFloat(btn.dataset.mrp);
                const stockText = btn.dataset.stock;
                const inCart = btn.dataset.inCart == 1;
                const variantName = btn.dataset.variantName;

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
                    addBtn.dataset.variant = variantId;

                    let stockNumber = parseInt(stockText);
                    if (stockText.toLowerCase().includes('unlimited')) stockNumber = Infinity;
                    const isOutOfStock = stockNumber < 1;

                    if (inCart) {
                        addBtn.classList.add('hidden');
                        viewBtn.classList.remove('hidden');
                    } else if (isOutOfStock) {
                        addBtn.disabled = true;
                        addBtn.textContent = 'Sold Out';
                        addBtn.classList.remove('bg-gradient-to-r', 'from-pink-400', 'to-pink-600');
                        addBtn.classList.add('bg-gray-300', 'cursor-not-allowed');
                        viewBtn.classList.add('hidden');
                        addBtn.classList.remove('hidden');
                    } else {
                        addBtn.disabled = false;
                        addBtn.textContent = 'Add to Cart';
                        addBtn.classList.add('bg-gradient-to-r', 'from-pink-400', 'to-pink-600');
                        addBtn.classList.remove('bg-gray-300', 'cursor-not-allowed');
                        viewBtn.classList.add('hidden');
                        addBtn.classList.remove('hidden');
                    }
                }

                // Save selected variant
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

            // Add click event to variant buttons
            variantButtons.forEach(btn => btn.addEventListener('click', () => selectVariant(btn)));

            // Add to cart
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

        // // AJAX Form Submission
        // // Show/Hide report modal
        // $("#reportThisProduct").on("click", function() {
        //     $("#reportProductContent").fadeToggle();
        // });

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
                            // Optional: small success toast or inline message
                            $("#reportProductContent").fadeOut(); // close modal
                            $("#reportForm")[0].reset(); // reset form
                            $("<div class='bg-green-500 text-white px-4 py-2 rounded fixed top-5 right-5 z-50'>Report sent successfully!</div>")
                                .appendTo("body")
                                .delay(3000)
                                .fadeOut(500, function() {
                                    $(this).remove();
                                });
                        } else {
                            $("<div class='bg-red-500 text-white px-4 py-2 rounded fixed top-5 right-5 z-50'>" + response.message + "</div>")
                                .appendTo("body")
                                .delay(3000)
                                .fadeOut(500, function() {
                                    $(this).remove();
                                });
                        }
                    }
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error:", error);
                }
            });
        });
    </script>


</body>

</html>