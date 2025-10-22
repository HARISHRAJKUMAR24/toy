<?php include_once __DIR__ . "/includes/files_includes.php"; ?>


<!DOCTYPE html>
<html lang="en">

<head>
    <!--Php File Include For Head Links & Scripts-->
    <?php include_once __DIR__ . "/includes/head_links.php"; ?>
    <style>
        /*<==========> CSS Styles <==========>*/

        /*------------- Phone Number Input Field Full Width Fix -------------*/
        .iti {
            width: 100% !important;
        }
    </style>
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


    <!-- Register Section Start -->
    <section class="flex items-center justify-center bg-pink-50 py-12 px-4">
        <div class="w-full max-w-md bg-white/70 backdrop-blur-md rounded-3xl shadow-lg p-6">

            <!-- Header -->
            <div class="text-center mb-6">
                <img src="https://img.icons8.com/color/48/toy-train.png" alt="Logo" class="mx-auto mb-2">
                <h2 class="text-2xl sm:text-3xl md:text-4xl lg:text-4xl font-bold text-pink-600">Sign Up</h2>
                <p class="text-gray-600 text-sm mt-1">Enter your details to continue</p>
            </div>

            <!-- Form -->
            <form id="form" class="space-y-4">
                <!-- Step 1 -->
                <div id="step1">
                    <!-- Name -->
                    <div class="mb-4">
                        <label for="name" class="block text-gray-700 font-medium mb-1">Name</label>
                        <input type="text" name="name" id="name" placeholder="Enter your name" required
                            class="w-full px-4 py-2 border rounded-xl focus:outline-none focus:ring-2 focus:ring-pink-400 transition">
                    </div>

                    <!-- Phone Number -->
                    <div class="mb-4">
                        <label for="phone" class="block text-gray-700 font-medium mb-1">Phone Number</label>
                        <input type="tel" name="phone[main]" id="phone" placeholder="Enter your phone" required
                            class="w-full px-4 py-2 border rounded-xl focus:outline-none focus:ring-2 focus:ring-pink-400 transition">
                    </div>


                    <!-- Email -->
                    <div class="mb-4">
                        <label for="email" class="block text-gray-700 font-medium mb-1">Email Address (optional)</label>
                        <input type="email" name="email" id="email" placeholder="Enter your email"
                            class="w-full px-4 py-2 border rounded-xl focus:outline-none focus:ring-2 focus:ring-pink-400 transition">
                    </div>

                    <!-- Password -->
                    <div class="mb-4">
                        <label for="password" class="block text-gray-700 font-medium mb-1">Password</label>
                        <input type="password" name="password" id="password" placeholder="Enter a password" required
                            class="w-full px-4 py-2 border rounded-xl focus:outline-none focus:ring-2 focus:ring-pink-400 transition">
                    </div>

                    <!-- Send OTP Button -->
                    <button type="button" id="sendOtp"
                        class="w-full bg-gradient-to-r from-pink-400 to-pink-600 text-white py-2 rounded-xl font-semibold shadow-lg hover:from-pink-500 hover:to-pink-700 transition-all">
                        SEND OTP
                    </button>
                </div>

                <!-- Step 2 -->
                <div id="step2" style="display:none;">
                    <div id="msg" class="p-3 rounded-lg bg-cyan-100 text-cyan-700 text-sm mb-4"></div>

                    <div>
                        <label for="otp" class="block text-gray-700 font-medium mb-1">Enter OTP</label>
                        <input type="number" name="otp" id="otp" placeholder="Enter OTP" required
                            class="w-full px-4 py-2 border rounded-xl focus:outline-none focus:ring-2 focus:ring-pink-400 transition">
                    </div>

                    <!-- Create Account Button -->
                    <button type="button" id="create"
                        class="w-full mt-4 bg-gradient-to-r from-pink-400 to-pink-600 text-white py-2 rounded-xl font-semibold shadow-lg hover:from-pink-500 hover:to-pink-700 transition-all">
                        CREATE ACCOUNT
                    </button>
                </div>
            </form>

            <!-- Login Link -->
            <p class="text-center text-gray-600 text-sm mt-6">
                Already have an account?
                <a href="<?= $storeUrl ?>login<?= isset($_GET['step']) ? '?step' : '' ?>" class="text-pink-600 font-semibold hover:underline">Login</a>
            </p>

        </div>
    </section>
    <!-- Register Section End-->


    <!--Footer File Includes that file has all JS Files includes links-->
    <?php include_once __DIR__ . "/includes/footer.php"; ?>

    <script src="<?= APP_URL ?>shop/javascripts/register.js"></script>

    <!-- Js Code For Automatically Take (+91) -->
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

</body>

</html>