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
        <input id="search-bar" type="text" placeholder="Search here"
          class="bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-lg shadow-sm focus:ring focus:ring-blue-300 focus:outline-none w-72" />
      </div>
      <!-- Filter Dropdown -->
      <div class="relative">
        <select id="status-filter"
          class="bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-lg shadow-sm focus:ring focus:ring-blue-300 focus:outline-none">
          <option value="all">no Filter</option>
          <option value="active">Active</option>
          <option value="inactive ">Inactive</option>
        </select>
      </div>
      <!-- Add Menu Button -->
      <button onclick="create_menu.showModal()"
        class="bg-red-500 btn text-white px-4 py-2 rounded-lg shadow-sm flex items-center space-x-2 hover:bg-red-600">
        <i class="ti ti-plus"></i>
        <span>New Menu</span>
      </button>
      <dialog id="create_menu" class="modal">
        <div class="modal-box">
          <h3 class="text-lg font-bold">Add New Menu</h3>
            <form id="add-menu-form" class="modal-backdrop" method="dialog" action="/Tenant/menu/add" enctype="multipart/form-data">
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
              </select>

              <!-- Price Input -->
              <label for="add-menu-price" class="block text-sm font-medium text-gray-700 mb-1">Price</label>
              <input type="number" id="add-menu-price" name="price" value="0" placeholder="Enter menu price"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 mb-4" />

              <!-- Package Price -->
              <label for="add-menu-pkg-price" class="block text-sm font-medium text-gray-700 mb-1">Package Price</label>
              <input type="number" id="add-menu-pkg-price" name="pkg_price" value="0" placeholder="Enter package price"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 mb-2" />
            </div>

            <div class="modal-action">
              <button class="btn" onclick="event.preventDefault(); create_menu.close()">Close</button>
              <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 shadow-sm">
                Add Menu
              </button>
            </div>
          </form>
        </div>
      </dialog>
      <dialog id="update_menu" class="modal">
        <div class="modal-box">
            <h3 class="text-lg font-bold">Update Menu</h3>
            <form id="update-menu-form" method="POST" action="/Tenant/menu/update" enctype="multipart/form-data">
                <div class="text-left">
                    <!-- Image Input -->
                    <input type="hidden" id="update-menu-id" name="id_menu" />
                    <label for="update-menu-image" class="block text-sm font-medium text-gray-700 mb-1">Menu Image</label>
                    <input type="file" id="update-menu-image" name="image_path" accept="image/*"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 mb-4" />

                    <!-- Name Input -->
                    <label for="update-menu-name" class="block text-sm font-medium text-gray-700 mb-1">Menu Name</label>
                    <input type="text" id="update-menu-name" name="name" placeholder="Enter menu name"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 mb-4" />

                    <!-- Type Selector -->
                    <label for="update-menu-type" class="block text-sm font-medium text-gray-700 mb-1">Menu Type</label>
                    <select id="update-menu-type" name="menu_type"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 mb-4">
                        <option value="makanan">Foods</option>
                        <option value="minuman">Beverages</option>
                    </select>

                    <!-- Menu Category Selector -->
                    <label for="update-menu-category" class="block text-sm font-medium text-gray-700 mb-1">Menu Category</label>
                    <select id="update-menu-category" name="id_category"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 mb-4">
                    </select>

                    <!-- Price Input -->
                    <label for="update-menu-price" class="block text-sm font-medium text-gray-700 mb-1">Price</label>
                    <input type="number" id="update-menu-price" name="price" value="0" placeholder="Enter menu price"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 mb-4" />

                    <!-- Package Price -->
                    <label for="update-menu-pkg-price" class="block text-sm font-medium text-gray-700 mb-1">Package Price</label>
                    <input type="number" id="update-menu-pkg-price" name="pkg_price" value="0" placeholder="Enter package price"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 mb-2" />
                </div>

                <div class="modal-action">
                    <button class="btn" onclick="event.preventDefault(); update_menu.close()">Close</button>
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 shadow-sm">
                        Update Menu
                    </button>
                </div>
            </form>
        </div>
      </dialog>
    </div>
  </div>

  <!-- Menu List Section -->
  <div id="menu-list" class="lg:col-span-3 grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
  </div>
  <div class="flex justify-center mt-4" id="pagination-controls">
  </div>
</div>
</div>


<script>
    const categories = <?php echo json_encode($data['categories']); ?>;

    document.getElementById('add-menu-type').addEventListener('change', function() {
      const selectedType = this.value;
      const categorySelect = document.getElementById('add-menu-category');
      categorySelect.innerHTML = '';

      const filteredCategories = categories.filter(category => category.MAIN_CATEGORY === selectedType);
      filteredCategories.forEach(category => {
        const option = document.createElement('option');
        option.value = category.ID_CATEGORY;
        option.textContent = category.CATEGORY_NAME;
        categorySelect.appendChild(option);
      });
    });

    document.getElementById('add-menu-type').dispatchEvent(new Event('change'));
    let menus = <?= json_encode($data['menus']); ?>;
    const itemsPerPage = 8;
    let currentPage = 1;
    let filteredMenus = menus;

    const fuse = new Fuse(menus, {
        keys: ['NAME', 'MENU_TYPE', 'CATEGORY_NAME'],
        threshold: 0.3
    });

    document.getElementById('status-filter').addEventListener('change', function() {
  const selectedStatus = this.value;
  filterMenusByStatus(selectedStatus);
});

function filterMenusByStatus(status) {
  if (status === 'all') {
    filteredMenus = menus;
  } else {
    const isActive = status === 'active';
    filteredMenus = menus.filter(menu => menu.ACTIVE == (isActive ? 1 : 0));
  }
  currentPage = 1;
  renderMenus(filteredMenus);
}

    function renderMenus(menus, append = false) {
        const menuList = document.getElementById('menu-list');
        const paginationControls = document.getElementById('pagination-controls');

        if (!append) {
            menuList.innerHTML = '';
        }
        paginationControls.innerHTML = '';

        const totalPages = Math.ceil(menus.length / itemsPerPage);
        const startIndex = (currentPage - 1) * itemsPerPage;
        const endIndex = startIndex + itemsPerPage;
        const paginatedMenus = menus.slice(startIndex, endIndex);

        if (paginatedMenus.length > 0) {
            paginatedMenus.forEach(menu => {
                const menuItem = document.createElement('div');
                menuItem.setAttribute('data-id', menu.ID_MENU);
                menuItem.classList.add('menu-item', 'bg-white', 'shadow-lg', 'rounded-lg', 'px-4', 'py-2', 'w-full');
                menuItem.dataset.name = menu.NAME;
                menuItem.dataset.status = menu.ACTIVE ? 'active' : 'inactive';

                menuItem.innerHTML = `
                    <img src="<?= BASE_URL; ?>/assets/img/menu/${menu.IMAGE_PATH}" alt="Food Image" class="rounded-lg w-full h-36 fill-cover" />
        <div class="mt-3">
          <h2 class="text-md font-semibold">${menu.NAME}</h2>
          <div class="flex space-x-2">
            <p class="text-sm text-gray-500">${menu.MENU_TYPE}</p>
            <p class="text-sm text-gray-500">/</p>
            <p class="text-sm text-gray-500">${menu.CATEGORY_NAME}</p>
          </div>
          <div class="flex space-x-2">
            <h4 class="text-sm font-semibold text-black-500">Rp. ${menu.PRICE.toLocaleString('id-ID')},-</h4>
            <p class="text-sm text-gray-500">(pkg: +${menu.PKG_PRICE.toLocaleString('id-ID')})</p>
          </div>
        </div>
        <div class="flex gap-2 justify-center mt-4">
            <input type="hidden" name="menu_id" value="${menu.ID_MENU}">
            <input type="hidden" name="current_status" value="${menu.ACTIVE}">
            <button type="button" class="toggleButton ${menu.ACTIVE == 1 ? 'bg-green-500' : 'bg-red-500'} text-white text-xs px-3 py-1 rounded-lg flex items-center" data-id="${menu.ID_MENU}" data-status="${menu.ACTIVE}">
              <i class="ti ${menu.ACTIVE == 1 ? 'ti-eye' : 'ti-eye-closed'}"></i>
              <span>${menu.ACTIVE == 1 ? 'Active' : 'Inactive'}</span>
            </button>
            <button onclick="openEditMenuModal('${menu.ID_MENU}')" class="bg-yellow-500 text-white text-xs px-3 py-1 rounded-lg hover:bg-yellow-600 flex items-center">
    <i class="ti ti-edit"></i>
    <span>Edit</span>
</button>
            <button onclick="deleteMenu('${menu.ID_MENU}')" class="bg-red-500 text-white text-xs px-3 py-1 rounded-lg hover:bg-red-600 flex items-center">
              <i class="ti ti-trash"></i>
              <span>Delete</span>
            </button>
        </div>
                `;
                menuList.appendChild(menuItem);
            });
        } else {
            menuList.innerHTML = '<p class="text-center text-gray-500 dark:text-gray-400">No items available.</p>';
        }

        const pagination = `
            <div class="join">
                <button class="join-item btn" ${currentPage === 1 ? 'disabled' : ''} onclick="changePage(${currentPage - 1})">«</button>
                ${Array.from({ length: totalPages }, (_, i) => `
                    <button class="join-item btn ${currentPage === i + 1 ? 'btn-primary' : ''}" onclick="changePage(${i + 1})">${i + 1}</button>
                `).join('')}
                <button class="join-item btn" ${currentPage === totalPages ? 'disabled' : ''} onclick="changePage(${currentPage + 1})">»</button>
            </div>
        `;
        paginationControls.innerHTML = pagination;
    }

    function changePage(page) {
        currentPage = page;
        renderMenus(filteredMenus);
    }

    document.getElementById('search-bar').addEventListener('input', (e) => {
        const searchTerm = e.target.value;
        if (searchTerm === '') {
            filteredMenus = menus;
        } else {
            filteredMenus = fuse.search(searchTerm).map(result => result.item);
        }
        currentPage = 1;
        renderMenus(filteredMenus);
    });

    document.addEventListener('DOMContentLoaded', () => {
        renderMenus(menus);
    });

  $(document).on('click', '.toggleButton', function () {
    const button = $(this);
    const menuId = button.data('id');
    const currentStatus = parseInt(button.data('status'));
    const newStatus = currentStatus == 1 ? 0 : 1;

    Swal.fire({
      title: 'Are you sure?',
      text: `Do you want to change the menu to ${newStatus === 1 ? 'Active' : 'Inactive'}?`,
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: newStatus === 1 ? '#3085d6' : '#d33',
      cancelButtonColor: '#aaa',
      confirmButtonText: `Yes, set to ${newStatus === 1 ? 'Active' : 'Inactive'}`,
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: '/Tenant/menu/updateStatus',
          method: 'POST',
          data: {
            menu_id: menuId,
            current_status: currentStatus,
          },
          success: function (response) {
            if (response) {
              button.data('status', newStatus);
              button.toggleClass('bg-green-500 bg-red-500');
              button.find('i').toggleClass('ti-eye ti-eye-closed');
              button.find('span').text(newStatus === 1 ? 'Active' : 'Inactive');

              const menuIndex = menus.findIndex(menu => menu.ID_MENU == menuId);
              if (menuIndex !== -1) {
                  menus[menuIndex].ACTIVE = newStatus;
              }

              // Re-filter and re-render the menus
              filterMenusByStatus(document.getElementById('status-filter').value);
            }
          },
        });
      }
    });
  });

  function openEditMenuModal(menuId) {
    const menu = menus.find(m => m.ID_MENU === menuId);
    if (menu) {
        document.getElementById('update-menu-id').value = menu.ID_MENU;
        document.getElementById('update-menu-image').value = '';
        document.getElementById('update-menu-name').value = menu.NAME;
        document.getElementById('update-menu-type').value = menu.MENU_TYPE;
        
        // Reset dan isi kategori
        const categorySelect = document.getElementById('update-menu-category');
        categorySelect.innerHTML = ''; // Kosongkan kategori
        const filteredCategories = categories.filter(category => category.MAIN_CATEGORY === menu.MENU_TYPE);
        filteredCategories.forEach(category => {
            const option = document.createElement('option');
            option.value = category.ID_CATEGORY;
            option.textContent = category.CATEGORY_NAME;
            if (category.ID_CATEGORY === menu.ID_CATEGORY) {
                option.selected = true; // Pilih kategori yang sesuai
            }
            categorySelect.appendChild(option);
        });

        document.getElementById('update-menu-price').value = menu.PRICE;
        document.getElementById('update-menu-pkg-price').value = menu.PKG_PRICE;

        document.getElementById('update_menu').showModal();
    }
}

function deleteMenu(menuId) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel!',
        confirmButtonColor: '#e53e3e',
        cancelButtonColor: '#3182ce',
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '/Tenant/menu/delete',
                method: 'POST',
                data: {
                    id_menu: menuId
                },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Deleted!',
                        text: 'Your menu has been deleted.',
                        confirmButtonColor: '#38a169',
                    });

                    location.reload();
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong! Please try again.',
                    });
                }
            });
        }
    });
}
</script>