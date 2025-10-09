<?php
// =====================
// ADD TO CART FUNCTION
// =====================
function addToCartSection($id, $product_id, $cookie_id, $advancedVariant, $totalStocks, $variant = "", $currentQty = 0)
{
    $html = '<div class="addToCartWrapper" data-id="' . $id . '" id="addCart-' . $product_id . '" data-variant="' . $variant . '">';

    // Check if item is in cart
    $cartData = getData("id", "customer_cart", "customer_id='$cookie_id' AND product_id='$id' AND other='$variant'");
    if ($cartData) {
        $currentQty = getData("quantity", "customer_cart", "customer_id='$cookie_id' AND product_id='$id' AND other='$variant'");
        $html .= '<div class="qtySwitcher flex items-center justify-between border border-gray-300 rounded-md px-2 py-1 mt-1">
                    <button class="decreaseQtyBtn text-lg font-bold px-2" data-id="' . $id . '" data-advancedVariant="' . $advancedVariant . '">−</button>
                    <span class="text-base font-medium text-center currentQty">' . $currentQty . '</span>
                    <button class="increaseQtyBtn text-lg font-bold px-2" data-id="' . $id . '" data-advancedVariant="' . $advancedVariant . '">+</button>
                  </div>';
    } else {
        // Default Add button
        $isOutOfStock = (!$totalStocks && !getData("id", "seller_products", "id='$id' AND unlimited_stock=1"));
        $btnClass = $isOutOfStock
            ? 'bg-gray-100 text-pink-700 cursor-not-allowed'
            : 'bg-gradient-to-r from-pink-200 to-pink-300 text-pink-700 hover:from-pink-300 hover:to-pink-400';
        $btnText = $isOutOfStock ? 'Out of Stock' : 'Add';
        $html .= '<button type="button" class="addToCartBtn relative overflow-hidden px-4 py-2 rounded-md shadow transition-all duration-300 w-full flex items-center justify-center ' . $btnClass . '" 
                    data-id="' . $id . '" data-variant="" data-advancedVariant="' . $advancedVariant . '" ' . ($isOutOfStock ? 'disabled' : '') . '>
                    <span class="mgc_shopping_bag_3_line mr-1"></span> ' . $btnText . '
                  </button>';
    }

    $html .= '</div>'; // Closing wrapper
    return $html;
}

// =====================
// PRODUCT CARD FUNCTION
// =====================
function getProductHtml($id)
{
    global $storeCurrency, $storeUrl, $customerId, $cookie_id;

    $product_id = getData("product_id", "seller_products", "id='$id'") ?: die("Product ID not found");
    $slug       = getData("slug", "seller_products", "id='$id'") ?: die("Slug not found");
    $name       = getData("name", "seller_products", "id='$id'") ?: die("Product name not found");
    $image      = getData("image", "seller_products", "id='$id'") ?: die("Product image not found");
    $price      = getData("price", "seller_products", "id='$id'") ?: die("Price not found");
    $mrp_price  = getData("mrp_price", "seller_products", "id='$id'") ?: 0;
    $badge      = getData("badge", "seller_products", "id='$id'");
    $totalStocks = getData("total_stocks", "seller_products", "id='$id'") ?: 0;
    $unit       = getData("unit", "seller_products", "id='$id'");
    $unit_type  = getData("unit_type", "seller_products", "id='$id'");
    $variation  = getData("variation", "seller_products", "id='$id'");
    $advancedVariant = "";

    // Wishlist
    $wishlistClass = "bg-white/95 text-pink-600";
    if (isLoggedIn() && getData("id", "customer_wishlists", "customer_id='$customerId' AND product_id='$id'")) {
        $wishlistClass = "bg-pink-500 text-white";
    }
    $wishlist = '<button class="absolute top-2 right-2 w-10 h-10 flex items-center justify-center 
                        rounded-full shadow-lg transition transform hover:scale-110 handleWishlist ' . $wishlistClass . '" data-id="' . $id . '">
                        <i class="fa-solid fa-heart"></i>
                 </button>';

    // Advanced Variant
    if ($advVar = getData("id", "seller_product_advanced_variants", "product_id='$product_id'")) {
        $advancedVariant = $advVar;
        $price = getData("price", "seller_product_advanced_variants", "product_id='$product_id'") ?: $price;
        $mrp_price = getData("mrp_price", "seller_product_advanced_variants", "product_id='$product_id'") ?: $mrp_price;
        $image = getData("image", "seller_product_advanced_variants", "product_id='$product_id'") ?: $image;
        $totalStocks = getData("stock", "seller_product_advanced_variants", "product_id='$product_id'") ?: $totalStocks;
    }

    // Rating stars
    $rating = getData("rating", "product_ratings", "product_id='$id'") ?: 0;
    $stars = '';
    for ($i = 1; $i <= 5; $i++) {
        $stars .= $i <= $rating ? '<span class="mgc_star_fill text-yellow-400"></span>' : '<span class="mgc_star_line text-gray-300"></span>';
    }

    // Fetch variant stocks
    $variantData = readData("*", "seller_product_variants", "product_id='$product_id'");
    $variantStocks = [];
    while ($row = $variantData->fetch(PDO::FETCH_ASSOC)) {
        if (($row['unlimited_stock'] ?? 0) == 1) {
            $variantStocks[$row['id']] = "Unlimited stock";
        } else {
            $variantStocks[$row['id']] = (int)$row['stock'];
        }
    }

    // Start HTML
    $html = '<div class="group relative bg-white rounded-lg overflow-hidden shadow hover:shadow-lg transition duration-300 flex flex-col" data-id="' . $id . '">
                <div class="relative">
                    <a href="' . $storeUrl . 'product/' . $slug . '">
                        <img src="' . UPLOADS_URL . $image . '" alt="' . htmlspecialchars($name) . '" class="productImage w-full h-64 sm:h-72 md:h-64 lg:h-60 object-cover transition-transform duration-500 group-hover:scale-105">
                    </a>' . $wishlist . '</div>';

    // Product Info
    $html .= '<div class="p-4 flex flex-col flex-grow">
                <h3 class="text-base sm:text-lg font-semibold text-gray-800 group-hover:text-pink-600 transition-colors mb-1">' . htmlspecialchars($name) . '</h3>
                <div class="flex items-center mb-3">' . $stars . '</div>';

    // Variant dropdown
    if ($variantStocks) {
        $html .= '<div class="mb-3">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Select Variant:</label>
                    <div class="relative">
                        <select class="variantSelect block w-full appearance-none border border-gray-300 rounded-lg bg-white px-4 py-2 pr-10 text-gray-700 text-sm">
                            <option value="" selected disabled>Select</option>
                            <option value="main" data-image="' . UPLOADS_URL . $image . '" data-price="' . $price . '" data-mrp="' . $mrp_price . '" data-stock="' . $totalStocks . '" data-unlimited="' . (getData("unlimited_stock", "seller_products", "id='$id'") ?? 0) . '">'
            . htmlspecialchars(!empty($variation) ? $variation : $name) . '
                            </option>';
        foreach ($variantStocks as $vid => $stock) {
            $vQuery = readData("*", "seller_product_variants", "id='$vid'");
            $vData = $vQuery->fetch(PDO::FETCH_ASSOC);
            if (!$vData) continue;

            $html .= '<option value="' . $vid . '" 
        data-image="' . UPLOADS_URL . ($vData['image'] ?? $image) . '" 
        data-price="' . $vData['price'] . '" 
        data-mrp="' . $vData['mrp_price'] . '" 
        data-stock="' . $stock . '" 
        data-unlimited="' . ($vData['unlimited_stock'] ?? 0) . '">'
                . htmlspecialchars($vData['variation']) . '</option>';
        }

        $html .= '</select>
                  <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-400">
                    <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                  </div>
                  </div></div>';
    }

    // Price + Add to Cart
    $html .= '<div class="flex items-center justify-between mt-auto">
                <div class="flex flex-col sm:flex-row sm:items-center sm:space-x-2">
                    <span class="productPrice text-sm sm:text-base font-bold">' . currencyToSymbol($storeCurrency) . number_format($price) . '</span>' .
        (($mrp_price && $mrp_price > $price) ? '<span class="productMrp text-sm text-gray-400 line-through">' . currencyToSymbol($storeCurrency) . number_format($mrp_price) . '</span>' : '') .
        '</div>';

    $html .= addToCartSection($id, $product_id, $cookie_id, $advancedVariant, $totalStocks, $variation);
    $html .= '</div></div></div>';

    return $html;
}
?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.variantSelect').forEach(select => {
            select.addEventListener('change', function() {
                const selected = this.options[this.selectedIndex];
                const card = this.closest('.group');
                const addBtn = card.querySelector('.addToCartBtn');

                if (!selected.value) {
                    if (addBtn) addBtn.disabled = true;
                    return;
                }

                const img = selected.dataset.image;
                const price = selected.dataset.price;
                const mrp = selected.dataset.mrp;
                const stock = Number(selected.dataset.stock) || 0;
                const unlimited = Number(selected.dataset.unlimited) || 0;

                const imageEl = card.querySelector('.productImage');
                const priceEl = card.querySelector('.productPrice');
                const mrpEl = card.querySelector('.productMrp');

                if (imageEl) imageEl.src = img;
                if (priceEl) priceEl.textContent = "<?= currencyToSymbol($storeCurrency) ?>" + Number(price).toLocaleString();
                if (mrpEl) mrpEl.textContent = (mrp && mrp > price) ? "<?= currencyToSymbol($storeCurrency) ?>" + Number(mrp).toLocaleString() : '';

                if (addBtn) {
                    const isOutOfStock = stock <= 0 && unlimited !== 1;
                    addBtn.disabled = isOutOfStock;
                    addBtn.dataset.variant = selected.value === "main" ? "" : selected.value;
                    addBtn.textContent = isOutOfStock ? "Out of Stock" : "Add";

                    // Clear previous classes
                    addBtn.classList.remove('bg-gray-300', 'cursor-not-allowed', 'bg-gradient-to-r', 'from-pink-400', 'to-pink-600');

                    // Apply new classes based on stock
                    if (isOutOfStock) {
                        addBtn.classList.add('bg-gray-100', 'cursor-not-allowed', 'text-gray-00');
                    } else {
                        addBtn.classList.add('bg-gradient-to-r', 'from-pink-200', 'to-pink-300', 'text-pink-700');
                    }
                }
            });
        });
    });
</script>