<?php
$cartItems = getCartData()->fetchAll(PDO::FETCH_ASSOC);

foreach ($cartItems as $key => $cart) { // NO & reference here
    // Default product image
    $image = getData("image", "seller_products", "id='{$cart['product_id']}'");

    // Variant image
    $variantId = $cart['other'] ?? null;
    if (!empty($variantId)) {
        $variantImage = getData("image", "seller_product_variants", "id='{$variantId}'");
        if ($variantImage) $image = $variantImage;
    }

    // Advanced variant image
    $advVarId = $cart['advanced_variant'] ?? null;
    if (!empty($advVarId)) {
        $advImage = getData("image", "seller_product_advanced_variants", "id='{$advVarId}'");
        if ($advImage) $image = $advImage;
    }

    // Product name
    $productName = getData("name", "seller_products", "id='{$cart['product_id']}'");

    // Variant text
    $variationParts = [];
    $baseVar = getData("variation", "seller_products", "id='{$cart['product_id']}'");
    if ($baseVar) $variationParts[] = $baseVar;

    if (!empty($variantId)) {
        $simpleVar = getData("variation", "seller_product_variants", "id='{$variantId}'");
        if ($simpleVar) $variationParts[] = $simpleVar;
    }

    if (!empty($advVarId)) {
        $size = getData("size", "seller_product_advanced_variants", "id='{$advVarId}'");
        $colorId = getData("color", "seller_product_advanced_variants", "id='{$advVarId}'");
        $color = $colorId ? getData("color_name", "product_colors", "id='$colorId'") : '';
        if ($size) $variationParts[] = "Size: $size";
        if ($color) $variationParts[] = "Color: $color";
    }

    // Assign modified data back to cart array
    $cartItems[$key]['variation_text'] = implode(" | ", $variationParts);
    $cartItems[$key]['image'] = $image;
    $cartItems[$key]['product_name'] = $productName;
    $cartItems[$key]['mrp_price'] = $cart['mrp_price'] ?? $cart['price'];
    $cartItems[$key]['savedAmount'] = max(0, ($cartItems[$key]['mrp_price'] - $cart['price']) * $cart['quantity']);
}
?>


<div class="flex flex-col gap-6 lg:flex-colum" id="content">
    <?php if (!empty($cartItems)): ?>
        <?php foreach ($cartItems as $cart): ?>
            <div class="relative bg-white rounded-2xl shadow-md hover:shadow-xl transition p-4 flex gap-4">
                <!-- Delete Button -->
                <button class="absolute top-3 right-3 border border-gray-300 px-2 py-1 rounded-md hover:border-red-600 hover:text-red-600 transition bg-white shadow-sm removeQtyBtn"
                    data-id="<?= $cart['product_id'] ?>"
                    data-variant="<?= $cart['other'] ?? '' ?>"
                    data-advancedVariant="<?= $cart['advanced_variant'] ?? '' ?>">
                    <i class="fas fa-trash-alt text-sm"></i>
                </button>

                <!-- Product Image -->
                <img src="<?= UPLOADS_URL . $cart['image'] ?>" alt="<?= htmlspecialchars($cart['product_name']) ?>" class="w-24 h-24 object-cover rounded-xl">

                <!-- Product Details -->
                <div class="flex-1">
                    <h3 class="text-lg font-semibold text-gray-800 hover:text-pink-600 transition">
                        <?= limit_characters($cart['product_name'], 30) ?>
                    </h3>
                    <?php if (!empty($cart['variation_text'])): ?>
                        <p class="text-gray-500 text-sm"><?= $cart['variation_text'] ?></p>
                    <?php endif; ?>

                    <!-- Quantity Controls -->
                    <div class="mt-2 flex flex-wrap items-center gap-4">
                        <div class="flex items-center border rounded-lg overflow-hidden addToCartWrapper" data-id="<?= $cart['product_id'] ?>">
                            <button class="px-3 py-1 text-gray-600 hover:text-pink-600 decreaseQtyBtn" data-id="<?= $cart['product_id'] ?>" data-variant="<?= $cart['other'] ?? '' ?>" data-advancedVariant="<?= $cart['advanced_variant'] ?? '' ?>">-</button>
                            <span class="px-3 py-1 text-gray-800 font-medium currentQty"><?= $cart['quantity'] ?></span>
                            <button class="px-3 py-1 text-gray-600 hover:text-pink-600 increaseQtyBtn" data-id="<?= $cart['product_id'] ?>" data-variant="<?= $cart['other'] ?? '' ?>" data-advancedVariant="<?= $cart['advanced_variant'] ?? '' ?>">+</button>
                        </div>

                        <!-- Price Info -->
                        <div class="flex flex-col sm:flex-row sm:items-center sm:space-x-2">
                            <span class="line-through text-gray-400 text-sm"><?= currencyToSymbol($storeCurrency) . number_format($cart['mrp_price'] * $cart['quantity']) ?></span>
                            <span class="font-bold text-lg text-gray-900"><?= currencyToSymbol($storeCurrency) . number_format($cart['price'] * $cart['quantity']) ?></span>

                            <?php if ($cart['savedAmount'] > 0): ?>
                                <div class="flex items-center justify-between bg-pink-50 text-pink-600 rounded-lg px-3 py-1 mt-1 text-sm">
                                    <span class="flex items-center gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        You saved
                                    </span>
                                    <span class="font-semibold"><?= currencyToSymbol($storeCurrency) . number_format($cart['savedAmount']) ?></span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="text-center py-12">
            <h3 class="text-xl font-semibold text-gray-700 mb-2">Your cart is empty</h3>
            <p class="text-gray-500 mb-6">Looks like you haven't added any products yet.</p>
            <a href="<?= APP_URL ?>" class="inline-flex items-center px-5 py-3 bg-pink-500 text-white font-medium rounded-lg hover:bg-pink-600 transition">
                Continue Shopping
            </a>
        </div>
    <?php endif; ?>
</div>