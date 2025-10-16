<?php

// Including header
include_once __DIR__ . "/includes/header.php";

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

<div class="py-10">
    <div class="container">
        <div class="flex flex-col items-center justify-between gap-5 mb-10 sm:flex-row">
            <h1 class="text-xl font-bold">Order: #<?= $order_id ?></h1>

            <a href="<?= $storeUrl ?>download-invoice?id=<?= $order_id ?>" class="bg-green-500 text-white text-[14px] font-[400] py-2 px-3 flex items-center gap-2 rounded-lg transition hover:opacity-90 justify-center"><i class='bx bxs-download'></i> Download Invoice</a>
        </div>

        <div class="flex flex-col lg:flex-row gap-5">
            <div class="p-5 bg-white rounded-xl lg:w-[35%] flex justify-between flex-col">
                <ul class="space-y-2">
                    <li class="grid grid-cols-11 text-sm w-full font-medium bg-blue-50 p-2 rounded-xl">
                        <span class="col-span-4">Ordered At</span>
                        <span class="col-span-1">:</span>
                        <span class="col-span-6 text-blue-500"><?= $ordered_date ?></span>
                    </li>

                    <li class="grid grid-cols-11 text-sm w-full font-medium bg-green-50 p-2 rounded-xl">
                        <span class="col-span-4">Status</span>
                        <span class="col-span-1">:</span>
                        <span class="col-span-6 text-green-500"><?= $status ?></span>
                    </li>

                    <li class="grid grid-cols-11 text-sm w-full font-medium bg-indigo-50 p-2 rounded-xl">
                        <span class="col-span-4">Payment Status</span>
                        <span class="col-span-1">:</span>
                        <span class="col-span-6 text-indigo-500"><?= $payment_status ?></span>
                    </li>

                    <?php if ($courier_service) : ?>
                        <li class="grid grid-cols-11 text-sm w-full font-medium bg-cyan-50 p-2 rounded-xl">
                            <span class="col-span-4">Courier Service</span>
                            <span class="col-span-1">:</span>
                            <span class="col-span-6 text-cyan-500"><?= $courier_service ? $courier_service : 'update soon' ?></span>
                        </li>
                    <?php endif; ?>

                    <?php if ($expected_delivery_date) : ?>
                        <li class="grid grid-cols-11 text-sm w-full font-medium bg-orange-50 p-2 rounded-xl">
                            <span class="col-span-4">Expected Delivery Date</span>
                            <span class="col-span-1">:</span>
                            <span class="col-span-6 text-orange-500"><?= $expected_delivery_date ? date('M d, Y', strtotime($expected_delivery_date)) : 'update soon' ?></span>
                        </li>
                    <?php endif; ?>
                </ul>

                <?= $payment_status == "Unpaid" ? "<p class='block text-sm mt-3 text-red-500'><b>Note:</b> Once you paid manually it can takes 3-5hours time to verify the payment made</p>" : null ?>
            </div>

            <div class="p-5 bg-white rounded-xl lg:w-[65%]">
                <h3 class="mb-8 text-xl font-semibold flex items-center gap-2"><span class='mgc_package_2_fill text-3xl'></span> Ordered Products</h3>

                <div class="w-full overflow-x-auto">
                    <table class="table-auto text-[14px] w-full">
                        <thead>
                            <tr>
                                <th class="p-4 font-semibold text-left text-white bg-primary-500">Product</th>
                                <th class="p-4 font-semibold text-left text-white bg-primary-500">Price</th>
                                <th class="p-4 font-semibold text-left text-white bg-primary-500">MRP Price</th>
                                <th class="p-4 font-semibold text-left text-white bg-primary-500">Qty</th>
                                <th class="p-4 font-semibold text-left text-white bg-primary-500">Sub Total</th>
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
                                <tr class="border-t hover:bg-gray-50">
                                    <td class="p-4 border-t">
                                        <a href="<?= $storeUrl . "product/" . getData("slug", "seller_products", "id = '{$product['product_id']}'") ?>" class="flex items-center gap-5 text-primary-500">
                                            <img class="object-contain w-16 h-16 rounded" src="<?= UPLOADS_URL . $image ?>" alt="<?= getData("name", "seller_products", "id = '{$product['product_id']}'") . $other ?><">

                                            <div>
                                                <span class="font-bold block"><?= getData("name", "seller_products", "id = '{$product['product_id']}'") . $other ?></span>
                                                <span class="block text-sm text-gray-400 mt-0.5"><?= $advanced_variant ?></span>
                                            </div>
                                        </a>
                                    </td>
                                    <td class="p-4 border-t"><?= currencyToSymbol($currency) . number_format($product['price'], 2) ?></td>
                                    <td class="p-4 border-t"><?= currencyToSymbol($currency) . number_format($product['mrp_price'], 2) ?></td>
                                    <td class="p-4 border-t"><?= $product['quantity'] ?></td>
                                    <td class="p-4 border-t"><?= currencyToSymbol($currency) . number_format($product['price'] * $product['quantity'], 2) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="grid gap-5 mt-5 lg:grid-cols-3 md:grid-cols-2">

            <?php if ($payment_status == "Unpaid" && !empty(getSettings("bank_details")) && plan("payment_bank") && $payment_method === "Bank Transfer") : ?>
                <div class="p-5 bg-white rounded-xl">
                    <h3 class="mb-8 text-xl font-semibold flex items-center gap-2"><span class='mgc_bank_fill text-3xl'></span> Bank Information</h3>

                    <div class="p-4 mt-2 space-y-3 bg-teal-50 rounded-xl text-[14px] leading-[24px] max-w-[500px]">
                        <?= nl2br(getSettings("bank_details")) ?>
                    </div>
                </div>
            <?php endif ?>

            <?php if ($payment_status == "Unpaid" && !empty(getSettings("upi_qr_code")) && plan("payment_upi") && $payment_method === "UPI") : ?>
                <div class="p-5 bg-white rounded-xl">
                    <h3 class="mb-8 text-xl font-semibold flex items-center gap-2"><span class='text-3xl mgc_fast_forward_fill'></span> UPI Payment</h3>

                    <div class="p-4 mt-2 space-y-3 bg-orange-50 rounded-xl text-[14px] leading-[24px] max-w-[400px]">
                        <img src="<?= UPLOADS_URL . getSettings("upi_qr_code") ?>" alt="" class="max-h-[200px]">
                    </div>
                </div>
            <?php endif ?>

            <div class="p-5 bg-white rounded-xl">
                <h3 class="mb-8 text-xl font-semibold flex items-center gap-2"><span class='mgc_wallet_4_fill text-3xl'></span> Order Summary</h3>

                <ul class="space-y-4">
                    <li class="grid grid-cols-11 max-w-[350px] text-sm">
                        <span class="col-span-4 font-semibold">Sub Total</span>
                        <span class="col-span-1">:</span>
                        <span class="col-span-6"><?= currencyToSymbol($storeCurrency) . number_format($subTotal, 2) ?></span>
                    </li>

                    <li class="grid grid-cols-11 max-w-[350px] text-sm">
                        <span class="col-span-4 font-semibold">Delivery Charge</span>
                        <span class="col-span-1">:</span>
                        <span class="col-span-6"><?= currencyToSymbol($storeCurrency) . $delivery_charges ?></span>
                    </li>

                    <?= $gstTaxAmount ?>

                    <?php if ($discount_type == "fixed") { ?>
                        <li class="grid grid-cols-11 max-w-[350px] text-sm">
                            <span class="col-span-4 font-semibold">Discount</span>
                            <span class="col-span-1">:</span>
                            <span class="col-span-6"><?= currencyToSymbol($storeCurrency) . number_format($discount, 2) ?></span>
                        </li>
                    <?php } else { ?>
                        <li class="grid grid-cols-11 max-w-[350px] text-sm">
                            <span class="col-span-4 font-semibold">Discount</span>
                            <span class="col-span-1">:</span>
                            <span class="col-span-6"><?= number_format($discount, 2) . "%" ?></span>
                        </li>
                    <?php } ?>

                    <li class="grid grid-cols-11 max-w-[350px] text-sm">
                        <span class="col-span-4 font-semibold">Total</span>
                        <span class="col-span-1">:</span>
                        <span class="col-span-6"><?= currencyToSymbol($currency) . number_format($total, 2) ?></span>
                    </li>

                    <!-- <p class="text-sm text-gray-500"><?= $totalGst ?></p> -->
                </ul>
            </div>

            <div class="p-5 bg-white rounded-xl">
                <h3 class="mb-8 text-xl font-semibold flex items-center gap-2"><span class='mgc_truck_fill text-3xl'></span> Delivery Address</h3>

                <ul class="space-y-4">
                    <li class="grid grid-cols-11 max-w-[350px] text-sm">
                        <span class="col-span-4 font-semibold">Name</span>
                        <span class="col-span-1">:</span>
                        <span class="col-span-6"><?= getData("name", "seller_order_address", "type = 'shipping' AND order_id = '$order_id'") ?></span>
                    </li>
                    <li class="grid grid-cols-11 max-w-[350px] text-sm">
                        <span class="col-span-4 font-semibold">Phone</span>
                        <span class="col-span-1">:</span>
                        <span class="col-span-6"><?= getData("phone", "seller_order_address", "type = 'shipping' AND order_id = '$order_id'") ?></span>
                    </li>
                    <li class="grid grid-cols-11 max-w-[350px] text-sm">
                        <span class="col-span-4 font-semibold">Email</span>
                        <span class="col-span-1">:</span>
                        <span class="col-span-6"><?= getData("email", "seller_order_address", "type = 'shipping' AND order_id = '$order_id'") ?></span>
                    </li>

                    <ul class="text-sm">
                        <span class="block mb-2 font-semibold">Address:</span>
                        <li class="mt-1"><?= getData("address", "seller_order_address", "type = 'shipping' AND order_id = '$order_id'") ?></li>
                        <li class="mt-1"><?= getData("city", "seller_order_address", "type = 'shipping' AND order_id = '$order_id'") ?>, <?= getData("state", "seller_order_address", "type = 'shipping' AND order_id = '$order_id'") ?> <?= getData("pin_code", "seller_order_address", "type = 'shipping' AND order_id = '$order_id'") ?></li>
                    </ul>
                </ul>
            </div>

            <div class="p-5 bg-white rounded-xl">
                <h3 class="mb-8 text-xl font-semibold flex items-center gap-2"><span class='mgc_bill_fill text-3xl'></span> Billing Address</h3>

                <ul class="space-y-4">
                    <li class="grid grid-cols-11 max-w-[350px] text-sm">
                        <span class="col-span-4 font-semibold">Name</span>
                        <span class="col-span-1">:</span>
                        <span class="col-span-6"><?= getData("name", "seller_order_address", "type = 'billing' AND order_id = '$order_id'") ?></span>
                    </li>
                    <li class="grid grid-cols-11 max-w-[350px] text-sm">
                        <span class="col-span-4 font-semibold">Phone</span>
                        <span class="col-span-1">:</span>
                        <span class="col-span-6"><?= getData("phone", "seller_order_address", "type = 'billing' AND order_id = '$order_id'") ?></span>
                    </li>
                    <li class="grid grid-cols-11 max-w-[350px] text-sm">
                        <span class="col-span-4 font-semibold">Email</span>
                        <span class="col-span-1">:</span>
                        <span class="col-span-6"><?= getData("email", "seller_order_address", "type = 'billing' AND order_id = '$order_id'") ?></span>
                    </li>

                    <ul class="text-sm">
                        <span class="block mb-2 font-semibold">Address:</span>
                        <li class="mt-1"><?= getData("address", "seller_order_address", "type = 'billing' AND order_id = '$order_id'") ?></li>
                        <li class="mt-1"><?= getData("city", "seller_order_address", "type = 'billing' AND order_id = '$order_id'") ?>, <?= getData("state", "seller_order_address", "type = 'billing' AND order_id = '$order_id'") ?> <?= getData("pin_code", "seller_order_address", "type = 'billing' AND order_id = '$order_id'") ?></li>
                    </ul>
                </ul>
            </div>

            <?php if (!empty($courier_service)) : ?>
                <div class="p-5 bg-white rounded-xl">
                    <h3 class="mb-8 text-xl font-semibold flex items-center gap-2"><i class='text-3xl bx bx-package'></i> Courier Information</h3>

                    <ul class="space-y-4">
                        <li class="grid grid-cols-11 max-w-[350px] text-sm">
                            <span class="col-span-4 font-semibold">Courier Service</span>
                            <span class="col-span-1">:</span>
                            <span class="col-span-6"><?= $courier_service ?></span>
                        </li>
                        <li class="grid grid-cols-11 max-w-[350px] text-sm">
                            <span class="col-span-4 font-semibold">Tracking ID</span>
                            <span class="col-span-1">:</span>
                            <span class="col-span-6"><?= $tracking_id ?></span>
                        </li>
                        <li class="grid grid-cols-11 max-w-[350px] text-sm">
                            <span class="col-span-4 font-semibold">Expected Date</span>
                            <span class="col-span-1">:</span>
                            <span class="col-span-6"><?= $expected_delivery_date ? date('M d, Y', strtotime($expected_delivery_date)) : 'update soon' ?></span>
                        </li>
                    </ul>
                </div>
            <?php endif ?>
        </div>

        <div class="grid gap-5 lg:grid-cols-2">
            <?php if ($customized_gift) : ?>
                <div class="p-5 mt-5 bg-white rounded-lg">
                    <h3 class="mb-8 text-xl font-semibold flex items-center gap-2"><span class='mgc_wallet_4_fill text-3xl'></span> Customized Gift</h3>

                    <div class="[&_ul]:ml-8 [&_ul]:mt-2 [&_ul]:list-disc [&_a]:text-primary-500 [&_a]:underline">
                        <?= preg_replace('/customers\/\//', UPLOADS_URL . 'customers//', $customized_gift) ?>
                    </div>

                </div>
            <?php endif ?>
        </div>

        <p class="mt-10 font-medium text-center text-primary-500">Contact us for any help at <?= getSettings("phone") ?> - We're always here to assist you with your shopping needs!</p>
    </div>
</div>

<?php include_once __DIR__ . "/includes/footer.php"; ?>