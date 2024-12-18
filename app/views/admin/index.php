<div class="container mx-auto">
  <!-- Header Section -->
  <div class="mb-4 flex justify-between items-center">
    <div>
      <h1 class="text-2xl font-semibold">Transaction History</h1>
      <p class="text-sm text-gray-500">A detailed list of your past transactions</p>
    </div>
    <div class="flex space-x-4">
      <!-- Search Bar -->
      <div class="relative">
        <input
          type="text"
          placeholder="Search transactions..."
          class="bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-lg shadow-sm focus:ring focus:ring-blue-300 focus:outline-none w-72"
          id="search-bar"
          onkeyup="filterOrders()"
        />
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

  <!-- Table Section -->
  <div class="bg-white shadow-md rounded-lg overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200" id="orders-table">
      <thead class="bg-red-500">
        <tr>
          <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Order ID</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Date</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Customer Name</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Order Details</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Amount</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Payment</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Status</th>
        </tr>
      </thead>
      <tbody class="bg-white divide-y divide-gray-200">
        <!-- Table Row Example -->
        <tr class="hover:bg-gray-100">
          <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#555231</td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">26 March 2020, 12:42 AM</td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Mikasa Ackerman</td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">2x Coffee, 1x Sandwich</td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">$164.52</td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">QRIS</td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-green-500 font-semibold">Success</td>
        </tr>
        <!-- Add more rows as needed -->
      </tbody>
    </table>
  </div>
</div>
<script>
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
