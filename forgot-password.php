<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Wishlist - ToyShop</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="font-sans bg-pink-50 flex flex-col min-h-screen">

    <!-- Minimum Order Amount Start-->
    <?php if (!empty(getSettings("minimum_order_amount"))) : ?>
        <div class="w-full bg-pink-600 text-white text-center py-1 text-sm font-semibold">
            Minimum Order: <?= currencyToSymbol($storeCurrency) . getSettings("minimum_order_amount") ?>
        </div>
    <?php endif; ?>
    <!-- Minimum Order Amount End-->

    <!--Php File Include For Nav Bar-->
    <?php include_once __DIR__ . "/includes/navbar.php"; ?>



    <!-- Forgot Password Section Start-->
    <section class="flex items-center justify-center bg-pink-50 py-12 px-4">
        <div class="w-full max-w-md bg-white/70 backdrop-blur-md rounded-3xl shadow-lg p-6">

            <!-- Heading -->
            <div class="text-center mb-4">
                <img src="https://img.icons8.com/color/48/toy-train.png" alt="Logo" class="mx-auto mb-1">
                <h2 class="text-2xl sm:text-3xl md:text-4xl lg:text-4xl font-bold text-pink-600">Forgot Password?</h2>
                <p class="text-gray-600 text-sm mt-1">Enter your phone number to reset your password</p>
            </div>

            <!-- Form -->
            <form class="space-y-3">

                <!-- Phone Number Input -->
                <div>
                    <label for="phone" class="block text-gray-700 font-medium mb-1 text-sm">Phone Number</label>
                    <div class="flex">
                        <span
                            class="flex items-center gap-1 px-2 rounded-l-xl border border-r-0 border-gray-300 bg-gray-100 text-gray-700">
                            <img src="https://flagcdn.com/16x12/in.png" alt="India"
                                class="w-4 h-3 object-cover rounded-sm">
                            +91
                        </span>
                        <input type="tel" id="phone" placeholder="Enter your phone"
                            class="flex-1 px-2 py-1.5 border rounded-r-xl focus:outline-none focus:ring-2 focus:ring-pink-400 transition">
                    </div>
                </div>

                <!-- Send OTP Button -->
                <button type="submit"
                    class="w-full bg-gradient-to-r from-pink-400 to-pink-600 text-white py-2 rounded-xl font-semibold shadow-lg hover:from-pink-500 hover:to-pink-700 transition-all">
                    Send OTP
                </button>

            </form>

            <!-- Back to Login Link -->
            <p class="text-center text-gray-600 text-sm mt-4">
                Remembered your password?
                <a href="#" class="text-pink-600 font-semibold hover:underline">Login</a>
            </p>

        </div>
    </section>
    <!-- Forgot Password Section End-->

    <!--Footer File Includes that file has all JS Files includes links-->
    <?php include_once __DIR__ . "/includes/footer.php"; ?>

</body>

</html>