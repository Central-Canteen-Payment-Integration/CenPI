<div class="container mx-auto">
  <!-- Header Section -->
  <div class="mb-4 flex justify-between items-center">
    <div>
      <h1 class="text-2xl font-semibold">Your Orders</h1>
      <p class="text-sm text-gray-500">This is your order list data</p>
    </div>
    <div class="flex space-x-4">
      <!-- Search Bar -->
      <div class="relative">
        <input type="text" placeholder="Search orders..."
          class="bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-lg shadow-sm focus:ring focus:ring-blue-300 focus:outline-none w-72"
          id="search-bar" onkeyup="filterOrders()" />
      </div>
      <!-- Filter Date -->
      <button
        class="bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-lg shadow-sm flex items-center space-x-2">
        <i class="ti ti-calendar"></i>
        <span>Today</span>
        <i class="ti ti-chevron-down"></i>
      </button>
    </div>
  </div>

  <!-- Order Cards -->
  <div id="order-cards" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <!-- Example Card -->
    <div class="order-card bg-white border-4 border-red-500 rounded-lg shadow-lg p-6" data-status="Pending">
      <div class="flex items-center justify-between mb-4">
        <h2 class="text-lg font-bold text-gray-800">Order #555231</h2>
        <span class="text-sm text-gray-500">26 March 2020, 12:42 AM</span>
      </div>
      <p class="text-gray-700 text-sm mb-2"><strong>Customer:</strong> Mikasa Ackerman</p>
      <p class="text-gray-700 text-sm mb-2"><strong>Order Details:</strong> 2x Coffee, 1x Sandwich</p>
      <p class="text-gray-700 text-sm mb-2"><strong>Amount:</strong> $164.52</p>
      <p class="text-gray-700 text-sm mb-4"><strong>Payment:</strong> QRIS</p>
      <div class="flex items-center justify-between">
        <button class="bg-red-500 text-white text-sm px-4 py-2 rounded-lg hover:bg-red-600 shadow-md"
          onclick="acceptOrder(this)">
          Accept Order
        </button>
        <span class="text-sm text-red-500 status">Status: Pending</span>
      </div>
      <!-- Notes Section -->
      <p class="text-gray-500 text-xs italic mt-2"><strong>Notes:</strong> Please call before arriving</p>
    </div>
    <div class="order-card bg-white border-4 border-red-500 rounded-lg shadow-lg p-6" data-status="Pending">
      <div class="flex items-center justify-between mb-4">
        <h2 class="text-lg font-bold text-gray-800">Order #555231</h2>
        <span class="text-sm text-gray-500">26 March 2020, 12:42 AM</span>
      </div>
      <p class="text-gray-700 text-sm mb-2"><strong>Customer:</strong> Mikasa Ackerman</p>
      <p class="text-gray-700 text-sm mb-2"><strong>Order Details:</strong> 2x Coffee, 1x Sandwich</p>
      <p class="text-gray-700 text-sm mb-2"><strong>Amount:</strong> $164.52</p>
      <p class="text-gray-700 text-sm mb-4"><strong>Payment:</strong> QRIS</p>
      <div class="flex items-center justify-between">
        <button class="bg-red-500 text-white text-sm px-4 py-2 rounded-lg hover:bg-red-600 shadow-md"
          onclick="acceptOrder(this)">
          Accept Order
        </button>
        <span class="text-sm text-red-500 status">Status: Pending</span>
      </div>
      <!-- Notes Section -->
      <p class="text-gray-500 text-xs italic mt-2"><strong>Notes:</strong> Please call before arriving</p>
    </div>
    <div class="order-card bg-white border-4 border-red-500 rounded-lg shadow-lg p-6" data-status="Pending">
      <div class="flex items-center justify-between mb-4">
        <h2 class="text-lg font-bold text-gray-800">Order #555231</h2>
        <span class="text-sm text-gray-500">26 March 2020, 12:42 AM</span>
      </div>
      <p class="text-gray-700 text-sm mb-2"><strong>Customer:</strong> Mikasa Ackerman</p>
      <p class="text-gray-700 text-sm mb-2"><strong>Order Details:</strong> 2x Coffee, 1x Sandwich</p>
      <p class="text-gray-700 text-sm mb-2"><strong>Amount:</strong> $164.52</p>
      <p class="text-gray-700 text-sm mb-4"><strong>Payment:</strong> QRIS</p>
      <div class="flex items-center justify-between">
        <button class="bg-red-500 text-white text-sm px-4 py-2 rounded-lg hover:bg-red-600 shadow-md"
          onclick="acceptOrder(this)">
          Accept Order
        </button>
        <span class="text-sm text-red-500 status">Status: Pending</span>
      </div>
      <!-- Notes Section -->
      <p class="text-gray-500 text-xs italic mt-2"><strong>Notes:</strong> Please call before arriving</p>
    </div>
  </div>
</div>

<script>
  function acceptOrder(button) {
    const card = button.closest('.order-card');
    const statusElement = card.querySelector('.status');

    // SweetAlert confirmation
    Swal.fire({
      title: 'Accept Order?',
      text: 'This order will now be processed for delivery.',
      icon: 'success',
      showCancelButton: true,
      confirmButtonColor: '#f59e0b', // Yellow color for confirm button
      confirmButtonText: 'Accept',
    }).then((result) => {
      if (result.isConfirmed) {
        // Change status to "On Delivery"
        statusElement.textContent = 'Status: On Delivery';
        statusElement.classList.remove('text-red-500');
        statusElement.classList.add('text-yellow-500');
        card.classList.remove('border-red-500');
        card.classList.add('border-yellow-500');

        button.textContent = 'Complete Order';
        button.classList.remove('bg-blue-500', 'hover:bg-blue-600');
        button.classList.add('bg-yellow-500', 'hover:bg-yellow-600');
        button.setAttribute('onclick', 'completeOrder(this)');
      }
    });
  }

  function completeOrder(button) {
    const card = button.closest('.order-card');
    const statusElement = card.querySelector('.status');

    Swal.fire({
      title: 'Complete Order?',
      text: 'Are you sure this order has been completed?',
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Complete',
      confirmButtonColor: '#38a169', // Green color for confirm button
    }).then((result) => {
      if (result.isConfirmed) {
        // Change status to "Completed"
        statusElement.textContent = 'Status: Completed';
        statusElement.classList.remove('text-yellow-500');
        statusElement.classList.add('text-green-500');
        card.classList.remove('border-yellow-500');
        card.classList.add('border-green-500');

        button.remove(); // Remove the button after completion
        Swal.fire('Order Completed', 'This order has been completed.', 'success');
      }
    });
  }
</script>
