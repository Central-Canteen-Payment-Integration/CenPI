<div class="container mx-auto">
  <!-- Header Section -->
  <div class="flex justify-between items-center mb-6">
    <div>
      <h1 class="text-2xl font-semibold">Foods</h1>
      <p class="text-sm text-gray-500">Here is your menu summary with graph view</p>
    </div>
    <div class="flex space-x-4">
      <!-- Search Bar -->
      <div class="relative">
        <input
          type="text"
          placeholder="Search here"
          class="bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-lg shadow-sm focus:ring focus:ring-blue-300 focus:outline-none w-72"
        />
      </div>
      <!-- Filter Dropdown -->
      <div class="relative">
        <select
          class="bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-lg shadow-sm focus:ring focus:ring-blue-300 focus:outline-none">
          <option value="">All Categories</option>
          <option value="Food">Food</option>
          <option value="Drink">Drink</option>
        </select>
      </div>
      <!-- Add Menu Button -->
      <button
        class="bg-red-500 text-white px-4 py-2 rounded-lg shadow-sm flex items-center space-x-2 hover:bg-red-600"
      >
        <i class="ti ti-plus"></i>
        <span>New Menu</span>
      </button>
    </div>
  </div>

  <!-- Menu List Section -->
  <div class="flex flex-wrap justify-center gap-4">
    <!-- Card Item -->
    <div class="bg-white shadow-lg rounded-lg p-4 w-[23%]">
      <img
        src="<?= BASE_URL; ?>/assets/img/menu/ayamgeprekkeju.jpg"
        alt="Food Image"
        class="rounded-lg w-full h-36 fill-cover"
      />
      <div class="mt-4">
        <h2 class="text-md font-semibold">Ayam Geprek Keju</h2>
        <p class="text-sm text-gray-500">Food / Chicken</p>
      </div>
      <div class="flex space-x-2 justify-center mt-4">
        <button class="bg-green-500 text-white text-xs px-3 py-1 rounded-lg hover:bg-green-600 flex items-center space-x-1">
          <i class="ti ti-eye"></i>
          <span>View</span>
        </button>
        <button class="bg-yellow-500 text-white text-xs px-3 py-1 rounded-lg hover:bg-yellow-600 flex items-center space-x-1">
          <i class="ti ti-edit"></i>
          <span>Edit</span>
        </button>
        <button class="bg-red-500 text-white text-xs px-3 py-1 rounded-lg hover:bg-red-600 flex items-center space-x-1">
          <i class="ti ti-trash"></i>
          <span>Delete</span>
        </button>
      </div>
    </div>
    <!-- Repeat other cards -->
    <div class="bg-white shadow-lg rounded-lg p-4 w-[23%]">
      <img
        src="<?= BASE_URL; ?>/assets/img/menu/ayamgeprekkeju.jpg"
        alt="Food Image"
        class="rounded-lg w-full h-36 fill-cover"
      />
      <div class="mt-4">
        <h2 class="text-md font-semibold">Ayam Geprek Keju</h2>
        <p class="text-sm text-gray-500">Food / Chicken</p>
      </div>
      <div class="flex space-x-2 justify-center mt-4">
        <button class="bg-green-500 text-white text-xs px-3 py-1 rounded-lg hover:bg-green-600 flex items-center space-x-1">
          <i class="ti ti-eye"></i>
          <span>View</span>
        </button>
        <button class="bg-yellow-500 text-white text-xs px-3 py-1 rounded-lg hover:bg-yellow-600 flex items-center space-x-1">
          <i class="ti ti-edit"></i>
          <span>Edit</span>
        </button>
        <button class="bg-red-500 text-white text-xs px-3 py-1 rounded-lg hover:bg-red-600 flex items-center space-x-1">
          <i class="ti ti-trash"></i>
          <span>Delete</span>
        </button>
      </div>
    </div>
  </div>

  <!-- Pagination -->
  <div class="flex justify-between items-center mt-6">
    <p class="text-sm text-gray-500">Showing .. from ... Menu</p>
    <div class="flex space-x-2">
      <button class="bg-gray-200 px-3 py-1 rounded-lg hover:bg-gray-300">1</button>
      <button class="bg-gray-200 px-3 py-1 rounded-lg hover:bg-gray-300">2</button>
      <button class="bg-gray-200 px-3 py-1 rounded-lg hover:bg-gray-300">3</button>
      <button class="bg-gray-200 px-3 py-1 rounded-lg hover:bg-gray-300">4</button>
    </div>
  </div>
</div>
