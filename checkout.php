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
        <?php
        $primary_color = getData("color", "seller_settings", "(seller_id='$sellerId' AND store_id='$storeId')") ?? '#ff007f';
        $hover_color = getData("hover_color", "seller_settings", "(seller_id='$sellerId' AND store_id='$storeId')") ?? '#ec4899';
        ?>
        <div class="w-full text-white text-center py-1.5 sm:py-2 md:py-2.5 lg:py-2 text-sm sm:text-base md:text-lg lg:text-base font-semibold transition-all duration-500 ease-out cursor-pointer"
            style="background: linear-gradient(90deg, color-mix(in srgb, <?= htmlspecialchars($primary_color) ?> 95%, transparent) 0%, color-mix(in srgb, <?= htmlspecialchars($hover_color) ?> 90%, transparent) 100%);"
            onmouseover="this.style.background='linear-gradient(90deg, color-mix(in srgb, <?= htmlspecialchars($hover_color) ?> 98%, transparent) 0%, color-mix(in srgb, <?= htmlspecialchars($primary_color) ?> 95%, transparent) 100%)'; this.style.transform='scale(1.01) translateY(-1px)'; this.style.boxShadow='0 4px 12px rgba(0,0,0,0.15)';"
            onmouseout="this.style.background='linear-gradient(90deg, color-mix(in srgb, <?= htmlspecialchars($primary_color) ?> 95%, transparent) 0%, color-mix(in srgb, <?= htmlspecialchars($hover_color) ?> 90%, transparent) 100%)'; this.style.transform='scale(1) translateY(0)'; this.style.boxShadow='none';">
            Minimum Order: <?= currencyToSymbol($storeCurrency) . ' ' . getSettings("minimum_order_amount") ?>
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
            z-index: 0;
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

        /*<----------- Style For Gif Images Preview -------------->*/
        /* Image Upload Styles */
        .image-upload-item {
            transition: all 0.3s ease;
        }

        .image-upload-item.fade-out {
            opacity: 0;
            transform: translateY(-10px);
            height: 0;
            margin: 0;
            padding: 0;
            overflow: hidden;
        }

        /* Uploaded Images Preview Container - No flex, no grid */
        #uploadedImagesPreview {
            min-height: 100px;
            padding: 12px;
            background: #f8fafc;
            border-radius: 12px;
            border: 2px dashed #e2e8f0;
            overflow: hidden;
            width: 100%;
            display: block;
        }

        /* Clearfix for floated elements */
        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }

        /* Uploaded image items - floated with fixed width */
        .uploaded-image-item {
            position: relative;
            width: 80px;
            height: 80px;
            border-radius: 8px;
            overflow: hidden;
            border: 2px solid #e5e7eb;
            transition: all 0.3s ease;
            float: left;
            margin: 0 8px 8px 0;
        }

        .uploaded-image-item:hover {
            transform: scale(1.05);
            border-color: #ec4899;
            box-shadow: 0 4px 12px rgba(236, 72, 153, 0.2);
        }

        .uploaded-image-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .remove-uploaded-image {
            position: absolute;
            top: -6px;
            right: -6px;
            background: #ef4444;
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            cursor: pointer;
            border: 2px solid white;
            opacity: 0;
            transition: opacity 0.3s ease;
            z-index: 10;
        }

        .uploaded-image-item:hover .remove-uploaded-image {
            opacity: 1;
        }

        .upload-count {
            background: #ec4899;
            color: white;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 12px;
            margin-left: 10px;
        }

        .hidden {
            display: none;
        }

        /* Success message styling */
        .success-message {
            background: #10b981;
            color: white;
            padding: 8px 12px;
            border-radius: 8px;
            margin-top: 8px;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 6px;
            animation: fadeIn 0.5s ease;
            clear: both;
        }

        .success-message.hidden {
            display: none;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Empty state styling */
        #uploadedImagesPreview:empty::before {
            content: "No images uploaded yet";
            color: #94a3b8;
            font-size: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100px;
            font-style: italic;
        }

        /* Responsive adjustments */
        @media (max-width: 640px) {
            #uploadedImagesPreview {
                min-height: 90px;
                padding: 10px;
            }

            .uploaded-image-item {
                width: 70px;
                height: 70px;
                margin: 0 6px 6px 0;
            }

            .remove-uploaded-image {
                width: 18px;
                height: 18px;
                font-size: 10px;
                top: -5px;
                right: -5px;
            }

            .success-message {
                font-size: 13px;
                padding: 6px 10px;
            }
        }

        /* Touch device improvements */
        @media (hover: none) {
            .uploaded-image-item .remove-uploaded-image {
                opacity: 1;
                background: rgba(239, 68, 68, 0.9);
            }

            .uploaded-image-item:hover {
                transform: none;
            }
        }

        /* Custom toastr colors to match theme */
        .toast-success {
            background-color: <?= htmlspecialchars(getData('color', 'seller_settings', "(seller_id='$sellerId' AND store_id='$storeId')") ?? '#ff007f') ?> !important;
            border-color: <?= htmlspecialchars(getData('color', 'seller_settings', "(seller_id='$sellerId' AND store_id='$storeId')") ?? '#ff007f') ?> !important;
        }

        .toast-info {
            background-color: <?= htmlspecialchars(getData('hover_color', 'seller_settings', "(seller_id='$sellerId' AND store_id='$storeId')") ?? '#ec4899') ?> !important;
            border-color: <?= htmlspecialchars(getData('hover_color', 'seller_settings', "(seller_id='$sellerId' AND store_id='$storeId')") ?? '#ec4899') ?> !important;
        }

        .toast-success .toast-close-button,
        .toast-info .toast-close-button {
            color: white !important;
            opacity: 0.8;
        }

        .toast-success .toast-close-button:hover,
        .toast-info .toast-close-button:hover {
            opacity: 1;
            color: white !important;
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

            <?php if (countData("*", "customer_cart", "customer_id = '$cookie_id' AND (seller_id = '$sellerId' AND store_id = '$storeId')")) { ?>
                <form id="placeOrderForm" onkeydown="return event.key != 'Enter';" class="flex flex-col gap-6 lg:flex-row lg:gap-8">
                    <!-- Left Column - Steps with Timeline -->
                    <div class="lg:w-3/5 flex flex-col gap-6 checkout-timeline">
                        <!-- Step 1: Delivery Area -->
                        <div class="flex gap-4 step-container active" id="step-1">
                            <div class="step-number active">01</div>
                            <div class="step-content p-4 sm:p-6 bg-white rounded-2xl shadow-lg border-2 border-pink-200">
                                <h3 class="mb-2 text-xl sm:text-2xl font-semibold text-gray-800">
                                    <?= getData("delivery_area_type", "seller_settings", "(seller_id = '$sellerId' AND store_id = '$storeId')") == "zip_code" ? "Check Pin Code" : "Select State" ?>
                                </h3>
                                <p class="text-sm text-gray-600 mb-4">
                                    <?= getData("delivery_area_type", "seller_settings", "(seller_id = '$sellerId' AND store_id = '$storeId')") == "zip_code" ? 'Please select a pin code' : 'Please select a state' ?>
                                </p>
                                <div class="flex items-center gap-3">
                                    <select class="custom-select px-4 h-[45px] border-2 rounded-full w-full transition focus:border-primary-500 text-sm font-[400] focus:bg-gray-50 step-field"
                                        id="deliveryArea"
                                        name="delivery_area"
                                        data-step="1"
                                        <?= getData("delivery_area_type", "seller_settings", "(seller_id = '$sellerId' AND store_id = '$storeId')") == "zip_code" ? 'data-pincode="true"' : null ?>>
                                        <option value="" hidden selected>
                                            <?= getData("delivery_area_type", "seller_settings", "(seller_id = '$sellerId' AND store_id = '$storeId')") == "state" ? "Select State" : "Select Pin Code" ?>
                                        </option>
                                        <?php
                                        $areas = getDeliveryAreas();
                                        foreach ($areas as $key => $area) {
                                            echo '<option value="' . $area['id'] . '">' . $area['value'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <?php if (getData("delivery_area_type", "seller_settings", "(seller_id = '$sellerId' AND store_id = '$storeId')") == "zip_code") : ?>
                                    <p class="mt-4 text-sm text-gray-500">
                                        You can check our delivery pin codes from here
                                        <a href="<?= $storeUrl ?>delivery-areas" class="text-hover hover:underline font-medium">Delivery Areas</a>
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
                                    <?php if (getData("id", "seller_locations", "(seller_id = '$sellerId' AND store_id = '$storeId') AND location_type = 'pickup'")) : ?>
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

                        <script>
                            document.addEventListener('DOMContentLoaded', () => {
                                // Clear any checked radios in this group
                                document.querySelectorAll('input[name="delivery_option"]').forEach(r => {
                                    r.checked = false;
                                    r.removeAttribute('checked'); // remove markup-level attribute too
                                });

                            });
                        </script>

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
                                    <div class="mb-4 p-3 bg-blue-50 rounded-lg border border-blue-200">
                                        <p class="text-sm text-blue-700 flex items-center gap-2">
                                            <i class="bx bx-info-circle text-blue-500"></i>
                                            Selecting a delivery address will automatically set the same address for billing
                                        </p>
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
                                <div class="mb-4 p-3 bg-yellow-50 rounded-lg border border-yellow-200">
                                    <p class="text-sm text-yellow-700 flex items-center gap-2">
                                        <i class="bx bx-info-circle text-yellow-500"></i>
                                        Same as delivery address by default. You can select a different billing address if needed.
                                    </p>
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

                                <!-- PAYMENT OPTIONS -->
                                <div class="flex flex-col gap-3" id="paymentOptions">

                                    <?php if (!empty(getSettings("cod")) && plan("payment_cod")) : ?>
                                        <label for="paymentCOD" class="flex items-center gap-3 p-4 bg-red-50 rounded-xl cursor-pointer hover:bg-red-100 transition border-2 border-transparent hover:border-red-200">
                                            <input type="radio" name="payment_method" id="paymentCOD" class="accent-red-500 w-5 h-5 paymentMethod step-field" value="COD" data-step="5">
                                            <img src="<?= APP_URL ?>assets/img/cod.png" alt="COD" class="w-8 h-8 flex-shrink-0">
                                            <div>
                                                <h3 class="font-semibold text-gray-800 leading-tight">Cash On Delivery (COD)</h3>
                                                <?php if (getSettings("cod_charges")): ?>
                                                    <p class="text-sm text-gray-600">Extra <?= currencyToSymbol($storeCurrency) . getSettings("cod_charges") ?> charges</p>
                                                <?php endif; ?>
                                            </div>
                                        </label>
                                    <?php endif ?>

                                    <?php if (!empty(getSettings("razorpay_key_id")) && plan("payment_razorpay")) : ?>
                                        <label for="paymentRazorpay" class="flex items-center gap-3 p-4 bg-indigo-50 rounded-xl cursor-pointer hover:bg-indigo-100 transition border-2 border-transparent hover:border-indigo-200">
                                            <input type="radio" name="payment_method" id="paymentRazorpay" class="accent-indigo-500 w-5 h-5 paymentMethod step-field" value="Razorpay" data-step="5">
                                            <img src="<?= APP_URL ?>assets/img/razorpay.png" alt="Razorpay" class="w-8 h-8 flex-shrink-0">
                                            <h3 class="font-semibold text-gray-800 leading-tight">Razorpay</h3>
                                        </label>
                                    <?php endif ?>

                                    <?php if ((!empty(getSettings("phonepe_key")) || !empty(getSettings("phonepe_client_id"))) && plan("payment_phonepe")) : ?>
                                        <label for="paymentPhonePe" class="flex items-center gap-3 p-4 bg-purple-50 rounded-xl cursor-pointer hover:bg-purple-100 transition border-2 border-transparent hover:border-purple-200">
                                            <input type="radio" name="payment_method" id="paymentPhonePe" class="accent-purple-500 w-5 h-5 paymentMethod step-field" value="PhonePe" data-step="5">
                                            <img src="<?= APP_URL ?>assets/img/phonepe.png" alt="PhonePe" class="w-8 h-8 flex-shrink-0">
                                            <h3 class="font-semibold text-gray-800 leading-tight">PhonePe</h3>
                                        </label>
                                    <?php endif ?>

                                    <?php if (!empty(getSettings("ippo_pay_public_key")) && plan("payment_ippopay")) : ?>
                                        <label for="paymentIppoPay" class="flex items-center gap-3 p-4 bg-blue-50 rounded-xl cursor-pointer hover:bg-blue-100 transition border-2 border-transparent hover:border-blue-200">
                                            <input type="radio" name="payment_method" id="paymentIppoPay" class="accent-blue-500 w-5 h-5 paymentMethod step-field" value="IppoPay" data-step="5">
                                            <img src="<?= APP_URL ?>assets/img/ippo-pay.png" alt="IppoPay" class="w-8 h-8 flex-shrink-0">
                                            <h3 class="font-semibold text-gray-800 leading-tight">IppoPay</h3>
                                        </label>
                                    <?php endif ?>

                                    <?php if (!empty(getSettings("bank_details")) && plan("payment_bank")) : ?>
                                        <label for="paymentBankTransfer" class="flex items-center gap-3 p-4 bg-teal-50 rounded-xl cursor-pointer hover:bg-teal-100 transition border-2 border-transparent hover:border-teal-200">
                                            <input type="radio" name="payment_method" id="paymentBankTransfer" class="accent-teal-500 w-5 h-5 paymentMethod step-field" value="Bank Transfer" data-step="5">
                                            <img src="<?= APP_URL ?>assets/img/bank.png" alt="Bank Transfer" class="w-8 h-8 flex-shrink-0">
                                            <h3 class="font-semibold text-gray-800 leading-tight">Bank Transfer</h3>
                                        </label>
                                    <?php endif; ?>

                                    <?php if (!empty(getSettings("upi_qr_code")) && plan("payment_upi")) : ?>
                                        <label for="paymentUPI" class="flex items-center gap-3 p-4 bg-orange-50 rounded-xl cursor-pointer hover:bg-orange-100 transition border-2 border-transparent hover:border-orange-200">
                                            <input type="radio" name="payment_method" id="paymentUPI" class="accent-orange-500 w-5 h-5 paymentMethod step-field" value="UPI" data-step="5">
                                            <img src="<?= APP_URL ?>assets/img/upi.webp" alt="UPI" class="w-8 h-8 flex-shrink-0">
                                            <h3 class="font-semibold text-gray-800 leading-tight">UPI (Scan QR / Pay to UPI ID)</h3>
                                        </label>
                                    <?php endif; ?>
                                </div>

                                <!-- EXTRA PAYMENT DETAILS -->
                                <div id="extraPaymentDetails" class="mt-4 space-y-4">

                                    <?php if (!empty(getSettings("bank_details")) && plan("payment_bank")) : ?>
                                        <div id="bankDetails" class="p-5 bg-teal-50 rounded-2xl border border-teal-200" style="display:none;">
                                            <?= nl2br(getSettings("bank_details")) ?>
                                            <div class="mt-5 pt-4 border-t text-sm text-gray-700 leading-relaxed">
                                                <i>Please email <?= getSettings("email") ?> with your bank slip once payment is made.</i>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <?php if (!empty(getSettings("upi_qr_code")) && plan("payment_upi")) : ?>
                                        <div id="upiImg" class="p-5 sm:p-6 bg-orange-50 rounded-2xl border border-orange-200 shadow-sm" style="display:none;">
                                            <h4 class="text-lg font-semibold text-gray-800 mb-3 flex items-center gap-2">
                                                <i class='bx bx-credit-card text-orange-500 text-xl'></i> Pay via UPI
                                            </h4>

                                            <div class="flex flex-col sm:flex-row sm:items-center gap-3 mb-5">
                                                <div class="flex-1">
                                                    <p class="text-sm text-gray-600 mb-2">Copy UPI ID and pay using any app</p>
                                                    <div class="flex items-center gap-2 p-3 bg-gray-50 rounded-lg border border-gray-200">
                                                        <span class="text-base sm:text-lg font-semibold text-primary-600 flex-1 truncate"><?= getSettings("upi_id") ?></span>
                                                        <button type="button"
                                                            onclick="copyUPIID(this, &quot;<?= getSettings('upi_id') ?>&quot;)"
                                                            class="px-3 py-2 bg-primary-500 text-white text-sm font-medium rounded-lg hover:bg-primary-600 transition flex items-center gap-2">
                                                            <i class='bx bx-copy text-sm'></i> Copy
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="p-4 bg-white rounded-xl border border-orange-100 shadow-sm">
                                                <h4 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                                                    <i class='bx bx-qr-scan text-orange-500 text-xl'></i> Scan QR Code
                                                </h4>
                                                <div class="flex flex-col lg:flex-row items-center gap-6">
                                                    <div class="bg-white p-4 rounded-xl border-2 border-orange-200 shadow-md">
                                                        <img src="<?= UPLOADS_URL . getSettings("upi_qr_code") ?>" alt="UPI QR Code" class="w-[260px] sm:w-[300px] h-auto rounded-lg">
                                                    </div>

                                                    <div class="flex-1 space-y-3">
                                                        <div class="p-3 bg-blue-50 rounded-lg border border-blue-200">
                                                            <h5 class="font-semibold text-blue-800 mb-1">How to Pay</h5>
                                                            <ul class="text-sm text-blue-700 space-y-1">
                                                                <li>• Open any UPI app</li>
                                                                <li>• Tap “Scan QR”</li>
                                                                <li>• Point camera at the code</li>
                                                                <li>• Enter amount and pay</li>
                                                            </ul>
                                                        </div>

                                                        <div class="p-3 bg-green-50 rounded-lg border border-green-200">
                                                            <h5 class="font-semibold text-green-800 mb-1">Supported Apps</h5>
                                                            <div class="flex flex-wrap gap-2 mt-2">
                                                                <span class="px-3 py-1 bg-white text-gray-700 text-xs font-medium rounded-full border border-gray-300">Google Pay</span>
                                                                <span class="px-3 py-1 bg-white text-gray-700 text-xs font-medium rounded-full border border-gray-300">PhonePe</span>
                                                                <span class="px-3 py-1 bg-white text-gray-700 text-xs font-medium rounded-full border border-gray-300">Paytm</span>
                                                                <span class="px-3 py-1 bg-white text-gray-700 text-xs font-medium rounded-full border border-gray-300">BHIM</span>
                                                                <span class="px-3 py-1 bg-white text-gray-700 text-xs font-medium rounded-full border border-gray-300">Any UPI App</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mt-4 p-4 bg-yellow-50 rounded-xl border border-yellow-200">
                                                <div class="flex items-start gap-3">
                                                    <i class='bx bx-info-circle text-yellow-500 text-xl'></i>
                                                    <p class="text-sm text-yellow-700">
                                                        Note: If you pay manually via UPI, it may take 3–5 hours to verify your payment and process your order.
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                </div>
                            </div>
                        </div>

                        <!-- JS -->
                        <script>

                        </script>


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
                            <?php
                            $primary_color = getData("color", "seller_settings", "(seller_id='$sellerId' AND store_id='$storeId')") ?? '#ff007f';
                            ?>
                            <div class="flex gap-4 step-container" id="step-7">
                                <div class="step-number">07</div>
                                <div class="step-content p-4 sm:p-6 bg-white rounded-2xl shadow-lg border-2 border-gray-100">
                                    <h4 class="text-xl font-semibold text-gray-800 mb-4">Customized Gift <sup class="text-gray-500">(optional)</sup></h4>
                                    <div class="grid gap-4">
                                        <div>
                                            <label class="block mb-2 font-medium text-gray-700">
                                                Gift Images
                                                <span id="uploadCount" class="upload-count" style="background: <?= htmlspecialchars($primary_color) ?>">0/8</span>
                                            </label>

                                            <!-- Uploaded Images Preview - No flex, no grid, controlled layout -->
                                            <div id="uploadedImagesPreview" class="mb-4 py-2 clearfix">
                                                <!-- Uploaded images will appear here -->
                                            </div>

                                            <!-- Hidden file input for form submission -->
                                            <input type="file" name="customized_gift_images[]" id="customized_gift_images" class="hidden" accept="image/*" multiple>

                                            <div id="imageUploadContainer">
                                                <!-- Only ONE input shown initially -->
                                                <div class="image-upload-item mb-3">
                                                    <input type="file" name="temp_images[]"
                                                        class="image-upload-input bg-gray-50 rounded-xl p-4 w-full font-medium border-2 border-gray-200 step-field"
                                                        accept="image/*" multiple data-step="7">
                                                </div>
                                            </div>
                                            <small class="text-gray-500 block mt-2">You can upload up to 8 images. Each image should be less than 10MB.</small>
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
                                    class="px-6 py-3 bg-primary-500 text-white text-sm font-semibold rounded-xl hover:bg-hover transition shadow-lg hover:shadow-xl">
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
                                    <span>Shipping Charges</span>
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
                                        <p class="text-hover font-semibold text-sm">
                                            Minimum order is
                                            <span class="font-bold text-hover">
                                                <?= currencyToSymbol($storeCurrency) . number_format($minimumOrder, 2) ?>
                                            </span>
                                        </p>
                                    </div>
                                <?php else: ?>
                                    <button id="payBtn" type="submit"
                                        class="w-full py-4 rounded-xl font-bold text-white bg-primary-500 hover:bg-hover shadow-lg hover:shadow-xl transition transform hover:scale-105 text-lg">
                                        Place Order
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Add Address Modal -->
                <div id="addAddressModal" class="fixed top-0 left-0 flex items-center justify-center hidden w-full h-full bg-black/70 backdrop-blur-sm transition-opacity duration-300 opacity-0 z-50">
                    <div class="p-6 bg-white/95 rounded-2xl max-w-[750px] w-full shadow-2xl border border-gray-100">
                        <!-- Header -->
                        <div class="flex items-center justify-between mb-6 border-b pb-3">
                            <h3 class="text-2xl font-semibold text-gray-800">Add Address</h3>
                            <button class="addAddressToggle w-[44px] h-[44px] bg-gradient-to-r from-red-500 to-red-600 text-white rounded-xl hover:shadow-md hover:scale-105 transition">
                                <i class="text-lg font-medium bx bx-x"></i>
                            </button>
                        </div>

                        <!-- Form -->
                        <form id="addAddressForm" class="max-h-[75vh] overflow-y-auto space-y-5 pb-[50px] lg:pb-0 px-1">

                            <!-- Name -->
                            <div>
                                <label for="name" class="block mb-2 font-medium text-gray-600">Name <span class="text-red-500">*</span></label>
                                <input type="text" name="name" id="name" placeholder="Enter your name"
                                    class="border border-gray-200 font-medium text-sm h-12 px-4 rounded-xl w-full shadow-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition"
                                    value="<?= customer('name') ?>" required>
                            </div>

                            <!-- Phone + Email -->
                            <div class="grid gap-5 sm:grid-cols-2">
                                <div>
                                    <label for="phone" class="block mb-2 font-medium text-gray-600">Phone Number <span class="text-red-500">*</span></label>
                                    <input type="tell" name="phone[main]" id="phone" placeholder="XXXXX XXXXX"
                                        class="border border-gray-200 font-medium text-sm h-12 px-4 rounded-xl w-full shadow-sm focus:ring-2 focus:ring-primary-500 transition"
                                        value="<?= customer('phone') ?>" required>
                                </div>
                                <div>
                                    <label for="email" class="block mb-2 font-medium text-gray-600">Email Address</label>
                                    <input type="email" name="email" id="email" placeholder="Enter your email"
                                        class="border border-gray-200 font-medium text-sm h-12 px-4 rounded-xl w-full shadow-sm focus:ring-2 focus:ring-primary-500 transition"
                                        value="<?= customer('email') ?>">
                                </div>
                            </div>

                            <!-- Address -->
                            <div>
                                <label for="address" class="block mb-2 font-medium text-gray-600">Address <span class="text-red-500">*</span></label>
                                <input type="text" name="address" id="address" placeholder="Flat / House No, Building, Colony"
                                    class="border border-gray-200 font-medium text-sm h-12 px-4 rounded-xl w-full shadow-sm focus:ring-2 focus:ring-primary-500 transition"
                                    required>
                            </div>

                            <!-- Area + Landmark -->
                            <div class="grid gap-5 sm:grid-cols-2">
                                <div>
                                    <label for="area" class="block mb-2 font-medium text-gray-600">Locality / Area <small class="text-gray-400">(optional)</small></label>
                                    <input type="text" name="area" id="area" placeholder="E.g. MG Road, Gandhi Nagar"
                                        class="border border-gray-200 font-medium text-sm h-12 px-4 rounded-xl w-full shadow-sm focus:ring-2 focus:ring-primary-500 transition">
                                </div>
                                <div>
                                    <label for="landmark" class="block mb-2 font-medium text-gray-600">Landmark <small class="text-gray-400">(optional)</small></label>
                                    <input type="text" name="landmark" id="landmark" placeholder="E.g. Near Bank, Chowk, etc."
                                        class="border border-gray-200 font-medium text-sm h-12 px-4 rounded-xl w-full shadow-sm focus:ring-2 focus:ring-primary-500 transition">
                                </div>
                            </div>

                            <!-- City, Pincode, State -->
                            <div class="grid gap-5 sm:grid-cols-3">
                                <div>
                                    <label for="city" class="block mb-2 font-medium text-gray-600">City <span class="text-red-500">*</span></label>
                                    <input type="text" name="city" id="city" placeholder="Enter city"
                                        class="border border-gray-200 font-medium text-sm h-12 px-4 rounded-xl w-full shadow-sm focus:ring-2 focus:ring-primary-500 transition"
                                        required>
                                </div>

                                <div>
                                    <label for="pin_code" class="block mb-2 font-medium text-gray-600">Pin Code <span class="text-red-500">*</span></label>
                                    <input type="text" name="pin_code" id="pin_code" placeholder="Enter pin code"
                                        class="border border-gray-200 font-medium text-sm h-12 px-4 rounded-xl w-full shadow-sm focus:ring-2 focus:ring-primary-500 transition"
                                        required>
                                </div>

                                <div>
                                    <label for="state" class="block mb-2 font-medium text-gray-600">State <span class="text-red-500">*</span></label>
                                    <?php if ($storeCountry == "IN") { ?>
                                        <select name="state" id="state"
                                            class="border border-gray-200 font-medium text-sm h-12 px-4 rounded-xl w-full shadow-sm focus:ring-2 focus:ring-primary-500 transition"
                                            required>
                                            <option value="" disabled hidden selected>Select state</option>
                                            <option value="Andhra Pradesh">Andhra Pradesh</option>
                                            <option value="Arunachal Pradesh">Arunachal Pradesh</option>
                                            <option value="Assam">Assam</option>
                                            <option value="Bihar">Bihar</option>
                                            <option value="Goa">Goa</option>
                                            <option value="Gujarat">Gujarat</option>
                                            <option value="Haryana">Haryana</option>
                                            <option value="Himachal Pradesh">Himachal Pradesh</option>
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
                                        <input type="text" name="state" id="state" placeholder="Enter state"
                                            class="border border-gray-200 font-medium text-sm h-12 px-4 rounded-xl w-full shadow-sm focus:ring-2 focus:ring-primary-500 transition"
                                            required>
                                    <?php } ?>
                                </div>
                            </div>

                            <!-- Submit -->
                            <button
                                class="bg-gradient-to-r bg-primary-500 hover:from-primary-600 hover:to-primary-700 h-[50px] rounded-xl font-semibold text-base text-white flex items-center justify-center w-full transition-all shadow-md hover:shadow-lg">
                                Add Address
                            </button>
                        </form>
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
        // Auto-select billing address when delivery address is selected
        $(document).on('change', '.shipping_address', function() {
            const selectedAddressId = $(this).val();

            if (selectedAddressId) {
                // Find the corresponding billing address radio button and check it
                $(`.billing_address[value="${selectedAddressId}"]`).prop('checked', true);

                // Trigger change event to update UI
                $(`.billing_address[value="${selectedAddressId}"]`).trigger('change');

                // Show success message with primary color
                toastr.success('Billing address set to match delivery address', '', {
                    closeButton: true,
                    progressBar: true,
                    positionClass: "toast-top-right",
                    timeOut: 3000,
                    showMethod: "fadeIn",
                    hideMethod: "fadeOut"
                });
            }
        });

        // When user manually changes billing address, show info message
        $(document).on('change', '.billing_address', function() {
            const shippingAddress = $('.shipping_address:checked').val();
            const billingAddress = $(this).val();

            if (shippingAddress && billingAddress !== shippingAddress) {
                // Show info message with hover color styling
                toastr.info('You have selected a different billing address', '', {
                    closeButton: true,
                    progressBar: true,
                    positionClass: "toast-top-right",
                    timeOut: 3000,
                    showMethod: "fadeIn",
                    hideMethod: "fadeOut"
                });
            }
        });

        // <-----------> js code for auto click  <----------->
        document.querySelectorAll('.paymentMethod').forEach(radio => {
            radio.addEventListener('change', function() {
                document.querySelectorAll('#upiImg, #bankDetails').forEach(el => el.style.display = 'none');
                if (this.value === 'UPI') document.getElementById('upiImg').style.display = 'block';
                if (this.value === 'Bank Transfer') document.getElementById('bankDetails').style.display = 'block';
            });
        });

        function copyUPIID(button, upiId) {
            navigator.clipboard.writeText(upiId).then(() => {
                const original = button.innerHTML;
                button.innerHTML = '<i class="bx bx-check"></i> Copied!';
                button.classList.replace('bg-primary-500', 'bg-green-500');
                setTimeout(() => {
                    button.innerHTML = original;
                    button.classList.replace('bg-green-500', 'bg-primary-500');
                }, 2000);
            });
        }

        // <---------- Js For Gift Section ------------>

        // <---------- Js For Gift Section ------------>
        // Dynamic Image Upload Functionality for Step 7
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('imageUploadContainer');
            const previewContainer = document.getElementById('uploadedImagesPreview');
            const mainFileInput = document.getElementById('customized_gift_images');

            if (!container || !previewContainer || !mainFileInput) return;

            const maxImages = 8;
            let uploadedImages = 0;
            let uploadedFiles = [];

            // Create success message element
            const successMessage = document.createElement('div');
            successMessage.className = 'success-message hidden';
            successMessage.innerHTML = `
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
        </svg>
        <span>All 8 images uploaded successfully!</span>
    `;
            container.parentNode.insertBefore(successMessage, container.nextSibling);

            // Function to create new file input
            function createFileInput() {
                if (uploadedImages >= maxImages) return;

                const newItem = document.createElement('div');
                newItem.className = 'image-upload-item mb-3';
                newItem.innerHTML = `
            <input type="file" name="temp_images[]" 
                   class="image-upload-input bg-gray-50 rounded-xl p-4 w-full font-medium border-2 border-gray-200 step-field" 
                   accept="image/*" multiple data-step="7">
        `;

                container.appendChild(newItem);

                const newInput = newItem.querySelector('.image-upload-input');
                newInput.addEventListener('change', handleImageUpload);

                return newInput;
            }

            // Handle image upload
            function handleImageUpload(event) {
                const input = event.target;
                const item = input.closest('.image-upload-item');
                const files = input.files;

                if (files && files.length > 0) {
                    const validTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/bmp', 'image/svg+xml', 'image/webp'];
                    const maxSize = 10 * 1024 * 1024;

                    // Calculate how many more images we can upload
                    const remainingSlots = maxImages - uploadedImages;
                    const filesToProcess = Math.min(files.length, remainingSlots);

                    let processedFiles = 0;
                    let validFiles = [];

                    // First, validate all files
                    for (let i = 0; i < filesToProcess; i++) {
                        const file = files[i];

                        if (!validTypes.includes(file.type)) {
                            var msg = new SpeechSynthesisUtterance('Invalid file type. Please upload only image files.');
                            window.speechSynthesis.speak(msg);
                            toastr.error('Invalid file type. Please upload only image files.');
                            continue;
                        }

                        if (file.size > maxSize) {
                            var msg = new SpeechSynthesisUtterance('File size too large. Maximum size is 10MB.');
                            window.speechSynthesis.speak(msg);
                            toastr.error('File size too large. Maximum size is 10MB.');
                            continue;
                        }

                        validFiles.push(file);
                        processedFiles++;
                    }

                    // Process valid files
                    if (validFiles.length > 0) {
                        let filesProcessed = 0;

                        validFiles.forEach((file) => {
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                uploadedFiles.push(file);
                                updateMainFileInput();
                                addImageToPreview(e.target.result, uploadedFiles.length - 1);

                                uploadedImages++;
                                updateUploadCount();

                                filesProcessed++;

                                // Show batch success message when all files from this batch are processed
                                if (filesProcessed === validFiles.length) {
                                    // Show success message when all 8 images are uploaded
                                    if (uploadedImages === maxImages) {
                                        successMessage.classList.remove('hidden');
                                        container.style.display = 'none';

                                        var msg = new SpeechSynthesisUtterance('All 8 images uploaded successfully!');
                                        window.speechSynthesis.speak(msg);
                                        toastr.success('All 8 images uploaded successfully!');
                                    } else {
                                        // Show batch upload message
                                        var msg = new SpeechSynthesisUtterance(`${validFiles.length} images uploaded successfully! Totally: ${uploadedImages} images`);
                                        window.speechSynthesis.speak(msg);
                                        toastr.success(`${validFiles.length} images uploaded successfully! Totally: ${uploadedImages} images`);
                                    }
                                }
                            };
                            reader.readAsDataURL(file);
                        });
                    }

                    // Show warning if user tried to upload more than remaining slots
                    if (files.length > remainingSlots) {
                        var msg = new SpeechSynthesisUtterance(`You can only upload ${remainingSlots} more images. ${files.length - remainingSlots} images were skipped.`);
                        window.speechSynthesis.speak(msg);
                        toastr.warning(`You can only upload ${remainingSlots} more images. ${files.length - remainingSlots} images were skipped.`);
                    }

                    // Disable input and fade out after processing all files
                    input.disabled = true;
                    input.style.opacity = '0.5';

                    setTimeout(() => {
                        item.classList.add('fade-out');
                        setTimeout(() => {
                            if (uploadedImages < maxImages) {
                                createFileInput();
                            }
                            item.remove();
                        }, 300);
                    }, 1000);
                }
            }

            // Update main file input with all uploaded files
            function updateMainFileInput() {
                const dataTransfer = new DataTransfer();
                uploadedFiles.forEach(file => {
                    dataTransfer.items.add(file);
                });
                mainFileInput.files = dataTransfer.files;
            }

            // Add image to preview container
            function addImageToPreview(imageSrc, index) {
                const previewItem = document.createElement('div');
                previewItem.className = 'uploaded-image-item';
                previewItem.innerHTML = `
            <img src="${imageSrc}" alt="Uploaded image ${index + 1}">
            <span class="remove-uploaded-image" onclick="removeUploadedImage(${index})">×</span>
        `;
                previewContainer.appendChild(previewItem);
            }

            // Remove uploaded image function (global)
            window.removeUploadedImage = function(index) {
                uploadedFiles.splice(index, 1);
                uploadedImages--;
                updateMainFileInput();
                updatePreviewContainer();
                updateUploadCount();

                // Hide success message and show input container if not at max
                if (uploadedImages < maxImages) {
                    successMessage.classList.add('hidden');
                    container.style.display = 'block';
                }

                var msg = new SpeechSynthesisUtterance('Image removed successfully!');
                window.speechSynthesis.speak(msg);
                toastr.info('Image removed successfully!');

                const activeInputs = container.querySelectorAll('.image-upload-input:not([disabled])');
                if (activeInputs.length === 0 && uploadedImages < maxImages) {
                    createFileInput();
                }
            }

            // Update preview container after removal
            function updatePreviewContainer() {
                previewContainer.innerHTML = '';
                uploadedFiles.forEach((fileData, index) => {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        addImageToPreview(e.target.result, index);
                    };
                    reader.readAsDataURL(fileData);
                });
            }

            // Update upload count display
            function updateUploadCount() {
                const countDisplay = document.getElementById('uploadCount');
                if (countDisplay) {
                    countDisplay.textContent = `${uploadedImages}/${maxImages}`;
                }
            }

            // Initialize
            const firstInput = container.querySelector('.image-upload-input');
            if (firstInput) {
                firstInput.addEventListener('change', handleImageUpload);
                updateUploadCount();
            }
        });
    </script>

    <script>
        const phoneInputField = document.querySelector("#phone");
        const phoneInput = window.intlTelInput(phoneInputField, {
            separateDialCode: true,
            onlyCountries: ['IN'],
            preferredCountries: ["<?= getSettings("country") ?>"],
            hiddenInput: "full",
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
        });
    </script>

    <!--Footer File Includes that file has all JS Files includes links-->
    <?php include_once __DIR__ . "/includes/footer.php"; ?>

</body>

</html>