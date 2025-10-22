<style>
    /* Mobile-first responsive utilities */
    .line-clamp-2 {
        display: -webkit-box;
        display: -moz-box;
        display: box;
        -webkit-line-clamp: 2;
        -moz-line-clamp: 2;
        line-clamp: 2;
        -webkit-box-orient: vertical;
        -moz-box-orient: vertical;
        box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* Fallback for browsers that don't support line-clamp */
    @supports not (-webkit-line-clamp: 2) {
        .line-clamp-2 {
            max-height: 3em;
            line-height: 1.5em;
        }
    }

    /* Ensure proper spacing on mobile */
    @media (max-width: 640px) {
        .min-h-\[2\.5rem\] {
            min-height: 2.5rem;
        }
    }
</style>

<?php
// =====================
// BADGE FUNCTIONS
// =====================
function calculateSavePercent($mrp_price, $price) {
    $savePercent = 0;
    if ($mrp_price && $mrp_price > $price) {
        $savePercent = round((($mrp_price - $price) / $mrp_price) * 100);
    }
    return $savePercent;
}

function displayProductBadge($badge, $savePercent = 0) {
    if ($badge || $savePercent > 0) {
        $html = '<div class="absolute top-2 left-2 flex flex-col items-center justify-center min-w-[3.5rem] px-2 py-1 
                       bg-gradient-to-b from-red-600 to-red-800 text-white rounded shadow-lg border-2 border-red-300 border-opacity-50 
                       text-[6px] sm:text-[8px] font-bold uppercase text-center">
                    <span>' . strtoupper($badge ?: 'SAVE') . '</span>';
        
        if ($savePercent > 0) {
            $html .= '<span class="text-sm font-black leading-none">' . $savePercent . '%</span>';
        }
        
        $html .= '<div class="absolute -bottom-1 w-4/5 h-1 bg-red-900 rounded-b-lg opacity-80"></div>
                </div>';
        
        return $html;
    }
    return '';
}

// =====================
// ADD TO CART FUNCTION
// =====================
function addToCartSection($id, $product_id, $cookie_id, $hasAdvancedVariants, $totalStocks, $variant = "", $currentQty = 0)
{
    $html = '<div class="addToCartWrapper" data-id="' . $id . '" id="addCart-' . $product_id . '">';

    // Check if advanced variants exist - if yes, disable main product add to cart
    $isOutOfStock = (!$totalStocks && !getData("id", "seller_products", "id='$id' AND unlimited_stock=1"));

    if ($hasAdvancedVariants) {
        // If advanced variants exist, disable main product button and show "Select"
        $btnClass = 'bg-gray-300 cursor-not-allowed text-gray-500';
        $btnText = 'Select';
        $disabled = 'disabled';
        $variantData = 'data-variant="" data-advancedvariant=""';
    } else {
        // Normal behavior for products without advanced variants
        $btnClass = $isOutOfStock
            ? 'bg-gray-100 text-gray-400 cursor-not-allowed'
            : 'bg-gradient-to-r from-pink-200 to-pink-300 text-pink-700 hover:from-pink-300 hover:to-pink-400';
        $btnText = $isOutOfStock ? 'Sold Out' : 'Add';
        $disabled = $isOutOfStock ? 'disabled' : '';
        $variantData = 'data-variant="" data-advancedvariant=""';
    }

    $html .= '<button type="button" class="addToCartBtn relative overflow-hidden px-3 py-2 md:px-4 md:py-2 rounded-md shadow transition-all duration-300 w-full flex items-center justify-center text-sm md:text-base ' . $btnClass . '" 
                    data-id="' . $id . '" ' . $variantData . ' ' . $disabled . '>
                    <span class="mgc_shopping_bag_3_line mr-1 text-sm md:text-base"></span> ' . $btnText . '
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

    // Calculate save percentage for badge
    $savePercent = 0;
    if ($badge === "Save" && $mrp_price && $mrp_price > $price) {
        $savePercent = calculateSavePercent($mrp_price, $price);
    }

    // Check if advanced variants exist
    $hasAdvancedVariants = getData("id", "seller_product_advanced_variants", "product_id='$product_id'");
    $hasBasicVariants = getData("id", "seller_product_variants", "product_id='$product_id'");

    // Check if product is in wishlist
    $inWishlist = false;
    if (isLoggedIn()) {
        $inWishlist = getData("id", "customer_wishlists", "customer_id='$customerId' AND product_id='$id'") ? true : false;
    }

    // Set button and icon classes based on state
    $btnBg   = $inWishlist ? "bg-white" : "bg-gray-500";
    $btnText = $inWishlist ? "text-rose-500" : "text-white";

    $wishlist = '<button class="absolute top-2 right-2 
        w-7 h-7 sm:w-8 sm:h-8 md:w-7 md:h-7
        flex items-center justify-center 
        rounded-full shadow-lg transition transform 
        hover:scale-110 handleWishlist ' . $btnBg . '" 
        data-id="' . $id . '">
        <i class="fa-solid fa-heart 
        text-xs sm:text-sm md:text-base ' . $btnText . '"></i>  
     </button>';

    // Start HTML
    $html = '<div class="group relative bg-white rounded-lg overflow-hidden shadow-xl hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300 flex flex-col h-full" data-id="' . $id . '">
            <div class="relative">
                <a href="' . $storeUrl . 'product/' . $slug . '">
                    <img src="' . UPLOADS_URL . $image . '" alt="' . htmlspecialchars($name) . '" class="productImage w-full h-40 sm:h-48 md:h-56 object-cover transition-transform duration-500 group-hover:scale-105">
                </a>';

    // Add badge display
    $html .= displayProductBadge($badge, $savePercent);
    
    // Add wishlist button
    $html .= $wishlist . '</div>';

    // Product Info
    $html .= '<div class="p-3 sm:p-4 flex flex-col flex-grow">
                <h3 class="text-sm sm:text-base font-semibold text-gray-800 group-hover:text-pink-600 transition-colors mb-1 line-clamp-2 min-h-[2.5rem]">' . htmlspecialchars($name) . '</h3>
                <div class="flex items-center mb-2 sm:mb-3"> </div>';

    // Variant dropdown - Show if any variants exist
    if ($hasAdvancedVariants || $hasBasicVariants) {
        $html .= '<div class="mb-2 sm:mb-3">
                    <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">Select Option:</label>
                    <div class="relative">
                        <select class="variantSelect block w-full appearance-none border border-gray-300 rounded-lg bg-white px-3 py-2 pr-8 text-gray-700 text-xs sm:text-sm">
                            <option value="" selected disabled>Select Option</option>';

        // ALWAYS show main product option in dropdown, even for advanced variants
        $html .= '<option value="main" 
                    data-image="' . UPLOADS_URL . $image . '" 
                    data-price="' . $price . '" 
                    data-mrp="' . $mrp_price . '" 
                    data-stock="' . $totalStocks . '" 
                    data-unlimited="' . (getData("unlimited_stock", "seller_products", "id='$id'") ?? 0) . '" 
                    data-variant-type="main"
                    data-is-main="true">
                    ' . htmlspecialchars(!empty($variation) ? $variation : $name) . '
                </option>';

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
                    data-variant-type="basic"
                    data-is-main="false">
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
                if (!$variantLabel) $variantLabel = "Advanced Variant";

                $stock = ($av['unlimited_stock'] ?? 0) == 1 ? "Unlimited" : (int)($av['stock'] ?? 0);

                $html .= '<option value="' . $av['id'] . '" 
                    data-image="' . UPLOADS_URL . ($av['image'] ?? $image) . '" 
                    data-price="' . $av['price'] . '" 
                    data-mrp="' . $av['mrp_price'] . '" 
                    data-stock="' . $stock . '" 
                    data-unlimited="' . ($av['unlimited_stock'] ?? 0) . '" 
                    data-variant-type="advanced"
                    data-is-main="false">
                    ' . htmlspecialchars($variantLabel) . '
                </option>';
            }
        }

        $html .= '</select>
                  <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-400">
                    <svg class="h-3 w-3 sm:h-4 sm:w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                  </div>
                  </div></div>';
    }

    // Price + Add to Cart
    $html .= '<div class="flex items-center justify-between mt-auto pt-2">
                <div class="flex flex-col sm:flex-row sm:items-center sm:space-x-2">
                    <span class="productPrice text-sm sm:text-base font-bold">' . currencyToSymbol($storeCurrency) . number_format($price) . '</span>' .
        (($mrp_price && $mrp_price > $price) ? '<span class="productMrp text-xs sm:text-sm text-gray-400 line-through">' . currencyToSymbol($storeCurrency) . number_format($mrp_price) . '</span>' : '') .
        '</div>';

    // Pass hasAdvancedVariants flag to determine button state
    $html .= addToCartSection($id, $product_id, $cookie_id, $hasAdvancedVariants, $totalStocks, "");
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
                const isMain = selected.dataset.isMain === 'true';

                const imageEl = card.querySelector('.productImage');
                const priceEl = card.querySelector('.productPrice');
                const mrpEl = card.querySelector('.productMrp');

                // Update image and prices
                if (imageEl && img) imageEl.src = img;
                if (priceEl) priceEl.textContent = "<?= currencyToSymbol($storeCurrency) ?>" + Number(price).toLocaleString();
                if (mrpEl) mrpEl.textContent = (mrp && mrp > price) ?
                    "<?= currencyToSymbol($storeCurrency) ?>" + Number(mrp).toLocaleString() :
                    '';

                // Handle Add button
                if (addBtn) {
                    const isOutOfStock = stock <= 0 && unlimited !== 1;
                    const hasAdvancedVariants = addBtn.classList.contains('bg-gray-300'); // Check if initially disabled

                    // Clear previous variant data
                    addBtn.dataset.variant = "";
                    addBtn.dataset.advancedvariant = "";

                    // Set the correct data attributes based on variant type
                    if (variantType === 'main') {
                        // Main product - no variants needed
                        addBtn.dataset.variant = "";
                        addBtn.dataset.advancedvariant = "";
                    } else if (variantType === 'advanced') {
                        // Advanced variant - use advancedvariant parameter
                        addBtn.dataset.advancedvariant = variantValue;
                        addBtn.dataset.variant = "";
                    } else {
                        // Basic variant - use variant parameter
                        addBtn.dataset.variant = variantValue;
                        addBtn.dataset.advancedvariant = "";
                    }

                    // SPECIAL LOGIC: If advanced variants exist AND main product is selected, show "Select"
                    if (hasAdvancedVariants && isMain) {
                        addBtn.disabled = true;
                        addBtn.innerHTML = '<span class="mgc_shopping_bag_3_line mr-1 text-sm md:text-base"></span> Select';
                        addBtn.classList.remove('bg-gradient-to-r', 'from-pink-200', 'to-pink-300', 'text-pink-700');
                        addBtn.classList.add('bg-gray-300', 'cursor-not-allowed', 'text-gray-500');
                    }
                    // Handle out of stock
                    else if (isOutOfStock) {
                        addBtn.disabled = true;
                        addBtn.innerHTML = '<span class="mgc_shopping_bag_3_line mr-1 text-sm md:text-base"></span> Sold Out';
                        addBtn.classList.remove('bg-gradient-to-r', 'from-pink-200', 'to-pink-300', 'text-pink-700');
                        addBtn.classList.add('bg-gray-100', 'cursor-not-allowed', 'text-gray-400');
                    }
                    // Enable button for non-main variants
                    else {
                        addBtn.disabled = false;
                        addBtn.innerHTML = '<span class="mgc_shopping_bag_3_line mr-1 text-sm md:text-base"></span> Add';
                        addBtn.classList.remove('bg-gray-100', 'cursor-not-allowed', 'text-gray-400', 'bg-gray-300');
                        addBtn.classList.add('bg-gradient-to-r', 'from-pink-200', 'to-pink-300', 'text-pink-700');
                    }

                    console.log('Variant selected:', {
                        type: variantType,
                        value: variantValue,
                        isMain: isMain,
                        variant: addBtn.dataset.variant,
                        advancedVariant: addBtn.dataset.advancedvariant,
                        enabled: !addBtn.disabled,
                        hasAdvancedVariants: hasAdvancedVariants
                    });
                }
            });
        });

        // --- Reset dropdowns on page load/refresh ---
        function resetVariantSelects() {
            document.querySelectorAll('.variantSelect').forEach(select => {
                const card = select.closest('.group');
                const addBtn = card.querySelector('.addToCartBtn');
                const hasAdvancedVariants = addBtn.classList.contains('bg-gray-300'); // Check if initially disabled

                // Reset to first option (Select Option)
                if (select.querySelector('option[value=""]')) {
                    select.value = ""; // reset dropdown to "Select Option"
                } else {
                    select.selectedIndex = 0;
                }

                // If advanced variants exist, ensure button shows "Select"
                if (hasAdvancedVariants && addBtn) {
                    addBtn.disabled = true;
                    addBtn.innerHTML = '<span class="mgc_shopping_bag_3_line mr-1 text-sm md:text-base"></span> Select';
                    addBtn.classList.remove('bg-gradient-to-r', 'from-pink-200', 'to-pink-300', 'text-pink-700');
                    addBtn.classList.add('bg-gray-300', 'cursor-not-allowed', 'text-gray-500');
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