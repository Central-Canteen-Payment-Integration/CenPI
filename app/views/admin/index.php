<div class="container mx-auto">
  <!-- Header Section -->
  <div class="mb-4 flex justify-between items-center">
    <div>
      <h1 class="text-2xl font-semibold">Tenant Activation</h1>
      <p class="text-sm text-gray-500">Manage Tenant Account Activation</p>
    </div>
    <div class="flex space-x-4">
      <!-- Search Bar (for tenant search functionality) -->
      <div class="relative">
        <input
          type="text"
          placeholder="Search tenants..."
          class="bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-lg shadow-sm focus:ring focus:ring-blue-300 focus:outline-none w-72"
          id="search-bar"
          onkeyup="filterOrders()" />
      </div>
    </div>
  </div>

  <!-- Table Section -->
  <div class="bg-white shadow-md rounded-lg overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200" id="orders-table">
      <thead class="bg-red-500">
        <tr>
          <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Image</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Tenant Name</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Location Name</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Location Booth</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Status</th>
        </tr>
      </thead>
      <tbody class="bg-white divide-y divide-gray-200">
        <?php foreach ($data['tenants'] as $tenant): ?>
          <tr class="hover:bg-gray-100">
            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
              <img src="<?= MENU_URL . $tenant['IMAGE_PATH'] ?>" alt="Tenant Image" class="w-12 h-12 rounded-full">
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= $tenant['TENANT_NAME']; ?></td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= $tenant['LOCATION_NAME']; ?></td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= $tenant['LOCATION_BOOTH']; ?></td>
            <td class="px-6 py-4 whitespace-nowrap text-sm">
              <!-- Toggle Button for Status -->
              <form action="<?= BASE_URL; ?>/admin/toggleStatus/<?= $tenant['ID_TENANT']; ?>" method="POST">
                <button type="submit" class="px-4 py-2 rounded-md text-white <?= $tenant['ACTIVE'] ? 'bg-green-500' : 'bg-red-500' ?>">
                  <?= $tenant['ACTIVE'] ? 'Active' : 'Inactive'; ?>
                </button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<script>
  function filterOrders() {
    const searchBar = document.getElementById('search-bar');
    const query = searchBar.value.toLowerCase();
    const rows = document.querySelectorAll('#orders-table tbody tr');

    rows.forEach(row => {
      const tenantName = row.cells[1].textContent.toLowerCase();
      const locationName = row.cells[2].textContent.toLowerCase();
      const locationBooth = row.cells[3].textContent.toLowerCase();

      if (tenantName.includes(query) || locationName.includes(query) || locationBooth.includes(query)) {
        row.style.display = '';
      } else {
        row.style.display = 'none';
      }
    });
  }
</script>