<div class="flex justify-between items-center mb-6 relative">
  <h2 class="text-2xl font-semibold text-gray-800 flex items-center space-x-2 mb-4">
    <i class="ti ti-layout-dashboard text-blue-500"></i>
    <span>Dashboard</span>
  </h2>
  
  <!-- Filter Periode -->
  <div class="bg-white p-3 rounded-md flex items-center space-x-3 cursor-pointer shadow-md relative hover:shadow-lg transition-shadow duration-300" id="filter-period">
    <i class="ti ti-calendar text-blue-500 text-lg"></i>
    <span class="text-gray-800">Filter Periode</span>
    <span class="text-gray-500" id="period-text">DD-MM-YYYY - DD-MM-YYYY</span>
    <button class="text-blue-500 focus:outline-none">
      <i class="ti ti-chevron-down" id="chevron-icon"></i>
    </button>
  </div>
</div>

<!-- Card stats -->
<div class="grid grid-cols-4 gap-6">
  <div class="bg-white p-4 rounded-lg shadow flex items-center space-x-4">
    <div class="p-3 bg-blue-100 rounded-full">
      <i class="ti ti-file-invoice text-blue-500 text-2xl"></i>
    </div>
    <div>
      <p class="text-sm text-gray-500">Total Orders</p>
      <h3 class="text-xl font-semibold text-gray-800">75</h3>
    </div>
  </div>

  <div class="bg-white p-4 rounded-lg shadow flex items-center space-x-4">
    <div class="p-3 bg-green-100 rounded-full">
      <i class="ti ti-package text-green-500 text-2xl"></i>
    </div>
    <div>
      <p class="text-sm text-gray-500">Total Delivered</p>
      <h3 class="text-xl font-semibold text-gray-800">357</h3>
    </div>
  </div>

  <div class="bg-white p-4 rounded-lg shadow flex items-center space-x-4">
    <div class="p-3 bg-red-100 rounded-full">
      <i class="ti ti-ban text-red-500 text-2xl"></i>
    </div>
    <div>
      <p class="text-sm text-gray-500">Total Cancelled</p>
      <h3 class="text-xl font-semibold text-gray-800">65</h3>
    </div>
  </div>

  <div class="bg-white p-4 rounded-lg shadow flex items-center space-x-4">
    <div class="p-3 bg-yellow-100 rounded-full">
      <i class="ti ti-cash text-yellow-500 text-2xl"></i>
    </div>
    <div>
      <p class="text-sm text-gray-500">Total Revenue</p>
      <h3 class="text-xl font-semibold text-gray-800">$128</h3>
    </div>
  </div>
</div>

<!-- buat chart (kalo ada) -->
<div class="bg-white p-6 rounded-lg shadow mt-6">
  <h3 class="text-xl font-semibold text-gray-800 mb-4">Chart</h3>
  </div>
</div>

