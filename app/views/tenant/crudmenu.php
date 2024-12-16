<div class="container mx-auto">
  <!-- Header Section -->
  <div class="flex justify-between items-center mb-6">
    <div>
      <h1 class="text-2xl font-semibold">Foods</h1>
      <p class="text-sm text-gray-500">Here is your menu summary with graph view</p>
    </div>
    <div class="flex gap-4">
      <!-- Search Bar -->
      <div class="relative">
        <input type="text" placeholder="Search here"
          class="bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-lg shadow-sm focus:ring focus:ring-blue-300 focus:outline-none w-72" />
      </div>
      <!-- Filter Dropdown -->
      <div class="relative">
        <select
          class="bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-lg shadow-sm focus:ring focus:ring-blue-300 focus:outline-none">
          <option value="">Filter</option>
          <option value="active">Active</option>
          <option value="inactive ">Inactive</option>
        </select>
      </div>
      <!-- Add Menu Button -->
      <button onclick="openAddMenuModal()"
        class="bg-red-500 text-white px-4 py-2 rounded-lg shadow-sm flex items-center space-x-2 hover:bg-red-600">
        <i class="ti ti-plus"></i>
        <span>New Menu</span>
      </button>
      <div id="add-menu-modal"
        class="hidden fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center z-50">
        <div id="add-modal-content"
          class="bg-white rounded-lg w-full max-w-lg p-6 shadow-lg opacity-0 scale-95 transform transition-all duration-300">
          <!-- Modal Header -->
          <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold text-gray-800">Add New Menu</h2>
            <button onclick="closeAddMenuModal()" class="text-gray-400 hover:text-gray-600">
              <i class="ti ti-x text-xl"></i>
            </button>
          </div>
          <!-- Modal Body -->
          <form id="add-menu-form" method="POST" action="/tenant/addMenu" enctype="multipart/form-data">
            <div class="text-left">
              <!-- Image Input -->
              <label for="add-menu-image" class="block text-sm font-medium text-gray-700 mb-1">Menu Image</label>
              <input type="file" id="add-menu-image" name="image_path" accept="image/*"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 mb-4" />

              <!-- Name Input -->
              <label for="add-menu-name" class="block text-sm font-medium text-gray-700 mb-1">Menu Name</label>
              <input type="text" id="add-menu-name" name="name" placeholder="Enter menu name"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 mb-4" />

              <!-- Type Selector -->
              <label for="add-menu-type" class="block text-sm font-medium text-gray-700 mb-1">Menu Type</label>
              <select id="add-menu-type" name="menu_type"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 mb-4">
                <option value="makanan">makanan</option>
                <option value="minuman">minuman</option>
              </select>

              <!-- Menu Category Selector -->
              <label for="add-menu-category" class="block text-sm font-medium text-gray-700 mb-1">Menu Category</label>
              <select id="add-menu-category" name="id_category"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 mb-4">
                <option value="1">Goreng</option>
                <option value="2">Bakar</option>
                <option value="3">Rebus</option>
                <option value="4">Es</option>
                <option value="5">Panas</option>
              </select>

              <!-- Price Input -->
              <label for="add-menu-price" class="block text-sm font-medium text-gray-700 mb-1">Price</label>
              <input type="number" id="add-menu-price" name="price" placeholder="Enter menu price"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 mb-4" />

              <!-- Package Price -->
              <label for="add-menu-pkg-price" class="block text-sm font-medium text-gray-700 mb-1">Package Price</label>
              <input type="number" id="add-menu-pkg-price" name="pkg_price" placeholder="Enter package price"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 mb-2" />
            </div>

            <div class="mt-6 flex justify-end space-x-4">
              <button type="button" onclick="closeAddMenuModal()"
                class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400 shadow-sm">
                Cancel
              </button>
              <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 shadow-sm">
                Add Menu
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Menu List Section -->
  <div class="flex flex-wrap justify-center gap-4">
    <?php if (!empty($data['menus'])): ?>
      <?php foreach ($data['menus'] as $menu): ?>
        <!-- Card Item -->
        <div class="bg-white shadow-lg rounded-lg p-4 w-[25%]">
          <img src="<?= BASE_URL; ?>/assets/img/menu/<?= htmlspecialchars($menu['IMAGE_PATH']); ?>" alt="Food Image"
            class="rounded-lg w-full h-36 fill-cover" />
          <div class="mt-4">
            <h2 class="text-md font-semibold"><?= htmlspecialchars($menu['NAME']); ?></h2>
            <div class="flex space-x-2">
              <p class="text-sm text-gray-500"><?= htmlspecialchars($menu['MENU_TYPE']); ?></p>
              <p class="text-sm text-gray-500">/</p>
              <p class="text-sm text-gray-500"><?= htmlspecialchars($menu['CATEGORY_NAME']); ?></p>
            </div>
            <div class="flex space-x-2">
              <h4 class="text-sm font-semibold text-black-500">
                Rp. <?= number_format($menu['PRICE'], 0, ',', '.'); ?>,-
              </h4>
              <p class="text-sm text-gray-500">(pkg: +<?= number_format($menu['PKG_PRICE'], 0, ',', '.'); ?>)</p>
            </div>
          </div>
          <div class="flex gap-2 justify-center mt-4">
            <!-- Active Button -->
            <button id="toggleButton"
              class="bg-green-500 text-white text-xs px-3 py-1 rounded-lg flex items-center space-x-1">
              <i class="ti ti-eye"></i>
              <span id="buttonText"><?= $menu['ACTIVE'] ? 'Active' : 'Inactive'; ?></span>
            </button>
            <!-- Edit Button -->
            <button onclick="openEditMenuModal('<?= htmlspecialchars($menu['ID_MENU']); ?>')"
              class="bg-yellow-500 text-white text-xs px-3 py-1 rounded-lg hover:bg-yellow-600 flex items-center">
              <i class="ti ti-edit"></i>
              <span>Edit</span>
            </button>
            <!-- Delete Button -->
            <button onclick="deleteMenu('<?= htmlspecialchars($menu['ID_MENU']); ?>')"
              class="bg-red-500 text-white text-xs px-3 py-1 rounded-lg hover:bg-red-600 flex items-center">
              <i class="ti ti-trash"></i>
              <span>Delete</span>
            </button>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p class="text-gray-500">No menus available for this tenant.</p>
    <?php endif; ?>
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


<script>
  const toggleButton = document.getElementById('toggleButton');
  const buttonText = document.getElementById('buttonText');

  toggleButton.addEventListener('click', () => {
    const isActive = toggleButton.classList.contains('bg-green-500');

    Swal.fire({
      title: 'Are you sure?',
      text: `Do you want to change the menu to ${isActive ? 'Inactive' : 'Active'}?`,
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: isActive ? '#d33' : '#3085d6',
      cancelButtonColor: '#aaa',
      confirmButtonText: `Yes, set to ${isActive ? 'Inactive' : 'Active'}`,
    }).then((result) => {
      if (result.isConfirmed) {
        if (isActive) {
          toggleButton.classList.remove('bg-green-500', 'hover:bg-green-600');
          toggleButton.classList.add('bg-red-500', 'hover:bg-red-600');
          buttonText.textContent = 'Inactive';
        } else {
          toggleButton.classList.remove('bg-red-500', 'hover:bg-red-600');
          toggleButton.classList.add('bg-green-500', 'hover:bg-green-600');
          buttonText.textContent = 'Active';
        }

        Swal.fire(
          'Changed!',
          `The menu is now ${isActive ? 'Inactive' : 'Active'}.`,
          'success'
        );
      }
    });
  });

  // fungsi open edit menu
  function openEditMenuModal() {
    const modal = document.getElementById('edit-menu-modal');
    const modalContent = modal.querySelector('.bg-white');

    modal.classList.remove('hidden');
    // animasi modal
    setTimeout(() => {
      modalContent.classList.remove('opacity-0', 'scale-95');
      modalContent.classList.add('opacity-100', 'scale-100');
    }, 50);
  }

  // funsgi close edit menu
  function closeEditMenuModal() {
    const modal = document.getElementById('edit-menu-modal');
    const modalContent = modal.querySelector('.bg-white');

    modalContent.classList.remove('opacity-100', 'scale-100');
    modalContent.classList.add('opacity-0', 'scale-95');
    setTimeout(() => {
      modal.classList.add('hidden');
    }, 300);
  }


  function saveMenuEdit() {
    closeEditMenuModal();

    Swal.fire({
      icon: 'success',
      title: 'Menu Updated',
      text: 'The menu has been successfully updated!',
      confirmButtonColor: '#38a169', // Green
    });
  }

  function openAddMenuModal() {
    const modal = document.getElementById('add-menu-modal');
    const modalContent = document.getElementById('add-modal-content');

    modal.classList.remove('hidden');
    setTimeout(() => {
      modalContent.classList.remove('opacity-0', 'scale-95');
      modalContent.classList.add('opacity-100', 'scale-100');
    }, 50);
  }

  // Close the add menu modal with animation
  function closeAddMenuModal() {
    const modal = document.getElementById('add-menu-modal');
    const modalContent = document.getElementById('add-modal-content');

    modalContent.classList.remove('opacity-100', 'scale-100');
    modalContent.classList.add('opacity-0', 'scale-95');
    setTimeout(() => {
      modal.classList.add('hidden');
    }, 300);
  }

  function saveAddMenu() {
    closeAddMenuModal();

    Swal.fire({
      icon: 'success',
      title: 'Menu Added',
      text: 'Your new menu has been successfully added!',
      confirmButtonColor: '#38a169',
    });
  }

  function deleteMenu(button) {
    Swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes, delete it!',
      cancelButtonText: 'No, cancel!',
      confirmButtonColor: '#e53e3e', // Red
      cancelButtonColor: '#3182ce', // Blue
    }).then((result) => {
      if (result.isConfirmed) {
        Swal.fire({
          icon: 'success',
          title: 'Deleted!',
          text: 'Your menu has been deleted.',
          confirmButtonColor: '#38a169', // Green
        });
      }
    });
  }
</script>