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
<div class="max-w-6xl mx-auto px-3 sm:px-4">

    <!-- Your Cart Section Heading -->
    <div class="relative flex items-center justify-center mb-4 sm:mb-6">

        <!-- Animated GIF - clickable -->
        <a href="<?= $storeUrl ?>shop-all" class="absolute left-2 lg:hidden animate-slide-in">
            <img
                src="<?= APP_URL ?>assets/image/carticon.gif"
                alt="Cart Animation"
                class="w-20 h-20 sm:w-24 sm:h-24">
        </a>

        <!-- Heading -->
        <h2 class="text-xl sm:text-2xl md:text-3xl font-bold text-gray-800 text-center">
            Your Cart
        </h2>
    </div>

    <style>
        @keyframes slide-in {
            0% {
                transform: translateX(-120%);
                /* reduced from -150% */
                opacity: 0;
            }

            20% {
                transform: translateX(0);
                opacity: 1;
            }

            80% {
                transform: translateX(0);
                opacity: 1;
            }

            100% {
                transform: translateX(-120%);
                /* match start */
                opacity: 0;
            }
        }

        .animate-slide-in {
            animation: slide-in 8s ease-in-out infinite;
        }

        /* Toast Animation */
        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes slideOutRight {
            from {
                transform: translateX(0);
                opacity: 1;
            }

            to {
                transform: translateX(100%);
                opacity: 0;
            }
        }

        .toast-slide-in {
            animation: slideInRight 0.5s ease-out forwards;
        }

        .toast-slide-out {
            animation: slideOutRight 0.5s ease-in forwards;
        }

        /* Remove animation */
        .remove-animation {
            animation: removeItem 0.3s ease-out forwards;
        }

        @keyframes removeItem {
            to {
                opacity: 0;
                transform: translateX(-100%);
                height: 0;
                margin: 0;
                padding: 0;
            }
        }

        /* Product name truncation */
        .product-name-truncate {
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
            line-height: 1.4;
            max-height: 2.8em;
        }

        /* Variation text truncation */
        .variation-truncate {
            display: -webkit-box;
            display: -moz-box;
            display: box;
            -webkit-line-clamp: 1;
            -moz-line-clamp: 1;
            line-clamp: 1;
            -webkit-box-orient: vertical;
            -moz-box-orient: vertical;
            box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
            line-height: 1.3;
            max-height: 1.3em;
        }

        /* Fallback for browsers that don't support line-clamp */
        @supports not (-webkit-line-clamp: 2) {
            .product-name-truncate {
                max-height: 2.8em;
                line-height: 1.4em;
            }

            .variation-truncate {
                max-height: 1.3em;
                line-height: 1.3em;
            }
        }
    </style>


    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6 lg:gap-8">
        <!-- Left Side: Cart Items -->
        <div class="lg:col-span-2 space-y-4 sm:space-y-6">
            <div class="bg-gray-50 p-4 sm:p-6 rounded-2xl sm:rounded-3xl shadow-lg space-y-4">

                <div class="py-6 sm:py-10">
                    <div class="px-0 sm:px-2">
                        <div class="flex flex-col gap-4 sm:gap-6">
                            <div class="flex flex-col gap-4 sm:gap-6" id="cartItemsContainer">
                                <?php if (!empty($cartItems)): ?>
                                    <?php foreach ($cartItems as $cart): ?>
                                        <div class="cart-item relative bg-white rounded-xl sm:rounded-2xl shadow-md hover:shadow-lg transition p-3 sm:p-4 flex gap-3 sm:gap-4 items-start"
                                            data-id="<?= $cart['product_id'] ?>"
                                            data-variant="<?= $cart['other'] ?? '' ?>"
                                            data-advancedvariant="<?= $cart['advanced_variant'] ?? '' ?>">
                                            <!-- Product Image -->
                                            <div class="flex-shrink-0">
                                                <img src="<?= UPLOADS_URL . $cart['image'] ?>" alt="<?= htmlspecialchars($cart['product_name']) ?>" class="w-16 h-16 sm:w-20 sm:h-20 object-cover rounded-lg">
                                            </div>

                                            <!-- Product Details -->
                                            <div class="flex-1 min-w-0">
                                                <!-- Product Name and Variation -->
                                                <div class="mb-2">
                                                    <h3 class="text-base sm:text-lg font-semibold text-gray-800 mb-1 product-name-truncate" title="<?= htmlspecialchars($cart['product_name']) ?>">
                                                        <?= htmlspecialchars(mb_strlen($cart['product_name']) > 50 ? mb_substr($cart['product_name'], 0, 50) . '...' : $cart['product_name']) ?>
                                                    </h3>
                                                    <?php if (!empty($cart['variation_text'])): ?>
                                                        <p class="text-gray-500 text-xs sm:text-sm variation-truncate" title="<?= htmlspecialchars($cart['variation_text']) ?>">
                                                            <?= htmlspecialchars(mb_strlen($cart['variation_text']) > 40 ? mb_substr($cart['variation_text'], 0, 40) . '...' : $cart['variation_text']) ?>
                                                        </p>
                                                    <?php endif; ?>
                                                </div>

                                                <!-- Quantity Controls -->
                                                <div class="flex items-center gap-3 mb-2">
                                                    <div class="flex items-center border rounded-lg overflow-hidden addToCartWrapper w-fit" data-id="<?= $cart['product_id'] ?>">
                                                        <button class="px-2 sm:px-3 py-1 text-gray-600 hover:text-pink-600 decreaseQtyBtn text-sm"
                                                            data-id="<?= $cart['product_id'] ?>"
                                                            data-variant="<?= $cart['other'] ?? '' ?>"
                                                            data-advancedVariant="<?= $cart['advanced_variant'] ?? '' ?>">-</button>
                                                        <span class="px-2 sm:px-3 py-1 text-gray-800 font-medium currentQty text-sm"><?= $cart['quantity'] ?></span>
                                                        <button class="px-2 sm:px-3 py-1 text-gray-600 hover:text-pink-600 increaseQtyBtn text-sm"
                                                            data-id="<?= $cart['product_id'] ?>"
                                                            data-variant="<?= $cart['other'] ?? '' ?>"
                                                            data-advancedVariant="<?= $cart['advanced_variant'] ?? '' ?>">+</button>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Price Section - Right Aligned -->
                                            <div class="flex flex-col items-end justify-between h-full min-w-[100px] sm:min-w-[120px]">
                                                <!-- Delete Button - Top Right -->
                                                <button class="removeQtyBtn border border-gray-300 px-2 py-1 rounded-md hover:border-red-600 hover:text-red-600 transition bg-white shadow-sm text-xs sm:text-sm mb-2"
                                                    data-id="<?= $cart['product_id'] ?>"
                                                    data-variant="<?= $cart['other'] ?? '' ?>"
                                                    data-advancedvariant="<?= $cart['advanced_variant'] ?? '' ?>"
                                                    data-product-name="<?= htmlspecialchars($cart['product_name']) ?>">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>

                                                <!-- Prices -->
                                                <div class="flex items-center gap-3">
                                                    <div class="line-through text-gray-400 text-sm sm:text-base">
                                                        <?= currencyToSymbol($storeCurrency) . number_format($cart['mrp_price'] * $cart['quantity']) ?>
                                                    </div>
                                                    <div class="font-bold text-lg sm:text-xl text-gray-900">
                                                        <?= currencyToSymbol($storeCurrency) . number_format($cart['price'] * $cart['quantity']) ?>
                                                    </div>
                                                </div>

                                                <!-- Saved Amount -->
                                                <?php if ($cart['savedAmount'] > 0): ?>
                                                    <div class="inline-flex items-center gap-1 bg-green-600 text-white rounded-lg px-2 py-1 text-xs font-medium mt-2">
                                                        <!-- Check Icon -->
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                        </svg>
                                                        <!-- Text -->
                                                        <span>Saved <?= currencyToSymbol($storeCurrency) . number_format($cart['savedAmount']) ?></span>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Right Side: Sticky Order Summary -->
        <div class="lg:col-span-1">
            <div class="bg-white p-4 sm:p-6 rounded-xl sm:rounded-2xl shadow-lg hover:shadow-xl transition sticky top-4 sm:top-20">
                <!-- Header -->
                <h2 class="text-xl sm:text-2xl font-bold text-gray-800 mb-3 sm:mb-4 flex items-center gap-2">
                    <i class="fas fa-shopping-cart text-hover text-lg sm:text-xl"></i> Summary
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
                <div class="space-y-2 sm:space-y-3 mb-4">
                    <div class="flex items-center justify-between">
                        <span class="text-sm sm:text-base text-gray-500">Subtotal</span>
                        <span class="text-sm sm:text-base text-gray-500" id="subTotal"><?= currencyToSymbol($storeCurrency) . number_format($subTotal, 2) ?></span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm sm:text-base text-gray-500">Tax</span>
                        <span class="text-sm sm:text-base text-gray-500" id="gstTax">
                            <?= getSettings("gst_tax_type") == "inclusive" ? currencyToSymbol($storeCurrency) . "0.00" : currencyToSymbol($storeCurrency) . number_format($gstAmount, 2) ?>
                        </span>
                    </div>

                    <div class="flex items-center justify-between">
                        <span class="text-sm sm:text-base text-gray-500">Discount</span>
                        <span class="text-sm sm:text-base text-gray-500" id="discount"><?= currencyToSymbol($storeCurrency) . number_format($discountAmount, 2) ?></span>
                    </div>

                    <div class="flex items-center justify-between pt-3 sm:pt-5 mt-3 sm:mt-5 border-t">
                        <span class="text-base sm:text-lg font-medium">Total (<?= $storeCurrency ?>)</span>
                        <span class="text-base sm:text-lg font-medium text-emerald-500" id="total"><?= currencyToSymbol($storeCurrency) . number_format($subTotalWithTax - $discountAmount, 2) ?></span>
                    </div>
                </div>

                <!-- Payment Methods -->
                <div class="mb-4">
                    <h3 class="text-gray-700 font-semibold text-sm sm:text-base mb-3">Pay with</h3>
                    <div class="flex flex-wrap gap-3 sm:gap-4 justify-center sm:justify-start">

                        <!-- Razorpay -->
                        <div class="flex flex-col items-center cursor-pointer">
                            <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full border flex items-center justify-center bg-white hover:shadow-md transition">
                                <i class="fas fa-credit-card text-blue-600 text-lg sm:text-xl"></i>
                            </div>
                            <span class="mt-1 text-xs font-medium">Razorpay</span>
                        </div>

                        <!-- Cash on Delivery -->
                        <div class="flex flex-col items-center cursor-pointer">
                            <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full border flex items-center justify-center bg-white hover:shadow-md transition">
                                <i class="fas fa-money-bill-wave text-green-600 text-lg sm:text-xl"></i>
                            </div>
                            <span class="mt-1 text-xs font-medium">Cash</span>
                        </div>

                        <!-- PhonePe -->
                        <div class="flex flex-col items-center cursor-pointer">
                            <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full border flex items-center justify-center bg-white hover:shadow-md transition">
                                <i class="fas fa-mobile-alt text-purple-600 text-lg sm:text-xl"></i>
                            </div>
                            <span class="mt-1 text-xs font-medium">PhonePe</span>
                        </div>

                        <!-- Bank to Bank -->
                        <div class="flex flex-col items-center cursor-pointer">
                            <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full border flex items-center justify-center bg-white hover:shadow-md transition">
                                <i class="fas fa-university text-pink-600 text-lg sm:text-xl"></i>
                            </div>
                            <span class="mt-1 text-xs font-medium">Bank</span>
                        </div>

                    </div>
                </div>

                <!-- Checkout Section -->
                <div class="mt-4">
                    <?php
                    $minimumOrder = (int)getSettings("minimum_order_amount");
                    ?>
                    <?php if (!empty($minimumOrder) && $subTotal < $minimumOrder): ?>
                        <!-- Stylish Marketing-Themed Minimum Order Message -->
                        <div class="py-2 sm:py-3 px-3 sm:px-4 rounded-lg sm:rounded-xl text-center bg-gradient-to-r from-pink-50 to-pink-100 border border-pink-200 shadow-sm">
                            <p class="text-hover font-semibold text-xs sm:text-sm">
                                Minimum order is
                                <span class="font-bold text-hover">
                                    <?= currencyToSymbol($storeCurrency) . number_format($minimumOrder, 2) ?>
                                </span>
                            </p>
                            <p class="text-xs text-hover mt-1 italic">
                                Great deals await when you checkout!
                            </p>
                        </div>
                    <?php else: ?>
                        <!-- Checkout Button -->
                        <button
                            onclick="window.location.href='<?= $storeUrl ?>checkout';"
                            class="w-full py-2 sm:py-3 mt-2 sm:mt-3 rounded-lg sm:rounded-xl font-semibold text-white bg-primary-500 hover:bg-hover shadow-lg transition text-sm sm:text-base">
                            Checkout Now
                        </button>
                    <?php endif; ?>
                </div>

                <!-- Security Note -->
                <p class="mt-3 sm:mt-4 text-gray-500 flex items-center gap-2 text-xs sm:text-sm">
                    <i class="fas fa-shield-alt text-pink-600 text-xs sm:text-sm"></i> 100% Secure Payment
                </p>
            </div>
        </div>
    </div>
</div>

<script>
    // Custom toast function with character limits for messages
    function showCustomToast(message, type) {
        // For remove actions, show generic "Item removed" message
        const displayMessage = message.toLowerCase().includes('removed') ? 'Item removed from cart' : message;

        // Limit message length to prevent overflow
        const maxLength = 80;
        const finalMessage = displayMessage.length > maxLength ? displayMessage.substring(0, maxLength) + '...' : displayMessage;

        // Remove any existing toasts
        const existingToasts = document.querySelectorAll('.custom-cart-toast');
        existingToasts.forEach(toast => toast.remove());

        // Create toast element
        const toast = document.createElement('div');
        toast.className = 'custom-cart-toast fixed top-20 right-4 z-50 max-w-sm'; // Moved down to avoid heading overlap
        toast.innerHTML = `
    <div style="background-color: var(--primary-color) !important; color: white !important; border-color: var(--primary-dark) !important;" 
         class="px-4 py-3 rounded-lg shadow-lg border-l-4 flex items-center gap-3 break-words">
        <i class='bx ${type === 'success' ? 'bx-check-circle' : 'bx-error-circle'} text-xl flex-shrink-0'></i>
        <span class="font-semibold text-sm">${finalMessage}</span>
    </div>
`;

        // Add to page
        document.body.appendChild(toast);

        // Add slide in animation
        const toastContent = toast.querySelector('div');
        toastContent.classList.add('toast-slide-in');

        // Auto remove after 3 seconds with slide out animation
        setTimeout(() => {
            toastContent.classList.remove('toast-slide-in');
            toastContent.classList.add('toast-slide-out');

            // Remove from DOM after animation completes
            setTimeout(() => {
                if (toast.parentNode) {
                    toast.remove();
                }
            }, 500);
        }, 3000);
    }
</script>