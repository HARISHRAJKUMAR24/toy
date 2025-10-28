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

<body class="font-sans bg-pink-50 flex flex-col min-h-screen">



    <!--Php File Include For Nav Bar-->
    <?php include_once __DIR__ . "/includes/navbar.php"; ?>


    <!-- Login Section Start -->
    <section class="flex items-center justify-center bg-pink-50 py-12 px-4">
        <div class="w-full max-w-md bg-white/70 backdrop-blur-md rounded-3xl shadow-lg p-6">

            <!-- Header -->
            <div class="text-center mb-6">
                <?php if (getSettings("logo")) : ?>
                    <img src="<?= UPLOADS_URL . getSettings("logo") ?>" alt="Logo" class="mx-auto mb-2 h-12 w-auto">
                <?php else : ?>
                    <div class="mx-auto mb-2 w-12 h-12 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 text-white rounded-full flex items-center justify-center uppercase text-lg font-bold">
                        <?= substr($storeName, 0, 1) ?>
                    </div>
                <?php endif; ?>
                <h2 class="text-xl sm:text-2xl md:text-3xl lg:text-3xl font-bold text-hover"> Login to your account </h2>

                <p class="text-gray-600 text-sm mt-1">Enter your details to continue</p>
            </div>

            <!-- Rest of your form code remains the same -->
            <form id="form" class="space-y-4">
                <div id="step1">
                    <!-- Email/Phone -->
                    <div class="mb-4" id="emailWrapper" style="display:none;">
                        <label for="email" class="block text-gray-700 font-medium mb-1">Email or Phone</label>
                        <input type="email" name="email" id="email" placeholder="Email or Phone"
                            class="w-full px-4 py-3 border rounded-xl focus:outline-none focus:ring-2 focus:ring-pink-400 transition email-and-phone">
                    </div>

                    <div class="mb-4" id="phoneWrapper">
                        <label for="phone" class="block text-gray-700 font-medium mb-1">Phone or Email</label>
                        <input type="tel" name="phone[main]" id="phone" placeholder="Phone or Email"
                            class="w-full px-4 py-3 border rounded-xl focus:outline-none focus:ring-2 focus:ring-pink-400 transition email-and-phone">
                    </div>

                    <!-- Password -->
                    <div class="mb-4">
                        <div class="flex items-center justify-between">
                            <label for="password" class="block text-gray-700 font-medium mb-1">Password</label>
                            <a href="<?= $storeUrl ?>forgot-password" class="text-hover font-semibold hover:underline text-sm">Forgot Password?</a>
                        </div>
                        <input type="password" name="password" id="password" placeholder="Enter a password" required
                            class="w-full px-4 py-3 border rounded-xl focus:outline-none focus:ring-2 focus:ring-pink-400 transition">
                    </div>

                    <!-- Login Button -->
                    <button type="button" id="sendOtp"
                        class="w-full bg-primary-500 text-white py-3 rounded-xl font-semibold shadow-lg hover:bg-hover transition-all login">
                        Login
                    </button>
                </div>
            </form>

            <!-- Register Link -->
            <p class="text-center text-gray-600 text-sm mt-6">
                Don't have an account?
                <a href="<?= $storeUrl ?>register<?= isset($_GET['step']) ? '?step' : '' ?>" class="text-hover font-semibold hover:underline">Create</a>
            </p>

        </div>
    </section>
    <!-- Login Section End -->


    <!--Footer File Includes that file has all JS Files includes links-->
    <?php include_once __DIR__ . "/includes/footer.php"; ?>


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

    <script src="<?= APP_URL ?>shop/javascripts/login.js"></script>
</body>

</html>