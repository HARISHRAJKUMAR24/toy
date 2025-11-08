<?php include_once __DIR__ . "/includes/files_includes.php"; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include_once __DIR__ . "/includes/head_links.php"; ?>
</head>

<body class="font-sans bg-pink-50 flex flex-col min-h-screen">

    <!--Php File Include For Nav Bar-->
    <?php include_once __DIR__ . "/includes/navbar.php"; ?>

    <!-- Forgot Password Section Start-->
    <section class="flex items-center justify-center bg-pink-50 py-12 px-4">
        <div class="w-full max-w-md bg-white/70 backdrop-blur-md rounded-3xl shadow-lg p-6">

            <!-- Heading -->
            <div class="text-center mb-6">
                <?php if (getSettings("logo")) : ?>
                    <img src="<?= UPLOADS_URL . getSettings("logo") ?>" alt="Logo" class="mx-auto mb-2 h-12 w-auto">
                <?php else : ?>
                    <div class="mx-auto mb-2 w-12 h-12 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 text-white rounded-full flex items-center justify-center uppercase text-lg font-bold">
                        <?= substr($storeName, 0, 1) ?>
                    </div>
                <?php endif; ?>
                <h2 class="text-xl sm:text-2xl md:text-3xl lg:text-3xl font-bold text-hover"> Forgot password</h2>
                <p class="text-gray-600 text-sm mt-1">
                    <?php if ((int)getSeller("credits") <= 0) { ?>
                        Enter your email to reset your password
                    <?php } else { ?>
                        Enter your phone number to reset your password
                    <?php } ?>
                </p>
            </div>

            <!-- Form -->
            <form id="form" class="space-y-4">

                <!-- Step 1 -->
                <div id="step1">
                    <?php if ((int)getSeller("credits") <= 0) { ?>
                        <!-- Email Input -->
                        <div class="mb-4">
                            <label for="email" class="block text-gray-700 font-medium mb-2 text-sm">Email Address</label>
                            <input type="email" name="user" id="email" placeholder="Enter your email"
                                class="w-full px-3 py-2 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-pink-400 transition">
                        </div>
                    <?php } else { ?>
                        <!-- Phone Number Input -->
                        <div class="mb-4">
                            <label for="phone" class="block text-gray-700 font-medium mb-2 text-sm">Phone Number</label>
                            <div class="w-full">
                                <input type="tel" name="user" id="phone" placeholder="Enter your phone number"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-pink-400 transition">
                            </div>
                        </div>
                    <?php } ?>

                    <!-- Send OTP Button -->
                    <button id="sendOtp" type="button"
                        class="w-full bg-primary-500 text-white py-3 rounded-xl font-semibold shadow-lg hover:bg-hover transition-all mt-2">
                        Send OTP
                    </button>
                </div>

                <!-- Step 2 -->
                <div id="step2" style="display: none;">
                    <!-- OTP Message -->
                    <div id="msg" class="p-3 mb-4 text-sm rounded-lg bg-cyan-100 text-cyan-500"></div>

                    <!-- OTP Input -->
                    <div class="mb-4">
                        <label for="otp" class="block text-gray-700 font-medium mb-2 text-sm">OTP Code</label>
                        <input type="number" name="otp" id="otp" placeholder="Enter OTP code"
                            class="w-full px-3 py-2 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-pink-400 transition">
                    </div>

                    <!-- New Password -->
                    <div class="mb-4">
                        <label for="new_password" class="block text-gray-700 font-medium mb-2 text-sm">New Password</label>
                        <input type="password" name="new_password" id="new_password" placeholder="Enter new password"
                            class="w-full px-3 py-2 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-pink-400 transition">
                    </div>

                    <!-- Confirm Password -->
                    <div class="mb-4">
                        <label for="confirm_password" class="block text-gray-700 font-medium mb-2 text-sm">Confirm Password</label>
                        <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm new password"
                            class="w-full px-3 py-2 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-pink-400 transition">
                    </div>

                    <!-- Change Password Button -->
                    <button id="change" type="button"
                        class="w-full bg-primary-500 text-white py-3 rounded-xl font-semibold shadow-lg hover:bg-hover transition-all mt-2">
                        Change Password
                    </button>
                </div>

            </form>

            <!-- Back to Login Link -->
            <p class="text-center text-gray-600 text-sm mt-6">
                Remembered your password?
                <a href="<?= $storeUrl ?>login" class="text-pink-600 font-semibold hover:underline">
                    Login
                </a>
            </p>

        </div>
    </section>
    <!-- Forgot Password Section End-->

    <!--Footer File Includes that file has all JS Files includes links-->
    <?php include_once __DIR__ . "/includes/footer.php"; ?>

    <!-- Intl Tel Input CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css" />

    <!-- Intl Tel Input JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>

    <style>
        .iti {
            width: 100%;
        }

        .iti input {
            width: 100% !important;
        }
    </style>

    <script>
        // Initialize intl tel input only if phone field exists
        const phoneInputField = document.querySelector("#phone");
        if (phoneInputField) {
            const phoneInput = window.intlTelInput(phoneInputField, {
                initialCountry: "in",
                separateDialCode: true,
                onlyCountries: ['IN'],
                preferredCountries: ["<?= getSettings("country") ?>"],
                hiddenInput: "full",
                utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
            });
        }
    </script>

    <script src="<?= APP_URL ?>shop/javascripts/forgot-password.js"></script>

</body>

</html>