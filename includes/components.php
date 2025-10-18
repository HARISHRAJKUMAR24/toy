<?php
// =====================
// ADD TO CART FUNCTION
// =====================
function addToCartSection($id, $product_id, $cookie_id, $advancedVariant, $totalStocks, $variant = "", $currentQty = 0, $hasAdvancedVariants = false)
{
    $html = '<div class="addToCartWrapper" data-id="' . $id . '" id="addCart-' . $product_id . '" data-variant="' . $variant . '">';

    // Check if advanced variants exist - if yes, main product should be disabled
    $isMainProductDisabled = $hasAdvancedVariants && $variant === "" && $advancedVariant === "";
    
    // Check if item is in cart
    $cartData = getData("id", "customer_cart", "customer_id='$cookie_id' AND product_id='$id' AND other='$variant'");

    // Default Add button
    $isOutOfStock = (!$totalStocks && !getData("id", "seller_products", "id='$id' AND unlimited_stock=1"));
    
    // If main product has advanced variants, disable it and show "Select Color and Size"
    if ($isMainProductDisabled) {
        $btnClass = 'bg-gray-300 cursor-not-allowed';
        $btnText = 'Select Color and Size';
        $disabled = 'disabled';
    } else {
        $btnClass = $isOutOfStock
            ? 'bg-gray-100 text-gray-400 cursor-not-allowed'
            : 'bg-gradient-to-r from-pink-200 to-pink-300 text-pink-700 hover:from-pink-300 hover:to-pink-400';
        $btnText = $isOutOfStock ? 'Out of Stock' : 'Add';
        $disabled = $isOutOfStock ? 'disabled' : '';
    }
    
    $html .= '<button type="button" class="addToCartBtn relative overflow-hidden px-4 py-2 rounded-md shadow transition-all duration-300 w-full flex items-center justify-center ' . $btnClass . '" 
                    data-id="' . $id . '" data-variant="' . $variant . '" data-advancedVariant="' . $advancedVariant . '" ' . $disabled . '>
                    <span class="mgc_shopping_bag_3_line mr-1"></span> ' . $btnText . '
                  </button>';

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

    // Check if advanced variants exist
    $hasAdvancedVariants = getData("id", "seller_product_advanced_variants", "product_id='$product_id'");

    // Check if product is in wishlist
    $inWishlist = false;
    if (isLoggedIn()) {
        $inWishlist = getData("id", "customer_wishlists", "customer_id='$customerId' AND product_id='$id'") ? true : false;
    }

    // Set button and icon classes based on state
    $btnBg   = $inWishlist ? "bg-white" : "bg-gray-500";
    $btnText = $inWishlist ? "text-rose-500" : "text-white";

    $wishlist = '<button class="absolute top-2 right-2 
        w-8 h-8 md:w-7 md:h-7
        flex items-center justify-center 
        rounded-full shadow-lg transition transform 
        hover:scale-110 handleWishlist ' . $btnBg . '" 
        data-id="' . $id . '">
        <i class="fa-solid fa-heart 
        text-sm md:text-base ' . $btnText . '"></i>  
     </button>';

    // Check if basic variants exist
    $hasBasicVariants = getData("id", "seller_product_variants", "product_id='$product_id'");

    // Rating stars
    $rating = getData("rating", "product_ratings", "product_id='$id'") ?: 0;
    $stars = '';
    for ($i = 1; $i <= 5; $i++) {
        $stars .= $i <= $rating ? '<span class="mgc_star_fill text-yellow-400"></span>' : '<span class="mgc_star_line text-gray-300"></span>';
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

    // Variant dropdown - Show if any variants exist
    if ($hasAdvancedVariants || $hasBasicVariants) {
        $html .= '<div class="mb-3">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Select Option:</label>
                    <div class="relative">
                        <select class="variantSelect block w-full appearance-none border border-gray-300 rounded-lg bg-white px-4 py-2 pr-10 text-gray-700 text-sm">
                            <option value="" selected disabled>Select Option</option>';

        // Only show main product option if NO advanced variants exist (only basic variants)
        if (!$hasAdvancedVariants) {
            $html .= '<option value="main" data-image="' . UPLOADS_URL . $image . '" data-price="' . $price . '" data-mrp="' . $mrp_price . '" data-stock="' . $totalStocks . '" data-unlimited="' . (getData("unlimited_stock", "seller_products", "id='$id'") ?? 0) . '" data-variant-type="main">'
                . htmlspecialchars(!empty($variation) ? $variation : $name) . '
                            </option>';
        }

        // Add basic variants
        if ($hasBasicVariants) {
            $basicVariants = readData("*", "seller_product_variants", "product_id='$product_id'");
            while ($bv = $basicVariants->fetch(PDO::FETCH_ASSOC)) {
                $stock = ($bv['unlimited_stock'] ?? 0) == 1 ? "Unlimited" : (int)($bv['stock'] ?? 0);
                $html .= '<option value="' . $bv['id'] . '" 
                    data-image="' . UPLOADS_URL . ($bv['image'] ?? $image) . '" 
                    data-price="' . $bv['price'] . '" 
                    data-mrp="' . $bv['mrp_price'] . '" 
                    data-stock="' . $stock . '" 
                    data-unlimited="' . ($bv['unlimited_stock'] ?? 0) . '" 
                    data-variant-type="basic">
                    ' . htmlspecialchars($bv['variation'] ?? $bv['name'] ?? "Variant") . '
                </option>';
            }
        }

        // Add advanced variants
        if ($hasAdvancedVariants) {
            $advancedVariants = readData("*", "seller_product_advanced_variants", "product_id='$product_id'");
            while ($av = $advancedVariants->fetch(PDO::FETCH_ASSOC)) {
                $size = $av['size'] ?? '';
                $colorId = $av['color'] ?? '';
                $colorName = getData("color_name", "product_colors", "id='$colorId'") ?? '';
                $colorCode = getData("color_code", "product_colors", "id='$colorId'") ?? '#ccc';
                
                $variantLabel = '';
                if ($size) $variantLabel .= "Size: $size";
                if ($colorName) $variantLabel .= ($variantLabel ? " - " : "") . "Color: $colorName";
                if (!$variantLabel) $variantLabel = "Variant";
                
                $stock = ($av['unlimited_stock'] ?? 0) == 1 ? "Unlimited" : (int)($av['stock'] ?? 0);
                
                $html .= '<option value="' . $av['id'] . '" 
                    data-image="' . UPLOADS_URL . ($av['image'] ?? $image) . '" 
                    data-price="' . $av['price'] . '" 
                    data-mrp="' . $av['mrp_price'] . '" 
                    data-stock="' . $stock . '" 
                    data-unlimited="' . ($av['unlimited_stock'] ?? 0) . '" 
                    data-variant-type="advanced">
                    ' . htmlspecialchars($variantLabel) . '
                </option>';
            }
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

    // FIXED: Pass empty variant for main product, not $variation
    $html .= addToCartSection($id, $product_id, $cookie_id, "", $totalStocks, "", 0, $hasAdvancedVariants);
    $html .= '</div></div></div>';

    return $html;
}
?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.variantSelect').forEach(select => {

            // Handle variant change
            select.addEventListener('change', function() {
                const selected = this.options[this.selectedIndex];
                const card = this.closest('.group');
                const addBtn = card.querySelector('.addToCartBtn');

                const img = selected.dataset.image;
                const price = selected.dataset.price;
                const mrp = selected.dataset.mrp;
                const stock = Number(selected.dataset.stock) || 0;
                const unlimited = Number(selected.dataset.unlimited) || 0;
                const variantType = selected.dataset.variantType;
                const variantValue = selected.value;

                const imageEl = card.querySelector('.productImage');
                const priceEl = card.querySelector('.productPrice');
                const mrpEl = card.querySelector('.productMrp');

                // Update image and prices
                if (imageEl) imageEl.src = img;
                if (priceEl) priceEl.textContent = "<?= currencyToSymbol($storeCurrency) ?>" + Number(price).toLocaleString();
                if (mrpEl) mrpEl.textContent = (mrp && mrp > price) ?
                    "<?= currencyToSymbol($storeCurrency) ?>" + Number(mrp).toLocaleString() :
                    '';

                // Handle Add button
                if (addBtn) {
                    const isOutOfStock = stock <= 0 && unlimited !== 1;
                    
                    // Set the correct data attributes based on variant type
                    if (variantType === 'main') {
                        addBtn.dataset.variant = "";
                        addBtn.dataset.advancedVariant = "";
                    } else if (variantType === 'advanced') {
                        addBtn.dataset.advancedVariant = variantValue;
                        addBtn.dataset.variant = "";
                    } else {
                        addBtn.dataset.variant = variantValue;
                        addBtn.dataset.advancedVariant = "";
                    }
                    
                    addBtn.disabled = isOutOfStock;
                    addBtn.textContent = isOutOfStock ? "Out of Stock" : "Add";

                    // Reset styles
                    addBtn.classList.remove('bg-gray-100', 'cursor-not-allowed', 'text-gray-400', 'bg-gradient-to-r', 'from-pink-200', 'to-pink-300', 'text-pink-700', 'bg-gray-300');

                    // Apply styles
                    if (isOutOfStock) {
                        addBtn.classList.add('bg-gray-100', 'cursor-not-allowed', 'text-gray-400');
                    } else {
                        addBtn.classList.add('bg-gradient-to-r', 'from-pink-200', 'to-pink-300', 'text-pink-700');
                    }
                }
            });
        });

        // --- Reset dropdowns on page load/refresh ---
        function resetVariantSelects() {
            document.querySelectorAll('.variantSelect').forEach(select => {
                const card = select.closest('.group');
                const mainOption = select.querySelector('option[value="main"]');
                const addBtn = card.querySelector('.addToCartBtn');
                const imageEl = card.querySelector('.productImage');
                const priceEl = card.querySelector('.productPrice');
                const mrpEl = card.querySelector('.productMrp');

                if (select.querySelector('option[value=""]')) {
                    select.value = ""; // reset dropdown to "Select"
                } else {
                    select.selectedIndex = 0;
                }

                // --- Show main product details ---
                if (mainOption) {
                    const img = mainOption.dataset.image;
                    const price = mainOption.dataset.price;
                    const mrp = mainOption.dataset.mrp;
                    const stock = Number(mainOption.dataset.stock) || 0;
                    const unlimited = Number(mainOption.dataset.unlimited) || 0;

                    if (imageEl) imageEl.src = img;
                    if (priceEl) priceEl.textContent = "<?= currencyToSymbol($storeCurrency) ?>" + Number(price).toLocaleString();
                    if (mrpEl) mrpEl.textContent = (mrp && mrp > price) ?
                        "<?= currencyToSymbol($storeCurrency) ?>" + Number(mrp).toLocaleString() :
                        '';

                    // Update Add to Cart button for main product
                    if (addBtn) {
                        const isOutOfStock = stock <= 0 && unlimited !== 1;
                        addBtn.disabled = isOutOfStock;
                        addBtn.dataset.variant = "";
                        addBtn.dataset.advancedVariant = "";
                        addBtn.textContent = isOutOfStock ? "Out of Stock" : "Add";

                        // Reset and apply button classes
                        addBtn.classList.remove('bg-gray-100', 'cursor-not-allowed', 'text-gray-400', 'bg-gradient-to-r', 'from-pink-200', 'to-pink-300', 'text-pink-700', 'bg-gray-300');
                        if (isOutOfStock) {
                            addBtn.classList.add('bg-gray-100', 'cursor-not-allowed', 'text-gray-400');
                        } else {
                            addBtn.classList.add('bg-gradient-to-r', 'from-pink-200', 'to-pink-300', 'text-pink-700');
                        }
                    }
                }
            });
        }

        // Run after load
        setTimeout(resetVariantSelects, 0);

        // Also handle browser back/forward cache restore
        window.addEventListener('pageshow', function() {
            setTimeout(resetVariantSelects, 50);
        });
    });
</script>