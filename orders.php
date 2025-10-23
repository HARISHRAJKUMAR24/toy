<?php
include_once __DIR__ . "/includes/files_includes.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php include_once __DIR__ . "/includes/head_links.php"; ?>
  <style>
    /*<==========> CSS Styles <==========>*/
    /* Custom DataTables Styling */
    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter,
    .dataTables_wrapper .dataTables_info,
    .dataTables_wrapper .dataTables_paginate {
      padding: 8px 4px;
    }

    .dataTables_wrapper .dataTables_length select,
    .dataTables_wrapper .dataTables_filter input {
      border: 1px solid #f9a8d4;
      border-radius: 8px;
      padding: 6px 12px;
      background: white;
    }

    .dataTables_wrapper .dataTables_length select:focus,
    .dataTables_wrapper .dataTables_filter input:focus {
      outline: none;
      box-shadow: 0 0 0 2px rgba(236, 72, 153, 0.2);
      border-color: #ec4899;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
      border: 1px solid #f9a8d4;
      border-radius: 8px;
      padding: 6px 12px;
      margin: 0 2px;
      background: white;
      color: #db2777;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current,
    .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
      background: #ec4899;
      color: white;
      border-color: #ec4899;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
      background: #fdf2f8;
      color: #be185d;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.disabled,
    .dataTables_wrapper .dataTables_paginate .paginate_button.disabled:hover {
      background: #fce7f3;
      color: #9ca3af;
      border-color: #fbcfe8;
    }

    /* Center the no orders message */
    .dataTables_empty {
      text-align: center !important;
      padding: 40px 20px !important;
      font-size: 16px !important;
      color: #6b7280 !important;
    }

    /* Ensure the table row centers the message */
    #ordersTable td.dataTables_empty {
      text-align: center !important;
      padding: 40px 20px !important;
    }
  </style>
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
  ?>

  <!-- Main Container -->
  <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex flex-col lg:flex-row gap-6 lg:gap-8">

      <!-- Left Sidebar -->
      <div class="w-full lg:w-1/3 xl:w-2/5">
        <div class="bg-white/70 backdrop-blur-md border border-white/50 rounded-2xl p-6 shadow-lg">

          <!-- Profile Info -->
          <div class="flex flex-col items-center mb-6">
            <div class="relative mb-4">
              <img id="previewImage"
                src="<?= !empty(customer('photo')) ? UPLOADS_URL . customer('photo') : 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?auto=format&fit=crop&w=200&q=80' ?>"
                alt="User Profile"
                class="w-24 h-24 rounded-full border-4 border-white/50 object-cover transition-all duration-300 shadow-sm">
              <label for="photo"
                class="absolute bottom-0 right-0 w-8 h-8 bg-pink-500 rounded-full flex items-center justify-center border-2 border-white cursor-pointer hover:bg-pink-600 transition"
                onclick="window.location.href='<?= $storeUrl ?>profile'">
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
              class="flex items-center gap-3 p-3 rounded-xl transition <?= $page == 'wishlists.php' ? 'bg-pink-100 text-pink-500' : 'bg-gray-100 text-gray-700 hover:bg-pink-100 hover:text-pink-600' ?>">
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

      <!-- Right: Orders Table -->
      <div class="w-full lg:w-2/3 xl:w-3/5">
        <div class="bg-white rounded-3xl p-4 sm:p-6 shadow-lg">
          <h3 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-6 text-center sm:text-left">My Orders</h3>

          <!-- Orders Table Container -->
          <div class="overflow-x-auto rounded-xl border border-pink-100">
            <table id="ordersTable" class="min-w-full table-auto border-collapse text-sm">
              <thead class="bg-pink-50">
                <tr>
                  <th class="px-4 py-3 text-left font-semibold text-gray-700 border-b border-pink-100">Order ID</th>
                  <th class="px-4 py-3 text-left font-semibold text-gray-700 border-b border-pink-100">Created</th>
                  <th class="px-4 py-3 text-left font-semibold text-gray-700 border-b border-pink-100">Total</th>
                  <th class="px-4 py-3 text-left font-semibold text-gray-700 border-b border-pink-100">Payment Method</th>
                  <th class="px-4 py-3 text-left font-semibold text-gray-700 border-b border-pink-100">Status</th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-pink-50">
                <!-- Data will be loaded via AJAX -->
              </tbody>
            </table>
          </div>

        </div>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <?php include_once __DIR__ . "/includes/footer.php"; ?>

  <!-- DataTables Script -->
  <script>
    $(document).ready(function() {
      // Initialize DataTable with server-side processing
      var table = $('#ordersTable').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
          "url": "shop/ajax/orders.php",
          "type": "POST",
          "data": function(d) {
            // Ensure recent orders come first by default
            if (!d.order || d.order.length === 0) {
              d.order = [
                [1, 'desc']
              ]; // Sort by Created date (column index 1) descending
            }
          }
        },
        "columns": [{
            "data": "order_id",
            "className": "px-4 py-3 whitespace-nowrap"
          },
          {
            "data": "created_at",
            "className": "px-4 py-3 whitespace-nowrap"
          },
          {
            "data": "total",
            "className": "px-4 py-3 whitespace-nowrap"
          },
          {
            "data": "payment_method",
            "className": "px-4 py-3 whitespace-nowrap"
          },
          {
            "data": "status",
            "className": "px-4 py-3 whitespace-nowrap"
          }
        ],
        "pageLength": 10,
        "lengthMenu": [
          [10, 25, 50],
          [10, 25, 50]
        ],
        "order": [
          [1, 'desc']
        ], // Default sort: Created date descending (recent first)
        "language": {
          "search": "",
          "searchPlaceholder": "Search orders...",
          "lengthMenu": "Show _MENU_ entries",
          "info": "Showing _START_ to _END_ of _TOTAL_ orders",
          "infoEmpty": "No orders found",
          "infoFiltered": "(filtered from _MAX_ total orders)",
          "zeroRecords": "You Dont't Place Order Yet 🛒",
          "paginate": {
            "first": "First",
            "last": "Last",
            "previous": "‹",
            "next": "›"
          },
          "processing": "Loading orders..."
        },
        "responsive": true,
        "dom": '<"flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6"<"w-full sm:w-auto"l><"w-full sm:w-auto flex justify-end"f>>rt<"flex flex-col sm:flex-row justify-between items-center gap-4 mt-6"<"text-sm text-gray-600"i><"flex gap-2"p>>',
        "initComplete": function() {
          // Add custom classes to search input and move to right
          $('.dataTables_filter')
            .addClass('w-full sm:w-auto')
            .find('input')
            .addClass('w-full sm:w-64 px-4 py-2 border border-pink-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-pink-400 transition placeholder-gray-400')
            .attr('placeholder', 'Search orders...');

          // Add custom classes to length select
          $('.dataTables_length select')
            .addClass('px-3 py-2 border border-pink-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-pink-400 transition');
        },
        "drawCallback": function() {
          // Re-apply custom classes after each draw
          $('.dataTables_filter')
            .addClass('w-full sm:w-auto')
            .find('input')
            .addClass('w-full sm:w-64 px-4 py-2 border border-pink-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-pink-400 transition placeholder-gray-400')
            .attr('placeholder', 'Search orders...');

          $('.dataTables_length select')
            .addClass('px-3 py-2 border border-pink-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-pink-400 transition');
        }
      });
    });
  </script>

</body>

</html>