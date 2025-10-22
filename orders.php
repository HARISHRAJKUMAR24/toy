<?php

include_once __DIR__ . "/includes/files_includes.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php include_once __DIR__ . "/includes/head_links.php"; ?>
</head>

<body class="font-sans bg-pink-50 min-h-screen">

  <!-- Minimum Order Amount -->
  <?php if (!empty(getSettings("minimum_order_amount"))) : ?>
    <div class="w-full bg-pink-600 text-white text-center py-1 text-sm font-semibold">
      Minimum Order: <?= currencyToSymbol($storeCurrency) . getSettings("minimum_order_amount") ?>
    </div>
  <?php endif; ?>

  <!-- Navbar -->
  <?php include_once __DIR__ . "/includes/navbar.php"; ?>

  <?php
  // Get logged-in user ID from session
  $userId = $_SESSION['user_id'] ?? 0;
  $storeUrl = rtrim($storeUrl ?? '/', '/') . '/';

  // Fetch user info
  $userQuery = $db->prepare("SELECT name, email FROM seller_customers WHERE id = :id LIMIT 1");
  $userQuery->bindValue(':id', $userId, PDO::PARAM_INT);
  $userQuery->execute();
  $userData = $userQuery->fetch(PDO::FETCH_ASSOC);

  $userName = $userData['name'] ?? 'Guest';
  $userEmail = $userData['email'] ?? 'guest@example.com';

  // Fetch orders
  $orderQuery = $db->prepare("SELECT order_id, created_at, total, payment_method, status, currency FROM seller_orders WHERE customer_id = :id ORDER BY created_at DESC");
  $orderQuery->bindValue(':id', $userId, PDO::PARAM_INT);
  $orderQuery->execute();
  $ordersData = $orderQuery->fetchAll(PDO::FETCH_ASSOC);

  // Format orders for display
  $orders = [];
  foreach ($ordersData as $order) {
    $orders[] = [
      'order_id' => '<a href="' . $storeUrl . 'order?id=' . $order['order_id'] . '" class="underline text-primary-500">#' . $order['order_id'] . '</a>',
      'created_at' => $order['created_at'],
      'total' => currencyToSymbol($order['currency']) . number_format($order['total'], 2),
      'payment_method' => $order['payment_method'],
      'status' => ucfirst($order['status']),
    ];
  }
  ?>

  <!-- Main Container -->
  <div class="container mx-auto px-4 py-8">
    <div class="flex flex-col md:flex-row gap-8">

      <!-- Left: Profile Card -->
      <div class="w-full md:w-1/4">
        <div class="bg-white/70 backdrop-blur-[12px] border border-white/50 rounded-2xl p-6 shadow-lg">
          <div class="flex flex-col items-center mb-6">
            <div class="relative mb-4">
              <img src="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?ixlib=rb-4.0.3&auto=format&fit=crop&w=200&q=80"
                alt="User Profile" class="w-24 h-24 rounded-full border-4 border-white/50 object-cover">
              <div class="absolute bottom-0 right-0 w-8 h-8 bg-pink-500 rounded-full flex items-center justify-center border-2 border-white">
                <i class='bx bx-edit text-white text-sm'></i>
              </div>
            </div>
            <h2 class="text-xl font-semibold text-gray-800"><?= htmlspecialchars($userName) ?></h2>
            <p class="text-gray-600 text-sm"><?= htmlspecialchars($userEmail) ?></p>
          </div>

          <div class="space-y-4">
            <a href="#" class="flex items-center gap-3 p-3 rounded-xl text-gray-700 hover:bg-pink-100 hover:text-pink-600 transition">
              <i class='bx bx-user-circle text-xl'></i>
              <span>My Profile</span>
            </a>
            <a href="#" class="flex items-center gap-3 p-3 rounded-xl bg-pink-100 text-pink-600 transition">
              <i class='bx bx-package text-xl'></i>
              <span>My Orders</span>
            </a>
            <a href="#" class="flex items-center gap-3 p-3 rounded-xl text-gray-700 hover:bg-pink-100 hover:text-pink-600 transition">
              <i class='bx bx-heart text-xl'></i>
              <span>Wishlists</span>
            </a>
            <a href="#" class="flex items-center gap-3 p-3 rounded-xl text-gray-700 hover:bg-pink-100 hover:text-pink-600 transition">
              <i class='bx bx-log-out text-xl'></i>
              <span>Logout</span>
            </a>
          </div>
        </div>
      </div>

      <!-- Right: Orders Table -->
      <div class="w-full md:w-3/4 bg-white rounded-3xl p-6 shadow-lg overflow-x-auto">
        <h3 class="text-2xl sm:text-3xl md:text-4xl lg:text-4xl font-bold text-gray-800 mb-6">My Orders</h3>

        <!-- Top Controls (replace your current block) -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-6 bg-white/70 backdrop-blur-md border border-pink-200 rounded-xl p-4 shadow-md gap-4">
          <span class="text-gray-700 text-sm md:text-base font-medium">
            Show
            <select id="entriesSelect" class="border border-pink-300 rounded-lg px-3 py-1 text-gray-700 focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-pink-400 transition">
              <option value="10">10</option>
              <option value="25">25</option>
              <option value="50">50</option>
            </select>
            entries
          </span>
          <div class="flex items-center gap-2 w-full md:w-auto">
            <input id="searchInput" type="text" placeholder="Search..." class="flex-1 border border-pink-300 rounded-lg px-3 py-1 text-gray-700 text-sm focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-pink-400 transition placeholder:text-gray-400">

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
              <?php if (!empty($orders)): ?>
                <?php foreach ($orders as $order): ?>
                  <tr class="hover:bg-pink-50 transition">
                    <td class="border border-gray-200 px-4 py-2"><?= $order['order_id'] ?></td>
                    <td class="border border-gray-200 px-4 py-2"><?= $order['created_at'] ?></td>
                    <td class="border border-gray-200 px-4 py-2"><?= $order['total'] ?></td>
                    <td class="border border-gray-200 px-4 py-2"><?= $order['payment_method'] ?></td>
                    <td class="border border-gray-200 px-4 py-2"><?= $order['status'] ?></td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="5" class="text-center py-4 text-gray-500">No orders found.</td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>

        <!-- Pagination -->
        <div id="pagination" class="flex justify-end items-center gap-2 mt-6 flex-wrap"></div>


      </div>
    </div>
  </div>

  <!-- Footer -->
  <?php include_once __DIR__ . "/includes/footer.php"; ?>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Reliable element grabs
      const tbody = document.querySelector('table tbody');
      if (!tbody) return; // no table on page -> nothing to do

      const allRows = Array.from(tbody.querySelectorAll('tr'));
      const entriesSelect = document.getElementById('entriesSelect');
      const searchInput = document.getElementById('searchInput');
      const searchButton = document.getElementById('searchBtn');
      const paginationContainer = document.getElementById('pagination');

      // safety checks
      if (!entriesSelect || !searchInput || !searchButton || !paginationContainer) {
        console.warn('Missing one of the required controls (entriesSelect, searchInput, searchBtn, pagination).');
      }

      let currentPage = 1;
      let rowsPerPage = parseInt(entriesSelect?.value || '10', 10);
      let filteredRows = [...allRows]; // visible rows after filter

      function renderTable() {
        // hide all first
        allRows.forEach(r => r.style.display = 'none');

        // handle no rows at all
        if (filteredRows.length === 0) {
          renderPagination(); // still render pagination (shows page 1)
          return;
        }

        const start = (currentPage - 1) * rowsPerPage;
        const end = start + rowsPerPage;

        // show the page slice
        filteredRows.slice(start, end).forEach(row => row.style.display = '');

        renderPagination();
      }

      function renderPagination() {
        const totalPages = Math.max(1, Math.ceil(filteredRows.length / rowsPerPage));
        paginationContainer.innerHTML = '';

        // Prev
        const prevBtn = document.createElement('button');
        prevBtn.textContent = 'Prev';
        prevBtn.disabled = currentPage <= 1;
        prevBtn.className = 'px-3 py-1 rounded-lg border border-pink-300 text-pink-500 hover:bg-pink-100 transition disabled:opacity-50 disabled:cursor-not-allowed';
        prevBtn.addEventListener('click', () => {
          if (currentPage > 1) {
            currentPage--;
            renderTable();
          }
        });
        paginationContainer.appendChild(prevBtn);

        // Page buttons (if many pages, we can limit display — simple approach: show all)
        for (let i = 1; i <= totalPages; i++) {
          const btn = document.createElement('button');
          btn.textContent = i;
          btn.className = `px-3 py-1 rounded-lg border border-pink-300 ${currentPage === i ? 'bg-pink-500 text-white' : 'text-pink-500 hover:bg-pink-100'} transition`;
          btn.addEventListener('click', () => {
            currentPage = i;
            renderTable();
          });
          paginationContainer.appendChild(btn);
        }

        // Next
        const nextBtn = document.createElement('button');
        nextBtn.textContent = 'Next';
        nextBtn.disabled = currentPage >= totalPages;
        nextBtn.className = 'px-3 py-1 rounded-lg border border-pink-300 text-pink-500 hover:bg-pink-100 transition disabled:opacity-50 disabled:cursor-not-allowed';
        nextBtn.addEventListener('click', () => {
          if (currentPage < totalPages) {
            currentPage++;
            renderTable();
          }
        });
        paginationContainer.appendChild(nextBtn);
      }

      // When entries per page changes
      entriesSelect.addEventListener('change', () => {
        const val = parseInt(entriesSelect.value, 10);
        rowsPerPage = Number.isFinite(val) && val > 0 ? val : 10;
        currentPage = 1;
        renderTable();
      });

      // Search logic
      function performSearch() {
        const q = (searchInput.value || '').trim().toLowerCase();

        if (q === '') {
          // reset filter
          filteredRows = [...allRows];
        } else {
          filteredRows = allRows.filter(row => row.textContent.toLowerCase().includes(q));
        }

        // reset page and render
        currentPage = 1;
        renderTable();
      }

      // event listeners
      searchInput.addEventListener('keyup', performSearch);
      searchButton.addEventListener('click', performSearch);

      // esc clears search
      searchInput.addEventListener('keydown', e => {
        if (e.key === 'Escape') {
          searchInput.value = '';
          performSearch();
        }
      });

      // initial render
      renderTable();
    });
  </script>



</body>

</html>