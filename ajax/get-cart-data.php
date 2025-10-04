<?php
require_once __DIR__ . "/../../../config/autoload.php";

$cartData = getCartData();
$html = "";

if (!empty($cartData)):
    foreach ($cartData as $cart):
        // Determine variant or advanced variant
        $variantId = $cart['other'];
        $advVarId = $cart['advanced_variant'];

        // Fetch variant details
        if ($advVarId) {
            $variantData = getData("*", "seller_product_advanced_variants", "id='$advVarId'");
            $price = $variantData['price'] ?? $cart['price'];
            $mrp_price = $variantData['mrp_price'] ?? $cart['mrp_price'];
            $variation = "Size: " . $variantData['size'] . " | Color: " . getData("color_name", "product_colors", "id='" . $variantData['color'] . "'");
            $image = $variantData['image'] ?: getData("image", "seller_products", "id='{$cart['product_id']}'");
        } elseif ($variantId) {
            $variantData = getData("*", "seller_product_variants", "id='$variantId'");
            $price = $variantData['price'] ?? $cart['price'];
            $mrp_price = $variantData['mrp_price'] ?? $cart['mrp_price'];
            $variation = $variantData['variation'] ?? '';
            $image = $variantData['image'] ?: getData("image", "seller_products", "id='{$cart['product_id']}'");
        } else {
            $price = $cart['price'];
            $mrp_price = $cart['mrp_price'];
            $variation = '';
            $image = getData("image", "seller_products", "id='{$cart['product_id']}'");
        }

        $unit_type = getData("unit_type", "seller_products", "id='{$cart['product_id']}'");
        $variation_text = ($variation) ? "($variation)" : "($unit_type)";

        // Calculate saved amount
        $savedAmount = ($mrp_price > $price) ? ($mrp_price - $price) * $cart['quantity'] : 0;

        $html .= '<div class="relative bg-white rounded-2xl shadow-md hover:shadow-xl transition p-4 flex gap-4">
            <button class="absolute top-3 right-3 border border-gray-300 px-2 py-1 rounded-md hover:border-red-600 hover:text-red-600 transition bg-white shadow-sm removeQtyBtn" data-id="' . $cart['product_id'] . '" data-variant="' . $variantId . '" data-advancedVariant="' . $advVarId . '">
                <i class="fas fa-trash-alt text-sm"></i>
            </button>
            <img src="' . UPLOADS_URL . $image . '" alt="' . getData("name", "seller_products", "id='{$cart['product_id']}'") . '" class="w-24 h-24 object-cover rounded-xl">
            <div class="flex-1">
                <h3 class="text-lg font-semibold text-gray-800 hover:text-pink-600 transition">' . limit_characters(getData("name", "seller_products", "id='{$cart['product_id']}'"), 30) . ' ' . $variation_text . '</h3>
                <p class="text-gray-500 text-sm">' . $variation . '</p>
                <div class="mt-2 flex flex-wrap items-center gap-4">
                    <div class="flex items-center border rounded-lg overflow-hidden addToCartWrapper" data-id="' . $cart['product_id'] . '">
                        <button class="px-3 py-1 text-gray-600 hover:text-pink-600 decreaseQtyBtn" data-id="' . $cart['product_id'] . '" data-variant="' . $variantId . '" data-advancedVariant="' . $advVarId . '">-</button>
                        <span class="px-3 py-1 text-gray-800 font-medium currentQty">' . $cart['quantity'] . '</span>
                        <button class="px-3 py-1 text-gray-600 hover:text-pink-600 increaseQtyBtn" data-id="' . $cart['product_id'] . '" data-variant="' . $variantId . '" data-advancedVariant="' . $advVarId . '">+</button>
                    </div>
                    <div class="flex flex-col sm:flex-row sm:items-center sm:space-x-2">
                        <span class="line-through text-gray-400 text-sm">' . currencyToSymbol($storeCurrency) . number_format($mrp_price * $cart['quantity']) . '</span>
                        <span class="font-bold text-lg text-gray-900">' . currencyToSymbol($storeCurrency) . number_format($price * $cart['quantity']) . '</span>
                        ' . ($savedAmount > 0 ? '<div class="flex items-center justify-between bg-pink-50 text-pink-600 rounded-lg px-3 py-1 mt-1 text-sm">
                            <span class="flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                You saved
                            </span>
                            <span class="font-semibold">' . currencyToSymbol($storeCurrency) . number_format($savedAmount) . '</span>
                        </div>' : '') . '
                    </div>
                </div>
            </div>
        </div>';
    endforeach;
else:
    $html = '<p class="text-center text-gray-500 py-6">Your cart is empty.</p>';
endif;

echo $html;
