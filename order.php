<?php
include_once __DIR__ . "/includes/files_includes.php";

// Get colors from database
$primary_color = getData("color", "seller_settings", "(seller_id='$sellerId' AND store_id='$storeId')") ?? '#ff007f';
$hover_color = getData("hover_color", "seller_settings", "(seller_id='$sellerId' AND store_id='$storeId')") ?? '#ec4899';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include_once __DIR__ . "/includes/head_links.php"; ?>
    <style>
        :root {
            --primary: <?= htmlspecialchars($primary_color) ?>;
            --hover-color: <?= htmlspecialchars($hover_color) ?>;
        }
        
        .bg-primary-gradient {
            background: linear-gradient(135deg, var(--primary), var(--hover-color));
        }
        
        .text-primary {
            color: var(--primary);
        }
        
        .border-primary {
            border-color: var(--primary);
        }
        
        .hover-primary:hover {
            color: var(--primary);
        }
    </style>
</head>

<body class="font-sans bg-gray-50 min-h-screen" style="--primary: <?= htmlspecialchars($primary_color) ?>; --hover-color: <?= htmlspecialchars($hover_color) ?>;">
    <!-- Navbar -->
    <?php include_once __DIR__ . "/includes/navbar.php"; ?>

    <?php
    if (isset($_GET['id']) && getData("id", "seller_orders", "order_id = '{$_GET['id']}'")) {
        $order_id = $_GET['id'];

        $ordered_date = date('F d, Y', strtotime(getData("created_at", "seller_orders", "order_id = '$order_id'")));
        $status = ucwords(getData("status", "seller_orders", "order_id = '$order_id'"));
        $payment_status = ucwords(getData("payment_status", "seller_orders", "order_id = '$order_id'"));
        $courier_service = getData("courier_service", "seller_orders", "order_id = '$order_id'");
        $tracking_id = getData("tracking_id", "seller_orders", "order_id = '$order_id'");
        $expected_delivery_date = getData("expected_delivery_date", "seller_orders", "order_id = '$order_id'");
        $tax = getData("tax", "seller_orders", "order_id = '$order_id'");
        $customized_gift = getData("customized_gift", "seller_orders", "order_id = '$order_id'");
        $delivery_charges = getData("delivery_charges", "seller_orders", "order_id = '$order_id'");
        $total = getData("total", "seller_orders", "order_id = '$order_id'");
        $discount = getData("discount", "seller_orders", "order_id = '$order_id'");
        $discount_type = getData("discount_type", "seller_orders", "order_id = '$order_id'");
        $currency = getData("currency", "seller_orders", "order_id = '$order_id'");
        $payment_method = getData("payment_method", "seller_orders", "order_id = '$order_id'");

        $gst_number = getData("gst_number", "seller_orders", "order_id = '$order_id'");
        $gst_tax_type = getData("gst_tax_type", "seller_orders", "order_id = '$order_id'");
        $gst_percentage = getData("gst_percentage", "seller_orders", "order_id = '$order_id'");

        $gstTaxAmount = '';
        $totalGst = '';
        if ($tax != 0 && !empty($gst_percentage)) {
            $totalGst = $gst_tax_type == "inclusive" ? "(Inclusive GST -$gst_percentage%)" : "(Exclusive GST +$gst_percentage%)";

            if ($gst_tax_type != "inclusive") {
                $gstTaxAmount = '<li class="grid grid-cols-11 max-w-[350px] text-sm">
                        <span class="col-span-4 font-semibold">GST (' . $gst_percentage . '%)</span>
                        <span class="col-span-1">:</span>
                        <span class="col-span-6">' . currencyToSymbol($currency) . number_format($tax, 2) . '</span>
                    </li>';
            }
        }

        $subTotal = 0;
        foreach (getOrderedProducts(array("orderId" => $order_id)) as $key => $product) {
            $subTotal += $product['price'] * $product['quantity'];
        }
    } else {
        redirect($storeUrl);
    }
    ?>

    <div class="py-6 sm:py-8">
        <div class="px-3 sm:px-4 lg:px-6 max-w-7xl mx-auto">
            <!-- Header Section -->
            <div class="flex flex-col items-center justify-between gap-4 sm:gap-5 mb-6 sm:mb-8">
                <h1 class="text-xl sm:text-2xl font-bold text-gray-800 text-center sm:text-left">Order: #<?= $order_id ?></h1>
                <a href="<?= $storeUrl ?>download-invoice?id=<?= $order_id ?>" 
                   class="text-white text-sm font-medium py-2 px-4 flex items-center gap-2 rounded-lg transition hover:opacity-90 justify-center shadow-lg hover:shadow-xl w-full sm:w-auto bg-primary-gradient">
                    <i class='bx bxs-download'></i> Download Invoice
                </a>
            </div>

            <!-- Main Content Grid -->
            <div class="flex flex-col lg:flex-row gap-4 sm:gap-6">
                <!-- Order Status Card -->
                <div class="p-4 sm:p-6 bg-white rounded-2xl shadow-lg lg:w-[35%]">
                    <ul class="space-y-3">
                        <li class="grid grid-cols-11 text-sm w-full font-medium p-3 rounded-xl border transition-all duration-300 hover:shadow-md"
                            style="background-color: color-mix(in srgb, var(--primary) 8%, white); border-color: color-mix(in srgb, var(--primary) 20%, transparent);">
                            <span class="col-span-4" style="color: var(--primary);">Ordered At</span>
                            <span class="col-span-1" style="color: var(--primary); opacity: 0.7;">:</span>
                            <span class="col-span-6 font-semibold" style="color: var(--primary);"><?= $ordered_date ?></span>
                        </li>

                        <li class="grid grid-cols-11 text-sm w-full font-medium p-3 rounded-xl border transition-all duration-300 hover:shadow-md"
                            style="background-color: color-mix(in srgb, #10b981 8%, white); border-color: color-mix(in srgb, #10b981 20%, transparent);">
                            <span class="col-span-4 text-green-700">Status</span>
                            <span class="col-span-1 text-green-500">:</span>
                            <span class="col-span-6 font-semibold text-green-600"><?= $status ?></span>
                        </li>

                        <li class="grid grid-cols-11 text-sm w-full font-medium p-3 rounded-xl border transition-all duration-300 hover:shadow-md"
                            style="background-color: color-mix(in srgb, var(--hover-color) 8%, white); border-color: color-mix(in srgb, var(--hover-color) 20%, transparent);">
                            <span class="col-span-4" style="color: var(--hover-color);">Payment Status</span>
                            <span class="col-span-1" style="color: var(--hover-color); opacity: 0.7;">:</span>
                            <span class="col-span-6 font-semibold" style="color: var(--hover-color);"><?= $payment_status ?></span>
                        </li>

                        <?php if ($courier_service) : ?>
                            <li class="grid grid-cols-11 text-sm w-full font-medium p-3 rounded-xl border transition-all duration-300 hover:shadow-md"
                                style="background-color: color-mix(in srgb, #06b6d4 8%, white); border-color: color-mix(in srgb, #06b6d4 20%, transparent);">
                                <span class="col-span-4 text-cyan-700">Courier Service</span>
                                <span class="col-span-1 text-cyan-500">:</span>
                                <span class="col-span-6 text-cyan-600 font-semibold"><?= $courier_service ? $courier_service : 'update soon' ?></span>
                            </li>
                        <?php endif; ?>

                        <?php if ($expected_delivery_date) : ?>
                            <li class="grid grid-cols-11 text-sm w-full font-medium p-3 rounded-xl border transition-all duration-300 hover:shadow-md"
                                style="background-color: color-mix(in srgb, #f59e0b 8%, white); border-color: color-mix(in srgb, #f59e0b 20%, transparent);">
                                <span class="col-span-4 text-orange-700">Expected Delivery</span>
                                <span class="col-span-1 text-orange-500">:</span>
                                <span class="col-span-6 text-orange-600 font-semibold"><?= $expected_delivery_date ? date('M d, Y', strtotime($expected_delivery_date)) : 'update soon' ?></span>
                            </li>
                        <?php endif; ?>
                    </ul>

                    <?= $payment_status == "Unpaid" ? "<p class='block text-sm mt-4 p-3 rounded-lg border transition-all duration-300' style='color: #ef4444; background-color: color-mix(in srgb, #ef4444 8%, white); border-color: color-mix(in srgb, #ef4444 20%, transparent);'><b>Note:</b> Once you paid manually it can takes 3-5hours time to verify the payment made</p>" : null ?>
                </div>

                <!-- Ordered Products - Responsive Table -->
                <div class="p-4 sm:p-6 bg-white rounded-2xl shadow-lg lg:w-[65%]">
                    <h3 class="mb-6 text-xl font-semibold text-gray-800 flex items-center gap-3">
                        <span class='mgc_package_2_fill text-2xl' style="color: var(--primary);"></span> Ordered Products
                    </h3>

                    <!-- Desktop Table -->
                    <div class="hidden md:block w-full overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="bg-primary-gradient">
                                    <th class="p-3 font-semibold text-left text-white">Product</th>
                                    <th class="p-3 font-semibold text-left text-white">Price</th>
                                    <th class="p-3 font-semibold text-left text-white">MRP Price</th>
                                    <th class="p-3 font-semibold text-left text-white">Qty</th>
                                    <th class="p-3 font-semibold text-left text-white">Sub Total</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-700">
                                <?php
                                $products = getOrderedProducts(array("orderId" => $order_id));
                                $subTotal = 0;

                                foreach ($products as $key => $product) :
                                    $subTotal += $product['price'] * $product['quantity'];

                                    $image = getData("image", "seller_products", "id = '{$product['product_id']}'");
                                    if ($product['other'] && getData("image", "seller_product_variants", "id = '{$product['other']}'")) {
                                        $image = getData("image", "seller_product_variants", "id = '{$product['other']}'");
                                    }

                                    $other = "";
                                    $advanced_variant = "";
                                    if ($product['other']) {
                                        $other = " - " . getData("variation", "seller_product_variants", "id = '{$product['other']}'");
                                    }
                                    if ($product && $product['advanced_variant']) {
                                        $size = getData("size", "seller_product_advanced_variants", "id = '{$product['advanced_variant']}'");
                                        $color = getData("color", "seller_product_advanced_variants", "id = '{$product['advanced_variant']}'");
                                        $color = getData("color_name", "product_colors", "id = '$color'");

                                        $advanced_variant = "Size: $size | Color: $color";

                                        if (getData("image", "seller_product_advanced_variants", "id = '{$product['advanced_variant']}'")) $image = getData("image", "seller_product_advanced_variants", "id = '{$product['advanced_variant']}'");
                                    }
                                ?>
                                    <tr class="border-t hover:bg-gray-50 transition">
                                        <td class="p-3 border-t">
                                            <a href="<?= $storeUrl . "product/" . getData("slug", "seller_products", "id = '{$product['product_id']}'") ?>" 
                                               class="flex items-center gap-3 transition hover-primary"
                                               style="color: var(--primary);">
                                                <img class="object-contain w-12 h-12 rounded-lg shadow-sm" src="<?= UPLOADS_URL . $image ?>" alt="<?= getData("name", "seller_products", "id = '{$product['product_id']}'") . $other ?>">
                                                <div>
                                                    <span class="font-bold block text-sm"><?= limit_characters(getData("name", "seller_products", "id = '{$product['product_id']}'") . $other, 35) ?></span>
                                                    <span class="block text-xs text-gray-400 mt-1"><?= $advanced_variant ?></span>
                                                </div>
                                            </a>
                                        </td>
                                        <td class="p-3 border-t font-medium"><?= currencyToSymbol($currency) . number_format($product['price'], 2) ?></td>
                                        <td class="p-3 border-t text-gray-500"><?= currencyToSymbol($currency) . number_format($product['mrp_price'], 2) ?></td>
                                        <td class="p-3 border-t font-medium"><?= $product['quantity'] ?></td>
                                        <td class="p-3 border-t font-semibold text-green-600"><?= currencyToSymbol($currency) . number_format($product['price'] * $product['quantity'], 2) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Mobile Cards -->
                    <div class="md:hidden space-y-4">
                        <?php
                        $products = getOrderedProducts(array("orderId" => $order_id));
                        foreach ($products as $key => $product) :
                            $image = getData("image", "seller_products", "id = '{$product['product_id']}'");
                            if ($product['other'] && getData("image", "seller_product_variants", "id = '{$product['other']}'")) {
                                $image = getData("image", "seller_product_variants", "id = '{$product['other']}'");
                            }

                            $other = "";
                            $advanced_variant = "";
                            if ($product['other']) {
                                $other = " - " . getData("variation", "seller_product_variants", "id = '{$product['other']}'");
                            }
                            if ($product && $product['advanced_variant']) {
                                $size = getData("size", "seller_product_advanced_variants", "id = '{$product['advanced_variant']}'");
                                $color = getData("color", "seller_product_advanced_variants", "id = '{$product['advanced_variant']}'");
                                $color = getData("color_name", "product_colors", "id = '$color'");
                                $advanced_variant = "Size: $size | Color: $color";
                                if (getData("image", "seller_product_advanced_variants", "id = '{$product['advanced_variant']}'")) $image = getData("image", "seller_product_advanced_variants", "id = '{$product['advanced_variant']}'");
                            }
                        ?>
                            <div class="bg-gray-50 p-4 rounded-xl border border-gray-200 transition-all duration-300 hover:shadow-md">
                                <div class="flex items-start gap-3">
                                    <img class="object-contain w-16 h-16 rounded-lg shadow-sm flex-shrink-0" src="<?= UPLOADS_URL . $image ?>" alt="<?= getData("name", "seller_products", "id = '{$product['product_id']}'") . $other ?>">
                                    <div class="flex-1 min-w-0">
                                        <a href="<?= $storeUrl . "product/" . getData("slug", "seller_products", "id = '{$product['product_id']}'") ?>" 
                                           class="font-bold block text-sm text-gray-800 transition mb-1 hover-primary"
                                           style="color: var(--primary);">
                                            <?= limit_characters(getData("name", "seller_products", "id = '{$product['product_id']}'") . $other, 40) ?>
                                        </a>
                                        <?php if ($advanced_variant) : ?>
                                            <p class="text-xs text-gray-500 mb-2"><?= $advanced_variant ?></p>
                                        <?php endif; ?>

                                        <div class="grid grid-cols-2 gap-2 text-sm">
                                            <div>
                                                <span class="text-gray-600">Price:</span>
                                                <span class="font-medium block"><?= currencyToSymbol($currency) . number_format($product['price'], 2) ?></span>
                                            </div>
                                            <div>
                                                <span class="text-gray-600">MRP:</span>
                                                <span class="text-gray-500 block"><?= currencyToSymbol($currency) . number_format($product['mrp_price'], 2) ?></span>
                                            </div>
                                            <div>
                                                <span class="text-gray-600">Qty:</span>
                                                <span class="font-medium block"><?= $product['quantity'] ?></span>
                                            </div>
                                            <div>
                                                <span class="text-gray-600">Total:</span>
                                                <span class="font-semibold text-green-600 block"><?= currencyToSymbol($currency) . number_format($product['price'] * $product['quantity'], 2) ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- Additional Information Cards -->
            <div class="grid gap-4 sm:gap-6 mt-6 lg:grid-cols-3 md:grid-cols-2">

                <?php if ($payment_status == "Unpaid" && !empty(getSettings("bank_details")) && plan("payment_bank") && $payment_method === "Bank Transfer") : ?>
                    <div class="p-4 sm:p-6 bg-white rounded-2xl shadow-lg transition-all duration-300 hover:shadow-xl">
                        <h3 class="mb-6 text-xl font-semibold text-gray-800 flex items-center gap-3">
                            <span class='mgc_bank_fill text-2xl' style="color: var(--primary);"></span> Bank Information
                        </h3>
                        <div class="p-4 mt-2 space-y-3 rounded-xl text-sm leading-6 border transition-all duration-300"
                             style="background-color: color-mix(in srgb, var(--primary) 5%, white); border-color: color-mix(in srgb, var(--primary) 15%, transparent);">
                            <?= nl2br(getSettings("bank_details")) ?>
                        </div>
                    </div>
                <?php endif ?>

                <?php if ($payment_status == "Unpaid" && !empty(getSettings("upi_qr_code")) && plan("payment_upi") && $payment_method === "UPI") : ?>
                    <div class="p-4 sm:p-6 bg-white rounded-2xl shadow-lg transition-all duration-300 hover:shadow-xl">
                        <h3 class="mb-6 text-xl font-semibold text-gray-800 flex items-center gap-3">
                            <span class='text-2xl mgc_fast_forward_fill' style="color: var(--hover-color);"></span> UPI Payment
                        </h3>
                        <div class="p-4 mt-2 space-y-3 rounded-xl text-sm leading-6 border transition-all duration-300"
                             style="background-color: color-mix(in srgb, var(--hover-color) 5%, white); border-color: color-mix(in srgb, var(--hover-color) 15%, transparent);">
                            <img src="<?= UPLOADS_URL . getSettings("upi_qr_code") ?>" alt="UPI QR Code" class="max-h-[180px] mx-auto rounded-lg shadow-sm">
                        </div>
                    </div>
                <?php endif ?>

                <!-- Order Summary -->
                <div class="p-4 sm:p-6 bg-white rounded-2xl shadow-lg transition-all duration-300 hover:shadow-xl">
                    <h3 class="mb-6 text-xl font-semibold text-gray-800 flex items-center gap-3">
                        <span class='mgc_wallet_4_fill text-2xl' style="color: var(--primary);"></span> Order Summary
                    </h3>
                    <ul class="space-y-4">
                        <li class="grid grid-cols-11 max-w-[350px] text-sm">
                            <span class="col-span-4 font-semibold text-gray-700">Sub Total</span>
                            <span class="col-span-1 text-gray-500">:</span>
                            <span class="col-span-6 font-medium"><?= currencyToSymbol($storeCurrency) . number_format($subTotal, 2) ?></span>
                        </li>
                        <li class="grid grid-cols-11 max-w-[350px] text-sm">
                            <span class="col-span-4 font-semibold text-gray-700">Delivery Charge</span>
                            <span class="col-span-1 text-gray-500">:</span>
                            <span class="col-span-6 font-medium"><?= currencyToSymbol($storeCurrency) . $delivery_charges ?></span>
                        </li>
                        <?= $gstTaxAmount ?>
                        <?php if ($discount_type == "fixed") { ?>
                            <li class="grid grid-cols-11 max-w-[350px] text-sm">
                                <span class="col-span-4 font-semibold text-gray-700">Discount</span>
                                <span class="col-span-1 text-gray-500">:</span>
                                <span class="col-span-6 font-medium text-green-600">-<?= currencyToSymbol($storeCurrency) . number_format($discount, 2) ?></span>
                            </li>
                        <?php } else { ?>
                            <li class="grid grid-cols-11 max-w-[350px] text-sm">
                                <span class="col-span-4 font-semibold text-gray-700">Discount</span>
                                <span class="col-span-1 text-gray-500">:</span>
                                <span class="col-span-6 font-medium text-green-600">-<?= number_format($discount, 2) . "%" ?></span>
                            </li>
                        <?php } ?>
                        <li class="grid grid-cols-11 max-w-[350px] text-sm border-t pt-3 mt-3">
                            <span class="col-span-4 font-bold text-gray-800">Total</span>
                            <span class="col-span-1 text-gray-500">:</span>
                            <span class="col-span-6 font-bold text-lg text-emerald-600"><?= currencyToSymbol($currency) . number_format($total, 2) ?></span>
                        </li>
                    </ul>
                </div>

                <!-- Delivery Address -->
                <div class="p-4 sm:p-6 bg-white rounded-2xl shadow-lg transition-all duration-300 hover:shadow-xl">
                    <h3 class="mb-6 text-xl font-semibold text-gray-800 flex items-center gap-3">
                        <span class='mgc_truck_fill text-2xl' style="color: var(--hover-color);"></span> Delivery Address
                    </h3>
                    <ul class="space-y-4">
                        <li class="grid grid-cols-11 max-w-[350px] text-sm">
                            <span class="col-span-4 font-semibold text-gray-700">Name</span>
                            <span class="col-span-1 text-gray-500">:</span>
                            <span class="col-span-6 font-medium"><?= getData("name", "seller_order_address", "type = 'shipping' AND order_id = '$order_id'") ?></span>
                        </li>
                        <li class="grid grid-cols-11 max-w-[350px] text-sm">
                            <span class="col-span-4 font-semibold text-gray-700">Phone</span>
                            <span class="col-span-1 text-gray-500">:</span>
                            <span class="col-span-6 font-medium"><?= getData("phone", "seller_order_address", "type = 'shipping' AND order_id = '$order_id'") ?></span>
                        </li>
                        <li class="grid grid-cols-11 max-w-[350px] text-sm">
                            <span class="col-span-4 font-semibold text-gray-700">Email</span>
                            <span class="col-span-1 text-gray-500">:</span>
                            <span class="col-span-6 font-medium"><?= getData("email", "seller_order_address", "type = 'shipping' AND order_id = '$order_id'") ?></span>
                        </li>
                        <div class="text-sm p-3 rounded-lg border transition-all duration-300"
                             style="background-color: color-mix(in srgb, var(--primary) 3%, white); border-color: color-mix(in srgb, var(--primary) 10%, transparent);">
                            <span class="block mb-2 font-semibold text-gray-700">Address:</span>
                            <p class="mt-1 text-gray-600"><?= getData("address", "seller_order_address", "type = 'shipping' AND order_id = '$order_id'") ?></p>
                            <p class="mt-1 text-gray-600"><?= getData("city", "seller_order_address", "type = 'shipping' AND order_id = '$order_id'") ?>, <?= getData("state", "seller_order_address", "type = 'shipping' AND order_id = '$order_id'") ?> <?= getData("pin_code", "seller_order_address", "type = 'shipping' AND order_id = '$order_id'") ?></p>
                        </div>
                    </ul>
                </div>

                <!-- Billing Address -->
                <div class="p-4 sm:p-6 bg-white rounded-2xl shadow-lg transition-all duration-300 hover:shadow-xl">
                    <h3 class="mb-6 text-xl font-semibold text-gray-800 flex items-center gap-3">
                        <span class='mgc_bill_fill text-2xl' style="color: var(--primary);"></span> Billing Address
                    </h3>
                    <ul class="space-y-4">
                        <li class="grid grid-cols-11 max-w-[350px] text-sm">
                            <span class="col-span-4 font-semibold text-gray-700">Name</span>
                            <span class="col-span-1 text-gray-500">:</span>
                            <span class="col-span-6 font-medium"><?= getData("name", "seller_order_address", "type = 'billing' AND order_id = '$order_id'") ?></span>
                        </li>
                        <li class="grid grid-cols-11 max-w-[350px] text-sm">
                            <span class="col-span-4 font-semibold text-gray-700">Phone</span>
                            <span class="col-span-1 text-gray-500">:</span>
                            <span class="col-span-6 font-medium"><?= getData("phone", "seller_order_address", "type = 'billing' AND order_id = '$order_id'") ?></span>
                        </li>
                        <li class="grid grid-cols-11 max-w-[350px] text-sm">
                            <span class="col-span-4 font-semibold text-gray-700">Email</span>
                            <span class="col-span-1 text-gray-500">:</span>
                            <span class="col-span-6 font-medium"><?= getData("email", "seller_order_address", "type = 'billing' AND order_id = '$order_id'") ?></span>
                        </li>
                        <div class="text-sm p-3 rounded-lg border transition-all duration-300"
                             style="background-color: color-mix(in srgb, var(--hover-color) 3%, white); border-color: color-mix(in srgb, var(--hover-color) 10%, transparent);">
                            <span class="block mb-2 font-semibold text-gray-700">Address:</span>
                            <p class="mt-1 text-gray-600"><?= getData("address", "seller_order_address", "type = 'billing' AND order_id = '$order_id'") ?></p>
                            <p class="mt-1 text-gray-600"><?= getData("city", "seller_order_address", "type = 'billing' AND order_id = '$order_id'") ?>, <?= getData("state", "seller_order_address", "type = 'billing' AND order_id = '$order_id'") ?> <?= getData("pin_code", "seller_order_address", "type = 'billing' AND order_id = '$order_id'") ?></p>
                        </div>
                    </ul>
                </div>

                <?php if (!empty($courier_service)) : ?>
                    <div class="p-4 sm:p-6 bg-white rounded-2xl shadow-lg transition-all duration-300 hover:shadow-xl">
                        <h3 class="mb-6 text-xl font-semibold text-gray-800 flex items-center gap-3">
                            <i class='text-2xl bx bx-package' style="color: var(--primary);"></i> Courier Information
                        </h3>
                        <ul class="space-y-4">
                            <li class="grid grid-cols-11 max-w-[350px] text-sm">
                                <span class="col-span-4 font-semibold text-gray-700">Courier Service</span>
                                <span class="col-span-1 text-gray-500">:</span>
                                <span class="col-span-6 font-medium"><?= $courier_service ?></span>
                            </li>
                            <li class="grid grid-cols-11 max-w-[350px] text-sm">
                                <span class="col-span-4 font-semibold text-gray-700">Tracking ID</span>
                                <span class="col-span-1 text-gray-500">:</span>
                                <span class="col-span-6 font-medium" style="color: var(--hover-color);"><?= $tracking_id ?></span>
                            </li>
                            <li class="grid grid-cols-11 max-w-[350px] text-sm">
                                <span class="col-span-4 font-semibold text-gray-700">Expected Date</span>
                                <span class="col-span-1 text-gray-500">:</span>
                                <span class="col-span-6 font-medium"><?= $expected_delivery_date ? date('M d, Y', strtotime($expected_delivery_date)) : 'update soon' ?></span>
                            </li>
                        </ul>
                    </div>
                <?php endif ?>
            </div>

            <!-- Customized Gift Section -->
            <?php if ($customized_gift) : ?>
                <div class="p-4 sm:p-6 mt-6 bg-white rounded-2xl shadow-lg transition-all duration-300 hover:shadow-xl">
                    <h3 class="mb-6 text-xl font-semibold text-gray-800 flex items-center gap-3">
                        <span class='mgc_gift_fill text-2xl' style="color: var(--primary);"></span> Customized Gift
                    </h3>
                    <div class="[&_ul]:ml-8 [&_ul]:mt-2 [&_ul]:list-disc [&_a]:underline bg-pink-50 p-4 rounded-xl border border-pink-100 transition-all duration-300"
                         style="background-color: color-mix(in srgb, var(--primary) 5%, white); border-color: color-mix(in srgb, var(--primary) 15%, transparent);">
                        <?= preg_replace('/customers\/\//', UPLOADS_URL . 'customers//', $customized_gift) ?>
                    </div>
                </div>
            <?php endif ?>

            <!-- Contact Information -->
            <p class="mt-6 sm:mt-8 font-medium text-center bg-white p-4 rounded-2xl shadow-lg text-sm sm:text-base transition-all duration-300 hover:shadow-xl"
               style="color: var(--primary); background-color: color-mix(in srgb, var(--primary) 5%, white);">
                Contact us for any help at <?= getSettings("phone") ?> - We're always here to assist you with your shopping needs!
            </p>
        </div>
    </div>

    <!-- Footer -->
    <?php include_once __DIR__ . "/includes/footer.php"; ?>

</body>

</html>