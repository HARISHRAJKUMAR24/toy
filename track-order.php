<?php
include_once __DIR__ . "/includes/files_includes.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include_once __DIR__ . "/includes/head_links.php"; ?>
</head>

<body class="font-sans bg-pink-50 min-h-screen">
    <!-- Navbar -->
    <?php include_once __DIR__ . "/includes/navbar.php"; ?>

    <div class="py-8 sm:py-10">
        <div class="px-3 sm:px-4 lg:container-fluid max-w-7xl mx-auto">
            <!-- Right -->
            <div class="lg:w-[50%] w-full mx-auto">
                <div class="p-6 bg-white rounded-2xl shadow-lg">
                    <div class="pb-6 mb-6 border-b border-gray-200">
                        <h3 class="text-2xl font-bold text-gray-800">Track Your Order</h3>
                        <p class="mt-3 text-sm text-gray-600">Enter your order ID or invoice number below to track your order status.</p>
                    </div>

                    <form action="<?= $storeUrl ?>order">
                        <div class="mb-6">
                            <label for="order_id" class="block mb-3 text-base font-semibold text-gray-700">Order ID/Invoice Number</label>
                            <input type="text" id="order_id" name="id" placeholder="Enter your order ID or invoice number"
                                class="px-4 h-[54px] border-2 border-gray-200 w-full rounded-xl transition focus:border-primary-500 focus:ring-2 focus:ring-primary-300 focus:bg-white text-gray-700 placeholder-gray-400">
                        </div>

                        <button class="bg-primary-500 h-[50px] rounded-xl font-semibold text-base text-white flex items-center justify-center w-full gap-2 hover:bg-hover transition transform hover:scale-105 shadow-lg hover:shadow-xl">
                            Track Order <i class='text-lg bx bx-send'></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        const order_id = document.getElementById("order_id");
        order_id.addEventListener("input", function() {
            this.value = this.value.replace(/#/g, "");
        });
    </script>
    <!-- Footer -->
    <?php include_once __DIR__ . "/includes/footer.php"; ?>

</body>

</html>