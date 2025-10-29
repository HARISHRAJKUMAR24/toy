<?php include_once __DIR__ . "/includes/files_includes.php"; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!--Php File Include For Head Links & Scripts-->
    <?php include_once __DIR__ . "/includes/head_links.php"; ?>
    <style>
        :root {
            --primary: <?= htmlspecialchars(getData("color", "seller_settings", "(seller_id='$sellerId' AND store_id='$storeId')") ?? '#ff007f') ?>;
            --hover-color: <?= htmlspecialchars(getData("hover_color", "seller_settings", "(seller_id='$sellerId' AND store_id='$storeId')") ?? '#ec4899') ?>;
        }

        .gradient-bg {
            background: linear-gradient(135deg, color-mix(in srgb, var(--primary) 5%, white) 0%, color-mix(in srgb, var(--primary) 8%, white) 50%, color-mix(in srgb, var(--primary) 12%, white) 100%);
        }

        .location-card {
            background: white;
            border: 1px solid color-mix(in srgb, var(--primary) 20%, transparent);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .location-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--primary), var(--hover-color), color-mix(in srgb, var(--primary) 70%, black));
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        .location-card:hover::before {
            transform: scaleX(1);
        }

        .location-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 25px 50px -12px color-mix(in srgb, var(--primary) 25%, transparent);
            border-color: color-mix(in srgb, var(--primary) 40%, transparent);
        }

        .number-badge {
            background: linear-gradient(135deg, var(--primary), var(--hover-color));
            color: white;
            box-shadow: 0 4px 6px -1px color-mix(in srgb, var(--primary) 30%, transparent), 0 2px 4px -1px color-mix(in srgb, var(--primary) 10%, transparent);
        }

        .type-badge {
            background: linear-gradient(135deg, #fbbf24, #f59e0b);
            color: white;
            font-size: 0.7rem;
            padding: 0.25rem 0.75rem;
        }

        .free-delivery {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
        }

        .section-title {
            background: linear-gradient(135deg, #1f2937, #374151);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .divider {
            background: linear-gradient(90deg, transparent, var(--primary), transparent);
            height: 2px;
        }

        .info-item {
            transition: all 0.3s ease;
        }

        .info-item:hover {
            background: color-mix(in srgb, var(--primary) 5%, white);
            border-radius: 0.5rem;
        }

        .pulse-dot {
            animation: pulse 2s infinite;
            background-color: var(--primary);
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.5;
            }
        }

        .icon-color {
            color: var(--primary);
        }

        .hover-icon:hover {
            color: var(--hover-color);
        }
    </style>
</head>

<body class="font-sans" style="--primary: <?= htmlspecialchars(getData('color', 'seller_settings', "(seller_id='$sellerId' AND store_id='$storeId')") ?? '#ff007f') ?>; --hover-color: <?= htmlspecialchars(getData('hover_color', 'seller_settings', "(seller_id='$sellerId' AND store_id='$storeId')") ?? '#ec4899') ?>;">

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

    <!-- Navigation -->
    <?php include_once __DIR__ . "/includes/navbar.php"; ?>

    <!-- Hero Section -->
    <div class="gradient-bg py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="mb-8">
                <div class="w-20 h-20 mx-auto mb-4 bg-white rounded-2xl shadow-lg flex items-center justify-center">
                    <i class='bx bx-map-pin text-3xl icon-color'></i>
                </div>
                <h1 class="text-4xl md:text-5xl font-bold section-title mb-4">Delivery & Locations</h1>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    We bring happiness to your doorstep! Check our delivery areas and visit our beautiful stores.
                </p>
            </div>
        </div>
    </div>

    <div class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Delivery Areas Section -->
            <div class="mb-20">
                <div class="text-center mb-12">
                    <div class="inline-flex items-center gap-3 mb-4">
                        <div class="w-2 h-2 rounded-full pulse-dot"></div>
                        <h2 class="text-3xl md:text-4xl font-bold section-title">Delivery Areas</h2>
                        <div class="w-2 h-2 rounded-full pulse-dot"></div>
                    </div>
                    <p class="text-gray-600 text-lg max-w-2xl mx-auto">
                        We deliver to these wonderful locations with love and care 💖
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <?php
                    $data = getDeliveryAreas();
                    foreach ($data as $key => $area) :
                        $key += 1;
                    ?>
                        <div class="location-card rounded-2xl p-6 shadow-lg">
                            <!-- Number badge centered at top -->
                            <div class="flex justify-center mb-4">
                                <div class="number-badge w-12 h-12 rounded-xl flex items-center justify-center text-white font-bold text-lg shadow-lg">
                                    <?= $key ?>
                                </div>
                            </div>

                            <div class="flex items-start gap-4">
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-3 mb-4 pb-3 border-b" style="border-color: color-mix(in srgb, var(--primary) 10%, transparent);">
                                        <h5 class="text-xl font-bold text-gray-800 flex-1"><?= $area['value'] ?></h5>
                                        <div class="flex items-center gap-1 text-sm <?= $area['charges'] > 0 ? 'text-gray-600' : 'free-delivery px-3 py-1 rounded-full font-semibold' ?>">
                                            <?php if ($area['charges'] > 0): ?>
                                                <i class='bx bx-package'></i>
                                                <?= currencyToSymbol($storeCurrency) . $area['charges'] ?>
                                            <?php else: ?>
                                                <i class='bx bx-gift'></i>
                                                FREE
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <div class="space-y-4">
                                        <div class="info-item p-3 rounded-lg">
                                            <div class="flex items-center text-sm">
                                                <span class="font-semibold text-gray-700 w-32 flex-shrink-0 flex items-center gap-2">
                                                    <i class='bx bx-map icon-color'></i>
                                                    <?= getData("delivery_area_type", "seller_settings", "(seller_id = '$sellerId' AND store_id = '$storeId')") == "zip_code" ? "Postal Code" : "State" ?>
                                                </span>
                                                <span class="text-gray-900 font-medium px-3 py-1 rounded-full" style="background-color: color-mix(in srgb, var(--primary) 5%, white);"><?= $area['value'] ?></span>
                                            </div>
                                        </div>

                                        <div class="info-item p-3 rounded-lg">
                                            <div class="flex items-center text-sm">
                                                <span class="font-semibold text-gray-700 w-32 flex-shrink-0 flex items-center gap-2">
                                                    <i class='bx bx-dollar-circle icon-color'></i>
                                                    Delivery Fee
                                                </span>
                                                <span class="<?= $area['charges'] > 0 ? 'text-gray-900 font-medium' : 'text-emerald-600 font-semibold' ?>">
                                                    <?= $area['charges'] > 0 ? currencyToSymbol($storeCurrency) . $area['charges'] : "No Charges" ?>
                                                </span>
                                            </div>
                                        </div>

                                        <?php if (!empty($area['delivery_notes'])) : ?>
                                            <div class="mt-4 pt-4 rounded-xl p-4" style="border-top: 1px solid color-mix(in srgb, var(--primary) 10%, transparent); background-color: color-mix(in srgb, var(--primary) 3%, white);">
                                                <div class="flex items-start gap-2">
                                                    <i class='bx bx-info-circle icon-color mt-0.5 flex-shrink-0'></i>
                                                    <p class="text-sm text-gray-600 leading-relaxed"><?= $area['delivery_notes'] ?></p>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Divider -->
            <div class="divider my-16 w-3/4 mx-auto"></div>

            <!-- Our Locations Section -->
            <div class="mb-16">
                <div class="text-center mb-12">
                    <div class="inline-flex items-center gap-3 mb-4">
                        <div class="w-2 h-2 rounded-full pulse-dot"></div>
                        <h2 class="text-3xl md:text-4xl font-bold section-title">Our Locations</h2>
                        <div class="w-2 h-2 rounded-full pulse-dot"></div>
                    </div>
                    <p class="text-gray-600 text-lg max-w-2xl mx-auto">
                        Visit us at any of our beautiful stores and experience the magic ✨
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">
                    <?php
                    $data = readData("*", "seller_locations", "(seller_id = '$sellerId' AND store_id = '$storeId')");
                    foreach ($data as $key => $location) :
                        $key += 1;
                        $locationTypeClass = $location['location_type'] == "pickup" ? "type-badge" : "bg-gradient-to-r from-purple-500 to-purple-600 text-white px-3 py-1 rounded-full text-xs font-medium";
                        $locationTypeText = $location['location_type'] == "pickup" ? "Pickup Point" : "Store Location";
                        $locationIcon = $location['location_type'] == "pickup" ? "bx-package" : "bx-store";
                    ?>
                        <div class="location-card rounded-2xl p-6 shadow-lg">
                            <div class="flex justify-center mb-5">
                                <div class="number-badge w-12 h-12 rounded-xl flex items-center justify-center text-white font-bold text-lg shadow-lg">
                                    <?= $key ?>
                                </div>
                            </div>
                            <div class="flex items-start gap-4">
                                <div class="flex-1 min-w-0">
                                    <h5 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                                        <?= $location['name'] ?>
                                        <?php if ($location['phone']) : ?>
                                            <a href="tel:<?= $location['phone'] ?>" class="hover-icon transition-colors" style="color: var(--primary);">
                                                <i class='bx bx-phone-call text-lg'></i>
                                            </a>
                                        <?php endif ?>
                                    </h5>

                                    <div class="space-y-3 text-sm">
                                        <!-- Address -->
                                        <div class="info-item p-3 rounded-lg">
                                            <div class="flex items-start">
                                                <span class="font-semibold text-gray-700 w-24 flex-shrink-0 flex items-center gap-2">
                                                    <i class='bx bx-map-pin icon-color'></i>
                                                    Address
                                                </span>
                                                <span class="text-gray-900 flex-1"><?= $location['address_1'] ?></span>
                                            </div>
                                        </div>

                                        <?php if ($location['address_2']) : ?>
                                            <div class="info-item p-3 rounded-lg">
                                                <div class="flex items-start">
                                                    <span class="font-semibold text-gray-700 w-24 flex-shrink-0 flex items-center gap-2">
                                                        <i class='bx bx-map icon-color'></i>
                                                        Address 2
                                                    </span>
                                                    <span class="text-gray-900 flex-1"><?= $location['address_2'] ?></span>
                                                </div>
                                            </div>
                                        <?php endif ?>

                                        <!-- Location Details -->
                                        <div class="grid grid-cols-2 gap-3">
                                            <div class="info-item p-3 rounded-lg">
                                                <div class="flex items-center">
                                                    <span class="font-semibold text-gray-700 text-xs flex items-center gap-1">
                                                        <i class='bx bx-buildings icon-color'></i>
                                                        City
                                                    </span>
                                                </div>
                                                <span class="text-gray-900 text-sm font-medium"><?= $location['city'] ?></span>
                                            </div>

                                            <div class="info-item p-3 rounded-lg">
                                                <div class="flex items-center">
                                                    <span class="font-semibold text-gray-700 text-xs flex items-center gap-1">
                                                        <i class='bx bx-mail-send icon-color'></i>
                                                        Postal Code
                                                    </span>
                                                </div>
                                                <span class="text-gray-900 text-sm font-medium"><?= $location['zip_code'] ?></span>
                                            </div>

                                            <div class="info-item p-3 rounded-lg">
                                                <div class="flex items-center">
                                                    <span class="font-semibold text-gray-700 text-xs flex items-center gap-1">
                                                        <i class='bx bx-globe icon-color'></i>
                                                        State
                                                    </span>
                                                </div>
                                                <span class="text-gray-900 text-sm font-medium"><?= $location['state'] ?></span>
                                            </div>

                                            <div class="info-item p-3 rounded-lg">
                                                <div class="flex items-center">
                                                    <span class="font-semibold text-gray-700 text-xs flex items-center gap-1">
                                                        <i class='bx bx-flag icon-color'></i>
                                                        Country
                                                    </span>
                                                </div>
                                                <span class="text-gray-900 text-sm font-medium"><?= codeToCountry($location['country']) ?></span>
                                            </div>
                                        </div>

                                        <!-- Contact Info -->
                                        <?php if ($location['phone'] || $location['email']) : ?>
                                            <div class="mt-4 pt-4" style="border-top: 1px solid color-mix(in srgb, var(--primary) 10%, transparent);">
                                                <h6 class="font-semibold text-gray-800 mb-3 text-sm flex items-center gap-2">
                                                    <i class='bx bx-chat icon-color'></i>
                                                    Contact Info
                                                </h6>
                                                <div class="grid grid-cols-1 gap-2">
                                                    <?php if ($location['phone']) : ?>
                                                        <div class="flex items-center gap-3 p-2 rounded-lg transition-colors hover:bg-pink-50">
                                                            <i class='bx bx-phone icon-color'></i>
                                                            <a href="tel:<?= $location['phone'] ?>" class="hover-icon font-medium text-sm" style="color: var(--primary);">
                                                                <?= formatPhoneNumber($location['phone']) ?>
                                                            </a>
                                                        </div>
                                                    <?php endif ?>

                                                    <?php if ($location['email']) : ?>
                                                        <div class="flex items-center gap-3 p-2 rounded-lg transition-colors hover:bg-pink-50">
                                                            <i class='bx bx-envelope icon-color'></i>
                                                            <a href="mailto:<?= $location['email'] ?>" class="hover-icon font-medium text-sm truncate" style="color: var(--primary);">
                                                                <?= $location['email'] ?>
                                                            </a>
                                                        </div>
                                                    <?php endif ?>
                                                </div>
                                            </div>
                                        <?php endif ?>
                                    </div>

                                    <!-- Business Hours -->
                                    <div class="mt-6 pt-4" style="border-top: 1px solid color-mix(in srgb, var(--primary) 10%, transparent);">
                                        <h6 class="font-semibold text-gray-800 mb-3 text-sm flex items-center gap-2">
                                            <i class='bx bx-time-five icon-color'></i>
                                            Business Hours
                                        </h6>
                                        <div class="grid grid-cols-1 gap-2">
                                            <?php
                                            $business_hours = getLocationBusinessHour($location['location_id']);
                                            foreach ($business_hours as $key => $hour) :
                                            ?>
                                                <div class="flex items-center justify-between text-xs p-2 rounded-lg transition-colors hover:bg-pink-50">
                                                    <span class="font-medium text-gray-700"><?= $hour['day'] ?></span>
                                                    <span class="text-gray-500 font-medium">
                                                        <?= strtoupper(date('h:i a', strtotime($hour['time_from']))) ?> - <?= strtoupper(date('h:i a', strtotime($hour['time_to']))) ?>
                                                    </span>
                                                </div>
                                            <?php endforeach ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

        </div>
    </div>

    <!-- CTA Section -->
    <div class="py-12" style="background: linear-gradient(to right, var(--primary), var(--hover-color));">
        <div class="max-w-4xl mx-auto text-center px-4">
            <h3 class="text-2xl md:text-3xl font-bold text-white mb-4">Ready to Experience the Magic?</h3>
            <p class="text-pink-100 text-lg mb-6">Order now and let us bring happiness to your doorstep!</p>
            <a href="<?= $storeUrl ?>shop-all"
                class="inline-flex items-center gap-2 bg-white px-8 py-3 rounded-full font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 hover:opacity-90"
                style="color: var(--primary);">
                <i class='bx bx-shopping-bag'></i>
                Start Shopping
            </a>
        </div>
    </div>

    <!-- Footer -->
    <?php include_once __DIR__ . "/includes/footer.php"; ?>

</body>

</html>