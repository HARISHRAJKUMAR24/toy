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
        $html .= ($totalStocks || !getData("id", "seller_products", "id='$id' AND unlimited_stock=0"))
            ? '<button type="button" class="addToCartBtn relative overflow-hidden bg-gradient-to-r from-pink-200 to-pink-300 
                      text-pink-700 px-4 py-2 rounded-md shadow transition-all duration-500 
                      bg-[length:200%_100%] bg-left hover:bg-right uppercase font-semibold text-sm sm:text-base flex items-center justify-center w-full mt-1" 
                      data-id="' . $id . '" data-variant="" data-advancedVariant="' . $advancedVariant . '">
                        <span class="mgc_shopping_bag_3_line mr-1"></span> Add
               </button>'
            : '<button type="button" class="bg-gray-100 text-gray-500 rounded-md h-11 flex items-center justify-center px-3 font-medium w-full transition cursor-not-allowed" disabled>Out of Stock</button>';
    }

    $html .= '</div>';
    return $html;
}

// =====================
// PRODUCT CARD FUNCTION
// =====================
function getProductHtml($id)
{
    global $storeCurrency, $storeUrl, $customerId, $cookie_id;

    $product_id = getData("product_id", "seller_products", "id='$id'") ?: die("Product ID not found for $id");
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

    if (empty($variation)) $variation = $unit . $unit_type;

    // Calculate save %
    $savePercent = 0;
    if ($badge === "Save" && $mrp_price && $mrp_price > $price) {
        $savePercent = round((($mrp_price - $price) / $mrp_price) * 100);
    }

    // Wishlist Button
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
        if ($i <= $rating) $stars .= '<span class="mgc_star_fill text-yellow-400"></span>';
        else $stars .= '<span class="mgc_star_line text-gray-300"></span>';
    }

    // Start HTML
    $html = '<div class="group relative bg-white rounded-lg overflow-hidden shadow hover:shadow-lg transition duration-300 flex flex-col" data-id="' . $id . '">
                <div class="relative">
                    <a href="' . $storeUrl . 'product/' . $slug . '">
                        <img src="' . UPLOADS_URL . $image . '" alt="' . htmlspecialchars($name) . '" class="productImage w-full h-64 sm:h-72 md:h-64 lg:h-60 object-cover transition-transform duration-500 group-hover:scale-105">
                    </a>';

    // Badge
    if ($badge || $savePercent > 0) {
        $html .= '<div class="absolute top-2 left-2 flex flex-col items-center justify-center min-w-[3.5rem] px-2 py-1 bg-gradient-to-b from-red-600 to-red-800 text-white rounded shadow-lg border-2 border-red-300 border-opacity-50 text-[6px] sm:text-[8px] font-bold uppercase text-center">
                    <span>' . strtoupper($badge ?: 'SAVE') . '</span>' .
            ($savePercent > 0 ? '<span class="text-sm font-black leading-none">' . $savePercent . '%</span>' : '') . '
                  </div>';
    }

    $html .= $wishlist . '</div>';

    // Product Info
    $html .= '<div class="p-4 flex flex-col flex-grow">
                <h3 class="text-base sm:text-lg font-semibold text-gray-800 group-hover:text-pink-600 transition-colors mb-1">' . htmlspecialchars($name) . '</h3>
                <div class="flex items-center mb-3">' . $stars . '</div>';

    // Variant Dropdown
    $variantData = readData("*", "seller_product_variants", "product_id='$product_id' AND (stock>0 OR unlimited_stock=1)");
    if ($variantData && $variantData->rowCount()) {
        $html .= '<div class="mb-3">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Select Variant:</label>
                    <div class="relative">
                        <select class="variantSelect block w-full appearance-none border border-gray-300 rounded-lg bg-white px-4 py-2 pr-10 text-gray-700 text-sm">
                            <option value="" disabled selected>Select</option>';
        while ($row = $variantData->fetch(PDO::FETCH_ASSOC)) {
            $html .= '<option value="' . $row['id'] . '" data-image="' . UPLOADS_URL . $row['image'] . '" data-price="' . $row['price'] . '" data-mrp="' . $row['mrp_price'] . '">' . htmlspecialchars($row['variation']) . '</option>';
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
<!-- ===================== -->
<!-- VARIANT & PRICE JS -->
<!-- ===================== -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.variantSelect').forEach(select => {
            select.addEventListener('change', function() {
                const selected = this.options[this.selectedIndex];
                const img = selected.dataset.image;
                const price = selected.dataset.price;
                const mrp = selected.dataset.mrp;

                const card = this.closest('.group');
                const imageEl = card.querySelector('.productImage');
                const priceEl = card.querySelector('.productPrice');
                const mrpEl = card.querySelector('.productMrp');
                const addBtn = card.querySelector('.addToCartBtn');

                if (imageEl) imageEl.src = img;
                if (priceEl) priceEl.textContent = "<?= currencyToSymbol($storeCurrency) ?>" + parseFloat(price).toLocaleString();
                if (mrpEl) mrpEl.textContent = (mrp && mrp > price) ? "<?= currencyToSymbol($storeCurrency) ?>" + parseFloat(mrp).toLocaleString() : '';
                if (addBtn) addBtn.dataset.variant = selected.value;
            });
        });
    });
</script>