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


  <!-- My Oders Main Container Start -->
  <div class="container mx-auto px-4 py-8">
    <div class="flex flex-col md:flex-row gap-8">

      <!-- Left Side: Profile Card -->
      <div class="w-full md:w-1/4">
        <div class="bg-white/70 backdrop-blur-[12px] border border-white/50 rounded-2xl p-6 shadow-lg">
          <div class="flex flex-col items-center mb-6">
            <div class="relative mb-4">
              <img
                src="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?ixlib=rb-4.0.3&auto=format&fit=crop&w=200&q=80"
                alt="User Profile" class="w-24 h-24 rounded-full border-4 border-white/50 object-cover">
              <div
                class="absolute bottom-0 right-0 w-8 h-8 bg-pink-500 rounded-full flex items-center justify-center border-2 border-white">
                <i class='bx bx-edit text-white text-sm'></i>
              </div>
            </div>
            <h2 class="text-xl font-semibold text-gray-800">Rahul Sharma</h2>
            <p class="text-gray-600 text-sm">rahul@example.com</p>
          </div>

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

      <!-- Right Side: Orders Table -->
      <div class="w-full md:w-3/4 bg-white rounded-3xl p-6 shadow-lg overflow-x-auto">

        <!-- Section Title -->
        <h3 class="text-2xl sm:text-3xl md:text-4xl lg:text-4xl font-bold text-gray-800 mb-6">My Orders</h3>

        <!-- Top Controls: Entries & Search -->
        <div
          class="flex flex-col md:flex-row justify-between items-center mb-6 bg-white/70 backdrop-blur-md border border-pink-200 rounded-xl p-4 shadow-md gap-4">

          <span class="text-gray-700 text-sm md:text-base font-medium">
            Show
            <select
              class="border border-pink-300 rounded-lg px-3 py-1 text-gray-700 focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-pink-400 transition">
              <option>10</option>
              <option>25</option>
              <option>50</option>
            </select>
            entries
          </span>

          <div class="flex items-center gap-2 w-full md:w-auto">
            <input type="text" placeholder="Search..."
              class="flex-1 border border-pink-300 rounded-lg px-3 py-1 text-gray-700 text-sm focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-pink-400 transition placeholder:text-gray-400">
            <button class="bg-pink-500 text-white px-4 py-1 rounded-lg hover:bg-pink-600 transition shadow-sm">
              Search
            </button>
          </div>

        </div>

        <!-- Orders Table -->
        <div class="overflow-x-auto scrollbar-thin scrollbar-thumb-pink-300 scrollbar-track-pink-100 rounded-lg">
          <table class="min-w-full table-auto border-collapse border border-gray-200 text-sm">
            <thead class="bg-pink-50">
              <tr>
                <th class="border border-gray-200 px-4 py-2 text-left">Order ID</th>
                <th class="border border-gray-200 px-4 py-2 text-left">Created</th>
                <th class="border border-gray-200 px-4 py-2 text-left">Total</th>
                <th class="border border-gray-200 px-4 py-2 text-left">Payment Method</th>
                <th class="border border-gray-200 px-4 py-2 text-left">Status</th>
              </tr>
            </thead>
            <tbody>
              <tr class="hover:bg-pink-50 transition">
                <td class="border border-gray-200 px-4 py-2">#2155-1079813</td>
                <td class="border border-gray-200 px-4 py-2">2025-04-17 18:01:07</td>
                <td class="border border-gray-200 px-4 py-2">₹940.00</td>
                <td class="border border-gray-200 px-4 py-2">COD</td>
                <td class="border border-gray-200 px-4 py-2">Order Accepted</td>
              </tr>
              <tr class="hover:bg-pink-50 transition">
                <td class="border border-gray-200 px-4 py-2">#2155-1057074</td>
                <td class="border border-gray-200 px-4 py-2">2024-09-14 12:57:18</td>
                <td class="border border-gray-200 px-4 py-2">₹1,160.00</td>
                <td class="border border-gray-200 px-4 py-2">IppoPay</td>
                <td class="border border-gray-200 px-4 py-2">Order Accepted</td>
              </tr>
              <tr class="hover:bg-pink-50 transition">
                <td class="border border-gray-200 px-4 py-2">#2155-1021546</td>
                <td class="border border-gray-200 px-4 py-2">2024-09-14 12:55:59</td>
                <td class="border border-gray-200 px-4 py-2">₹1,160.00</td>
                <td class="border border-gray-200 px-4 py-2">COD</td>
                <td class="border border-gray-200 px-4 py-2">Order Accepted</td>
              </tr>
              <tr class="hover:bg-pink-50 transition">
                <td class="border border-gray-200 px-4 py-2">#2155-1070225</td>
                <td class="border border-gray-200 px-4 py-2">2024-09-14 12:54:43</td>
                <td class="border border-gray-200 px-4 py-2">₹410.00</td>
                <td class="border border-gray-200 px-4 py-2">IppoPay</td>
                <td class="border border-gray-200 px-4 py-2">Order Accepted</td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Pagination -->
        <div class="flex justify-end items-center gap-2 mt-6 flex-wrap">
          <button
            class="px-3 py-1 rounded-lg border border-pink-300 text-pink-500 hover:bg-pink-100 transition disabled:opacity-50 disabled:cursor-not-allowed"
            disabled>
            Prev
          </button>

          <button
            class="px-3 py-1 rounded-lg border border-pink-300 bg-pink-500 text-white hover:bg-pink-600 transition">
            1
          </button>
          <button class="px-3 py-1 rounded-lg border border-pink-300 text-pink-500 hover:bg-pink-100 transition">
            2
          </button>
          <button class="px-3 py-1 rounded-lg border border-pink-300 text-pink-500 hover:bg-pink-100 transition">
            3
          </button>
          <span class="px-3 py-1 text-gray-500">...</span>
          <button class="px-3 py-1 rounded-lg border border-pink-300 text-pink-500 hover:bg-pink-100 transition">
            10
          </button>

          <button class="px-3 py-1 rounded-lg border border-pink-300 text-pink-500 hover:bg-pink-100 transition">
            Next
          </button>
        </div>

      </div>



    </div>
  </div>
  <!-- My Oders Main Container End -->

  <!--Footer File Includes that file has all JS Files includes links-->
  <?php include_once __DIR__ . "/includes/footer.php"; ?>

</body>

</html>