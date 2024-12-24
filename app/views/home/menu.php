<div class="bg-white">
  <div>
    <main class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
      <div class="flex items-center justify-between border-b border-gray-200 pb-6">
        <h1 class="text-4xl font-bold tracking-tight text-gray-900">Menu</h1>

        <div class="block bg-gray-100 rounded-lg shadow-md w-[60%] max-md:w-[40%] mx-auto">
            <div class="flex items-center">
                <div class="flex-1">
                    <input id="search-input"
                        class="input input-bordered w-full rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Search" />
                </div>
            </div>
        </div>
      </div>

      <section aria-labelledby="products-heading" class="pb-24 pt-6">
        <div class="grid grid-cols-1 gap-x-8 gap-y-10 lg:grid-cols-4">
          <!-- Filters -->
          <form class="hidden categories lg:block">
            <div class="border-b border-gray-200 py-6">
              <h3 class="-my-3 flow-root">
                <div class="flex w-full items-center justify-between bg-white py-3 text-sm text-gray-400 hover:text-gray-500" aria-controls="filter-section-0" aria-expanded="false">
                  <span class="font-medium text-gray-900">Canteen</span>
                </div>
              </h3>
              <div class="pt-6" id="filter-section-0">
                <div class="space-y-4">
                  <?php
                    $locations = array_unique(array_column($data['menus'], 'LOCATION_NAME'));
                    foreach ($locations as $location) {
                      echo '<div class="flex gap-3">';
                      echo '<input id="filter-location-' . htmlspecialchars($location) . '" name="location[]" value="' . htmlspecialchars($location) . '" type="checkbox" class="checkbox">';
                      echo '<label for="filter-location-' . htmlspecialchars($location) . '" class="text-gray-500">' . htmlspecialchars($location) . '</label>';
                      echo '</div>';
                    }
                  ?>
                </div>
              </div>
            </div>
            <div class="border-b border-gray-200 py-6">
              <h3 class="-my-3 flow-root">
                <div class="flex w-full items-center justify-between bg-white py-3 text-sm text-gray-400 hover:text-gray-500" aria-controls="filter-section-0" aria-expanded="false">
                  <span class="font-medium text-gray-900">Food</span>
                </div>
              </h3>
              <div class="pt-6" id="filter-section-0">
                <div class="space-y-4">
                  <?php
                      $subcategories = array_unique(array_column(array_filter($data['menus'], function($menu) {
                        return $menu['MAIN_CATEGORY'] === 'makanan';
                      }), 'SUBCATEGORY_NAME'));
                      foreach ($subcategories as $subcategory) {
                        echo '<div class="flex gap-3">';
                        echo '<input id="filter-food-subcategory-' . htmlspecialchars($subcategory) . '" name="subcategory[]" value="' . htmlspecialchars($subcategory) . '" type="checkbox" class="checkbox">';
                        echo '<label for="filter-food-subcategory-' . htmlspecialchars($subcategory) . '" class="text-gray-500">' . htmlspecialchars($subcategory) . '</label>';
                        echo '</div>';
                      }
                    ?>
                </div>
              </div>
            </div>
            <div class="border-b border-gray-200 py-6">
              <h3 class="-my-3 flow-root">
                <div class="flex w-full items-center justify-between bg-white py-3 text-sm text-gray-400 hover:text-gray-500" aria-controls="filter-section-0" aria-expanded="false">
                  <span class="font-medium text-gray-900">Beverage</span>
                </div>
              </h3>
              <div class="pt-6" id="filter-section-0">
                <div class="space-y-4">
                    <?php
                      $subcategories = array_unique(array_column(array_filter($data['menus'], function($menu) {
                        return $menu['MAIN_CATEGORY'] === 'minuman';
                      }), 'SUBCATEGORY_NAME'));
                      foreach ($subcategories as $subcategory) {
                        echo '<div class="flex gap-3">';
                        echo '<input class"minuman" id="filter-drinks-subcategory-' . htmlspecialchars($subcategory) . '" name="subcategory[]" value="' . htmlspecialchars($subcategory) . '" type="checkbox" class="checkbox">';
                        echo '<label for="filter-drinks-subcategory-' . htmlspecialchars($subcategory) . '" class="text-gray-500">' . htmlspecialchars($subcategory) . '</label>';
                        echo '</div>';
                      }
                    ?>
                </div>
              </div>
            </div>
          </form>

          <!-- Product grid -->
          <div class="lg:col-span-3 grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-4" id="menu-container">
          </div>
        </div>
        <div class="flex justify-center mt-4" id="pagination-controls">
        </div>
      </section>
    </main>
  </div>
</div>

<!-- Please Login Modal -->
<input type="checkbox" id="login-modal" class="modal-toggle" hidden>
<div class="modal">
    <div class="modal-box relative max-w-xs sm:max-w-sm md:max-w-md lg:max-w-lg">
        <label for="login-modal" class="btn btn-sm btn-circle absolute right-2 top-2">✕</label>
        <h3 class="text-lg font-bold text-center">Please Login First!.</h3>
        <p class="py-4 text-center">Login First If You Want to Buy Some Food!</p>

        <!-- button login -->
        <div class="modal-action flex justify-center w-full">
            <a href="<?= BASE_URL; ?>/User/login"
                class="relative w-full max-w-[140px] h-[50px] rounded-xl overflow-hidden border-none outline-none flex flex-col group">
                <!-- Login? -->
                <div
                    class="absolute inset-0 bg-orange-500 flex items-center justify-center transition-all duration-300 ease-in-out">
                    <p class="text-lg font-bold text-white">Login?</p>
                </div>
                <!-- Login! -->
                <div
                    class="absolute inset-0 bg-yellow-500 flex items-center justify-center transition-all duration-300 ease-in-out transform translate-y-full group-hover:translate-y-0">
                    <p class="text-lg font-bold text-white">Login!</p>
                </div>
            </a>
        </div>
    </div>
</div>
<script>
    const allMenus = <?php echo json_encode($data['menus']); ?>;
    const itemsPerPage = 8;
    let currentPage = 1;
    let filteredMenus = allMenus;

    const fuse = new Fuse(allMenus, {
        keys: ['NAME'],
        threshold: 0.2,
        minMatchCharLength: 1,
        useExtendedSearch: true,
    });

    function applyFilters() {
        const selectedLocations = Array.from(document.querySelectorAll('input[name="location[]"]:checked')).map(cb => cb.value);
        const selectedSubcategories = Array.from(document.querySelectorAll('input[name="subcategory[]"]:checked')).map(cb => cb.value);

        filteredMenus = allMenus.filter(menu => {
            const locationMatch = selectedLocations.length === 0 || selectedLocations.includes(menu.LOCATION_NAME);
            console.log(locationMatch);
            const subcategoryMatch = selectedSubcategories.length === 0 || selectedSubcategories.includes(menu.SUBCATEGORY_NAME);
            return locationMatch && subcategoryMatch;
        });

        renderMenus(filteredMenus);
    }

    function renderMenus(menus, append = false) {
      const menuContainer = document.getElementById('menu-container');
      const paginationControls = document.getElementById('pagination-controls');
      
      if (!append) {
          menuContainer.innerHTML = '';
      }
      paginationControls.innerHTML = '';

      const totalPages = Math.ceil(menus.length / itemsPerPage);
      const startIndex = (currentPage - 1) * itemsPerPage;
      const endIndex = startIndex + itemsPerPage;
      const paginatedMenus = menus.slice(startIndex, endIndex);

      if (paginatedMenus.length > 0) {
          paginatedMenus.forEach(menu => {
              const menuCard = `
                  <div class="relative max-h-[270px] bg-white border border-gray-200 rounded-lg shadow-md overflow-hidden">
                      <figure class="h-40 overflow-hidden">
                          <img class="w-full h-full object-cover"
                              src="<?= MENU_URL ?>${menu.MENU_IMAGE_PATH || 'placeholder.jpg'}"
                              alt="${menu.NAME}" />
                      </figure>
                      <div class="description p-3">
                          <h2 class="text-lg font-semibold text-gray-800 max-md:text-sm truncate">${menu.NAME}</h2>
                          <div class="flex justify-between items-center mt-2">
                              <div class="text-lg font-bold text-gray-900 max-md:text-sm">
                                  Rp. ${menu.PRICE.toLocaleString('id-ID')}
                              </div>
                              <?php if (isset($_SESSION['user'])): ?>
                                  <button class="btn btn-primary text-white add-to-cart max-md:text-sm" data-id=${menu.ID_MENU}>
                                      Add
                                  </button>
                              <?php else: ?>
                                  <label class="btn btn-primary text-white max-md:text-sm" for="login-modal">
                                      Add
                                  </label>
                              <?php endif; ?>
                          </div>
                      </div>
                  </div>
              `;
              menuContainer.innerHTML += menuCard;
          });
      } else {
          menuContainer.innerHTML = '<p class="text-center text-gray-500 dark:text-gray-400">No items available.</p>';
      }

        if (window.innerWidth <= 768) {
            if (currentPage < totalPages) {
                const loadMoreButton = `
                    <div class="flex justify-center mt-4">
                        <button class="btn btn-primary text-white" onclick="loadMore()">Load More</button>
                    </div>
                `;
                paginationControls.innerHTML = loadMoreButton;
            }
        } else {
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
    }

    function changePage(page) {
        currentPage = page;
        renderMenus(filteredMenus);
    }

    function loadMore() {
        currentPage++;
        renderMenus(filteredMenus, true);
    }

    document.addEventListener('DOMContentLoaded', () => {
        renderMenus(allMenus);

        const filterCheckboxes = document.querySelectorAll('input[type="checkbox"]');
        filterCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', applyFilters);
        });

        const searchInput = document.getElementById('search-input');
        searchInput.addEventListener('input', (e) => {
            const searchTerm = e.target.value;
            if (searchTerm === '') {
                filteredMenus = allMenus;
            } else {
                filteredMenus = fuse.search(searchTerm).map(result => result.item);
            }
            currentPage = 1;
            renderMenus(filteredMenus);
        });
    });

    $(document).on('click', '.add-to-cart', function() {
        const menu = $(this).data();

        $.ajax({
            url: '/Cart/add',
            type: 'POST',
            data: {
                id_menu: menu.id,
            },
            dataType: 'json',
            success: function(res) {
                if (res.status === 'success') {
                    updateCartDisplay(res.cart);
                    swalert('success', 'Item added to cart.');
                } else {
                    swalert('error', 'Error updating cart: ' + res.message, {timer: 2500});
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error: ' + error);
                swalert('error', 'An error occurred while adding the item.', {timer: 2500});
            }
        });
    });
</script>