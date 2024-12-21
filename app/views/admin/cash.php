<div class="container mx-auto px-4 py-6">
  <!-- Header Section -->
  <div class="mb-6 flex justify-between items-center">
    <div>
      <h1 class="text-3xl font-semibold text-gray-800">Cash Management</h1>
      <p class="text-sm text-gray-500">Manage Your Cash Transaction</p>
    </div>
    <div class="flex space-x-4">
      <!-- Search Bar -->
      <input type="text" placeholder="Search by Name" class="px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none w-64">
    </div>
  </div>

  <!-- Table Section -->
  <div class="bg-white shadow-sm rounded-lg overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200" id="orders-table">
      <thead class="bg-gray-800 text-white">
        <tr>
          <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Angka Unik</th>
          <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Nama Pembeli</th>
          <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Total Bayar</th>
          <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Terima Uang</th>
        </tr>
      </thead>
      <tbody class="bg-white divide-y divide-gray-200">
        <?php foreach ($data['transactions'] as $transaction): ?>
          <tr class="hover:bg-gray-50">
            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
              <?= substr($transaction['ID_USER'], 0, 6); ?>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= $transaction['USERNAME']; ?></td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= number_format($transaction['TRX_PRICE'], 0, ',', '.'); ?></td>
            <td class="px-6 py-4 whitespace-nowrap text-sm">
              <!-- Terima Uang Button -->
              <?php if ($transaction['TRX_STATUS'] = 'Unpaid'): ?>
                <form action="<?= BASE_URL; ?>/admin/terimaUang/<?= $transaction['ID_TRANSACTION']; ?>" method="POST">
                  <button type="submit" class="px-4 py-2 rounded-md bg-blue-600 text-white text-sm font-semibold hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    Terima Uang
                  </button>
                </form>
              <?php else: ?>
                <span class="text-green-500 font-semibold">Completed</span>
              <?php endif; ?>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- Include jQuery and DataTables CDN -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

<!-- Initialize DataTable -->
<script>
  $(document).ready(function() {
    $('#orders-table').DataTable({
      "pageLength": 10,
      "lengthMenu": [10, 25, 50, 75, 100],
      "searching": true,
      "paging": true,
      "ordering": true,
      "language": {
        "search": "Cari:",
        "lengthMenu": "Tampilkan _MENU_ data per halaman",
        "zeroRecords": "Tidak ada data yang cocok",
        "info": "Menampilkan halaman _PAGE_ dari _PAGES_",
        "infoEmpty": "Tidak ada data yang tersedia",
        "infoFiltered": "(disaring dari _MAX_ total data)"
      }
    });
  });
</script>
