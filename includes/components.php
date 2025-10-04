<?php

function addToCartSection($html, $addToCartWrapperExtraClass, $id, $product_id, $cookie_id, $currentQty, $advancedVariant, $totalStocks, $variant_index, $variant)
{
    $htmlContentBtn = '<div class="addToCartWrapper ' . $addToCartWrapperExtraClass . '" data-id="' . $id . '" id="addCart-' . $product_id . '" data-variant="' . $variant . '">';

    if ($cartData = getData("id", "customer_cart", "customer_id='$cookie_id' AND product_id='$id' AND other='$variant'")) {
        $currentQty = getData("quantity", "customer_cart", "customer_id='$cookie_id' AND product_id='$id' AND other='$variant'");
        $htmlContentBtn .= '<div class="qtySwitcher flex items-center justify-between border border-gray-300 rounded-md px-2 py-1 mt-1">
            <button class="decreaseQtyBtn text-lg font-bold px-2" data-id="' . $id . '" data-advancedVariant="' . $advancedVariant . '">−</button>
            <span class="text-base font-medium text-center currentQty">' . $currentQty . '</span>
            <button class="increaseQtyBtn text-lg font-bold px-2" data-id="' . $id . '" data-advancedVariant="' . $advancedVariant . '">+</button>
        </div>';
    } else {
        $htmlContentBtn .= $totalStocks || !getData("id", "seller_products", "id='$id' AND unlimited_stock=0")
            ? '<button type="button" class="addToCartBtn relative overflow-hidden bg-gradient-to-r from-pink-200 to-pink-300 
                      text-pink-700 px-4 py-2 rounded-md shadow transition-all duration-500 
                      bg-[length:200%_100%] bg-left hover:bg-right uppercase font-semibold text-sm sm:text-base flex items-center justify-center w-full mt-1" 
                      data-id="' . $id . '" data-variant="" data-advancedVariant="' . $advancedVariant . '">
                        <span class="mgc_shopping_bag_3_line mr-1"></span> Add
               </button>'
            : '<button type="button" class="bg-gray-100 text-gray-500 rounded-md h-11 flex items-center justify-center px-3 font-medium w-full transition cursor-not-allowed" disabled>Out of Stock</button>';
    }

    $htmlContentBtn .= '</div>';
    return $htmlContentBtn;
}

function getProductHtml($id, $divClass = "")
{
    $divClass = "group relative bg-white rounded-lg overflow-hidden shadow hover:shadow-lg transition duration-300 flex flex-col";

    global $storeCurrency, $storeUrl, $customerId, $cookie_id;

    // Product Data
    $product_id   = getData("product_id", "seller_products", "id='$id'") ?: die("Product ID not found for $id");
    $url          = $storeUrl . "product/" . (getData("slug", "seller_products", "id='$id'") ?: die("Slug not found"));
    $name         = getData("name", "seller_products", "id='$id'") ?: die("Product name not found");
    $image        = getData("image", "seller_products", "id='$id'") ?: die("Product image not found");
    $price        = getData("price", "seller_products", "id='$id'") ?: die("Price not found");
    $mrp_price    = getData("mrp_price", "seller_products", "id='$id'") ?: 0;
    $badge        = getData("badge", "seller_products", "id='$id'");
    $totalStocks  = getData("total_stocks", "seller_products", "id='$id'") ?: 0;
    $unit         = getData("unit", "seller_products", "id='$id'");
    $unit_type    = getData("unit_type", "seller_products", "id='$id'");
    $variation    = getData("variation", "seller_products", "id='$id'");
    $advancedVariant = "";

    if (empty($variation)) $variation = $unit . $unit_type;

    // SAVE %

    $savePercent = 0;
    if ($badge === "Save" && $mrp_price && $mrp_price > $price) {
        $savePercent = round((($mrp_price - $price) / $mrp_price) * 100);
    }


    // Wishlist
    $wishlist = '<button class="absolute top-2 right-2 w-10 h-10 flex items-center justify-center 
                                bg-white/95 hover:bg-pink-100 text-pink-600 rounded-full shadow-lg 
                                transition transform hover:scale-110 handleWishlist" data-id="' . $id . '">
                                <i class="fa-solid fa-heart"></i>
                 </button>';
    if (isLoggedIn() && getData("id", "customer_wishlists", "customer_id='$customerId' AND product_id='$id' AND other=''")) {
        $wishlist = '<button class="absolute top-2 right-2 w-10 h-10 flex items-center justify-center 
                                bg-pink-500 text-white rounded-full shadow-lg 
                                transition transform hover:scale-110 handleWishlist" data-id="' . $id . '">
                                <i class="fa-solid fa-heart"></i>
                 </button>';
    }

    // Advanced Variant Override
    if ($advVar = getData("id", "seller_product_advanced_variants", "product_id='$product_id'")) {
        $advancedVariant = $advVar;
        $price = getData("price", "seller_product_advanced_variants", "product_id='$product_id'") ?: $price;
        $mrp_price = getData("mrp_price", "seller_product_advanced_variants", "product_id='$product_id'") ?: $mrp_price;
        $image = getData("image", "seller_product_advanced_variants", "product_id='$product_id'") ?: $image;
        $totalStocks = getData("stock", "seller_product_advanced_variants", "product_id='$product_id'") ?: $totalStocks;
    }

    // Star Ratings
    $rating = getData("rating", "product_ratings", "product_id='$id'") ?: 0;
    $stars = "";
    for ($i = 1; $i <= 5; $i++) {
        if ($i <= $rating) {
            $stars .= '<span class="mgc_star_fill before:!text-[#FDCC0D] text-xl sm:text-2xl"></span>';
        } elseif ($i - 0.5 == $rating) {
            $stars .= '<span class="mgc_star_half_fill before:!text-[#FDCC0D] text-xl sm:text-2xl"></span>';
        } else {
            $stars .= '<span class="mgc_star_line before:!text-[#FDCC0D] text-xl sm:text-2xl"></span>';
        }
    }

    // HTML Card Start
    $html = '<div class="' . $divClass . '" data-id="' . $id . '">

        <!-- Image + Badge + Wishlist -->
        <div class="relative">
            <a href="' . $url . '">
                <img src="' . UPLOADS_URL . $image . '" alt="' . $name . '" 
                     class="productImage w-full h-64 sm:h-72 md:h-64 lg:h-60 object-cover transition-transform duration-500 group-hover:scale-105">
            </a>';

    if ($badge || $savePercent > 0) {
        $html .= '<div class="absolute top-2 left-2 flex flex-col items-center justify-center min-w-[3.5rem] px-2 py-1 
                       bg-gradient-to-b from-red-600 to-red-800 text-white rounded shadow-lg border-2 border-red-300 border-opacity-50 
                       text-[6px] sm:text-[8px] font-bold uppercase text-center">
                    <span>' . strtoupper($badge ?: 'SAVE') . '</span>' .
            ($savePercent > 0 ? '<span class="text-sm font-black leading-none">' . $savePercent . '%</span>' : '') . '
                    <div class="absolute -bottom-1 w-4/5 h-1 bg-red-900 rounded-b-lg opacity-80"></div>
              </div>';
    }

    $html .= $wishlist . '</div>';

    // Product Name & Stars
    $html .= '<div class="p-4 flex flex-col flex-grow">
                <h3 class="text-base sm:text-lg md:text-lg lg:text-xl font-semibold text-gray-800 
                           group-hover:text-pink-600 transition-colors mb-1">' . htmlspecialchars($name) . '</h3>
                <div class="flex items-center mb-3">' . $stars . '</div>';

    // Variants Dropdown
    if ($variantData = getData("id", "seller_product_variants", "product_id='$product_id'")) {
        $html .= '<div class="mb-3">
                    <label for="variantSelect-' . $product_id . '" class="block text-sm font-medium text-gray-700 mb-1">Select Variant:</label>
                    <div class="relative">
                        <select id="variantSelect-' . $product_id . '" class="variantSelect block w-full appearance-none border border-gray-300 rounded-lg bg-white px-4 py-2 pr-10 text-gray-700 text-sm
                               focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-pink-400 transition shadow-sm hover:shadow-md">';
        $html .= '<option value="' . $product_id . '" data-image="' . UPLOADS_URL . $image . '" data-price="' . $price . '" data-mrp="' . $mrp_price . '">' . htmlspecialchars($variation) . '</option>';

        $data = readData("*", "seller_product_variants", "product_id='$product_id' AND (stock>0 OR unlimited_stock=1)");
        while ($row = $data->fetch()) {
            $html .= '<option value="' . $row['id'] . '" data-image="' . UPLOADS_URL . $row['image'] . '" data-price="' . $row['price'] . '" data-mrp="' . $row['mrp_price'] . '">' . htmlspecialchars($row['variation']) . '</option>';
        }

        $html .= '</select>
                  <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-400">
                        <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                  </div>
                  </div>
                  </div>';
    }

    // Price + AddToCart
    $html .= '<div class="flex items-center justify-between mt-auto">
                <div class="flex flex-col sm:flex-row sm:items-center sm:space-x-2">
                    <span class="productPrice text-sm sm:text-base md:text-lg font-bold">' . currencyToSymbol($storeCurrency) . number_format($price) . '</span>' .
        ($mrp_price && $mrp_price > $price ? '<span class="productMrp text-sm text-gray-400 line-through">' . currencyToSymbol($storeCurrency) . number_format($mrp_price) . '</span>' : '') .
        '</div>';

    $html .= addToCartSection($html, "", $id, $product_id, $cookie_id, 0, $advancedVariant, $totalStocks, 0, $variation);

    $html .= '</div></div></div>'; // close wrappers

    // JS for Variant Change
    $html .= "<script>
        document.getElementById('variantSelect-$product_id')?.addEventListener('change', function() {
            const selected = this.options[this.selectedIndex];
            const img = selected.dataset.image;
            const price = selected.dataset.price;
            const mrp = selected.dataset.mrp;

            const card = this.closest('.group');
            const imageEl = card.querySelector('.productImage');
            const priceEl = card.querySelector('.productPrice');
            const mrpEl = card.querySelector('.productMrp');

            if(imageEl) imageEl.src = img;
            if(priceEl) priceEl.textContent = '" . currencyToSymbol($storeCurrency) . "' + parseFloat(price).toLocaleString();
            if(mrpEl) mrpEl.textContent = mrp && mrp > price ? '" . currencyToSymbol($storeCurrency) . "' + parseFloat(mrp).toLocaleString() : '';
        });
    </script>";

    return $html;
}
