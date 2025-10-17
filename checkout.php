<?php include_once __DIR__ . "/includes/files_includes.php"; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!--Php File Include For Head Links & Scripts-->
    <?php include_once __DIR__ . "/includes/head_links.php"; ?>

</head>

<body class="font-sans">

    <!-- Minimum Order Amount Start-->
    <?php if (!empty(getSettings("minimum_order_amount"))) : ?>
        <div class="w-full bg-pink-600 text-white text-center py-1 text-sm font-semibold">
            Minimum Order: <?= currencyToSymbol($storeCurrency) . getSettings("minimum_order_amount") ?>
        </div>
    <?php endif; ?>
    <!-- Minimum Order Amount End-->

    <!--Php File Include For Nav Bar-->
    <?php include_once __DIR__ . "/includes/navbar.php"; ?>




    <!-- Intl tell input css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css" />

    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        .iti,
        .select2 {
            width: 100% !important;
        }

        .select2-selection--single {
            height: 55.2px !important;
            display: flex !important;
            justify-content: center;
            align-items: center;
            font-size: 1rem;
            border-radius: 0.5rem !important;
            font-weight: 500;
            border: 2px solid #e5e7eb !important;
            padding: 0 15px;
        }

        .select2-selection__arrow {
            height: 95% !important;
        }
    </style>
    <style>
        .appliedCoupon {
            background-color: #ec4899 !important;
            color: #fff !important;
            border-color: #ec4899 !important;
            cursor: default;
        }

        .appliedCoupon .glowDot {
            box-shadow: 0 0 10px rgba(255, 105, 180, 0.8);
            transform: scale(1.2);
        }

        .couponItem:hover {
            cursor: pointer;
            opacity: 0.9;
        }
    </style>
    <?php



    $subTotal = 0;
    $subTotalMrp = 0;
    $subTotalWithTax = 0;
    $gstAmount = 0;

    ?>

    <div class="py-10">
        <div class="px-2 sm:container lg:container-fluid">

            <div class="bg-white rounded-md mb-2">
                <?php include_once __DIR__ . "/includes/checkout-step.php"; ?>
            </div>

            <?php if (countData("*", "customer_cart", "customer_id = '$cookie_id' AND seller_id = '$sellerId'")) { ?>
                <form id="placeOrderForm" onkeydown="return event.key != 'Enter';" class="flex flex-col gap-6 lg:flex-row lg:gap-8">
                    <div class="lg:w-3/5 flex flex-col gap-6 relative before:sm:border-dashed before:sm:border before:sm:border-primary-300 before:sm:h-full before:sm:w-[1px] before:sm:absolute before:sm:left-[25px] before:sm:-z-10">
                        <div class="flex gap-4">
                            <div class="bg-primary-500 w-[50px] h-[50px] text-2xl font-medium text-white rounded-full sm:flex justify-center items-center hidden">01</div>
                            <div class="p-6 bg-white rounded-2xl shadow hover:shadow-lg w-full sm:w-[calc(100%_-_66px)]">
                                <h3 class="mb-2 text-2xl font-semibold"><?= getData("delivery_area_type", "seller_settings", "seller_id = '$sellerId'") == "zip_code" ? "Check Pin Code" : "Select State" ?></h3>
                                <p class="text-sm text-gray-500"><?= getData("delivery_area_type", "seller_settings", "seller_id = '$sellerId'") == "zip_code" ? 'Please select a pin code' : 'Please select a state' ?></p>
                                <div class="flex items-center gap-3 mt-6">
                                    <select class="custom-select px-4 h-[45px] border-2 rounded-full w-full transition focus:border-primary-500 text-sm font-[400] focus:bg-gray-50" id="deliveryArea" name="delivery_area" <?= getData("delivery_area_type", "seller_settings", "seller_id = '$sellerId'") == "zip_code" ? 'data-pincode="true"' : null ?>>
                                        <option value="" hidden selected><?= getData("delivery_area_type", "seller_settings", "seller_id = '$sellerId'") == "state" ? "Select State" : "Select Pin Code" ?></option>
                                        <?php
                                        $areas = getDeliveryAreas();
                                        foreach ($areas as $key => $area) {
                                            echo '<option value="' . $area['id'] . '">' . $area['value'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <?php if (getData("delivery_area_type", "seller_settings", "seller_id = '$sellerId'") == "zip_code") : ?>
                                    <p class="mt-5 text-sm text-gray-500">You can check our delivery pin codes from here <a href="<?= $storeUrl ?>delivery-areas" class="text-primary-500 hover:underline">Delivery Areas</a></p>
                                <?php endif ?>
                                <div id="deliveryNotes"></div>
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <div class="bg-primary-500 w-[50px] h-[50px] text-2xl font-medium text-white rounded-full sm:flex justify-center items-center hidden">02</div>
                            <div class="relative p-6 overflow-hidden bg-white rounded-2xl shadow hover:shadow-lg w-full sm:w-[calc(100%_-_66px)]">
                                <h3 class="mb-5 text-2xl font-semibold">Delivery Option</h3>
                                <div class="flex gap-5">
                                    <label for="deliveryDelivery" class="cursor-pointer">
                                        <div class="w-32 h-32 flex items-center justify-center bg-blue-50 rounded-md">
                                            <img src="<?= APP_URL ?>assets/img/delivery-truck.png" alt="" class="w-[72px] h-[72px]">
                                        </div>
                                        <div class="flex items-center justify-center gap-2 mt-3">
                                            <input type="radio" name="delivery_option" id="deliveryDelivery" class="accent-primary-500 w-3 h-3 deliveryOption" value="delivery" checked> <span class="text-gray-500">Delivery</span>
                                        </div>
                                    </label>
                                    <?php if (getData("id", "seller_locations", "seller_id = '$sellerId' AND location_type = 'pickup'")) : ?>
                                        <label for="deliveryPickup" class="cursor-pointer">
                                            <div class="w-32 h-32 flex items-center justify-center bg-orange-50 rounded-md">
                                                <img src="<?= APP_URL ?>assets/img/pickup.png" alt="" class="w-[72px] h-[72px]">
                                            </div>
                                            <div class="flex items-center justify-center gap-2 mt-3">
                                                <input type="radio" name="delivery_option" id="deliveryPickup" class="accent-primary-500 w-3 h-3 deliveryOption" value="pickup"> <span class="text-gray-500">Pickup</span>
                                            </div>
                                        </label>
                                    <?php endif ?>
                                </div>
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <div class="bg-primary-500 w-[50px] h-[50px] text-2xl font-medium text-white rounded-full sm:flex justify-center items-center hidden">03</div>
                            <div class="p-6 bg-white rounded-2xl shadow hover:shadow-lg w-full sm:w-[calc(100%_-_66px)]" id="pickupDateAndTime" style="display: none;">
                                <h3 class="mb-5 text-2xl font-semibold">Pickup Date & Time</h3>
                                <div class="grid gap-5 sm:grid-cols-2">
                                    <div class="col-span-2">
                                        <label for="pickupPoint" class="block mb-2 text-sm">Pickup Point</label>
                                        <select id="pickupPoint" name="pickup_point" class="px-4 h-[45px] border-2 rounded-lg w-full transition focus:border-primary-500 text-sm font-[400] focus:bg-gray-50">
                                            <option value="" hidden disabled selected>Select</option>
                                            <?php
                                            $locations = getLocations("pickup");
                                            foreach ($locations as $key => $location) :
                                            ?>
                                                <option value="<?= $location['id'] ?>"><?= $location['name'] . " - " . $location['address_1'] ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                    <div>
                                        <label for="pickup_days" class="block mb-2 text-sm">Day</label>
                                        <select id="pickup_days" name="pickup_day" class="px-4 h-[45px] border-2 rounded-lg w-full transition focus:border-primary-500 text-sm font-[400] focus:bg-gray-50">
                                            <option value="" hidden disabled selected>Select</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label for="pickup_times" class="block mb-2 text-sm">Time</label>
                                        <select id="pickup_times" name="pickup_time" class="px-4 h-[45px] border-2 rounded-lg w-full transition focus:border-primary-500 text-sm font-[400] focus:bg-gray-50">
                                            <option value="" hidden disabled selected>Select</option>
                                        </select>
                                    </div>
                                </div>
                                <div id="pickupLocations"></div>
                            </div>

                            <div class="p-6 bg-white rounded-2xl shadow hover:shadow-lg w-full sm:w-[calc(100%_-_66px)]" id="deliveryAddress">
                                <div class="flex items-center justify-between mb-5">
                                    <h3 class="text-2xl font-semibold">Delivery Address</h3>
                                    <button class="underline addAddressToggle text-primary-500" type="button">Add Address</button>
                                </div>
                                <div class="grid gap-5 lg:grid-cols-2 shippingAddressList"></div>
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <div class="bg-primary-500 w-[50px] h-[50px] text-2xl font-medium text-white rounded-full sm:flex justify-center items-center hidden">04</div>
                            <div class="p-6 bg-white rounded-2xl shadow hover:shadow-lg w-full sm:w-[calc(100%_-_66px)]">
                                <div class="flex items-center justify-between mb-5">
                                    <h3 class="text-2xl font-semibold">Billing Address</h3>
                                    <button class="underline addAddressToggle text-primary-500" type="button">Add Address</button>
                                </div>
                                <div class="grid gap-5 lg:grid-cols-2 billingAddressList"></div>
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <div class="bg-primary-500 w-[50px] h-[50px] text-2xl font-medium text-white rounded-full sm:flex justify-center items-center hidden">05</div>
                            <div class="p-6 bg-white rounded-2xl shadow hover:shadow-lg w-full sm:w-[calc(100%_-_66px)]">
                                <h3 class="mb-5 text-2xl font-semibold">Payment Method</h3>
                                <div class="grid grid-cols-1 space-y-5">
                                    <?php if (!empty(getSettings("cod")) && plan("payment_cod")) : ?>
                                        <label for="paymentCOD" class="flex items-center gap-3 p-5 bg-red-50 rounded-2xl cursor-pointer">
                                            <input type="radio" name="payment_method" id="paymentCOD" class="accent-red-500 w-4 h-4 paymentMethod" value="COD">
                                            <div class="flex items-center gap-2">
                                                <img src="<?= APP_URL ?>assets/img/cod.png" alt="" class="w-8 h-8">
                                                <h3 class="font-medium text-md">Cash On Delivery (COD) <?= getSettings("cod_charges") ? " - Extra " . currencyToSymbol($storeCurrency) . getSettings("cod_charges") . " Charges for COD" : null ?></h3>
                                            </div>
                                        </label>
                                    <?php endif ?>
                                    <?php if (!empty(getSettings("razorpay_key_id")) && plan("payment_razorpay")) : ?>
                                        <label for="paymentRazorpay" class="flex items-center gap-3 p-5 bg-indigo-50 rounded-2xl cursor-pointer">
                                            <input type="radio" name="payment_method" id="paymentRazorpay" class="accent-indigo-500 w-4 h-4 paymentMethod" value="Razorpay">
                                            <div class="flex items-center gap-2">
                                                <img src="<?= APP_URL ?>assets/img/razorpay.png" alt="" class="w-8 h-8">
                                                <h3 class="font-medium text-md">Razorpay</h3>
                                            </div>
                                        </label>
                                    <?php endif ?>
                                    <?php if (!empty(getSettings("phonepe_key")) && plan("payment_phonepe")) : ?>
                                        <label for="paymentPhonePe" class="flex items-center gap-3 p-5 bg-purple-50 rounded-2xl cursor-pointer">
                                            <input type="radio" name="payment_method" id="paymentPhonePe" class="accent-purple-500 w-4 h-4 paymentMethod" value="PhonePe">
                                            <div class="flex items-center gap-2">
                                                <img src="<?= APP_URL ?>assets/img/phonepe.png" alt="" class="w-8 h-8">
                                                <h3 class="font-medium text-md">PhonePe</h3>
                                            </div>
                                        </label>
                                    <?php endif ?>
                                    <?php if (!empty(getSettings("ippo_pay_public_key")) && plan("payment_ippopay")) : ?>
                                        <label for="paymentIppoPay" class="flex items-center gap-3 p-5 bg-blue-50 rounded-2xl cursor-pointer">
                                            <input type="radio" name="payment_method" id="paymentIppoPay" class="accent-blue-500 w-4 h-4 paymentMethod" value="IppoPay">
                                            <div class="flex items-center gap-2">
                                                <img src="<?= APP_URL ?>assets/img/ippo-pay.png" alt="" class="w-8 h-8">
                                                <h3 class="font-medium text-md">IppoPay</h3>
                                            </div>
                                        </label>
                                    <?php endif ?>
                                    <?php if (!empty(getSettings("bank_details")) && plan("payment_bank")) : ?>
                                        <label for="paymentBankTransfer" class="flex items-center gap-3 p-5 bg-teal-50 rounded-2xl cursor-pointer">
                                            <input type="radio" name="payment_method" id="paymentBankTransfer" class="accent-teal-500 w-4 h-4 paymentMethod" value="Bank Transfer">
                                            <div class="flex items-center gap-2">
                                                <img src="<?= APP_URL ?>assets/img/bank.png" alt="" class="w-8 h-8">
                                                <h3 class="font-medium text-md">Bank Transfer</h3>
                                            </div>
                                        </label>
                                        <div id="bankDetails" class="p-5 mt-3 space-y-3 bg-teal-50 rounded-2xl" style="display:none;">
                                            <?= nl2br(getSettings("bank_details")) ?>
                                            <div class="mt-5 pt-5 border-t">
                                                <i>Please send an email to <?= getSettings("email") ?> along with the scanned bank-in slip after completing all the required particulars once the payment is made.</i>
                                                <br />
                                                Order ID :
                                                <br />
                                                Payment Method :
                                                <br />
                                                Bank Name :
                                                <br />
                                                Bank-in Date :
                                                <br />
                                                Bank-in Amount :
                                                <br />
                                                Contact Name :
                                                <br />
                                                Contact Phone
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <?php if (!empty(getSettings("upi_qr_code")) && plan("payment_upi")) : ?>
                                        <label for="paymentUPI" class="flex items-center gap-3 p-5 bg-orange-50 rounded-2xl cursor-pointer">
                                            <input type="radio" name="payment_method" id="paymentUPI" class="accent-orange-500 w-4 h-4 paymentMethod" value="UPI">
                                            <div class="flex items-center gap-2">
                                                <img src="<?= APP_URL ?>assets/img/upi.webp" alt="" class="w-8 h-8">
                                                <h3 class="font-medium text-md">UPI (Scan this QR Code or Pay to this UPI ID)</h3>
                                            </div>
                                        </label>
                                        <div id="upiImg" class="p-5 mt-3 space-y-3 bg-orange-50 rounded-2xl" style="display:none;">
                                            <span class="block mb-2">UPI ID: <b class="text-primary-500 cursor-pointer" onclick="navigator.clipboard.writeText('<?= getSettings("upi_id") ?>')"><?= getSettings("upi_id") ?></b></span>
                                            <img src="<?= UPLOADS_URL . getSettings("upi_qr_code") ?>" alt="" class="max-w-full max-h-[400px]">
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <div class="bg-primary-500 w-[50px] h-[50px] text-2xl font-medium text-white rounded-full sm:flex justify-center items-center hidden">06</div>
                            <div class="p-6 bg-white rounded-2xl shadow hover:shadow-lg w-full sm:w-[calc(100%_-_66px)]">
                                <label for="notes" class="block mb-2 font-medium text-gray-700">Notes</label>
                                <textarea name="notes" id="notes" rows="5" class="bg-gray-100 rounded-xl p-4 w-full font-medium"></textarea>
                            </div>
                        </div>

                        <?php if (getSettings("customized_gift")) : ?>
                            <div class="flex gap-4">
                                <div class="bg-primary-500 w-[50px] h-[50px] text-2xl font-medium text-white rounded-full sm:flex justify-center items-center hidden">07</div>
                                <div class="p-6 bg-white rounded-2xl shadow hover:shadow-lg w-full sm:w-[calc(100%_-_66px)]">
                                    <h4 class="text-xl font-medium mb-5">Customized Gift <sup>(optional)</sup></h4>
                                    <div class="grid gap-5">
                                        <div>
                                            <label for="customized_gift_images" class="block mb-2 font-medium text-gray-700">Images</label>
                                            <input type="file" name="customized_gift_images[]" id="customized_gift_images" class="bg-gray-100 rounded-xl p-4 w-full font-medium" accept="image/*" max="3" multiple>
                                            <small class="text-red-500 block mt-1">You can only select a maximum of 3 images.</small>
                                        </div>
                                        <div>
                                            <label for="customized_gift_notes" class="block mb-2 font-medium text-gray-700">Details</label>
                                            <textarea name="customized_gift_notes" id="customized_gift_notes" rows="5" class="bg-gray-100 rounded-xl p-4 w-full font-medium"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif ?>
                    </div>

                    <div class="lg:w-2/5 flex flex-col gap-6">
                        <!-- Promo Code -->
                        <div class="mb-6 bg-gray-50 border border-gray-200 rounded-xl p-4 shadow-sm">
                            <label class="block text-gray-700 mb-2 font-semibold">Have a promo code?</label>

                            <!-- Input + Button Row -->
                            <div class="flex items-center gap-2 flex-nowrap">
                                <input type="text" id="couponCode" placeholder="Enter code"
                                    class="flex-1 min-w-0 px-2.5 py-2 border rounded-lg text-sm focus:ring-2 focus:ring-pink-400 focus:outline-none">
                                <button id="applyCoupon" type="button"
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
                                    <span class="flex items-center gap-1.5 bg-pink-50 text-pink-600 text-xs font-semibold px-3 py-1 rounded-full border border-pink-200 copyCoupon"
                                        data-code="<?= htmlspecialchars($discount['code']) ?>">
                                        <span class="w-2 h-2 rounded-full bg-pink-500 shadow-[0_0_8px_rgba(236,72,153,0.7)] animate-pulse glowDot"></span>
                                        <?= htmlspecialchars($discount['code']) ?>
                                    </span>
                                <?php endforeach; ?>
                            </div>
                        </div>






                        <div class="p-5 bg-white rounded-2xl shadow-sm">
                            <label for="gst_number" class="block mb-2 font-medium text-gray-700">Display my GSTIN number on invoice</label>
                            <input type="text" id="gst_number" name="gst_number" class="w-full px-3 py-2 border-2 rounded-lg focus:border-primary-500 focus:bg-gray-50 text-sm">
                        </div>

                        <div class="relative p-6 bg-white rounded-2xl shadow hover:shadow-lg">
                            <h3 class="pb-4 mb-6 text-2xl font-semibold border-b border-gray-200">Order Summary</h3>

                            <!-- Products List -->
                            <div id="productScroll" class="overflow-x-auto hide-scrollbar flex gap-4 whitespace-nowrap mb-4">
                                <ul role="list" class="flex gap-4">
                                    <?php
                                    $subTotal = 0;
                                    $subTotalWithTax = 0;
                                    $gstAmount = 0;
                                    $data = getCartData();
                                    foreach ($data as $key => $cart):
                                        $subTotal += ((int)$cart['price'] * $cart['quantity']);
                                        if (getData("gst_percentage", "seller_products", "id = '{$cart['product_id']}'")) {
                                            $subTotalWithTax += calculateGst((int)$cart['price'] * $cart['quantity'], getData("gst_percentage", "seller_products", "id = '{$cart['product_id']}'"))['getPrice'];
                                            $gstAmount += calculateGst((int)$cart['price'] * $cart['quantity'], getData("gst_percentage", "seller_products", "id = '{$cart['product_id']}'"))['gstAmount'];
                                        } else {
                                            $subTotalWithTax += calculateGst((int)$cart['price'] * $cart['quantity'])['getPrice'];
                                            $gstAmount += calculateGst((int)$cart['price'] * $cart['quantity'])['gstAmount'];
                                        }
                                        $variation = $cart['other'] ? getData("variation", "seller_product_variants", "id = '{$cart['other']}'") : getData("variation", "seller_products", "id = '{$cart['product_id']}'");
                                        $size = getData("size", "seller_product_advanced_variants", "id = '{$cart['advanced_variant']}'");
                                        $color = getData("color", "seller_product_advanced_variants", "id = '{$cart['advanced_variant']}'");
                                        $color = getData("color_name", "product_colors", "id = '$color'");
                                        if (!$variation && $size) {
                                            $variation = "Size: $size | Color: $color";
                                        }
                                        $image = getData("image", "seller_products", "id = '{$cart['product_id']}'");
                                        if ($cart['other'] && getData("image", "seller_product_variants", "id = '{$cart['other']}'")) {
                                            $image = getData("image", "seller_product_variants", "id = '{$cart['other']}'");
                                        }
                                        if ($cart['advanced_variant'] && getData("image", "seller_product_advanced_variants", "id = '{$cart['advanced_variant']}'")) {
                                            $image = getData("image", "seller_product_advanced_variants", "id = '{$cart['advanced_variant']}'");
                                        }
                                        $unit = (int)getData("unit", "seller_products", "id = '{$cart['product_id']}'");
                                        if ((int)getData("unit", "seller_product_variants", "id = '{$cart['other']}'")) {
                                            $unit = (int)getData("unit", "seller_product_variants", "id = '{$cart['other']}'");
                                        }
                                        $stock_unit = getData("stock_unit", "seller_products", "id = '{$cart['product_id']}'");
                                        $total_stocks = (int)$cart['quantity'] * $unit;
                                        if (!$stock_unit) $stock_unit = getData("unit_type", "seller_products", "id = '{$cart['product_id']}'");
                                        if ($stock_unit == "kg" || $stock_unit == "litre") {
                                            $total_stocks /= 1000;
                                        } else if ($stock_unit == "meter") {
                                            $total_stocks *= 0.3048;
                                        }
                                    ?>
                                        <li class="flex-none w-40 bg-gray-50 p-3 rounded-xl shadow hover:shadow-md transition inline-block">
                                            <div class="w-full h-40 rounded-md overflow-hidden mb-2">
                                                <img src="<?= isset($image) && $image ? UPLOADS_URL . $image : UPLOADS_URL . 'default-product.png' ?>"
                                                    alt="<?= isset($cart['slug']) ? APP_URL . "product/" . $cart['slug'] : 'Product Image' ?>"
                                                    class="w-full h-full object-cover">

                                            </div>
                                            <h4 class="text-sm font-medium text-gray-900 truncate"><?= limit_characters(getData("name", "seller_products", "id = '{$cart['product_id']}'"), 30) ?></h4>
                                            <p class="text-xs text-gray-500 truncate"><?= $variation ?></p>
                                            <div class="flex justify-between mt-1 text-sm text-gray-600">
                                                <span><?= $total_stocks . " " . $stock_unit ?></span>
                                                <span><?= currencyToSymbol($storeCurrency) . number_format((int)$cart['price'] * $cart['quantity'], 2) ?></span>
                                            </div>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>

                            <!-- Bottom Scroll Buttons (Right-Aligned) -->
                            <div class="flex justify-end gap-4 mb-4">
                                <button id="scrollLeftBtn" type="button"
                                    class="w-10 h-10 rounded-full shadow-md flex items-center justify-center bg-primary-500 text-white hover:bg-primary-600 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                    </svg>
                                </button>
                                <button id="scrollRightBtn" type="button"
                                    class="w-10 h-10 rounded-full shadow-md flex items-center justify-center bg-primary-500 text-white hover:bg-primary-600 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </button>
                            </div>



                            <!-- Totals Section -->
                            <div class="pt-4 border-t space-y-3 mt-4">
                                <div class="flex justify-between text-gray-600">
                                    <span>Subtotal</span>
                                    <span id="subTotal"><?= currencyToSymbol($storeCurrency) . number_format($subTotal, 2) ?></span>
                                </div>
                                <div class="flex justify-between text-gray-600">
                                    <span>Discount</span>
                                    <span id="discount">0.00</span>
                                </div>
                                <div class="flex justify-between text-gray-600 <?= getSettings("gst_tax_type") == "inclusive" || !getSettings("gst_number") ? 'hidden' : '' ?>">
                                    <span>GST Tax Amount</span>
                                    <span id="gstTax"><?= currencyToSymbol($gstAmount) ?></span>
                                </div>
                                <div class="flex justify-between text-gray-600">
                                    <span>Charges</span>
                                    <span id="charges">0.00</span>
                                </div>
                            </div>

                            <div class="flex justify-between mt-4 pt-4 border-t font-semibold text-lg text-emerald-600">
                                <span>Total (<?= $storeCurrency ?>)</span>
                                <span id="total"><?= currencyToSymbol($subTotalWithTax) ?></span>
                            </div>
                            <div class="mt-8 space-y-3">
                                <?php
                                $minimumOrder = getSettings("minimum_order_amount");
                                if (!empty($minimumOrder) && $subTotal < $minimumOrder): ?>
                                    <!-- Stylish Minimum Order Message -->
                                    <div class="py-3 px-4 rounded-xl text-center bg-gradient-to-r from-pink-50 to-pink-100 border border-pink-200 shadow-sm">
                                        <p class="text-pink-700 font-semibold text-sm">
                                            Minimum order is
                                            <span class="font-bold text-pink-600">
                                                <?= currencyToSymbol($storeCurrency) . number_format($minimumOrder, 2) ?>
                                            </span>.
                                        </p>
                                    </div>
                                <?php else: ?>
                                    <!-- Place Order Button -->
                                    <button id="payBtn" type="submit"
                                        class="w-full py-3 mt-3 rounded-xl font-semibold text-white bg-gradient-to-r from-pink-400 to-pink-600 hover:from-pink-500 hover:to-pink-700 shadow-lg transition">
                                        Place Order
                                    </button>
                                <?php endif; ?>
                            </div>

                        </div>

                        <style>
                            .hide-scrollbar::-webkit-scrollbar {
                                display: none;
                            }

                            .hide-scrollbar {
                                -ms-overflow-style: none;
                                scrollbar-width: none;
                            }
                        </style>

                        <script>
                            const scrollContainer = document.getElementById('productScroll');
                            const scrollLeftBtn = document.getElementById('scrollLeftBtn');
                            const scrollRightBtn = document.getElementById('scrollRightBtn');

                            scrollLeftBtn.addEventListener('click', () => {
                                scrollContainer.scrollBy({
                                    left: -200,
                                    behavior: 'smooth'
                                });
                            });
                            scrollRightBtn.addEventListener('click', () => {
                                scrollContainer.scrollBy({
                                    left: 200,
                                    behavior: 'smooth'
                                });
                            });
                        </script>

                    </div>
                </form>


                <!-- Add Address -->
                <div id="addAddressModal" class="fixed top-0 left-0 flex items-center justify-center hidden w-full h-full transition opacity-0 bg-black/80">
                    <div class="p-5 bg-white rounded-xl max-w-[750px] w-full shadow">
                        <div class="flex items-center justify-between mb-5">
                            <h3 class="text-2xl font-semibold">Add Address</h3>

                            <button class="addAddressToggle w-[44px] h-[44px] bg-red-500 text-white rounded-xl"><i class="text-lg font-medium bx bx-x"></i></button>
                        </div>

                        <form id="addAddressForm" class="max-h-[75vh] overflow-y-auto pb-[50px] lg:pb-0">
                            <div class="mb-5">
                                <label for="name" class="block mb-2 font-medium text-[#666666]">Name <span class="text-red-500">*</span> </label>
                                <input type="text" name="name" id="name" placeholder="Enter your name" class="border-2 border-[#F4F4F4] font-medium text-sm h-12 px-3 rounded-xl w-full transition focus:border-primary-500" value="<?= customer("name") ?>" required>
                            </div>

                            <div class="grid gap-5 mb-5 sm:grid-cols-2">
                                <div>
                                    <label for="phone" class="block mb-2 font-medium text-[#666666]">Phone Number <span class="text-red-500">*</span></label>
                                    <input type="tell" name="phone[main]" id="phone" placeholder="XXXXX XXXXX" class="border-2 border-[#F4F4F4] font-medium text-sm h-12 px-3 rounded-xl w-full transition focus:border-primary-500" value="<?= customer("phone") ?>" required>
                                </div>

                                <div>
                                    <label for="email" class="block mb-2 font-medium text-[#666666]">Email Address</label>
                                    <input type="email" name="email" id="email" placeholder="Enter your email" class="border-2 border-[#F4F4F4] font-medium text-sm h-12 px-3 rounded-xl w-full transition focus:border-primary-500" value="<?= customer("email") ?>">
                                </div>
                            </div>

                            <div class="mb-5">
                                <label for="address" class="block mb-2 font-medium text-[#666666]">Address <span class="text-red-500">*</span></label>
                                <input type="text" name="address" id="address" placeholder="Flat / House No, Building, Colony" class="border-2 border-[#F4F4F4] font-medium text-sm h-12 px-3 rounded-xl w-full transition focus:border-primary-500 empty-input" required>
                            </div>

                            <div class="grid gap-5 mb-5 sm:grid-cols-2">
                                <div>
                                    <label for="area" class="block mb-2 font-medium text-[#666666]">Locality / Area <small>(optional)</small></label>
                                    <input type="text" name="area" id="area" placeholder="E.g. MG Road, Gandhi Nagar" class="border-2 border-[#F4F4F4] font-medium text-sm h-12 px-3 rounded-xl w-full transition focus:border-primary-500 empty-input">
                                </div>

                                <div>
                                    <label for="landmark" class="block mb-2 font-medium text-[#666666]">Landmark <small>(optional)</small></label>
                                    <input type="text" name="landmark" id="landmark" placeholder="E.g. Near Bank, Chowk, etc." class="border-2 border-[#F4F4F4] font-medium text-sm h-12 px-3 rounded-xl w-full transition focus:border-primary-500 empty-input">
                                </div>
                            </div>

                            <div class="grid gap-5 mb-5 sm:grid-cols-3">
                                <div>
                                    <label for="city" class="block mb-2 font-medium text-[#666666]">City <span class="text-red-500">*</span></label>
                                    <input type="text" name="city" id="city" placeholder="Enter city" class="border-2 border-[#F4F4F4] font-medium text-sm h-12 px-3 rounded-xl w-full transition focus:border-primary-500 empty-input" required>
                                </div>

                                <div>
                                    <label for="pin_code" class="block mb-2 font-medium text-[#666666]">Pin Code <span class="text-red-500">*</span></label>
                                    <input type="text" name="pin_code" id="pin_code" placeholder="Enter pin code" class="border-2 border-[#F4F4F4] font-medium text-sm h-12 px-3 rounded-xl w-full transition focus:border-primary-500 empty-input" required>
                                </div>

                                <div>
                                    <label for="state" class="block mb-2 font-medium text-[#666666]">State <span class="text-red-500">*</span></label>
                                    <?php if ($storeCountry == "IN") { ?>
                                        <select name="state" id="state" class="border-2 border-[#F4F4F4] font-medium text-sm h-12 px-3 rounded-xl w-full transition focus:border-primary-500 empty-input" required>
                                            <option value="" disabled hidden selected>Select state</option>
                                            <option value="Andhra Pradesh">Andhra Pradesh</option>
                                            <option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option>
                                            <option value="Arunachal Pradesh">Arunachal Pradesh</option>
                                            <option value="Assam">Assam</option>
                                            <option value="Bihar">Bihar</option>
                                            <option value="Chandigarh">Chandigarh</option>
                                            <option value="Chhattisgarh">Chhattisgarh</option>
                                            <option value="Dadar and Nagar Haveli">Dadar and Nagar Haveli</option>
                                            <option value="Daman and Diu">Daman and Diu</option>
                                            <option value="Delhi">Delhi</option>
                                            <option value="Lakshadweep">Lakshadweep</option>
                                            <option value="Puducherry">Puducherry</option>
                                            <option value="Goa">Goa</option>
                                            <option value="Gujarat">Gujarat</option>
                                            <option value="Haryana">Haryana</option>
                                            <option value="Himachal Pradesh">Himachal Pradesh</option>
                                            <option value="Jammu and Kashmir">Jammu and Kashmir</option>
                                            <option value="Jharkhand">Jharkhand</option>
                                            <option value="Karnataka">Karnataka</option>
                                            <option value="Kerala">Kerala</option>
                                            <option value="Madhya Pradesh">Madhya Pradesh</option>
                                            <option value="Maharashtra">Maharashtra</option>
                                            <option value="Manipur">Manipur</option>
                                            <option value="Meghalaya">Meghalaya</option>
                                            <option value="Mizoram">Mizoram</option>
                                            <option value="Nagaland">Nagaland</option>
                                            <option value="Odisha">Odisha</option>
                                            <option value="Punjab">Punjab</option>
                                            <option value="Rajasthan">Rajasthan</option>
                                            <option value="Sikkim">Sikkim</option>
                                            <option value="Tamil Nadu">Tamil Nadu</option>
                                            <option value="Telangana">Telangana</option>
                                            <option value="Tripura">Tripura</option>
                                            <option value="Uttar Pradesh">Uttar Pradesh</option>
                                            <option value="Uttarakhand">Uttarakhand</option>
                                            <option value="West Bengal">West Bengal</option>
                                        </select>
                                    <?php } else { ?>
                                        <div>
                                            <label for="state" class="block mb-2 font-medium text-[#666666]">State <span class="text-red-500">*</span></label>
                                            <input type="text" name="state" id="state" placeholder="Enter state" class="border-2 border-[#F4F4F4] font-medium text-sm h-12 px-3 rounded-xl w-full transition focus:border-primary-500 empty-input" required>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>

                            <button class="bg-primary-500 h-[50px] rounded-xl font-medium text-base text-white flex items-center justify-center w-full ml-auto">Add Address</button>
                        </form>
                    </div>
                </div>
            <?php } else { ?>
                <div class="p-[30px] w-full text-center">
                    <img alt="" src="<?= APP_URL ?>assets/img/empty-bag.svg" width="216" height="126" class="mx-auto mt-[38px]">
                    <h3 class="leading-[17px] text-[20px] font-[700] mt-5">
                        Your bag is empty
                    </h3>
                    <p class="text-[#CCCCCC] leading-[25px] text-[16px] font-[400] mt-3">
                        Looks like you haven't made your choice yet.
                    </p>

                    <!-- Go to Shop button -->
                    <a href="<?= $storeUrl ?>" class="mt-6 inline-flex items-center px-6 py-3 bg-primary-500 hover:bg-rose-600 text-white font-semibold rounded-full transition transform hover:scale-105 shadow-lg">
                        <i class="fa-solid fa-shop mr-2"></i> Go to Shop
                    </a>
                </div>
            <?php } ?>
        </div>
    </div>



    <!-- Intl tell input js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>

    <!-- select2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        const phoneInputField = document.querySelector("#phone");
        const phoneInput = window.intlTelInput(phoneInputField, {
            separateDialCode: true,
            preferredCountries: ["<?= getSettings("country") ?>"],
            hiddenInput: "full",
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
        });
    </script>

    <script>
        {
            const coupons = document.querySelectorAll('.copyCoupon');

            coupons.forEach(coupon => {
                coupon.addEventListener('mouseenter', () => {
                    coupon.style.cursor = 'pointer';
                });

                coupon.addEventListener('mouseleave', () => {
                    coupon.style.cursor = 'default';
                });
            });
        }
        document.querySelectorAll('.copyCoupon').forEach(el => {
            el.addEventListener('click', function() {
                const code = this.dataset.code;
                const input = document.getElementById('couponCode');
                const applyBtn = document.getElementById('applyCoupon');

                input.value = code;

                // Glow effect
                applyBtn.classList.add('shadow-[0_0_12px_rgba(236,72,153,0.8)]');
                setTimeout(() => {
                    applyBtn.classList.remove('shadow-[0_0_12px_rgba(236,72,153,0.8)]');
                }, 1000);
            });
        });
    </script>
    <!-- Razorpay -->
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>


    <!--Footer File Includes that file has all JS Files includes links-->
    <?php include_once __DIR__ . "/includes/footer.php"; ?>

</body>

</html>