<?php
$cartData = getCartData();
if (!empty($cartData)):
    foreach ($cartData as $cart):
        $variation = $cart['other'] ? getData("variation", "seller_product_variants", "id='{$cart['other']}'")
            : getData("variation", "seller_products", "id='{$cart['product_id']}'");
        $unit = $cart['other'] ? getData("unit", "seller_product_variants", "id='{$cart['other']}'")
            : getData("unit", "seller_products", "id='{$cart['product_id']}'");

        $size = getData("size", "seller_product_advanced_variants", "id='{$cart['advanced_variant']}'");
        $color = getData("color", "seller_product_advanced_variants", "id='{$cart['advanced_variant']}'");
        $color = getData("color_name", "product_colors", "id='$color'");

        if (!$variation && $size) $variation = "Size: $size | Color: $color";

        $image = getData("image", "seller_products", "id='{$cart['product_id']}'");
        if ($cart['other'] && getData("image", "seller_product_variants", "id='{$cart['other']}'")) $image = getData("image", "seller_product_variants", "id='{$cart['other']}'");
        if ($cart['advanced_variant'] && getData("image", "seller_product_advanced_variants", "id='{$cart['advanced_variant']}'")) $image = getData("image", "seller_product_advanced_variants", "id='{$cart['advanced_variant']}'");

        $unit_calc_value = $unit * $cart['quantity'];
        $unit_type = getData("unit_type", "seller_products", "id='{$cart['product_id']}'");
        $variation_text = ($variation) ? "($variation)" : "($unit$unit_type)";
?>
        <div class="relative bg-white rounded-2xl shadow-md hover:shadow-xl transition p-4 flex gap-4">
            <button class="absolute top-3 right-3 border border-gray-300 px-2 py-1 rounded-md hover:border-red-600 hover:text-red-600 transition bg-white shadow-sm removeQtyBtn" data-id="<?= $cart['product_id'] ?>" data-variant="<?= $cart['other'] ?>" data-advancedVariant="<?= $cart['advanced_variant'] ?>">
                <i class="fas fa-trash-alt text-sm"></i>
            </button>
            <img src="<?= UPLOADS_URL . $image ?>" alt="<?= getData("name", "seller_products", "id='{$cart['product_id']}'") ?>" class="w-24 h-24 object-cover rounded-xl">
            <div class="flex-1">
                <h3 class="text-lg font-semibold text-gray-800 hover:text-pink-600 transition"><?= limit_characters(getData("name", "seller_products", "id='{$cart['product_id']}'"), 30) . ' ' . $variation_text ?></h3>
                <p class="text-gray-500 text-sm"><?= $variation ?></p>
                <div class="mt-2 flex flex-wrap items-center gap-4">
                    <div class="flex items-center border rounded-lg overflow-hidden addToCartWrapper" data-id="<?= $cart['product_id'] ?>">
                        <button class="px-3 py-1 text-gray-600 hover:text-pink-600 decreaseQtyBtn" data-id="<?= $cart['product_id'] ?>" data-variant="<?= $cart['other'] ?>" data-advancedVariant="<?= $cart['advanced_variant'] ?>">-</button>
                        <span class="px-3 py-1 text-gray-800 font-medium currentQty"><?= $cart['quantity'] ?></span>
                        <button class="px-3 py-1 text-gray-600 hover:text-pink-600 increaseQtyBtn" data-id="<?= $cart['product_id'] ?>" data-variant="<?= $cart['other'] ?>" data-advancedVariant="<?= $cart['advanced_variant'] ?>">+</button>
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="line-through text-gray-400 text-sm"><?= currencyToSymbol($storeCurrency) . number_format($cart['mrp_price']) ?></span>
                            <span class="font-bold text-lg text-gray-900"><?= currencyToSymbol($storeCurrency) . number_format($cart['price'] * $cart['quantity']) ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<?php
    endforeach;
else:
    echo '<p class="text-center text-gray-500 py-6">Your cart is empty.</p>';
endif;
