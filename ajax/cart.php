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
<div class="max-w-6xl mx-auto px-4">
    <!-- Your Cart Section Heading -->
    <h2 class="text-2xl sm:text-3xl md:text-4xl lg:text-4xl font-bold text-gray-800 mb-2 text-center">Your Cart
    </h2>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left Side: Cart Items -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-gray-50 p-6 rounded-3xl shadow-lg space-y-4">

                <div class="py-10">
                    <div class="px-2 sm:container lg:container-fluid">

                        <div class="flex flex-col gap-6 lg:flex-colum">

                            <div class="flex flex-col gap-6 lg:flex-colum">
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
                                                            <div class="inline-flex items-center gap-2 bg-pink-50 text-pink-600 rounded-lg px-3 py-1 mt-1 text-sm font-medium">
                                                                <!-- Check Icon -->
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                                </svg>
                                                                <!-- Text -->
                                                                <span>You saved <?= currencyToSymbol($storeCurrency) . number_format($cart['savedAmount']) ?></span>
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
                        </div>
                    </div>
                </div>

            </div>
        </div>



        <!-- Right Side: Sticky Order Summary -->
        <div class="lg:col-span-1">
            <div class="bg-white p-6 rounded-2xl shadow-xl hover:shadow-2xl transition sticky top-20">
                <!-- Header -->
                <h2 class="text-2xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <i class="fas fa-shopping-cart text-pink-600"></i> Summary
                </h2>

                <?php

                // Initialize totals
                $subTotal = 0.0;
                $subTotalMrp = 0.0;
                $subTotalWithTax = 0.0;
                $gstAmount = 0.0;
                $discountAmount = 0; // for coupon

                // Loop through cart items and calculate GST properly
                foreach ($cartItems as $key => $cart) {
                    $quantity = isset($cart['quantity']) ? (int)$cart['quantity'] : 1;
                    $price = isset($cart['price']) ? (float)$cart['price'] : 0.0;
                    $mrp_price = isset($cart['mrp_price']) && $cart['mrp_price'] !== '' ? (float)$cart['mrp_price'] : $price;

                    // Update saved amount
                    $cartItems[$key]['savedAmount'] = max(0, ($mrp_price - $price) * $quantity);

                    // Subtotals
                    $subTotal += $price * $quantity;
                    $subTotalMrp += $mrp_price * $quantity;

                    // GST calculation using old code logic
                    $gstPercentage = getData("gst_percentage", "seller_products", "id='{$cart['product_id']}'");
                    if ($gstPercentage !== null && $gstPercentage !== '') {
                        $gstCalc = calculateGst($price * $quantity, $gstPercentage);
                    } else {
                        $gstCalc = calculateGst($price * $quantity);
                    }

                    $subTotalWithTax += isset($gstCalc['getPrice']) ? (float)$gstCalc['getPrice'] : ($price * $quantity);
                    $gstAmount += isset($gstCalc['gstAmount']) ? (float)$gstCalc['gstAmount'] : 0;
                }

                // Final total
                $total = max(0, $subTotalWithTax - $discountAmount);
                ?>

                <!-- Summary -->
                <div class="space-y-2 mb-4">
                    <div class="flex items-center justify-between">
                        <span class="text-base text-gray-500">Subtotal</span>
                        <span class="text-base text-gray-500" id="subTotal"><?= currencyToSymbol($storeCurrency) . number_format($subTotal, 2) ?></span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-base text-gray-500">Tax</span>
                        <span class="text-base text-gray-500" id="gstTax">
                            <?= getSettings("gst_tax_type") == "inclusive" ? currencyToSymbol($storeCurrency) . "0.00" : currencyToSymbol($storeCurrency) . number_format($gstAmount, 2) ?>
                        </span>
                    </div>

                    <div class="flex items-center justify-between">
                        <span class="text-base text-gray-500">Discount</span>
                        <span class="text-base text-gray-500" id="discount"><?= currencyToSymbol($storeCurrency) . number_format($discountAmount, 2) ?></span>
                    </div>

                    <div class="flex items-center justify-between pt-5 mt-5 border-t">
                        <span class="text-lg font-medium">Total (<?= $storeCurrency ?>)</span>
                        <span class="text-lg font-medium text-emerald-500" id="total"><?= currencyToSymbol($storeCurrency) . number_format($subTotalWithTax - $discountAmount, 2) ?></span>
                    </div>

                </div>

                <!-- Payment Methods -->
                <div class="mb-4">
                    <h3 class="text-gray-700 font-semibold mb-3">Pay with</h3>
                    <div class="flex flex-wrap gap-6">

                        <!-- Razorpay -->
                        <div class="flex flex-col items-center cursor-pointer">
                            <div
                                class="w-14 h-14 rounded-full border flex items-center justify-center bg-white hover:shadow-md transition">
                                <i class="fas fa-credit-card text-blue-600 text-2xl"></i>
                            </div>
                            <span class="mt-2 text-xs font-medium">Razorpay</span>
                        </div>

                        <!-- Cash on Delivery -->
                        <div class="flex flex-col items-center cursor-pointer">
                            <div
                                class="w-14 h-14 rounded-full border flex items-center justify-center bg-white hover:shadow-md transition">
                                <i class="fas fa-money-bill-wave text-green-600 text-2xl"></i>
                            </div>
                            <span class="mt-2 text-xs font-medium">Cash</span>
                        </div>

                        <!-- PhonePe -->
                        <div class="flex flex-col items-center cursor-pointer">
                            <div
                                class="w-14 h-14 rounded-full border flex items-center justify-center bg-white hover:shadow-md transition">
                                <i class="fas fa-mobile-alt text-purple-600 text-2xl"></i>
                            </div>
                            <span class="mt-2 text-xs font-medium">PhonePe</span>
                        </div>

                        <!-- Bank to Bank -->
                        <div class="flex flex-col items-center cursor-pointer">
                            <div
                                class="w-14 h-14 rounded-full border flex items-center justify-center bg-white hover:shadow-md transition">
                                <i class="fas fa-university text-pink-600 text-2xl"></i>
                            </div>
                            <span class="mt-2 text-xs font-medium">Bank</span>
                        </div>

                    </div>
                </div>



                <!-- Checkout Button -->
                <?php
                $minimumOrder = (int)getSettings("minimum_order_amount");
                ?>


                <!-- Checkout Section -->
                <div class="mt-4">
                    <?php if (!empty($minimumOrder) && $subTotal < $minimumOrder): ?>
                        <!-- Stylish Marketing-Themed Minimum Order Message -->
                        <div class="py-3 px-4 rounded-xl text-center bg-gradient-to-r from-pink-50 to-pink-100 border border-pink-200 shadow-sm">
                            <p class="text-pink-700 font-semibold text-sm">
                                Minimum order is
                                <span class="font-bold text-pink-600">
                                    <?= currencyToSymbol($storeCurrency) . number_format($minimumOrder, 2) ?>
                                </span>.
                            </p>
                            <p class="text-xs text-pink-500 mt-1 italic">
                                Great deals await when you checkout!
                            </p>
                        </div>
                    <?php else: ?>
                        <!-- Checkout Button -->
                        <button
                            onclick="window.location.href='<?= $storeUrl ?>checkout';"
                            class="w-full py-3 mt-3 rounded-xl font-semibold text-white bg-gradient-to-r from-pink-400 to-pink-600 hover:from-pink-500 hover:to-pink-700 shadow-lg transition">
                            Checkout Now
                        </button>
                    <?php endif; ?>
                </div>




                <!-- Security Note -->
                <p class="mt-4 text-gray-500 flex items-center gap-2 text-sm">
                    <i class="fas fa-shield-alt text-pink-600"></i> 100% Secure Payment
                </p>
            </div>
        </div>

    </div>
</div>