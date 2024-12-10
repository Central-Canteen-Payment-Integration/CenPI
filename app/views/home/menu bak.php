<div class="join flex items-center space-x-4 p-4 bg-gray-100 rounded-lg shadow-md max-w-3xl w-full mx-auto mb-4">
    <div class="flex-1">
        <input id="search-input" class="input input-bordered join-item w-full p-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Search" />
    </div>
    <div class="flex-1">
        <select id="filter-select" class="select select-bordered join-item w-full p-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">All Menus</option>
            <option value="Kantin Teknik">Kantek</option>
            <option value="Kantin Bawah">Kawah</option>
        </select>
    </div>
    <div class="indicator flex items-center space-x-2">
        <span id="filter-indicator" class="indicator-item badge badge-secondary bg-blue-500 text-white rounded-full py-1 px-2 text-xs">new</span>
        <button id="search-btn" class="btn join-item bg-red-600  text-white py-2 px-4 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
            Search
        </button>
    </div>
</div>

<div class="flex flex-wrap gap-5 justify-center px-4" id="menu-container">
    <!-- Menus di didsplay -->
</div>



<!-- Please Login Modal -->
<input type="checkbox" id="login-modal" class="modal-toggle" hidden>
<div class="modal">
    <div class="modal-box relative max-w-xs sm:max-w-sm md:max-w-md lg:max-w-lg">
        <label for="login-modal" class="btn btn-sm btn-circle absolute right-2 top-2">✕</label>
        <h3 class="text-lg font-bold text-center">Please Login Dulu.</h3>
        <p class="py-4 text-center">Login Dulu Kalau Ingin Beli Makanan!</p>

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



<!-- Tombol buat mobel -->
<div class="fixed bottom-5 right-5 z-10 block md:hidden">
    <?php if (isset($_SESSION['user'])): ?>
        <button class="bg-primary text-white rounded-full p-4 shadow-lg hover:bg-accent"
            onclick="document.getElementById('mobile-cart-drawer').checked = true" id="mobile-cart-button">
            <div class="indicator">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <span class="badge badge-sm indicator-item qty-cart"></span>
            </div>
        </button>
    <?php else: ?>
        <!--  button buat non-logged-in users -->
        <button class="bg-primary text-white rounded-full p-4 shadow-lg hover:bg-accent"
            onclick="document.getElementById('login-modal').checked = true" id="mobile-login-button">
            <div class="indicator">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
        </button>
    <?php endif; ?>
</div>


<!-- Mobel Modal -->
<div class="drawer drawer-bottom block md:hidden z-30">
    <input id="mobile-cart-drawer" type="checkbox" class="drawer-toggle" />
    <div class="drawer-side">
        <label for="mobile-cart-drawer" class="drawer-overlay z-20"></label>
        <div class="relative z-40">
            <div class="bg-white text-base-content min-h-screen p-4 overflow-y-auto max-h-[80vh]">
                <div class="flex justify-between items-center">
                    <h2 class="text-lg font-medium text-secondary">Food Cart</h2>
                    <button type="button" class="text-gray-500 hover:text-gray-700"
                        onclick="document.getElementById('mobile-cart-drawer').checked = false">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="mt-2">
                    <div class="flow-root">
                        <ul role="list" class="divide-y divide-gray-200 cart-list">
                        </ul>
                    </div>
                </div>
                <div class="border-t border-gray-200 px-4 py-6 cart-btn">
                </div>
            </div>
        </div>
    </div>
</div>

<!-- logic buat cart & menu & filter -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    const isLoggedIn = <?php echo isset($_SESSION['user']) ? 'true' : 'false'; ?>;
    const allMenus = <?php echo json_encode($data['menus']); ?>;

    const filterIndicator = document.getElementById('filter-indicator');
    const filterSelect = document.getElementById('filter-select');
    const searchInput = document.getElementById('search-input');

    filterSelect.addEventListener('change', function() {
        const selectedFilter = filterSelect.value;
        updateFilterIndicator(selectedFilter);
        const searchTerm = searchInput.value.trim().toLowerCase();
        filterMenus(selectedFilter, searchTerm);
    });

    document.getElementById('search-btn').addEventListener('click', function() {
        const selectedFilter = filterSelect.value;
        const searchTerm = searchInput.value.trim().toLowerCase();
        filterMenus(selectedFilter, searchTerm);
    });

    function updateFilterIndicator(selectedFilter) {
        if (selectedFilter) {
            filterIndicator.textContent = `Filter: ${selectedFilter}`;
            filterIndicator.classList.remove('badge-secondary');
            filterIndicator.classList.add('badge-primary');
        } else {
            filterIndicator.textContent = 'New';
            filterIndicator.classList.remove('badge-primary');
            filterIndicator.classList.add('badge-secondary');
        }
    }

    function filterMenus(location = '', searchTerm = '') {
        console.log('Filtering menus for location:', location, 'and search term:', searchTerm);

        const filteredMenus = allMenus.filter(menu => {
            const menuLocation = (menu.LOCATION_NAME || '').toLowerCase().replace(/\s+/g, '');
            const menuName = (menu.NAME || '').toLowerCase().replace(/\s+/g, '');

            const matchesLocation = location ? menuLocation === location.toLowerCase().replace(/\s+/g, '') : true;

            const matchesSearchTerm = searchTerm ? menuName.startsWith(searchTerm) : true;

            return matchesLocation && matchesSearchTerm;
        });

        const menuContainer = document.getElementById('menu-container');
        menuContainer.innerHTML = '';

        if (filteredMenus.length > 0) {
            filteredMenus.forEach(menu => {
                const menuCard = `
                <div class="card card-compact bg-base-100 w-64 border-2 border-neutral shadow-xl">
                    <figure class="h-40 overflow-hidden">
                        <img class="w-full h-full fill-cover border-b-2 border-neutral"
                            src="<?= MENU_URL ?>${menu.MENU_IMAGE_PATH || 'placeholder.jpg'}"
                            alt="${menu.NAME}" />
                    </figure>
                    <div class="card-body">
                        <h2 class="card-title text-secondary">${menu.NAME}</h2>
                        <div class="flex justify-between items-center text-secondary">
                            <div class="text-lg font-bold">
                                Rp. ${menu.PRICE.toLocaleString('id-ID')}
                            </div>
                            <button class="btn btn-primary text-white ${isLoggedIn ? 'add-to-cart' : ''}"
                                ${isLoggedIn ? `data-id="${menu.ID_MENU}"` : 'onclick="document.getElementById(\'login-modal\').checked = true"'}>
                                Add
                            </button>
                        </div>
                    </div>
                </div>
            `;
                menuContainer.innerHTML += menuCard;
            });
        } else {
            menuContainer.innerHTML = '<p class="text-center text-gray-500 dark:text-gray-400">No items available.</p>';
        }
    }

    // Initialize with all menus displayed by default
    filterMenus();







    $(document).ready(function() {
        function updateCartDisplay(cartItems) {
            $('.cart-list').empty();
            $('.cart-btn').empty();
            let totalPrice = 0;

            if (cartItems.length > 0) {
                cartItems.forEach((item) => {
                    const listItem = document.createElement('li');
                    listItem.className = `flex py-6`;
                    listItem.innerHTML = `
                        <div class="size-24 shrink-0 overflow-hidden rounded-md border border-gray-200">
                        <img src="<?= MENU_URL ?>${item.IMAGE_PATH || 'placeholder.jpg'}" alt="${item.NAME}" class="size-full object-cover">
                        </div>
                        <div class="ml-4 flex flex-1 flex-col">
                            <div>
                                <div class="flex justify-between text-base font-medium text-gray-900">
                                    <h3>
                                        <a href="#">${item.NAME}</a>
                                    </h3>
                                    <p class="ml-4">Rp. ${item.PRICE}</p>
                                </div>
                            </div>
                            <div class="flex flex-1 items-end justify-between text-sm">
                                <p class="text-gray-500">Qty ${item.QTY}</p>
                                <div class="flex">
                                    <button type="button" class="font-medium text-primary hover:text-indigo-500 remove-btn" data-id="${item.ID_CART}">Remove</button>
                                </div>
                            </div>
                        </div>
                    `;
                    totalPrice += parseFloat(item.PRICE);
                    $('.cart-list').append(listItem);
                });

                const cartBtn = `
                    <div class="flex justify-between text-base font-medium text-secondary">
                        <p>Subtotal</p>
                        <p>Rp. ${totalPrice}</p>
                    </div>
                    <div class="mt-4">
                        <button type="button" id="clear-cart-btn" class="w-full flex items-center justify-center rounded-md border border-red-500 bg-white px-6 py-3 text-base font-medium text-red-600 hover:bg-red-100">
                            Clear Cart
                        </button>
                    </div>
                    <div class="mt-2">
                        <a href="<?= BASE_URL; ?>/Checkout" class="flex items-center justify-center rounded-md border border-transparent bg-primary px-6 py-3 text-base font-medium text-white hover:bg-red-600 mb-2">Checkout</a>
                    </div>
                `;
                $('.cart-btn').append(cartBtn);
            } else {
                const emptyMessage = `
                <div class="flex flex-col items-center justify-center h-full py-10 mt-4">
                    <div class="w-36 h-36 mb-6">
                        <img src="<?= BASE_URL; ?>/assets/img/emptycart.jpg" alt="Empty Cart" class="w-full h-full object-contain">
                    </div>
                    <h2 class="text-lg font-medium text-red-600 mb-2">Your cart is empty</h2>
                    <p class="text-center text-sm text-gray-500 mb-6">Looks like you have not added anything to your cart. Go ahead & explore our menu.</p>
                    <div class="mt-4">
                        <button type="button" onclick="document.getElementById('cart-drawer').checked = false;document.getElementById('mobile-cart-drawer').checked = false;" class="w-full flex items-center justify-center rounded-md border border-red-500 bg-white px-6 py-3 text-base font-medium text-red-600 hover:bg-red-100">
                            Go to Menu
                        </button>
                    </div>
                </div>
                `;
                $('.cart-list').html(emptyMessage);
            }

            $('.qty-cart').text(cartItems.length);

            if (cartItems.length > 0) {
                $('.dropdown.dropdown-end').addClass('md:inline');
            }
        }

        $(document).on('click', '.remove-btn', function() {
            const cart = $(this).data();

            $.ajax({
                url: '<?= BASE_URL; ?>/Cart/delete',
                type: 'POST',
                data: {
                    id_cart: cart.id
                },
                dataType: 'json',
                success: function(res) {
                    if (res.status === 'success') {
                        updateCartDisplay(res.cart);
                    } else {
                        alert('Error removing item: ' + res.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error: ' + error);
                }
            });
        });

        $(document).on('click', '.add-to-cart', function() {
            const menu = $(this).data();

            $.ajax({
                url: '<?= BASE_URL; ?>/Cart/add',
                type: 'POST',
                data: {
                    id_menu: menu.id,
                },
                dataType: 'json',
                success: function(res) {
                    if (res.status === 'success') {
                        updateCartDisplay(res.cart);
                    } else {
                        alert('Error updating cart: ' + res.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error: ' + error);
                }
            });
        });


        $(document).on('click', '#clear-cart-btn', function() {
            $.ajax({
                url: '<?= BASE_URL; ?>/Cart/clear',
                type: 'POST',
                dataType: 'json',
                success: function(res) {
                    if (res.status === 'success') {
                        updateCartDisplay(res.cart);
                    } else {
                        alert('Error clearing cart: ' + res.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error: ' + error);
                }
            });
        });

        const cart = <?= json_encode($data['cart']); ?>;
        updateCartDisplay(cart);
    });
</script>