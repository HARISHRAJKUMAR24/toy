<!DOCTYPE html>
<html lang="en">

<head>
    <?php include_once __DIR__ . "/../../components/head.php"; ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile - ToyShop</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

</head>

<body class="bg-pink-50 font-sans min-h-screen">

    <!-- Minimum Order Amount Start-->
    <?php if (!empty(getSettings("minimum_order_amount"))) : ?>
        <div class="w-full bg-pink-600 text-white text-center py-1 text-sm font-semibold">
            Minimum Order: <?= currencyToSymbol($storeCurrency) . getSettings("minimum_order_amount") ?>
        </div>
    <?php endif; ?>
    <!-- Minimum Order Amount End-->

    <!--Php File Include For Nav Bar-->
    <?php include_once __DIR__ . "/includes/navbar.php"; ?>

    <!-- My Profile Main Container Start -->
    <div class="container mx-auto px-4 py-8">
        <!--My Profile Heading-->
        <h1 class="text-2xl sm:text-3xl md:text-4xl lg:text-4xl font-bold text-gray-800 mb-6 text-center">My Profile
        </h1>

        <div class="flex flex-col lg:flex-row gap-8">

            <!-- Left Sidebar -->
            <div class="w-full lg:w-2/4">
                <div class="bg-white/70 backdrop-blur-md border border-white/50 rounded-2xl p-6 shadow-lg">
                    <!-- Profile Image -->
                    <div class="flex flex-col items-center mb-6">
                        <div class="relative mb-4">
                            <img src="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?ixlib=rb-4.0.3&auto=format&fit=crop&w=200&q=80"
                                alt="User Profile" class="w-24 h-24 rounded-full border-4 border-white/50 object-cover">
                            <div
                                class="absolute bottom-0 right-0 w-8 h-8 bg-pink-500 rounded-full flex items-center justify-center border-2 border-white cursor-pointer">
                                <i class='bx bx-edit text-white text-sm'></i>
                            </div>
                        </div>
                        <h2 class="text-xl font-semibold text-gray-800">Suvalakshmi</h2>
                        <p class="text-gray-600 text-sm">suvalakshmiweby@gmail.com</p>
                    </div>

                    <!-- Sidebar Links -->
                    <div class="space-y-4">
                        <a href="#"
                            class="flex items-center gap-3 p-3 rounded-xl text-gray-700 hover:bg-pink-100 hover:text-pink-600 transition">
                            <i class='bx bx-user-circle text-xl'></i>
                            <span>My Profile</span>
                        </a>
                        <a href="#"
                            class="flex items-center gap-3 p-3 rounded-xl text-gray-700 hover:bg-pink-100 hover:text-pink-600 transition">
                            <i class='bx bx-package text-xl'></i>
                            <span>My Orders</span>
                        </a>
                        <a href="#" class="flex items-center gap-3 p-3 rounded-xl bg-pink-100 text-pink-600 transition">
                            <i class='bx bx-heart text-xl'></i>
                            <span>Wishlists</span>
                        </a>
                        <a href="#"
                            class="flex items-center gap-3 p-3 rounded-xl text-gray-700 hover:bg-pink-100 hover:text-pink-600 transition">
                            <i class='bx bx-log-out text-xl'></i>
                            <span>Logout</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Right Sidebar Details: Edit Profile -->
            <div class="w-full lg:w-3/4">
                <div class="bg-white/70 backdrop-blur-md p-6 rounded-3xl shadow-lg">
                    <h3 class="text-xl sm:text-2xl md:text-2xl lg:text-2xl font-bold text-gray-800 mb-4 text-center">
                        Edit Profile
                    </h3>


                    <form class="space-y-4">
                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-gray-700 font-medium mb-1">Name</label>
                            <input type="text" id="name" value="Suvalakshmi"
                                class="w-full px-4 py-2 border rounded-xl focus:outline-none focus:ring-2 focus:ring-pink-400 transition">
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-gray-700 font-medium mb-1">Email</label>
                            <input type="email" id="email" value="suvalakshmiweby@gmail.com"
                                class="w-full px-4 py-2 border rounded-xl focus:outline-none focus:ring-2 focus:ring-pink-400 transition">
                        </div>
                        <!-- Phone Number Field -->
                        <div>
                            <label for="phone" class="block text-gray-700 font-medium mb-1">Phone Number</label>
                            <div class="flex">
                                <span
                                    class="flex items-center gap-1 px-3 rounded-l-xl border border-r-0 border-gray-300 bg-gray-100 text-gray-700">
                                    <img src="https://flagcdn.com/16x12/in.png" alt="India"
                                        class="w-4 h-3 object-cover rounded-sm">
                                    +91
                                </span>
                                <input type="tel" id="phone" placeholder="Enter your phone"
                                    class="flex-1 px-3 py-2 border rounded-r-xl focus:outline-none focus:ring-2 focus:ring-pink-400 transition">
                            </div>
                        </div>

                        <!-- Photo Upload Field -->
                        <div>
                            <label class="block text-gray-700 font-medium mb-1">Photo</label>
                            <label
                                class="flex items-center gap-2 px-4 py-2 bg-white border border-gray-300 rounded-xl cursor-pointer hover:bg-pink-50 text-gray-700 text-sm">
                                <i class='bx bx-upload text-lg'></i>
                                Choose File
                                <input type="file" class="hidden">
                            </label>
                        </div>

                        <!-- Save Button -->
                        <div>
                            <button type="submit"
                                class="bg-gradient-to-r from-pink-400 to-pink-600 text-white py-1.5 px-4 rounded-xl font-semibold shadow-lg hover:from-pink-500 hover:to-pink-700 transition-all text-sm">
                                Save Changes
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
    <!-- My Profile Main Container End -->

    <!--Footer File Includes that file has all JS Files includes links-->
    <?php include_once __DIR__ . "/includes/footer.php"; ?>

</body>

</html>