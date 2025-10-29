<?php include_once __DIR__ . "/includes/files_includes.php"; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!--Php File Include For Head Links & Scripts-->
    <?php include_once __DIR__ . "/includes/head_links.php"; ?>
    <style>
        :root {
            --primary: <?= htmlspecialchars(getData("color", "seller_settings", "(seller_id='$sellerId' AND store_id='$storeId')") ?? '#ff007f') ?>;
        }

        /* Simple confetti animation */
        .confetti {
            position: absolute;
            width: 10px;
            height: 10px;
            background: linear-gradient(45deg, var(--primary), #f97316, #8b5cf6, #06b6d4);
            opacity: 0.8;
            animation: confetti-fall 3s ease-in-out infinite;
        }

        .confetti:nth-child(1) {
            left: 10%;
            animation-delay: 0s;
        }

        .confetti:nth-child(2) {
            left: 30%;
            animation-delay: 0.5s;
        }

        .confetti:nth-child(3) {
            left: 50%;
            animation-delay: 1s;
        }

        .confetti:nth-child(4) {
            left: 70%;
            animation-delay: 1.5s;
        }

        .confetti:nth-child(5) {
            left: 90%;
            animation-delay: 2s;
        }

        @keyframes confetti-fall {
            0% {
                transform: translateY(-100px) rotate(0deg);
                opacity: 1;
            }

            100% {
                transform: translateY(500px) rotate(360deg);
                opacity: 0;
            }
        }
    </style>
</head>
<?php

if (isset($_GET['order_id']) && getData("id", "seller_orders", "order_id = '{$_GET['order_id']}' AND customer_id = '$customerId'")) {
    $order_id = $_GET['order_id'];
    $name = getData("name", "seller_order_address", "order_id = '$order_id' AND type = 'billing'");
} else {
    redirect($storeUrl);
}

?>

<body class="bg-gradient-to-br from-pink-50 to-rose-50 font-sans min-h-screen" style="--primary: <?= htmlspecialchars(getData('color', 'seller_settings', "(seller_id='$sellerId' AND store_id='$storeId')") ?? '#ff007f') ?>;">
    <!--Php File Include For Nav Bar-->
    <?php include_once __DIR__ . "/includes/navbar.php"; ?>

    <div class="py-16">
        <div class="max-w-2xl mx-auto px-4">
            <!-- Success Card -->
            <div class="bg-white rounded-2xl shadow-xl p-8 md:p-12 text-center border border-pink-100">
                <!-- Animated Checkmark -->
                <div class="w-24 h-24 mx-auto mb-6 rounded-full flex items-center justify-center shadow-lg"
                    style="background: linear-gradient(to bottom right, var(--primary), #f472b6);">
                    <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>

                <!-- Confetti Animation Container -->
                <div class="absolute top-0 left-0 w-full h-1 overflow-hidden">
                    <div class="confetti"></div>
                    <div class="confetti"></div>
                    <div class="confetti"></div>
                    <div class="confetti"></div>
                    <div class="confetti"></div>
                </div>

                <!-- Greeting -->
                <h3 class="text-lg font-semibold text-gray-600 mb-2">Hey <?= htmlspecialchars($name) ?>,</h3>

                <!-- Main Heading -->
                <h1 class="text-3xl md:text-4xl font-bold bg-clip-text text-transparent mb-4"
                    style="background: linear-gradient(to right, var(--primary), #f472b6); -webkit-background-clip: text; background-clip: text;">
                    Your Order is Confirmed!
                </h1>

                <!-- Description -->
                <p class="text-gray-600 text-lg leading-relaxed max-w-md mx-auto mb-8">
                    Your items are now being prepared, and we're excited for you to receive them soon.
                    Your support means everything to us!
                </p>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                    <!-- Check Status Button -->
                    <a href="<?= $storeUrl . "order?id=" . $order_id ?>"
                        class="text-white font-semibold py-3 px-8 rounded-full shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 inline-flex items-center gap-2"
                        style="background: linear-gradient(to right, var(--primary), #f472b6);">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        CHECK STATUS
                    </a>

                    <!-- WhatsApp Button -->
                    <?php if (!empty(getSettings("whatsapp_payment"))) : ?>
                        <a href="<?= $storeUrl . "whatsapp-order?id=" . $order_id ?>"
                            class="bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-semibold py-3 px-8 rounded-full shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 inline-flex items-center gap-2">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893-.001-3.189-1.262-6.209-3.549-8.485" />
                            </svg>
                            WHATSAPP MESSAGE
                        </a>
                    <?php endif ?>
                </div>

                <!-- Additional Info -->
                <div class="mt-8 pt-6 border-t border-pink-100">
                    <p class="text-sm text-gray-500">
                        Order ID:
                        <a href="<?= $storeUrl . "order?id=" . $order_id ?>"
                            class="font-mono font-semibold underline hover:opacity-80 transition"
                            style="color: var(--primary);">
                            #<?= htmlspecialchars($order_id) ?>
                        </a>
                    </p>
                    <p class="text-sm text-gray-500 mt-2">
                        We'll send you shipping confirmation soon!
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!--Footer File Includes that file has all JS Files includes links-->
    <?php include_once __DIR__ . "/includes/footer.php"; ?>
</body>

</html>