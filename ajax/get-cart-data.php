<?php
// Including autoload
require_once __DIR__ . '/../../../config/autoload.php';

// Count cart items
$count = countData("*", "customer_cart", " (seller_id = '$sellerId' AND store_id = '$storeId')");

// Initialize HTML
$html = "";

// Fetch cart data
$data = getCartData();

foreach ($data as $key => $cart) {

    // Get variation & unit
    if ($cart['other']) {
        $variation = getData("variation", "seller_product_variants", "id = '{$cart['other']}'");
        $unit = getData("unit", "seller_product_variants", "id = '{$cart['other']}'");
    } else {
        $variation = getData("variation", "seller_products", "id = '{$cart['product_id']}'");
        $unit = getData("unit", "seller_products", "id = '{$cart['product_id']}'");
    }

    // Advanced variant
    $size = getData("size", "seller_product_advanced_variants", "id = '{$cart['advanced_variant']}'");
    $color = getData("color", "seller_product_advanced_variants", "id = '{$cart['advanced_variant']}'");
    $color = getData("color_name", "product_colors", "id = '$color'");

    if (!$variation && $size) {
        $variation = "Size: $size | Color: $color";
    }

    // Product image
    $image = getData("image", "seller_products", "id = '{$cart['product_id']}'");

    if ($cart['other'] && getData("image", "seller_product_variants", "id = '{$cart['other']}'")) {
        $image = getData("image", "seller_product_variants", "id = '{$cart['other']}'");
    }
    if ($cart['advanced_variant'] && getData("image", "seller_product_advanced_variants", "id = '{$cart['advanced_variant']}'")) {
        $image = getData("image", "seller_product_advanced_variants", "id = '{$cart['advanced_variant']}'");
    }

    $stock_unit = getData("stock_unit", "seller_products", "id = '{$cart['product_id']}'");
    $unit_type = getData("unit_type", "seller_products", "id = '{$cart['product_id']}'");
    $total_stocks = (int)$cart['quantity'] * (int)getData("unit", "seller_products", "id = '{$cart['product_id']}'");

    if ($stock_unit == "kg" || $stock_unit == "litre") {
        $total_stocks /= 1000;
    } else if ($stock_unit == "meter") {
        $total_stocks *= 0.3048;
    }

    $unit_calc_value = ($unit * $cart['quantity']);
    $unit_type_updated = $unit_type;
    $variation_text = ($variation) ? "(" . $variation . ")" : "(" . $unit . $unit_type . ")";
    if (!$stock_unit) $stock_unit = getData("unit_type", "seller_products", "id = '{$cart['product_id']}'");

    // Generate HTML for each cart item
    $html .= '<li class="flex py-6 group">
        <div class="flex-shrink-0 w-24 h-24 overflow-hidden border border-gray-200 rounded-md">
            <img src="' . UPLOADS_URL . $image . '" alt="' . getData("name", "seller_products", "id = '{$cart['product_id']}'") . '" class="object-contain object-center w-full h-full">
        </div>
        <div class="flex flex-col flex-1 ml-4">
            <div class="flex justify-between text-base font-medium text-gray-900">
                <h3>
                    <a href="' . $storeUrl . "product/" . getData("slug", "seller_products", "id = '{$cart['product_id']}'") . '">' . limit_characters(getData("name", "seller_products", "id = '{$cart['product_id']}'"), 30) . ' ' . $variation_text . '</a>
                </h3>
                <p class="ml-4">' . currencyToSymbol($storeCurrency) . number_format($cart['price'] * $cart['quantity']) . '</p>
            </div>
            <div class="flex items-center justify-between flex-1 text-sm mt-2">
                <p class="text-gray-500">' . $unit_calc_value . ' ' . $unit_type_updated . '</p>
                <div class="flex items-center gap-3">
                    <div class="addToCartWrapper" data-id="' . $cart['product_id'] . '">
                        <div class="flex items-center gap-3 p-1 bg-gray-100 rounded-full">
                            <button class="w-[30px] h-[30px] bg-red-200 text-red-500 rounded-full flex items-center justify-center decreaseQtyBtn" data-id="' . $cart['product_id'] . '" data-variant="' . $cart['other'] . '" data-advancedVariant="' . $cart['advanced_variant'] . '"><i class="font-medium bx bx-minus"></i></button>
                            <span class="text-base font-medium text-center currentQty">' . $cart['quantity'] . '</span>
                            <button class="w-[30px] h-[30px] bg-green-200 text-green-500 rounded-full flex items-center justify-center increaseQtyBtn" data-id="' . $cart['product_id'] . '" data-variant="' . $cart['other'] . '" data-advancedVariant="' . $cart['advanced_variant'] . '"><i class="font-medium bx bx-plus"></i></button>
                        </div>
                    </div>
                    <button type="button" class="w-[30px] h-[30px] bg-red-100 text-red-500 rounded-full flex items-center justify-center transition hover:bg-red-500 hover:text-white removeQtyBtn" data-id="' . $cart['product_id'] . '" data-variant="' . $cart['other'] . '" data-advancedVariant="' . $cart['advanced_variant'] . '"><i class="font-medium bx bx-trash"></i></button>
                </div>
            </div>
        </div>
    </li>';
}

// Empty cart
if (!$count) {
    $html = '<div class="p-[30px] text-center">
        <img alt="" src="' . APP_URL . 'assets/img/empty-bag.svg" class="mx-auto mt-[38px]" width="216" height="126">
        <h3 class="text-[20px] font-bold mt-5">Your bag is empty</h3>
        <p class="text-[#CCCCCC] text-[16px] mt-3">Looks like you haven\'t made your choice yet.</p>
    </div>';
}

echo $html;
