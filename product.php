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
    if (isset($_GET['slug']) && getData("id", "seller_products", "slug = '{$_GET['slug']}' AND (visibility = 'publish' OR (visibility = 'schedule' AND schedule_date <= NOW())) AND seller_id = '$sellerId' AND status = 1")) {

        $slug = $_GET['slug'];
        $id = getData("id", "seller_products", "slug = '{$_GET['slug']}' AND seller_id = '$sellerId'");
        $product_id = getData("product_id", "seller_products", "slug = '{$_GET['slug']}' AND seller_id = '$sellerId'");
        $name = getData("name", "seller_products", "slug = '{$_GET['slug']}' AND seller_id = '$sellerId'");
        $variation = getData("variation", "seller_products", "slug = '{$_GET['slug']}' AND seller_id = '$sellerId'");
        $price = getData("price", "seller_products", "slug = '{$_GET['slug']}' AND seller_id = '$sellerId'");
        $mrp_price = getData("mrp_price", "seller_products", "slug = '{$_GET['slug']}' AND seller_id = '$sellerId'");
        $description = getData("description", "seller_products", "slug = '{$_GET['slug']}' AND seller_id = '$sellerId'");
        $image = getData("image", "seller_products", "slug = '{$_GET['slug']}' AND seller_id = '$sellerId'");

        $unlimited_stock = getData("unlimited_stock", "seller_products", "slug = '{$slug}' AND seller_id = '$sellerId'");
        $total_stocks = getData("total_stocks", "seller_products", "slug = '{$slug}' AND seller_id = '$sellerId'");
        $maxQty = ($unlimited_stock == 1) ? "Unlimited" : (int)$total_stocks;

        $variantId = isset($_GET['variation']) ? $_GET['variation'] : '';

        $db->prepare("UPDATE seller_products SET visitors = visitors+1 WHERE id = :id")->execute(['id' => $id]);
        $visitors = getData("visitors", "seller_products", "id = '$id'");

        $stmt = $db->prepare("SELECT AVG(rating) AS average_rating FROM product_ratings WHERE product_id = ?");
        $stmt->execute([$id]);
        $averageRating = ($stmt->rowCount() > 0) ? $stmt->fetch(PDO::FETCH_ASSOC)['average_rating'] : 0;

        $variantsData = readData("*", "seller_product_advanced_variants", "product_id = '$product_id'");
        $basicVariants = readData("*", "seller_product_variants", "product_id = '$product_id'");

        // Cart variants
        $cartVariants = readData("other", "customer_cart", "customer_id = '$cookie_id' AND product_id = '$id'")->fetchAll(PDO::FETCH_COLUMN);
        $inCartInitial = in_array($variantId, $cartVariants);
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

                    <!-- Info -->
                    <div class="flex-1 flex flex-col flex-[0.45]">
                        <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-800 mb-2"><?= htmlspecialchars($name) ?></h1>
                        <p class="text-base sm:text-lg md:text-xl text-gray-600 mb-4"><?= htmlspecialchars($variation) ?></p>

                        <!-- Variants -->
                        <?php if ($basicVariants && $basicVariants->rowCount() > 0) : ?>
                            <div class="flex flex-wrap gap-2 mb-4">
                                <?php while ($bv = $basicVariants->fetch()) : ?>
                                    <?php $variantLabel = $bv['variation'] ?? $bv['variant'] ?? ($bv['name'] ?? "Variant " . $bv['id']); ?>
                                    <button class="variant-btn px-3 py-1 border rounded-lg text-sm hover:bg-pink-100" data-variant-id="<?= $bv['id'] ?>" data-variant-image="<?= UPLOADS_URL . ($bv['image'] ?? $image) ?>">
                                        <?= htmlspecialchars($variantLabel) ?>
                                    </button>
                                <?php endwhile; ?>
                            </div>
                        <?php endif; ?>

                        <?php if ($variantsData->rowCount() > 0) : ?>
                            <div class="flex gap-2 sm:gap-3 mt-2 mb-4 flex-wrap">
                                <?php while ($v = $variantsData->fetch()):
                                    $colorCode = !empty($v['color']) ? getData("color_code", "product_colors", "id = '{$v['color']}'") : '';
                                    $variantImage = $v['image'] ?? $image;
                                ?>
                                    <button
                                        class="variant-btn px-3 py-1 sm:px-4 sm:py-2 text-sm sm:text-base font-semibold rounded-lg border hover:bg-pink-50 transition"
                                        style="<?= !empty($colorCode) ? "background-color: $colorCode; color: " . getContrastYIQ($colorCode) . "; border:none;" : "" ?>"
                                        data-variant-id="<?= $v['id'] ?>"
                                        data-variant-image="<?= UPLOADS_URL . $variantImage ?>">
                                        <?= strtoupper($v['color'] ?? $v['size'] ?? $v['variation'] ?? 'VAR') ?>
                                    </button>
                                <?php endwhile; ?>
                            </div>
                        <?php endif; ?>

                        <!-- Price & Ratings -->
                        <div class="flex items-center gap-3 mb-6">
                            <span class="text-2xl font-bold text-pink-600"><?= currencyToSymbol($storeCurrency) . $price ?></span>
                            <?php if ($mrp_price) : ?>
                                <span class="text-gray-400 line-through"><?= currencyToSymbol($storeCurrency) . $mrp_price ?></span>
                            <?php endif; ?>
                        </div>

                        <p class="text-gray-700 leading-relaxed mb-4"><?= $description ?></p>

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
                                data-variant="<?= $variantId ?>"
                                data-redirectUrl="<?= $storeUrl ?>cart"
                                <?= $disableAdd ? 'disabled' : '' ?>>
                                <?= ($maxQty !== "Unlimited" && (int)$maxQty <= 0) ? 'Out of Stock' : ($inCartInitial ? 'Already in Cart' : 'Add to Cart') ?>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
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
    <?php include_once __DIR__ . "/includes/footer_link.php"; ?>

    <script>
        const cartVariants = <?= json_encode($cartVariants) ?>;

        document.querySelectorAll('.variant-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.variant-btn').forEach(x => x.classList.remove('ring-2', 'ring-pink-400'));
                this.classList.add('ring-2', 'ring-pink-400');

                const variantImage = this.dataset.variantImage;
                if (variantImage) document.getElementById('mainProductImage').src = variantImage;

                const addBtn = document.querySelector('.addToCartBtn');
                if (addBtn) {
                    const variantId = this.dataset.variantId;
                    addBtn.dataset.variant = variantId;

                    if ((<?= (int)$maxQty ?> <= 0 && "<?= $unlimited_stock ?>" != "1") || cartVariants.includes(variantId)) {
                        addBtn.textContent = cartVariants.includes(variantId) ? 'Already in Cart' : 'Out of Stock';
                        addBtn.disabled = true;
                        addBtn.classList.remove('bg-gradient-to-r', 'from-pink-400', 'to-pink-600', 'hover:from-pink-500', 'hover:to-pink-700');
                        addBtn.classList.add('bg-gray-300', 'cursor-not-allowed');
                    } else {
                        addBtn.textContent = 'Add to Cart';
                        addBtn.disabled = false;
                        addBtn.classList.remove('bg-gray-300', 'cursor-not-allowed');
                        addBtn.classList.add('bg-gradient-to-r', 'from-pink-400', 'to-pink-600', 'hover:from-pink-500', 'hover:to-pink-700');
                    }
                }
            });
        });
    </script>

</body>

</html>

<?php
function getContrastYIQ($hexcolor)
{
    $hexcolor = str_replace("#", "", $hexcolor);
    $r = hexdec(substr($hexcolor, 0, 2));
    $g = hexdec(substr($hexcolor, 2, 2));
    $b = hexdec(substr($hexcolor, 4, 2));
    $yiq = (($r * 299) + ($g * 587) + ($b * 114)) / 1000;
    return ($yiq >= 128) ? '#000000' : '#FFFFFF';
}
?>