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
        <input
          type="text"
          placeholder="Search orders..."
          class="bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-lg shadow-sm focus:ring focus:ring-blue-300 focus:outline-none w-72"
          id="search-bar"
          onkeyup="filterOrders()"
        />
      </div>
      <!-- Filter Date -->
      <button class="bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-lg shadow-sm flex items-center space-x-2">
        <i class="ti ti-calendar"></i>
        <span>Today</span>
        <i class="ti ti-chevron-down"></i>
      </button>
    </div>
  </div>

  <!-- Table Section -->
  <div class="bg-white shadow-md rounded-lg overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200" id="orders-table">
      <thead class="bg-primary">
        <tr>
          <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase">Order ID</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase">Date</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase">Customer Name</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase">Order Details</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase">Amount</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase">Actions</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase">Status</th>
        </tr>
      </thead>
      <tbody>
        <!-- Table Row Example -->
        <tr>
          <td class="px-6 py-4 text-sm text-gray-900 font-medium">#555231</td>
          <td class="px-6 py-4 text-sm text-gray-900 font-medium">26 March 2020, 12:42 AM</td>
          <td class="px-6 py-4 text-sm text-gray-900 font-medium">Mikasa Ackerman</td>
          <td class="px-6 py-4 text-sm text-gray-900 font-medium">2x Coffee, 1x Sandwich</td>
          <td class="px-6 py-4 text-sm text-gray-900 font-medium">$164.52</td>
          <td class="px-6 py-4 text-sm">
            <button
              class="bg-primary text-white px-3 py-2 rounded-lg shadow hover:bg-blue-600"
              onclick="acceptOrder(this)">
              Accept Order
            </button>
          </td>
          <td class="px-6 py-4 text-sm text-gray-900 font-medium status">-</td>
        </tr>
      </tbody>
    </table>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  function acceptOrder(button) {
    const row = button.closest('tr');
    const statusCell = row.querySelector('.status');

    // Show SweetAlert confirmation and update status
    Swal.fire({
      title: 'Order Accepted!',
      text: 'This order is now on delivery.',
      icon: 'success',
      confirmButtonColor: '#38a169',
    }).then(() => {
      // Change status to "On Delivery"
      statusCell.innerHTML = `<button class="bg-yellow-500 text-white px-3 py-2 rounded-lg shadow hover:bg-yellow-600" onclick="completeOrder(this)">Completed order</button>`;
      button.remove(); // Remove the "Accept Order" button
    });
  }

  function completeOrder(button) {
    const row = button.closest('tr');
    const statusCell = row.querySelector('.status');

    Swal.fire({
      title: 'Complete this order?',
      text: 'Are you sure the order is completed?',
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Complete',
      confirmButtonColor: '#38a169',
    }).then((result) => {
      if (result.isConfirmed) {
        // Change status to "Completed"
        statusCell.textContent = 'Completed';
        Swal.fire('Order Completed', 'This order has been completed.', 'success');
      }
    });
  }

  // Function to filter orders based on search bar input
  function filterOrders() {
    const input = document.getElementById('search-bar').value.toLowerCase();
    const table = document.getElementById('orders-table');
    const rows = table.getElementsByTagName('tr');

    for (let i = 1; i < rows.length; i++) {
      const cells = rows[i].getElementsByTagName('td');
      let match = false;

      for (let j = 0; j < cells.length; j++) {
        if (cells[j].textContent.toLowerCase().includes(input)) {
          match = true;
          break;
        }
      }

      rows[i].style.display = match ? '' : 'none';
    }
  }
</script>
