<?php include_once __DIR__ . "/includes/files_includes.php"; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!--Php File Include For Head Links & Scripts-->
    <?php include_once __DIR__ . "/includes/head_links.php"; ?>
</head>

<body class="font-sans bg-pink-50 min-h-screen">

    <!-- Minimum Order Amount Start-->
    <?php if (!empty(getSettings("minimum_order_amount"))) : ?>
        <div class="w-full bg-pink-600 text-white text-center py-1 text-sm font-semibold">
            Minimum Order: <?= currencyToSymbol($storeCurrency) . getSettings("minimum_order_amount") ?>
        </div>
    <?php endif; ?>
    <!-- Minimum Order Amount End-->

    <!--Php File Include For Nav Bar-->
    <?php include_once __DIR__ . "/includes/navbar.php"; ?>

    <!-- Your Cart Section Start-->
    <div class="py-12 bg-gray-50" id="content">

        <!--Calling In ajax/cart.php-->

        <!-- Flex Layout -->

        <!-- Left Side: Cart Items -->

        <!-- Right Side: Sticky Order Summary -->

    </div>
    <!-- Your Cart Section End-->



    <!--Footer File Includes that file has all JS Files includes links-->
    <?php include_once __DIR__ . "/includes/footer.php"; ?>
        <!--This File For Cart Page View-->
        <script src="<?= APP_URL ?>shop/javascripts/cart.js"></script>

</body>

</html>