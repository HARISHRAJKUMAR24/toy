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

        /* Timeline and Step Number Styles */
        .checkout-timeline {
            position: relative;
        }

        .checkout-timeline::before {
            content: '';
            position: absolute;
            left: 25px;
            top: 0;
            bottom: 0;
            width: 2px;
            background: linear-gradient(to bottom, #ec4899, #f97316);
            z-index: 0;
        }

        @media (max-width: 640px) {
            .checkout-timeline::before {
                display: none;
            }
        }

        .step-number {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #ec4899, #f97316);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 1.25rem;
            box-shadow: 0 4px 15px rgba(236, 72, 153, 0.4);
            position: relative;
            z-index: 2;
            flex-shrink: 0;
            transition: all 0.3s ease;
        }

        .step-number.completed {
            background: linear-gradient(135deg, #10b981, #059669);
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.4);
            animation: none;
            /* Remove pulse animation for completed steps */
        }

        .step-number.active {
            box-shadow: 0 0 25px rgba(236, 72, 153, 0.8), 0 4px 20px rgba(236, 72, 153, 0.6);
            animation: pulse 2s infinite;
            transform: scale(1.05);
            background: linear-gradient(135deg, #ec4899, #f97316);
            /* Ensure active stays pink */
        }

        .step-content {
            width: 100%;
            transition: all 0.3s ease;
        }

        @media (min-width: 640px) {
            .step-content {
                width: calc(100% - 66px);
            }
        }

        .step-container {
            transition: all 0.3s ease;
        }

        .step-container.active .step-content {
            border-color: #ec4899;
            box-shadow: 0 10px 25px rgba(236, 72, 153, 0.15);
        }

        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        /* Responsive improvements */
        @media (max-width: 640px) {
            .step-container {
                flex-direction: column;
                gap: 1rem;
            }

            .delivery-options {
                flex-direction: column;
                align-items: center;
            }

            .payment-options {
                grid-template-columns: 1fr;
            }

            .step-number {
                width: 40px;
                height: 40px;
                font-size: 1rem;
            }
        }
    </style>

    <?php
    $subTotal = 0;
    $subTotalMrp = 0;
    $subTotalWithTax = 0;
    $gstAmount = 0;
    ?>

    <div class="py-6 sm:py-10">
        <div class="px-3 sm:px-4 lg:container-fluid max-w-7xl mx-auto">

            <div class="bg-white rounded-lg mb-4 sm:mb-6">
                <?php include_once __DIR__ . "/includes/checkout-step.php"; ?>
            </div>

            <?php if (countData("*", "customer_cart", "customer_id = '$cookie_id' AND seller_id = '$sellerId'")) { ?>
                <form id="placeOrderForm" onkeydown="return event.key != 'Enter';" class="flex flex-col gap-6 lg:flex-row lg:gap-8">
                    <!-- Left Column - Steps with Timeline -->
                    <div class="lg:w-3/5 flex flex-col gap-6 checkout-timeline">
                        <!-- Step 1: Delivery Area -->
                        <div class="flex gap-4 step-container active" id="step-1">
                            <div class="step-number active">01</div>
                            <div class="step-content p-4 sm:p-6 bg-white rounded-2xl shadow-lg border-2 border-pink-200">
                                <h3 class="mb-2 text-xl sm:text-2xl font-semibold text-gray-800">
                                    <?= getData("delivery_area_type", "seller_settings", "seller_id = '$sellerId'") == "zip_code" ? "Check Pin Code" : "Select State" ?>
                                </h3>
                                <p class="text-sm text-gray-600 mb-4">
                                    <?= getData("delivery_area_type", "seller_settings", "seller_id = '$sellerId'") == "zip_code" ? 'Please select a pin code' : 'Please select a state' ?>
                                </p>
                                <div class="flex items-center gap-3">
                                    <select class="custom-select px-4 h-[45px] border-2 rounded-full w-full transition focus:border-primary-500 text-sm font-[400] focus:bg-gray-50 step-field"
                                        id="deliveryArea"
                                        name="delivery_area"
                                        data-step="1"
                                        <?= getData("delivery_area_type", "seller_settings", "seller_id = '$sellerId'") == "zip_code" ? 'data-pincode="true"' : null ?>>
                                        <option value="" hidden selected>
                                            <?= getData("delivery_area_type", "seller_settings", "seller_id = '$sellerId'") == "state" ? "Select State" : "Select Pin Code" ?>
                                        </option>
                                        <?php
                                        $areas = getDeliveryAreas();
                                        foreach ($areas as $key => $area) {
                                            echo '<option value="' . $area['id'] . '">' . $area['value'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <?php if (getData("delivery_area_type", "seller_settings", "seller_id = '$sellerId'") == "zip_code") : ?>
                                    <p class="mt-4 text-sm text-gray-500">
                                        You can check our delivery pin codes from here
                                        <a href="<?= $storeUrl ?>delivery-areas" class="text-primary-500 hover:underline font-medium">Delivery Areas</a>
                                    </p>
                                <?php endif ?>
                                <div id="deliveryNotes" class="mt-3"></div>
                            </div>
                        </div>

                        <!-- Step 2: Delivery Option -->
                        <div class="flex gap-4 step-container" id="step-2">
                            <div class="step-number">02</div>
                            <div class="step-content relative p-4 sm:p-6 overflow-hidden bg-white rounded-2xl shadow-lg border-2 border-gray-100">
                                <h3 class="mb-4 text-xl sm:text-2xl font-semibold text-gray-800">Delivery Option</h3>
                                <div class="flex gap-4 sm:gap-6 delivery-options">
                                    <label for="deliveryDelivery" class="cursor-pointer flex flex-col items-center">
                                        <div class="w-24 h-24 sm:w-32 sm:h-32 flex items-center justify-center bg-blue-50 rounded-xl hover:bg-blue-100 transition">
                                            <img src="<?= APP_URL ?>assets/img/delivery-truck.png" alt="Delivery" class="w-16 h-16 sm:w-20 sm:h-20">
                                        </div>
                                        <div class="flex items-center justify-center gap-2 mt-3">
                                            <input type="radio" name="delivery_option" id="deliveryDelivery" class="accent-primary-500 w-4 h-4 deliveryOption step-field" value="delivery" data-step="2" checked>
                                            <span class="text-gray-700 font-medium">Delivery</span>
                                        </div>
                                    </label>
                                    <?php if (getData("id", "seller_locations", "seller_id = '$sellerId' AND location_type = 'pickup'")) : ?>
                                        <label for="deliveryPickup" class="cursor-pointer flex flex-col items-center">
                                            <div class="w-24 h-24 sm:w-32 sm:h-32 flex items-center justify-center bg-orange-50 rounded-xl hover:bg-orange-100 transition">
                                                <img src="<?= APP_URL ?>assets/img/pickup.png" alt="Pickup" class="w-16 h-16 sm:w-20 sm:h-20">
                                            </div>
                                            <div class="flex items-center justify-center gap-2 mt-3">
                                                <input type="radio" name="delivery_option" id="deliveryPickup" class="accent-primary-500 w-4 h-4 deliveryOption step-field" value="pickup" data-step="2">
                                                <span class="text-gray-700 font-medium">Pickup</span>
                                            </div>
                                        </label>
                                    <?php endif ?>
                                </div>
                            </div>
                        </div>

                        <!-- Step 3: Address -->
                        <div class="flex gap-4 step-container" id="step-3">
                            <div class="step-number">03</div>
                            <div class="step-content">
                                <!-- Pickup Date & Time -->
                                <div class="p-4 sm:p-6 bg-white rounded-2xl shadow-lg border-2 border-gray-100 mb-4" id="pickupDateAndTime" style="display: none;">
                                    <h3 class="mb-4 text-xl sm:text-2xl font-semibold text-gray-800">Pickup Date & Time</h3>
                                    <div class="grid gap-4 sm:gap-5 sm:grid-cols-2">
                                        <div class="col-span-2">
                                            <label for="pickupPoint" class="block mb-2 text-sm font-medium text-gray-700">Pickup Point</label>
                                            <select id="pickupPoint" name="pickup_point" class="px-4 h-[45px] border-2 rounded-lg w-full transition focus:border-primary-500 text-sm font-[400] focus:bg-gray-50 step-field" data-step="3">
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
                                            <label for="pickup_days" class="block mb-2 text-sm font-medium text-gray-700">Day</label>
                                            <select id="pickup_days" name="pickup_day" class="px-4 h-[45px] border-2 rounded-lg w-full transition focus:border-primary-500 text-sm font-[400] focus:bg-gray-50 step-field" data-step="3">
                                                <option value="" hidden disabled selected>Select</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label for="pickup_times" class="block mb-2 text-sm font-medium text-gray-700">Time</label>
                                            <select id="pickup_times" name="pickup_time" class="px-4 h-[45px] border-2 rounded-lg w-full transition focus:border-primary-500 text-sm font-[400] focus:bg-gray-50 step-field" data-step="3">
                                                <option value="" hidden disabled selected>Select</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div id="pickupLocations"></div>
                                </div>

                                <!-- Delivery Address -->
                                <div class="p-4 sm:p-6 bg-white rounded-2xl shadow-lg border-2 border-gray-100" id="deliveryAddress">
                                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4 gap-2">
                                        <h3 class="text-xl sm:text-2xl font-semibold text-gray-800">Delivery Address</h3>
                                        <button class="underline addAddressToggle text-primary-500 font-medium hover:text-primary-600 transition" type="button">Add Address</button>
                                    </div>
                                    <div class="grid gap-4 lg:grid-cols-2 shippingAddressList">
                                        <!-- Address cards will be loaded here -->
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Step 4: Billing Address -->
                        <div class="flex gap-4 step-container" id="step-4">
                            <div class="step-number">04</div>
                            <div class="step-content p-4 sm:p-6 bg-white rounded-2xl shadow-lg border-2 border-gray-100">
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4 gap-2">
                                    <h3 class="text-xl sm:text-2xl font-semibold text-gray-800">Billing Address</h3>
                                    <button class="underline addAddressToggle text-primary-500 font-medium hover:text-primary-600 transition" type="button">Add Address</button>
                                </div>
                                <div class="grid gap-4 lg:grid-cols-2 billingAddressList">
                                    <!-- Billing address cards will be loaded here -->
                                </div>
                            </div>
                        </div>

                        <!-- Step 5: Payment Method -->
                        <div class="flex gap-4 step-container" id="step-5">
                            <div class="step-number">05</div>
                            <div class="step-content p-4 sm:p-6 bg-white rounded-2xl shadow-lg border-2 border-gray-100">
                                <h3 class="mb-4 text-xl sm:text-2xl font-semibold text-gray-800">Payment Method</h3>
                                <div class="grid grid-cols-1 space-y-4 payment-options">
                                    <?php if (!empty(getSettings("cod")) && plan("payment_cod")) : ?>
                                        <label for="paymentCOD" class="flex items-center gap-3 p-4 bg-red-50 rounded-2xl cursor-pointer hover:bg-red-100 transition border-2 border-transparent hover:border-red-200">
                                            <input type="radio" name="payment_method" id="paymentCOD" class="accent-red-500 w-4 h-4 paymentMethod step-field" value="COD" data-step="5">
                                            <div class="flex items-center gap-3">
                                                <img src="<?= APP_URL ?>assets/img/cod.png" alt="COD" class="w-8 h-8">
                                                <div>
                                                    <h3 class="font-semibold text-gray-800">Cash On Delivery (COD)</h3>
                                                    <?php if (getSettings("cod_charges")): ?>
                                                        <p class="text-sm text-gray-600">Extra <?= currencyToSymbol($storeCurrency) . getSettings("cod_charges") ?> charges for COD</p>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </label>
                                    <?php endif ?>

                                    <?php if (!empty(getSettings("razorpay_key_id")) && plan("payment_razorpay")) : ?>
                                        <label for="paymentRazorpay" class="flex items-center gap-3 p-4 bg-indigo-50 rounded-2xl cursor-pointer hover:bg-indigo-100 transition border-2 border-transparent hover:border-indigo-200">
                                            <input type="radio" name="payment_method" id="paymentRazorpay" class="accent-indigo-500 w-4 h-4 paymentMethod step-field" value="Razorpay" data-step="5">
                                            <div class="flex items-center gap-3">
                                                <img src="<?= APP_URL ?>assets/img/razorpay.png" alt="Razorpay" class="w-8 h-8">
                                                <h3 class="font-semibold text-gray-800">Razorpay</h3>
                                            </div>
                                        </label>
                                    <?php endif ?>

                                    <?php if (!empty(getSettings("phonepe_key")) && plan("payment_phonepe")) : ?>
                                        <label for="paymentPhonePe" class="flex items-center gap-3 p-4 bg-purple-50 rounded-2xl cursor-pointer hover:bg-purple-100 transition border-2 border-transparent hover:border-purple-200">
                                            <input type="radio" name="payment_method" id="paymentPhonePe" class="accent-purple-500 w-4 h-4 paymentMethod step-field" value="PhonePe" data-step="5">
                                            <div class="flex items-center gap-3">
                                                <img src="<?= APP_URL ?>assets/img/phonepe.png" alt="PhonePe" class="w-8 h-8">
                                                <h3 class="font-semibold text-gray-800">PhonePe</h3>
                                            </div>
                                        </label>
                                    <?php endif ?>

                                    <?php if (!empty(getSettings("ippo_pay_public_key")) && plan("payment_ippopay")) : ?>
                                        <label for="paymentIppoPay" class="flex items-center gap-3 p-4 bg-blue-50 rounded-2xl cursor-pointer hover:bg-blue-100 transition border-2 border-transparent hover:border-blue-200">
                                            <input type="radio" name="payment_method" id="paymentIppoPay" class="accent-blue-500 w-4 h-4 paymentMethod step-field" value="IppoPay" data-step="5">
                                            <div class="flex items-center gap-3">
                                                <img src="<?= APP_URL ?>assets/img/ippo-pay.png" alt="IppoPay" class="w-8 h-8">
                                                <h3 class="font-semibold text-gray-800">IppoPay</h3>
                                            </div>
                                        </label>
                                    <?php endif ?>

                                    <?php if (!empty(getSettings("bank_details")) && plan("payment_bank")) : ?>
                                        <label for="paymentBankTransfer" class="flex items-center gap-3 p-4 bg-teal-50 rounded-2xl cursor-pointer hover:bg-teal-100 transition border-2 border-transparent hover:border-teal-200">
                                            <input type="radio" name="payment_method" id="paymentBankTransfer" class="accent-teal-500 w-4 h-4 paymentMethod step-field" value="Bank Transfer" data-step="5">
                                            <div class="flex items-center gap-3">
                                                <img src="<?= APP_URL ?>assets/img/bank.png" alt="Bank Transfer" class="w-8 h-8">
                                                <h3 class="font-semibold text-gray-800">Bank Transfer</h3>
                                            </div>
                                        </label>
                                        <div id="bankDetails" class="p-5 mt-3 space-y-3 bg-teal-50 rounded-2xl" style="display:none;">
                                            <?= nl2br(getSettings("bank_details")) ?>
                                            <div class="mt-5 pt-5 border-t">
                                                <i>Please send an email to <?= getSettings("email") ?> along with the scanned bank-in slip after completing all the required particulars once the payment is made.</i>
                                                <br />
                                                Order ID :<br />
                                                Payment Method :<br />
                                                Bank Name :<br />
                                                Bank-in Date :<br />
                                                Bank-in Amount :<br />
                                                Contact Name :<br />
                                                Contact Phone
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <?php if (!empty(getSettings("upi_qr_code")) && plan("payment_upi")) : ?>
                                        <label for="paymentUPI" class="flex items-center gap-3 p-4 bg-orange-50 rounded-2xl cursor-pointer hover:bg-orange-100 transition border-2 border-transparent hover:border-orange-200">
                                            <input type="radio" name="payment_method" id="paymentUPI" class="accent-orange-500 w-4 h-4 paymentMethod step-field" value="UPI" data-step="5">
                                            <div class="flex items-center gap-3">
                                                <img src="<?= APP_URL ?>assets/img/upi.webp" alt="UPI" class="w-8 h-8">
                                                <h3 class="font-semibold text-gray-800">UPI (Scan QR Code or Pay to UPI ID)</h3>
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

                        <!-- Step 6: Notes -->
                        <div class="flex gap-4 step-container" id="step-6">
                            <div class="step-number">06</div>
                            <div class="step-content p-4 sm:p-6 bg-white rounded-2xl shadow-lg border-2 border-gray-100">
                                <label for="notes" class="block mb-3 font-semibold text-gray-700">Additional Notes</label>
                                <textarea name="notes" id="notes" rows="4" class="bg-gray-50 rounded-xl p-4 w-full font-medium border-2 border-gray-200 focus:border-primary-500 focus:bg-white transition step-field" placeholder="Any special instructions for your order..." data-step="6"></textarea>
                            </div>
                        </div>

                        <!-- Step 7: Customized Gift (if enabled) -->
                        <?php if (getSettings("customized_gift")) : ?>
                            <div class="flex gap-4 step-container" id="step-7">
                                <div class="step-number">07</div>
                                <div class="step-content p-4 sm:p-6 bg-white rounded-2xl shadow-lg border-2 border-gray-100">
                                    <h4 class="text-xl font-semibold text-gray-800 mb-4">Customized Gift <sup class="text-gray-500">(optional)</sup></h4>
                                    <div class="grid gap-4">
                                        <div>
                                            <label for="customized_gift_images" class="block mb-2 font-medium text-gray-700">Images</label>
                                            <input type="file" name="customized_gift_images[]" id="customized_gift_images" class="bg-gray-50 rounded-xl p-4 w-full font-medium border-2 border-gray-200 step-field" accept="image/*" max="3" multiple data-step="7">
                                            <small class="text-gray-500 block mt-2">You can only select a maximum of 3 images.</small>
                                        </div>
                                        <div>
                                            <label for="customized_gift_notes" class="block mb-2 font-medium text-gray-700">Details</label>
                                            <textarea name="customized_gift_notes" id="customized_gift_notes" rows="4" class="bg-gray-50 rounded-xl p-4 w-full font-medium border-2 border-gray-200 focus:border-primary-500 focus:bg-white transition step-field" placeholder="Enter gift customization details..." data-step="7"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif ?>
                    </div>

                    <!-- Right Column - Order Summary -->
                    <div class="lg:w-2/5 flex flex-col gap-6">
                        <!-- Promo Code Section -->
                        <div class="bg-white border border-gray-200 rounded-2xl p-4 sm:p-6 shadow-lg">
                            <label class="block text-gray-800 mb-3 font-semibold text-lg">Have a promo code?</label>
                            <div class="flex items-center gap-2 flex-nowrap mb-3">
                                <input type="text" id="couponCode" placeholder="Enter code"
                                    class="flex-1 min-w-0 px-4 py-3 border-2 border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-pink-400 focus:border-pink-400 focus:outline-none transition">
                                <button id="applyCoupon" type="button"
                                    class="px-6 py-3 bg-pink-500 text-white text-sm font-semibold rounded-xl hover:bg-pink-600 transition shadow-lg hover:shadow-xl">
                                    Apply
                                </button>
                            </div>
                            <p class="text-sm text-gray-600 font-medium mb-3">Click a coupon below to automatically apply</p>
                            <div class="flex flex-wrap gap-2 couponSuggestions">
                                <?php
                                $discounts = getDiscounts();
                                foreach ($discounts as $discount):
                                ?>
                                    <span class="flex items-center gap-1.5 bg-pink-50 text-pink-600 text-xs font-semibold px-3 py-2 rounded-full border border-pink-200 copyCoupon hover:bg-pink-100 transition cursor-pointer"
                                        data-code="<?= htmlspecialchars($discount['code']) ?>">
                                        <span class="w-2 h-2 rounded-full bg-pink-500 shadow-[0_0_8px_rgba(236,72,153,0.7)] animate-pulse glowDot"></span>
                                        <?= htmlspecialchars($discount['code']) ?>
                                    </span>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <!-- GST Number -->
                        <div class="p-4 sm:p-6 bg-white rounded-2xl shadow-lg">
                            <label for="gst_number" class="block mb-3 font-semibold text-gray-700">Display my GSTIN number on invoice</label>
                            <input type="text" id="gst_number" name="gst_number" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-primary-500 focus:bg-white transition text-sm">
                        </div>

                        <!-- Order Summary -->
                        <div class="p-4 sm:p-6 bg-white rounded-2xl shadow-lg">
                            <h3 class="pb-4 mb-6 text-xl sm:text-2xl font-semibold border-b border-gray-200 text-gray-800">Order Summary</h3>

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
                                        $color = $color ? getData("color_name", "product_colors", "id = '$color'") : '';
                                        if (!$variation && $size) {
                                            $variation = "Size: $size" . ($color ? " | Color: $color" : "");
                                        }
                                        $image = getData("image", "seller_products", "id = '{$cart['product_id']}'");
                                        if ($cart['other'] && getData("image", "seller_product_variants", "id = '{$cart['other']}'")) {
                                            $image = getData("image", "seller_product_variants", "id = '{$cart['other']}'");
                                        }
                                        if ($cart['advanced_variant'] && getData("image", "seller_product_advanced_variants", "id = '{$cart['advanced_variant']}'")) {
                                            $image = getData("image", "seller_product_advanced_variants", "id = '{$cart['advanced_variant']}'");
                                        }

                                        // // Fix for stock variables
                                        // $unit = (int)getData("unit", "seller_products", "id = '{$cart['product_id']}'");
                                        // if ($cart['other'] && (int)getData("unit", "seller_product_variants", "id = '{$cart['other']}'")) {
                                        //     $unit = (int)getData("unit", "seller_product_variants", "id = '{$cart['other']}'");
                                        // }

                                        // $stock_unit = getData("stock_unit", "seller_products", "id = '{$cart['product_id']}'");
                                        // $total_stocks = (int)$cart['quantity'] * $unit;

                                        // if (!$stock_unit) {
                                        //     $stock_unit = getData("unit_type", "seller_products", "id = '{$cart['product_id']}'") ?: 'pcs';
                                        // }

                                        // // Unit conversion if needed
                                        // if ($stock_unit == "kg" || $stock_unit == "litre") {
                                        //     $total_stocks /= 1000;
                                        // } else if ($stock_unit == "meter") {
                                        //     $total_stocks *= 0.3048;
                                        // }

                                        // // // Ensure variables have default values
                                        // // $total_stocks = $total_stocks ?? 0;
                                        // // $stock_unit = $stock_unit ?? 'pcs';
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
                                                <!-- <span><? //= $total_stocks . " " . $stock_unit 
                                                            ?></span> -->
                                                <span><?= currencyToSymbol($storeCurrency) . number_format((int)$cart['price'] * $cart['quantity'], 2) ?></span>
                                            </div>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>

                            <!-- Scroll Buttons -->
                            <div class="flex justify-end gap-3 mb-6">
                                <button id="scrollLeftBtn" type="button"
                                    class="w-10 h-10 rounded-full shadow-lg flex items-center justify-center bg-primary-500 text-white hover:bg-primary-600 transition transform hover:scale-105">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                    </svg>
                                </button>
                                <button id="scrollRightBtn" type="button"
                                    class="w-10 h-10 rounded-full shadow-lg flex items-center justify-center bg-primary-500 text-white hover:bg-primary-600 transition transform hover:scale-105">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </button>
                            </div>

                            <!-- Totals Section -->
                            <div class="pt-4 border-t space-y-3">
                                <div class="flex justify-between text-gray-600">
                                    <span>Subtotal</span>
                                    <span id="subTotal" class="font-semibold"><?= currencyToSymbol($storeCurrency) . number_format($subTotal, 2) ?></span>
                                </div>
                                <div class="flex justify-between text-gray-600">
                                    <span>Discount</span>
                                    <span id="discount" class="font-semibold">0.00</span>
                                </div>
                                <div class="flex justify-between text-gray-600 <?= getSettings("gst_tax_type") == "inclusive" || !getSettings("gst_number") ? 'hidden' : '' ?>">
                                    <span>GST Tax Amount</span>
                                    <span id="gstTax" class="font-semibold"><?= currencyToSymbol($gstAmount) ?></span>
                                </div>
                                <div class="flex justify-between text-gray-600">
                                    <span>Charges</span>
                                    <span id="charges" class="font-semibold">0.00</span>
                                </div>
                            </div>

                            <div class="flex justify-between mt-4 pt-4 border-t font-bold text-lg text-emerald-600">
                                <span>Total (<?= $storeCurrency ?>)</span>
                                <span id="total"><?= currencyToSymbol($subTotalWithTax) ?></span>
                            </div>

                            <!-- Place Order Button -->
                            <div class="mt-6">
                                <?php
                                $minimumOrder = getSettings("minimum_order_amount");
                                if (!empty($minimumOrder) && $subTotal < $minimumOrder): ?>
                                    <div class="py-3 px-4 rounded-xl text-center bg-gradient-to-r from-pink-50 to-pink-100 border border-pink-200 shadow-sm">
                                        <p class="text-pink-700 font-semibold text-sm">
                                            Minimum order is
                                            <span class="font-bold text-pink-600">
                                                <?= currencyToSymbol($storeCurrency) . number_format($minimumOrder, 2) ?>
                                            </span>
                                        </p>
                                    </div>
                                <?php else: ?>
                                    <button id="payBtn" type="submit"
                                        class="w-full py-4 rounded-xl font-bold text-white bg-gradient-to-r from-pink-400 to-pink-600 hover:from-pink-500 hover:to-pink-700 shadow-lg hover:shadow-xl transition transform hover:scale-105 text-lg">
                                        Place Order
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Add Address Modal -->
                <div id="addAddressModal" class="fixed top-0 left-0 flex items-center justify-center hidden w-full h-full transition opacity-0 bg-black/80">
                    <!-- Your existing modal code remains the same -->
                    <div class="p-5 bg-white rounded-xl max-w-[750px] w-full shadow">
                        <!-- ... modal content ... -->
                    </div>
                </div>
            <?php } else { ?>
                <!-- Empty cart state -->
                <div class="p-6 sm:p-8 w-full text-center bg-white rounded-2xl shadow-lg">
                    <img alt="" src="<?= APP_URL ?>assets/img/empty-bag.svg" width="200" height="120" class="mx-auto">
                    <h3 class="text-xl sm:text-2xl font-bold text-gray-800 mt-6">Your bag is empty</h3>
                    <p class="text-gray-500 text-sm sm:text-base mt-3">Looks like you haven't made your choice yet.</p>
                    <a href="<?= $storeUrl ?>" class="mt-6 inline-flex items-center px-6 py-3 bg-primary-500 hover:bg-rose-600 text-white font-semibold rounded-full transition transform hover:scale-105 shadow-lg">
                        <i class="fa-solid fa-shop mr-2"></i> Go to Shop
                    </a>
                </div>
            <?php } ?>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>

    <script>
        // Step activation logic
        document.querySelectorAll('.step-field').forEach(field => {
            field.addEventListener('focus', function() {
                const step = this.dataset.step;

                // Remove active class from all steps
                document.querySelectorAll('.step-container').forEach(container => {
                    container.classList.remove('active');
                });
                document.querySelectorAll('.step-number').forEach(number => {
                    number.classList.remove('active');
                });

                // Add active class to current step
                const currentStep = document.getElementById(`step-${step}`);
                const currentNumber = currentStep.querySelector('.step-number');

                if (currentStep && currentNumber) {
                    currentStep.classList.add('active');
                    currentNumber.classList.add('active');
                }

                // Mark all previous steps as completed ONLY if they have user interaction
                markPreviousStepsAsCompleted(step);
            });

            // Mark step as completed only when user actually interacts
            field.addEventListener('input', function() {
                const step = this.dataset.step;
                // Mark this specific step as completed since user interacted with it
                const currentStepNumber = document.querySelector(`#step-${step} .step-number`);
                if (currentStepNumber && this.value && this.value.trim() !== '') {
                    currentStepNumber.classList.add('completed');
                }
                markPreviousStepsAsCompleted(step);
            });

            field.addEventListener('change', function() {
                const step = this.dataset.step;
                // Mark this specific step as completed since user made a selection
                const currentStepNumber = document.querySelector(`#step-${step} .step-number`);
                if (currentStepNumber) {
                    currentStepNumber.classList.add('completed');
                }
                markPreviousStepsAsCompleted(step);
            });
        });

        // Special handler for radio buttons (Steps 2 and 5)
        document.querySelectorAll('input[type="radio"]').forEach(radio => {
            radio.addEventListener('change', function() {
                // Find which step this radio belongs to
                const stepField = this.closest('.step-field');
                if (stepField) {
                    const step = stepField.dataset.step;
                    const stepNumber = document.querySelector(`#step-${step} .step-number`);
                    if (stepNumber) {
                        stepNumber.classList.add('completed');
                    }
                    markPreviousStepsAsCompleted(parseInt(step) + 1);
                } else {
                    // If no step-field class, check parent containers
                    const stepContainer = this.closest('[id^="step-"]');
                    if (stepContainer) {
                        const step = stepContainer.id.split('-')[1];
                        const stepNumber = document.querySelector(`#step-${step} .step-number`);
                        if (stepNumber) {
                            stepNumber.classList.add('completed');
                        }
                        markPreviousStepsAsCompleted(parseInt(step) + 1);
                    }
                }
            });
        });

        // Function to mark previous steps as completed (only those with user interaction)
        function markPreviousStepsAsCompleted(currentStep) {
            document.querySelectorAll('.step-number').forEach(number => {
                const stepContainer = number.closest('.step-container');
                const stepId = stepContainer.id;
                const stepNumber = stepId.split('-')[1];

                // Only mark as completed if it's a previous step AND has user interaction
                if (stepNumber < currentStep) {
                    // Check if this step has any filled fields
                    const hasInteraction = checkStepInteraction(stepNumber);
                    if (hasInteraction) {
                        number.classList.add('completed');
                    }
                    number.classList.remove('active');
                } else if (stepNumber == currentStep) {
                    number.classList.add('active');
                    number.classList.remove('completed');
                } else {
                    number.classList.remove('active', 'completed');
                }
            });
        }

        // Check if a step has any user interaction (filled fields)
        function checkStepInteraction(stepNumber) {
            const stepFields = document.querySelectorAll(`.step-field[data-step="${stepNumber}"]`);
            let hasInteraction = false;

            stepFields.forEach(field => {
                if (field.type === 'radio' || field.type === 'checkbox') {
                    if (field.checked) {
                        hasInteraction = true;
                    }
                } else if (field.value && field.value.trim() !== '') {
                    hasInteraction = true;
                }
            });

            // Also check for radio buttons without step-field class
            if (!hasInteraction) {
                const stepContainer = document.getElementById(`step-${stepNumber}`);
                const radios = stepContainer.querySelectorAll('input[type="radio"]:checked');
                if (radios.length > 0) {
                    hasInteraction = true;
                }
            }

            return hasInteraction;
        }

        // Form submission handler to mark all steps as completed
        document.getElementById('placeOrderForm')?.addEventListener('submit', function(e) {
            // Mark all steps as completed when form is submitted
            document.querySelectorAll('.step-number').forEach(number => {
                number.classList.add('completed');
                number.classList.remove('active');
            });
        });

        // Scroll functionality
        const scrollContainer = document.getElementById('productScroll');
        const scrollLeftBtn = document.getElementById('scrollLeftBtn');
        const scrollRightBtn = document.getElementById('scrollRightBtn');

        if (scrollLeftBtn && scrollRightBtn) {
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
        }

        // Coupon copy functionality
        document.querySelectorAll('.copyCoupon').forEach(el => {
            el.addEventListener('click', function() {
                const code = this.dataset.code;
                const input = document.getElementById('couponCode');
                const applyBtn = document.getElementById('applyCoupon');

                input.value = code;
                applyBtn.classList.add('shadow-[0_0_12px_rgba(236,72,153,0.8)]');
                setTimeout(() => {
                    applyBtn.classList.remove('shadow-[0_0_12px_rgba(236,72,153,0.8)]');
                }, 1000);
            });
        });

        // Initialize first step as active ONLY - no green on load
        document.addEventListener('DOMContentLoaded', function() {
            const firstStep = document.getElementById('step-1');
            const firstNumber = firstStep.querySelector('.step-number');
            firstStep.classList.add('active');
            firstNumber.classList.add('active');

            // Remove any completed classes that might be there by default
            document.querySelectorAll('.step-number').forEach(number => {
                number.classList.remove('completed');
            });

            // Check if any radio buttons are pre-selected and mark steps as completed
            checkPreSelectedRadios();
        });

        // Function to check for pre-selected radio buttons
        function checkPreSelectedRadios() {
            // Check Step 2 (Delivery Option) - "delivery" is pre-checked
            const deliveryChecked = document.querySelector('input[name="delivery_option"]:checked');
            if (deliveryChecked) {
                const step2Number = document.querySelector('#step-2 .step-number');
                if (step2Number) {
                    step2Number.classList.add('completed');
                }
            }

            // You can add similar checks for other pre-selected radios if needed
        }
    </script>

    <!--Footer File Includes that file has all JS Files includes links-->
    <?php include_once __DIR__ . "/includes/footer.php"; ?>

</body>

</html>