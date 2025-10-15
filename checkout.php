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
                <form id="placeOrderForm" onkeydown="return event.key != 'Enter';" class="flex flex-col gap-6 lg:flex-row">
                    <!-- Left -->
                    <div class="lg:w-[60%] flex flex-col gap-5 relative before:sm:border-dashed before:sm:border before:sm:border-primary-500 before:sm:h-full before:sm:w-[1px] before:sm:absolute before:sm:left-[25px] before:sm:-z-10">
                        <!-- Pin Code or State -->
                        <div class="flex gap-4">

                            <div class="bg-primary-500 w-[50px] h-[50px] text-2xl font-medium text-white rounded-full sm:flex justify-center items-center hidden">01</div>

                            <div class="p-5 bg-white rounded-md w-full sm:w-[calc(100%_-_66px)]">
                                <h3 class="mb-2 text-2xl font-semibold"><?= getData("delivery_area_type", "seller_settings", "seller_id = '$sellerId'") == "zip_code" ? "Check Pin Code" : "Select State" ?></h3>

                                <p class="text-sm text-gray-500">
                                    <?= getData("delivery_area_type", "seller_settings", "seller_id = '$sellerId'") == "zip_code" ? 'Please select a pin code' : 'Please select a state' ?>
                                </p>

                                <div class="flex items-center gap-3 mt-6">

                                    <select class="custom-select px-[15px] h-[45px] border-2 rounded-full w-full transition focus:border-primary-500 text-sm font-[400] focus:bg-gray-50" id="deliveryArea" name="delivery_area" <?= getData("delivery_area_type", "seller_settings", "seller_id = '$sellerId'") == "zip_code" ? 'data-pincode="true"' : null ?>>
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

                        <!-- Delivery Option -->
                        <div class="flex gap-4">
                            <div class="bg-primary-500 w-[50px] h-[50px] text-2xl font-medium text-white rounded-full sm:flex justify-center items-center hidden">02</div>

                            <div class="relative p-5 overflow-hidden bg-white rounded-md w-full sm:w-[calc(100%_-_66px)]">

                                <h3 class="mb-5 text-2xl font-semibold">Delivery Option</h3>

                                <div class="flex gap-5">
                                    <label for="deliveryDelivery">
                                        <div class="w-32 h-32 flex items-center justify-center bg-blue-50 rounded-md">
                                            <img src="<?= APP_URL ?>assets/img/delivery-truck.png" alt="" class="w-[72px] h-[72px]">
                                        </div>

                                        <div class="flex items-center justify-center gap-2 mt-3">
                                            <input type="radio" name="delivery_option" id="deliveryDelivery" class="accent-primary-500 w-3 h-3 deliveryOption" value="delivery" checked> <span class="text-gray-500">Delivery</span>
                                        </div>
                                    </label>

                                    <?php if (getData("id", "seller_locations", "seller_id = '$sellerId' AND location_type = 'pickup'")) : ?>
                                        <label for="deliveryPickup">
                                            <div class="w-32 h-32 flex items-center justify-center bg-orange-50 rounded-md">
                                                <img src="<?= APP_URL ?>assets/img/pickup.png" alt="" class="w-[72px] h-[72px]">
                                            </div>

                                            <div class="flex items-center justify-center gap-2 mt-3">
                                                <input type="radio" name="delivery_option" id="deliveryPickup" class="accent-primary-500 w-3 h- deliveryOption" value="pickup"> <span class="text-gray-500">Pickup</span>
                                            </div>

                                        </label>
                                    <?php endif ?>
                                </div>
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <div class="bg-primary-500 w-[50px] h-[50px] text-2xl font-medium text-white rounded-full sm:flex justify-center items-center hidden">03</div>

                            <!-- Pickup Date and Time -->
                            <div class="p-5 bg-white rounded-md w-full sm:w-[calc(100%_-_66px)]" id="pickupDateAndTime" style="display: none;">
                                <h3 class="mb-5 text-2xl font-semibold">Pickup Date & Time</h3>

                                <div class="grid gap-5 sm:grid-cols-2">
                                    <div class="col-span-2">
                                        <label for="pickupPoint" class="block mb-2 text-sm">Pickup Point</label>

                                        <select id="pickupPoint" name="pickup_point" class="px-[15px] h-[45px] border-2 rounded-lg w-full transition focus:border-primary-500 text-sm font-[400] focus:bg-gray-50">
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

                                        <select id="pickup_days" name="pickup_day" class="px-[15px] h-[45px] border-2 rounded-lg w-full transition focus:border-primary-500 text-sm font-[400] focus:bg-gray-50">
                                            <option value="" hidden disabled selected>Select</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label for="pickup_times" class="block mb-2 text-sm">Time</label>

                                        <select id="pickup_times" name="pickup_time" class="px-[15px] h-[45px] border-2 rounded-lg w-full transition focus:border-primary-500 text-sm font-[400] focus:bg-gray-50">
                                            <option value="" hidden disabled selected>Select</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Locations -->
                                <div id="pickupLocations">

                                </div>
                            </div>

                            <!-- Delivery Address -->
                            <div class="p-5 bg-white rounded-md w-full sm:w-[calc(100%_-_66px)]" id="deliveryAddress">
                                <div class="flex items-center justify-between mb-5">
                                    <h3 class="text-2xl font-semibold">Delivery Address</h3>

                                    <button class="underline addAddressToggle text-primary-500" type="button">Add Address</button>
                                </div>

                                <div class="grid gap-5 lg:grid-cols-2 shippingAddressList">

                                </div>
                            </div>
                        </div>

                        <!-- Billing Address -->
                        <div class="flex gap-4">
                            <div class="bg-primary-500 w-[50px] h-[50px] text-2xl font-medium text-white rounded-full sm:flex justify-center items-center hidden">04</div>

                            <div class="p-5 bg-white rounded-md w-full sm:w-[calc(100%_-_66px)]">
                                <div class="flex items-center justify-between mb-5">
                                    <h3 class="text-2xl font-semibold">Billing Address</h3>

                                    <button class="underline addAddressToggle text-primary-500" type="button">Add Address</button>
                                </div>

                                <div class="grid gap-5 lg:grid-cols-2 billingAddressList">

                                </div>
                            </div>
                        </div>

                        <!-- Payment Method -->
                        <div class="flex gap-4">
                            <div class="bg-primary-500 w-[50px] h-[50px] text-2xl font-medium text-white rounded-full sm:flex justify-center items-center hidden">05</div>

                            <div class="p-5 bg-white rounded-md w-full sm:w-[calc(100%_-_66px)]">
                                <h3 class="mb-5 text-2xl font-semibold">Payment Method</h3>

                                <div class="grid grid-cols-1 space-y-5">
                                    <?php if (!empty(getSettings("cod")) && plan("payment_cod")) : ?>
                                        <label for="paymentCOD" class="flex items-center gap-3 p-5 bg-red-50 rounded-md cursor-pointer">
                                            <input type="radio" name="payment_method" id="paymentCOD" class="accent-red-500 w-[16px] h-[16px] paymentMethod" value="COD">

                                            <div class="flex items-center gap-2">
                                                <img src="<?= APP_URL ?>assets/img/cod.png" alt="" class="w-8 h-8">

                                                <h3 class="font-medium text-md">Cash On Delivery (COD) <?= getSettings("cod_charges") ? " - Extra " . currencyToSymbol($storeCurrency) . getSettings("cod_charges") . " Charges for COD" : null ?></h3>
                                            </div>
                                        </label>
                                    <?php endif ?>

                                    <?php if (!empty(getSettings("razorpay_key_id")) && plan("payment_razorpay")) : ?>
                                        <label for="paymentRazorpay" class="flex items-center gap-3 p-5 bg-indigo-50 rounded-md cursor-pointer">
                                            <input type="radio" name="payment_method" id="paymentRazorpay" class="accent-indigo-500 w-[16px] h-[16px] paymentMethod" value="Razorpay">

                                            <div class="flex items-center gap-2">
                                                <img src="<?= APP_URL ?>assets/img/razorpay.png" alt="" class="w-8 h-8">

                                                <h3 class="font-medium text-md">Razorpay</h3>
                                            </div>
                                        </label>
                                    <?php endif ?>

                                    <?php if (!empty(getSettings("phonepe_key")) && plan("payment_phonepe")) : ?>
                                        <label for="paymentPhonePe" class="flex items-center gap-3 p-5 bg-purple-50 rounded-md cursor-pointer">
                                            <input type="radio" name="payment_method" id="paymentPhonePe" class="accent-purple-500 w-[16px] h-[16px] paymentMethod" value="PhonePe">

                                            <div class="flex items-center gap-2">
                                                <img src="<?= APP_URL ?>assets/img/phonepe.png" alt="" class="w-8 h-8">

                                                <h3 class="font-medium text-md">PhonePe</h3>
                                            </div>
                                        </label>
                                    <?php endif ?>

                                    <?php if (!empty(getSettings("ippo_pay_public_key")) && plan("payment_ippopay")) : ?>
                                        <label for="paymentIppoPay" class="flex items-center gap-3 p-5 bg-blue-50 rounded-md cursor-pointer">
                                            <input type="radio" name="payment_method" id="paymentIppoPay" class="accent-blue-500 w-[16px] h-[16px] paymentMethod" value="IppoPay">

                                            <div class="flex items-center gap-2">
                                                <img src="<?= APP_URL ?>assets/img/ippo-pay.png" alt="" class="w-8 h-8">

                                                <h3 class="font-medium text-md">IppoPay</h3>
                                            </div>
                                        </label>
                                    <?php endif; ?>

                                    <?php if (!empty(getSettings("bank_details")) && plan("payment_bank")) : ?>
                                        <label for="paymentBankTransfer" class="flex items-center gap-3 p-5 bg-teal-50 rounded-md cursor-pointer">
                                            <input type="radio" name="payment_method" id="paymentBankTransfer" class="accent-teal-500 w-[16px] h-[16px] paymentMethod" value="Bank Transfer">

                                            <div class="flex items-center gap-2">
                                                <img src="<?= APP_URL ?>assets/img/bank.png" alt="" class="w-8 h-8">

                                                <h3 class="font-medium text-md">Bank Transfer</h3>
                                            </div>
                                        </label>

                                        <div id="bankDetails" class="p-5 !mt-1 space-y-3 bg-teal-50 rounded-md" style="display:none;">
                                            <?= nl2br(getSettings("bank_details")) ?>

                                            <div class="!mt-5 !pt-5 border-t">
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
                                        <label for="paymentUPI" class="flex items-center gap-3 p-5 bg-orange-50 rounded-md cursor-pointer">
                                            <input type="radio" name="payment_method" id="paymentUPI" class="accent-orange-500 w-[16px] h-[16px] paymentMethod" value="UPI">

                                            <div class="flex items-center gap-2">
                                                <img src="<?= APP_URL ?>assets/img/upi.webp" alt="" class="w-8 h-8">

                                                <h3 class="font-medium text-md">UPI (Scan this QR Code or Pay to this UPI ID)</h3>
                                            </div>
                                        </label>

                                        <div id="upiImg" class="p-5 !mt-1 space-y-3 bg-orange-50 rounded-md" style="display:none;">
                                            <span class="block mb-2">UPI ID: <b class="text-primary-500 cursor-pointer" onclick="navigator.clipboard.writeText('<?= getSettings("upi_id") ?>')"><?= getSettings("upi_id") ?></b></span>

                                            <img src="<?= UPLOADS_URL . getSettings("upi_qr_code") ?>" alt="" class="max-w-full max-h-[400px]">
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <!-- notes -->
                        <div class="flex gap-4">
                            <div class="bg-primary-500 w-[50px] h-[50px] text-2xl font-medium text-white rounded-full sm:flex justify-center items-center hidden">06</div>

                            <div class="p-5 bg-white rounded-md w-full sm:w-[calc(100%_-_66px)]">
                                <label for="notes" class="block mb-2 font-medium">Notes</label>
                                <textarea name="notes" id="notes" rows="5" class="bg-[#F4F4F4] rounded-xl p-4 w-full font-medium"></textarea>
                            </div>
                        </div>

                        <?php if (getSettings("customized_gift")) : ?>
                            <!-- Customized gift -->
                            <div class="flex gap-4">
                                <div class="bg-primary-500 w-[50px] h-[50px] text-2xl font-medium text-white rounded-full sm:flex justify-center items-center hidden">07</div>

                                <div class="p-5 bg-white rounded-md w-full sm:w-[calc(100%_-_66px)]">
                                    <h4 class="text-xl font-medium mb-5">Customized Gift <sup>(optional)</sup></h4>

                                    <div class="grid gap-5">
                                        <div>
                                            <label for="customized_gift_images" class="block mb-2 font-medium">Images</label>
                                            <input type="file" name="customized_gift_images[]" id="customized_gift_images" class="bg-[#F4F4F4] rounded-xl p-4 w-full font-medium" accept="image/*" max="3" multiple>

                                            <small class="text-red-500 block mt-1">You can only select a maximum of 3 images.</small>
                                        </div>

                                        <div>
                                            <label for="customized_gift_notes" class="block mb-2 font-medium">Details</label>
                                            <textarea name="customized_gift_notes" id="customized_gift_notes" rows="5" class="bg-[#F4F4F4] rounded-xl p-4 w-full font-medium"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif ?>
                    </div>

                    <!-- Right -->
                    <div class="lg:w-[40%] space-y-5">

                        <!-- Coupon Codes -->
                        <div class="p-5 bg-white rounded-md">
                            <div class="flex items-center justify-center gap-2">
                                <input type="text" id="couponCode" name="couponCode" class="w-full px-3 py-2 text-base font-medium transition border-2 rounded-lg focus:border-primary-500 focus:bg-gray-50" placeholder="Coupon Code">

                                <button id="applyCoupon" type="button" class="bg-primary-500 border-2 border-primary-500 text-white text-[14px] font-[400] py-2 px-3 flex items-center gap-2 rounded-lg transition hover:opacity-90 justify-center disabled:opacity-50">Apply</button>
                            </div>

                            <ul class="pt-5 mt-5 space-y-4 border-t" id="couponList">
                                <?php

                                $discounts = getDiscounts();

                                foreach ($discounts as $key => $discount) :

                                ?>

                                    <li class="flex items-center justify-between">
                                        <span class="p-2 font-medium bg-gradient-to-r from-amber-50 to-orange-50"><?= $discount['code'] ?></span>
                                        <button type="button" class="px-2 py-1 text-sm text-white transition rounded-lg bg-primary-500 hover:opacity-90 copyCoupon" data-code="<?= $discount['code'] ?>">Copy</button>
                                    </li>

                                <?php endforeach ?>
                            </ul>
                        </div>

                        <div class="p-5 bg-white rounded-md">
                            <div class="flex items-center justify-between mb-5">
                                <h3 class="text-lg font-bold">Display my GSTIN number on invoice</h3>
                            </div>

                            <input type="text" id="gst_number" name="gst_number" class="w-full px-3 py-2 text-base font-medium transition border-2 rounded-lg focus:border-primary-500 focus:bg-gray-50" placeholder="GSTIN Number">
                        </div>

                        <!-- Summary -->
                        <div class="p-5 bg-primary-50 rounded-md">
                            <h3 class="pb-5 mb-5 text-xl font-semibold border-b">Order Summary</h3>

                            <!-- products -->
                            <div class="mb-5 space-y-5 max-h-[405px] h-auto overflow-auto lg:pr-5">
                                <ul role="list" class="-my-6 divide-y divide-gray-200">
                                    <?php
                                    $data = getCartData();

                                    foreach ($data as $key => $cart) :
                                        $subTotal += ((int)$cart['price'] * $cart['quantity']);
                                        $subTotalMrp += ((int)$cart['mrp_price'] * $cart['quantity']);

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

                                        if ($stock_unit == "kg") {
                                            $total_stocks = (int)$total_stocks / 1000;
                                        } else if ($stock_unit == "litre") {
                                            $total_stocks = (int)$total_stocks / 1000;
                                        } else if ($stock_unit == "meter") {
                                            $total_stocks = (int)$total_stocks * 0.3048;
                                        } else {
                                            $total_stocks = (int)$total_stocks;
                                        }
                                    ?>
                                        <li class="flex py-6 group">
                                            <div class="flex-shrink-0 w-24 h-24 overflow-hidden border border-gray-200 rounded-md">
                                                <img src="<?= UPLOADS_URL . $image ?>" alt="<?= APP_URL . "product/" . $cart['slug'] ?>" class="object-cover object-center w-full h-full">
                                            </div>

                                            <div class="flex flex-col flex-1 ml-4">
                                                <div>
                                                    <div class="flex justify-between text-base font-medium text-gray-900">
                                                        <h3>
                                                            <?= limit_characters(getData("name", "seller_products", "id = '{$cart['product_id']}'"), 30) ?>
                                                        </h3>
                                                    </div>
                                                    <p class="mt-1 text-sm text-gray-500"><?= $variation ?></p>
                                                </div>
                                                <div class="flex items-center justify-between flex-1 text-sm">
                                                    <p class="text-gray-500"><?= $total_stocks . " " . $stock_unit ?></p>
                                                    <p><?= currencyToSymbol($storeCurrency) . number_format((int)$cart['price'] * $cart['quantity'], 2) ?></p>
                                                </div>
                                            </div>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>

                            <div class="pt-5 mt-5 space-y-4 border-t">
                                <div class="flex items-center justify-between">
                                    <span class="text-base text-gray-500">Subtotal</span>
                                    <span class="text-base text-gray-500" id="subTotal"><?= currencyToSymbol($storeCurrency) . number_format($subTotal, 2) ?></span>
                                </div>

                                <div class="flex items-center justify-between">
                                    <span class="text-base text-gray-500">Discount</span>
                                    <span class="text-base text-gray-500" id="discount">0.00</span>
                                </div>

                                <div class="flex items-center justify-between <?= getSettings("gst_tax_type") == "inclusive" || !getSettings("gst_number")  ? 'hidden' : '' ?>">
                                    <span class="text-base text-gray-500">GST Tax Amount:</span>
                                    <span class="text-base text-gray-500" id="gstTax"><?= currencyToSymbol($storeCurrency) . number_format($gstAmount, 2) ?></span>
                                </div>

                                <div class="flex items-center justify-between">
                                    <span class="text-base text-gray-500">Charges</span>
                                    <span class="text-base text-gray-500" id="charges">0.00</span>
                                </div>
                            </div>

                            <div class="flex items-center justify-between pt-5 mt-5 border-t">
                                <span class="text-lg font-medium">Total (<?= $storeCurrency ?>)</span>
                                <span class="text-lg font-medium text-emerald-500" id="total"><?= currencyToSymbol($storeCurrency) . number_format($subTotalWithTax, 2) ?></span>
                            </div>
                            <p class="mt-1 text-sm text-gray-500">Including <?= ucfirst(getSettings("gst_tax_type")) ?> of tax</p>

                            <div class="mt-8 space-y-3">

                                <?php
                                if (!empty(getSettings("minimum_order_amount")) && $subTotal < (int)getSettings("minimum_order_amount")) {
                                    echo '<div class="bg-yellow-100 text-yellow-500 py-[14px] px-[15px] rounded-lg text-center">
                                Minimum Order Amount is ' . currencyToSymbol($storeCurrency) . getSettings("minimum_order_amount") . '
                            </div>';
                                } else { ?>

                                    <button id="payBtn" type="submit" class="bg-primary-500 h-[50px] rounded-lg font-medium text-base text-white flex items-center justify-center w-full">Place Order</button>
                                <?php } ?>
                            </div>
                        </div>
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
                <div class="p-[30px] w-full">
                    <img alt="" src="<?= APP_URL ?>/assets/img/empty-bag.svg" width="216" height="126" decoding="async" data-nimg="1" class="mx-auto mt-[38px]" loading="lazy" style="color: transparent">
                    <h3 class="leading-[17px] text-[20px] font-[700] text-center mt-5">
                        Your bag is empty
                    </h3>
                    <p class="text-[#CCCCCC] leading-[25px] text-[16px] font-[400] text-center mt-3">
                        Looks like you haven't made your choice yet.
                    </p>
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


    <!-- Razorpay -->
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>


    <!--Footer File Includes that file has all JS Files includes links-->
    <?php include_once __DIR__ . "/includes/footer.php"; ?>

</body>

</html>