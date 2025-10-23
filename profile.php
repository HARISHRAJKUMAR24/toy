<?php include_once __DIR__ . "/includes/files_includes.php"; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include_once __DIR__ . "/includes/head_links.php"; ?>
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css" />
</head>

<body class="bg-pink-50 font-sans min-h-screen">

    <!-- Minimum Order -->
    <?php if (!empty(getSettings("minimum_order_amount"))) : ?>
        <div class="w-full bg-pink-600 text-white text-center py-1 text-sm font-semibold">
            Minimum Order: <?= currencyToSymbol($storeCurrency) . getSettings("minimum_order_amount") ?>
        </div>
    <?php endif; ?>

    <?php include_once __DIR__ . "/includes/navbar.php"; ?>

    <!-- Profile Section -->
  <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-800 mb-6 text-center">
            My Profile
        </h1>

        <div class="flex flex-col lg:flex-row gap-8">

            <?php $page = basename($_SERVER['PHP_SELF']); ?>

            <!-- Left Sidebar -->
            <div class="w-full lg:w-2/4">
                <div class="bg-white/70 backdrop-blur-md border border-white/50 rounded-2xl p-6 shadow-lg">

                    <!-- Profile Info -->
                    <div class="flex flex-col items-center mb-6">
                        <div class="relative mb-4">
                            <img id="previewImage"
                                src="<?= !empty(customer('photo')) ? UPLOADS_URL . customer('photo') : 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?auto=format&fit=crop&w=200&q=80' ?>"
                                alt="User Profile"
                                class="w-24 h-24 rounded-full border-4 border-white/50 object-cover transition-all duration-300 shadow-sm">
                            <label for="photo"
                                class="absolute bottom-0 right-0 w-8 h-8 bg-pink-500 rounded-full flex items-center justify-center border-2 border-white cursor-pointer hover:bg-pink-600 transition">
                                <i class='bx bx-edit text-white text-sm'></i>
                            </label>
                        </div>
                        <h2 class="text-xl font-semibold text-gray-800"><?= customer("name") ?></h2>
                        <p class="text-gray-600 text-sm"><?= customer("email") ?></p>
                    </div>

                    <!-- Sidebar Links -->
                    <div class="space-y-4 w-full">
                        <a href="<?= $storeUrl ?>profile"
                            class="flex items-center gap-3 p-3 rounded-xl transition <?= $page == 'profile.php' ? 'bg-indigo-100 text-indigo-500' : 'bg-gray-100 text-gray-700 hover:bg-pink-100 hover:text-pink-600' ?>">
                            <span class="bg-white border transition w-[44px] h-[44px] flex items-center justify-center rounded-full text-xl">
                                <i class='bx bx-user'></i>
                            </span>
                            <span class="font-medium">My Profile</span>
                        </a>

                        <a href="<?= $storeUrl ?>orders"
                            class="flex items-center gap-3 p-3 rounded-xl transition <?= $page == 'orders.php' ? 'bg-orange-100 text-orange-500' : 'bg-gray-100 text-gray-700 hover:bg-pink-100 hover:text-pink-600' ?>">
                            <span class="bg-white border transition w-[44px] h-[44px] flex items-center justify-center rounded-full text-xl">
                                <i class='bx bx-package'></i>
                            </span>
                            <span class="font-medium">My Orders</span>
                        </a>

                        <a href="<?= $storeUrl ?>wishlists"
                            class="flex items-center gap-3 p-3 rounded-xl transition <?= $page == 'wishlists.php' ? 'bg-purple-100 text-purple-500' : 'bg-gray-100 text-gray-700 hover:bg-pink-100 hover:text-pink-600' ?>">
                            <span class="bg-white border transition w-[44px] h-[44px] flex items-center justify-center rounded-full text-xl">
                                <i class='bx bx-heart'></i>
                            </span>
                            <span class="font-medium">Wishlists</span>
                        </a>

                        <a href="<?= $storeUrl ?>logout"
                            class="flex items-center gap-3 p-3 rounded-xl transition bg-gray-100 text-gray-700 hover:bg-red-100 hover:text-red-500">
                            <span class="bg-white border transition w-[44px] h-[44px] flex items-center justify-center rounded-full text-xl">
                                <i class='bx bx-log-out'></i>
                            </span>
                            <span class="font-medium">Logout</span>
                        </a>
                    </div>
                </div>
            </div>


            <!-- Right Edit Form -->
            <div class="w-full lg:w-3/4">
                <div class="bg-white/70 backdrop-blur-md p-6 rounded-3xl shadow-lg">
                    <h3 class="text-2xl font-bold text-gray-800 mb-4 text-center">
                        Edit Profile
                    </h3>

                    <form id="form" method="post" enctype="multipart/form-data" class="space-y-4">

                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-gray-700 font-medium mb-1">Name</label>
                            <input type="text" name="name" id="name"
                                value="<?= customer('name') ?>"
                                class="w-full px-4 py-2 border rounded-xl focus:outline-none focus:ring-2 focus:ring-pink-400 transition"
                                placeholder="Enter your name" required>
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-gray-700 font-medium mb-1">Email</label>
                            <input type="email" name="email" id="email"
                                value="<?= customer('email') ?>"
                                class="w-full px-4 py-2 border rounded-xl focus:outline-none focus:ring-2 focus:ring-pink-400 transition"
                                placeholder="Enter your email">
                        </div>

                        <!-- Phone -->
                        <div>
                            <label for="phone" class="block text-gray-700 font-medium mb-1">Phone Number</label>
                            <input type="tel" name="phone[main]" id="phone"
                                value="<?= customer('phone') ?>"
                                class="w-full px-4 py-2 border rounded-xl focus:outline-none focus:ring-2 focus:ring-pink-400 transition"
                                placeholder="Enter your phone" required>
                        </div>

                        <!-- Photo Upload -->
                        <div>
                            <label class="block text-gray-700 font-medium mb-1">Photo</label>
                            <label
                                class="flex items-center gap-2 px-4 py-2 bg-white border border-gray-300 rounded-xl cursor-pointer hover:bg-pink-50 text-gray-700 text-sm">
                                <i class='bx bx-upload text-lg'></i>
                                Choose File
                                <input type="file" name="photo" id="photo"
                                    class="hidden" accept="image/*">
                            </label>

                            <?php if (!empty(customer("photo"))): ?>
                                <img id="oldImage"
                                    src="<?= UPLOADS_URL . customer("photo") ?>"
                                    alt="Profile Photo"
                                    class="max-w-[100px] max-h-[100px] object-cover mt-2 rounded-xl border transition-all duration-300">
                            <?php endif; ?>
                        </div>

                        <!-- Save Button -->
                        <div class="text-right">
                            <button type="submit"
                                class="bg-gradient-to-r from-pink-400 to-pink-600 text-white py-2 px-5 rounded-md font-semibold shadow-lg hover:from-pink-500 hover:to-pink-700 transition-all">
                                Save Changes
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php include_once __DIR__ . "/includes/footer.php"; ?>

    <!-- IntlTelInput -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>

    <script>
        // Phone Input (India only)
        const phoneInputField = document.querySelector("#phone");
        const phoneInput = window.intlTelInput(phoneInputField, {
            separateDialCode: true,
            onlyCountries: ["in"],
            initialCountry: "in",
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
        });

        // Live Photo Preview - Enhanced to update both images
        document.getElementById("photo").addEventListener("change", function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    // Update main profile image
                    document.getElementById("previewImage").src = e.target.result;

                    // Also update the old image preview if it exists
                    const oldImage = document.getElementById("oldImage");
                    if (oldImage) {
                        oldImage.src = e.target.result;
                    }
                };
                reader.readAsDataURL(file);
            }
        });

        // AJAX Save Profile - Fixed FormData handling
        $(document).on("submit", "#form", function(e) {
            e.preventDefault();

            // Create FormData from the form
            const formData = new FormData(this);

            // Get the full phone number with country code
            const fullPhoneNumber = phoneInput.getNumber();
            console.log("Full Phone Number:", fullPhoneNumber); // For debugging

            // Append the full phone number to FormData
            formData.append("phone[full]", fullPhoneNumber);

            // Log FormData contents for debugging
            for (let pair of formData.entries()) {
                console.log(pair[0] + ': ' + pair[1]);
            }

            $.ajax({
                url: "shop/ajax/profile.php",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(result) {
                    console.log("Server Response:", result); // For debugging
                    try {
                        const response = result && JSON.parse(result);
                        if (response) {
                            if (response.success) {
                                toastr.success(response.message);
                                setTimeout(() => window.location.reload(), 1500);
                            } else {
                                toastr.error(response.message);
                            }
                        }
                    } catch (error) {
                        console.error("Error parsing response:", error);
                        toastr.error("Invalid response from server.");
                    }
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error:", error);
                    toastr.error("Something went wrong. Please try again.");
                }
            });
        });
    </script>

</body>

</html>