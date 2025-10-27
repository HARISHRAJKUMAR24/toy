<?php include_once __DIR__ . "/includes/files_includes.php"; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!--Php File Include For Head Links & Scripts-->
    <?php include_once __DIR__ . "/includes/head_links.php"; ?>
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #fdf2f8 0%, #fce7f3 50%, #fbcfe8 100%);
        }

        .location-card {
            background: white;
            border: 1px solid #fbcfe8;
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
            background: linear-gradient(90deg, #ec4899, #db2777, #be185d);
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        .location-card:hover::before {
            transform: scaleX(1);
        }

        .location-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 25px 50px -12px rgba(236, 72, 153, 0.25);
            border-color: #f472b6;
        }

        .number-badge {
            background: linear-gradient(135deg, #ec4899, #db2777);
            color: white;
            box-shadow: 0 4px 6px -1px rgba(236, 72, 153, 0.3), 0 2px 4px -1px rgba(236, 72, 153, 0.1);
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
            background: linear-gradient(90deg, transparent, #f472b6, transparent);
            height: 2px;
        }

        .info-item {
            transition: all 0.3s ease;
        }

        .info-item:hover {
            background: #fdf2f8;
            border-radius: 0.5rem;
        }

        .pulse-dot {
            animation: pulse 2s infinite;
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
    </style>
</head>

<body class="font-sans">

    <!-- Minimum Order Amount Start-->
    <?php if (!empty(getSettings("minimum_order_amount"))) : ?>
        <div class="w-full bg-gradient-to-r from-pink-500 to-pink-600 text-white text-center py-3 text-sm font-semibold shadow-lg">
            Minimum Order: <?= currencyToSymbol($storeCurrency) . getSettings("minimum_order_amount") ?>
        </div>
    <?php endif; ?>
    <!-- Minimum Order Amount End-->

    <!--Php File Include For Nav Bar-->
    <?php include_once __DIR__ . "/includes/navbar.php"; ?>

    <!-- Hero Section -->
    <div class="gradient-bg py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="mb-8">
                <div class="w-20 h-20 mx-auto mb-4 bg-white rounded-2xl shadow-lg flex items-center justify-center">
                    <i class='bx bx-map-pin text-3xl text-pink-600'></i>
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
                        <div class="w-2 h-2 bg-pink-500 rounded-full pulse-dot"></div>
                        <h2 class="text-3xl md:text-4xl font-bold section-title">Delivery Areas</h2>
                        <div class="w-2 h-2 bg-pink-500 rounded-full pulse-dot"></div>
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
                            <div class="flex items-start gap-4">
                                <div class="relative flex-shrink-0">
                                    <div class="number-badge w-12 h-12 rounded-xl flex items-center justify-center text-white font-bold text-lg shadow-lg">
                                        <?= $key ?>
                                    </div>
                                </div>

                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-3 mb-4 pb-3 border-b border-pink-100">
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
                                                    <i class='bx bx-map text-pink-500'></i>
                                                    <?= getData("delivery_area_type", "seller_settings", "(seller_id = '$sellerId' AND store_id = '$storeId')") == "zip_code" ? "Postal Code" : "State" ?>
                                                </span>
                                                <span class="text-gray-900 font-medium bg-pink-50 px-3 py-1 rounded-full"><?= $area['value'] ?></span>
                                            </div>
                                        </div>

                                        <div class="info-item p-3 rounded-lg">
                                            <div class="flex items-center text-sm">
                                                <span class="font-semibold text-gray-700 w-32 flex-shrink-0 flex items-center gap-2">
                                                    <i class='bx bx-dollar-circle text-pink-500'></i>
                                                    Delivery Fee
                                                </span>
                                                <span class="<?= $area['charges'] > 0 ? 'text-gray-900 font-medium' : 'text-emerald-600 font-semibold' ?>">
                                                    <?= $area['charges'] > 0 ? currencyToSymbol($storeCurrency) . $area['charges'] : "No Charges" ?>
                                                </span>
                                            </div>
                                        </div>

                                        <?php if (!empty($area['delivery_notes'])) : ?>
                                            <div class="mt-4 pt-4 border-t border-pink-100 bg-pink-50/50 rounded-xl p-4">
                                                <div class="flex items-start gap-2">
                                                    <i class='bx bx-info-circle text-pink-500 mt-0.5 flex-shrink-0'></i>
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
                        <div class="w-2 h-2 bg-pink-500 rounded-full pulse-dot"></div>
                        <h2 class="text-3xl md:text-4xl font-bold section-title">Our Locations</h2>
                        <div class="w-2 h-2 bg-pink-500 rounded-full pulse-dot"></div>
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
                            <div class="flex items-start gap-4">
                                <div class="relative flex-shrink-0">
                                    <div class="number-badge w-12 h-12 rounded-xl flex items-center justify-center text-white font-bold text-lg shadow-lg">
                                        <?= $key ?>
                                    </div>
                                    <span class="absolute -top-2 -right-2 text-xs px-2 py-1 rounded-full <?= $locationTypeClass ?> font-medium shadow-lg">
                                        <i class='bx <?= $locationIcon ?> mr-1'></i>
                                        <?= $locationTypeText ?>
                                    </span>
                                </div>

                                <div class="flex-1 min-w-0">
                                    <h5 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                                        <?= $location['name'] ?>
                                        <?php if ($location['phone']) : ?>
                                            <a href="tel:<?= $location['phone'] ?>" class="text-pink-600 hover:text-pink-700 transition-colors">
                                                <i class='bx bx-phone-call text-lg'></i>
                                            </a>
                                        <?php endif ?>
                                    </h5>

                                    <div class="space-y-3 text-sm">
                                        <!-- Address -->
                                        <div class="info-item p-3 rounded-lg">
                                            <div class="flex items-start">
                                                <span class="font-semibold text-gray-700 w-24 flex-shrink-0 flex items-center gap-2">
                                                    <i class='bx bx-map-pin text-pink-500'></i>
                                                    Address
                                                </span>
                                                <span class="text-gray-900 flex-1"><?= $location['address_1'] ?></span>
                                            </div>
                                        </div>

                                        <?php if ($location['address_2']) : ?>
                                            <div class="info-item p-3 rounded-lg">
                                                <div class="flex items-start">
                                                    <span class="font-semibold text-gray-700 w-24 flex-shrink-0 flex items-center gap-2">
                                                        <i class='bx bx-map text-pink-500'></i>
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
                                                        <i class='bx bx-buildings text-pink-500'></i>
                                                        City
                                                    </span>
                                                </div>
                                                <span class="text-gray-900 text-sm font-medium"><?= $location['city'] ?></span>
                                            </div>

                                            <div class="info-item p-3 rounded-lg">
                                                <div class="flex items-center">
                                                    <span class="font-semibold text-gray-700 text-xs flex items-center gap-1">
                                                        <i class='bx bx-mail-send text-pink-500'></i>
                                                        Postal Code
                                                    </span>
                                                </div>
                                                <span class="text-gray-900 text-sm font-medium"><?= $location['zip_code'] ?></span>
                                            </div>

                                            <div class="info-item p-3 rounded-lg">
                                                <div class="flex items-center">
                                                    <span class="font-semibold text-gray-700 text-xs flex items-center gap-1">
                                                        <i class='bx bx-globe text-pink-500'></i>
                                                        State
                                                    </span>
                                                </div>
                                                <span class="text-gray-900 text-sm font-medium"><?= $location['state'] ?></span>
                                            </div>

                                            <div class="info-item p-3 rounded-lg">
                                                <div class="flex items-center">
                                                    <span class="font-semibold text-gray-700 text-xs flex items-center gap-1">
                                                        <i class='bx bx-flag text-pink-500'></i>
                                                        Country
                                                    </span>
                                                </div>
                                                <span class="text-gray-900 text-sm font-medium"><?= codeToCountry($location['country']) ?></span>
                                            </div>
                                        </div>

                                        <!-- Contact Info -->
                                        <?php if ($location['phone'] || $location['email']) : ?>
                                            <div class="mt-4 pt-4 border-t border-pink-100">
                                                <h6 class="font-semibold text-gray-800 mb-3 text-sm flex items-center gap-2">
                                                    <i class='bx bx-chat text-pink-500'></i>
                                                    Contact Info
                                                </h6>
                                                <div class="grid grid-cols-1 gap-2">
                                                    <?php if ($location['phone']) : ?>
                                                        <div class="flex items-center gap-3 p-2 rounded-lg hover:bg-pink-50 transition-colors">
                                                            <i class='bx bx-phone text-pink-500'></i>
                                                            <a href="tel:<?= $location['phone'] ?>" class="text-pink-600 hover:text-pink-700 font-medium text-sm">
                                                                <?= formatPhoneNumber($location['phone']) ?>
                                                            </a>
                                                        </div>
                                                    <?php endif ?>

                                                    <?php if ($location['email']) : ?>
                                                        <div class="flex items-center gap-3 p-2 rounded-lg hover:bg-pink-50 transition-colors">
                                                            <i class='bx bx-envelope text-pink-500'></i>
                                                            <a href="mailto:<?= $location['email'] ?>" class="text-pink-600 hover:text-pink-700 font-medium text-sm truncate">
                                                                <?= $location['email'] ?>
                                                            </a>
                                                        </div>
                                                    <?php endif ?>
                                                </div>
                                            </div>
                                        <?php endif ?>
                                    </div>

                                    <!-- Business Hours -->
                                    <div class="mt-6 pt-4 border-t border-pink-100">
                                        <h6 class="font-semibold text-gray-800 mb-3 text-sm flex items-center gap-2">
                                            <i class='bx bx-time-five text-pink-500'></i>
                                            Business Hours
                                        </h6>
                                        <div class="grid grid-cols-1 gap-2">
                                            <?php
                                            $business_hours = getLocationBusinessHour($location['location_id']);
                                            foreach ($business_hours as $key => $hour) :
                                            ?>
                                                <div class="flex items-center justify-between text-xs p-2 rounded-lg hover:bg-pink-50 transition-colors">
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
    <div class="bg-gradient-to-r from-pink-500 to-pink-600 py-12">
        <div class="max-w-4xl mx-auto text-center px-4">
            <h3 class="text-2xl md:text-3xl font-bold text-white mb-4">Ready to Experience the Magic?</h3>
            <p class="text-pink-100 text-lg mb-6">Order now and let us bring happiness to your doorstep!</p>
            <a href="<?= $storeUrl ?>shop-all"
                class="inline-flex items-center gap-2 bg-white text-pink-600 px-8 py-3 rounded-full font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
                <i class='bx bx-shopping-bag'></i>
                Start Shopping
            </a>
        </div>
    </div>

    <!--Footer File Includes that file has all JS Files includes links-->
    <?php include_once __DIR__ . "/includes/footer.php"; ?>

</body>

</html>