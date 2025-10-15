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

                // Loop through cart items and normalize fields safely
                foreach ($cartItems as $key => $cart) {
                    // ensure numeric quantity & price
                    $quantity = isset($cart['quantity']) ? (int)$cart['quantity'] : 1;
                    $price = isset($cart['price']) ? (float)$cart['price'] : 0.0;
                    $mrp_price = isset($cart['mrp_price']) && $cart['mrp_price'] !== '' ? (float)$cart['mrp_price'] : $price;

                    // Default product image
                    $image = getData("image", "seller_products", "id='{$cart['product_id']}'");

                    // Variant image (simple variant)
                    $variantId = $cart['other'] ?? null;
                    if (!empty($variantId)) {
                        $variantImage = getData("image", "seller_product_variants", "id='{$variantId}'");
                        if (!empty($variantImage)) $image = $variantImage;
                    }

                    // Advanced variant image
                    $advVarId = $cart['advanced_variant'] ?? null;
                    if (!empty($advVarId)) {
                        $advImage = getData("image", "seller_product_advanced_variants", "id='{$advVarId}'");
                        if (!empty($advImage)) $image = $advImage;
                    }

                    // Product name & variation text
                    $productName = getData("name", "seller_products", "id='{$cart['product_id']}'") ?: '';
                    $variationParts = [];
                    $baseVar = getData("variation", "seller_products", "id='{$cart['product_id']}'");
                    if (!empty($baseVar)) $variationParts[] = $baseVar;

                    if (!empty($variantId)) {
                        $simpleVar = getData("variation", "seller_product_variants", "id='{$variantId}'");
                        if (!empty($simpleVar)) $variationParts[] = $simpleVar;
                    }

                    if (!empty($advVarId)) {
                        $size = getData("size", "seller_product_advanced_variants", "id='{$advVarId}'");
                        $colorId = getData("color", "seller_product_advanced_variants", "id='{$advVarId}'");
                        $color = $colorId ? getData("color_name", "product_colors", "id='$colorId'") : '';
                        if (!empty($size)) $variationParts[] = "Size: $size";
                        if (!empty($color)) $variationParts[] = "Color: $color";
                    }

                    // Put normalized fields back so template can use them
                    $cartItems[$key]['variation_text'] = implode(" | ", $variationParts);
                    $cartItems[$key]['image'] = $image ?: '';
                    $cartItems[$key]['product_name'] = $productName;
                    $cartItems[$key]['mrp_price'] = $mrp_price;
                    $cartItems[$key]['savedAmount'] = max(0, ($mrp_price - $price) * $quantity);

                    // Totals calculation
                    $subTotal += ($price * $quantity);
                    $subTotalMrp += ($mrp_price * $quantity);

                    // GST calculation: reuse your app helper if available; fallback to 0% if no gst defined
                    $gstPercentage = getData("gst_percentage", "seller_products", "id = '{$cart['product_id']}'");
                    if ($gstPercentage !== null && $gstPercentage !== '') {
                        $gstCalc = calculateGst((int)$price * $quantity, $gstPercentage); // returns ['getPrice','gstAmount'] in your earlier code
                    } else {
                        $gstCalc = calculateGst((int)$price * $quantity); // assume default behavior of your helper
                    }
                    // protect against helper returning unexpected
                    $subTotalWithTax += isset($gstCalc['getPrice']) ? $gstCalc['getPrice'] : ($price * $quantity);
                    $gstAmount += isset($gstCalc['gstAmount']) ? $gstCalc['gstAmount'] : 0;
                }


                // Final total
                $total = $subTotalWithTax;

                // Optional: format numbers later in the template using number_format when echoing

                // End of initialization block
                ?>

                <!-- Summary -->
                <div class="space-y-2 mb-4">
                    <div class="flex justify-between text-gray-500">
                        <span>Subtotal</span>
                        <span><?= currencyToSymbol($storeCurrency) . number_format($subTotal, 2) ?></span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-base text-gray-500">Tax</span>
                        <span class="text-base text-gray-500" id="gstTax">
                            <?= getSettings("gst_tax_type") == "inclusive" ? currencyToSymbol($storeCurrency) . "0.00" : currencyToSymbol($storeCurrency) . number_format($gstAmount, 2) ?>
                        </span>
                    </div>

                    <div class="border-t border-gray-200 pt-3 flex justify-between text-gray-800 font-bold text-lg">
                        <span>Total</span>
                        <span><?= currencyToSymbol($storeCurrency) . number_format($total, 2) ?></span>
                    </div>
                </div>


                <!-- Promo Code -->
                <div class="mb-6 bg-gray-50 border border-gray-200 rounded-xl p-4 shadow-sm">
                    <label class="block text-gray-700 mb-2 font-semibold">Have a promo code?</label>

                    <!-- Input + Button Row -->
                    <div class="flex items-center gap-2 flex-nowrap">
                        <input type="text" id="couponCode" placeholder="Enter code"
                            class="flex-1 min-w-0 px-2.5 py-2 border rounded-lg text-sm focus:ring-2 focus:ring-pink-400 focus:outline-none">
                        <button id="applyCoupon"
                            class="px-4 py-2 bg-pink-500 text-white text-sm rounded-lg font-semibold hover:bg-pink-600 transition flex-shrink-0">
                            Apply
                        </button>
                    </div>

                    <!-- Heading below input -->
                    <p class="mt-2 text-sm text-gray-600 font-medium">Click a coupon below to automatically apply</p>

                    <!-- Suggested Coupons -->
                    <div class="mt-3 flex flex-wrap gap-2 couponSuggestions">
                        <?php
                        $discounts = getDiscounts(); // fetch from backend
                        foreach ($discounts as $discount):
                        ?>
                            <span class="flex items-center gap-1.5 bg-pink-50 text-pink-600 text-xs font-semibold px-3 py-1 rounded-full border border-pink-200 couponItem"
                                data-code="<?= htmlspecialchars($discount['code']) ?>">
                                <!-- Glowing Dot -->
                                <span class="w-2 h-2 rounded-full bg-pink-500 shadow-[0_0_8px_rgba(236,72,153,0.7)] animate-pulse glowDot"></span>
                                <?= htmlspecialchars($discount['code']) ?>
                            </span>
                        <?php endforeach; ?>
                    </div>
                </div>

<script>
const couponInput = document.getElementById('couponCode');
const applyBtn = document.getElementById('applyCoupon');
const subTotalEl = document.querySelector('.bg-white .space-y-2 .flex.justify-between span:nth-child(2)');
const gstEl = document.getElementById('gstTax');
const totalEl = document.querySelector('.border-t span:last-child');

// Example: coupon discounts from backend (replace with your dynamic PHP backend if needed)
const couponDiscounts = {
    "SAVE200": 200,       // flat 200 off
    "NEWUSER100": 100,    // flat 100 off
    "FREESHIP": 50        // example discount for shipping
};

function applyCoupon(code) {
    const originalSubTotal = <?= $subTotal ?>;
    const originalGst = <?= $gstAmount ?>;
    let discount = couponDiscounts[code] || 0;

    // update subtotal visually
    let newSubTotal = originalSubTotal - discount;
    if(newSubTotal < 0) newSubTotal = 0;

    // optionally recalc tax if needed
    let newGst = originalGst; // or recalc based on your rules

    // total = subtotal + gst
    let newTotal = newSubTotal + newGst;

    // Update DOM
    subTotalEl.textContent = "<?= currencyToSymbol($storeCurrency) ?>" + newSubTotal.toFixed(2);
    gstEl.textContent = "<?= currencyToSymbol($storeCurrency) ?>" + newGst.toFixed(2);
    totalEl.textContent = "<?= currencyToSymbol($storeCurrency) ?>" + newTotal.toFixed(2);
}

// Apply coupon when button clicked
applyBtn.addEventListener('click', () => {
    const code = couponInput.value.trim();
    if (!code) return;
    applyCoupon(code);
});

// Click on coupon suggestion applies it
document.querySelectorAll('.couponItem').forEach(item => {
    item.addEventListener('click', () => {
        const code = item.dataset.code;
        couponInput.value = code;
        applyCoupon(code);

        // Show as applied visually
        document.querySelectorAll('.couponItem').forEach(el => el.classList.remove('appliedCoupon'));
        item.classList.add('appliedCoupon');
    });
});
</script>


                <style>
                    /* Applied coupon looks like "Apply" button */
                    .appliedCoupon {
                        background-color: #ec4899 !important;
                        /* pink-500 */
                        color: #fff !important;
                        border-color: #ec4899 !important;
                        cursor: default;
                    }

                    /* Glow dot effect */
                    .appliedCoupon .glowDot {
                        box-shadow: 0 0 10px rgba(255, 105, 180, 0.8);
                        transform: scale(1.2);
                    }

                    /* Coupon hover cursor */
                    .couponItem:hover {
                        cursor: pointer;
                        opacity: 0.9;
                    }
                </style>





                <!-- Payment Methods -->
                <div class="mb-4">
                    <h3 class="text-gray-700 font-semibold mb-3">Pay with</h3>
                    <div class="flex flex-wrap gap-4">
                        <!-- Razorpay -->
                        <div
                            class="w-14 h-14 rounded-full border flex items-center justify-center overflow-hidden bg-white hover:shadow-md cursor-pointer transition">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/6/69/Razorpay_logo.png"
                                alt="Razorpay" class="w-8 h-8 object-contain" />
                        </div>

                        <!-- PhonePe -->
                        <div
                            class="w-14 h-14 rounded-full border flex items-center justify-center overflow-hidden bg-white hover:shadow-md cursor-pointer transition">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/5/5e/PhonePe_Logo.png"
                                alt="PhonePe" class="w-8 h-8 object-contain" />
                        </div>

                        <!-- UPI -->
                        <div
                            class="w-14 h-14 rounded-full border flex items-center justify-center overflow-hidden bg-white hover:shadow-md cursor-pointer transition">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/0/02/UPI_Logo.svg"
                                alt="UPI" class="w-8 h-8 object-contain" />
                        </div>

                        <!-- Bank -->
                        <div
                            class="w-14 h-14 rounded-full border flex items-center justify-center bg-white hover:shadow-md cursor-pointer transition">
                            <i class="fas fa-university text-pink-600 text-xl"></i>
                        </div>
                    </div>
                </div>


                <!-- Checkout Button -->
                <button
                    class="w-full py-3 rounded-xl font-semibold text-white bg-gradient-to-r from-pink-400 to-pink-600 hover:from-pink-500 hover:to-pink-700 shadow-lg transition">
                    Checkout Now
                </button>

                <!-- Security Note -->
                <p class="mt-4 text-gray-500 flex items-center gap-2 text-sm">
                    <i class="fas fa-shield-alt text-pink-600"></i> 100% Secure Payment
                </p>
            </div>
        </div>

    </div>
</div>