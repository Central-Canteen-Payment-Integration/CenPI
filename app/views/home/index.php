<div class="flex flex-wrap gap-5 justify-center px-4">
    <div class="flex flex-wrap justify-center gap-5">
        <?php if (!empty($data['menus'])): ?>
            <?php foreach ($data['menus'] as $menu): ?>
                <div class="card card-compact bg-base-100 w-64 border-2 border-neutral shadow-xl">
                    <figure class="h-40 overflow-hidden">
                        <img class="w-full h-full object-cover border-b-2 border-neutral"
                            src="<?php echo BASE_URL . (!empty($menu['IMAGE']) ? $menu['IMAGE'] : '/assets/img/placeholder.jpg'); ?>"
                            alt="<?php echo htmlspecialchars($menu['NAME']); ?>" />
                    </figure>
                    <div class="card-body">
                        <h2 class="card-title text-secondary"><?php echo htmlspecialchars($menu['NAME']); ?></h2>
                        <div class="flex justify-between items-center text-secondary">
                            <div class="text-lg font-bold">
                                Rp. <?php echo number_format($menu['PRICE'], 0, ',', '.'); ?>
                            </div>
                            <button class="btn btn-primary text-white add-to-cart" data-id="<?php echo $menu['ID_MENU']; ?>">
                                Add
                            </button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-center text-gray-500 dark:text-gray-400">No items available.</p>
        <?php endif; ?>
    </div>
</div>


<!-- Tombol buat mobel -->
<div class="fixed bottom-5 right-5 z-10 md:hidden">
    <button
        class="bg-primary text-white rounded-full p-4 shadow-lg hover:bg-accent"
        onclick="document.getElementById('mobile-cart-modal').checked = true"
        id="mobile-cart-button">
        <div class="indicator">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            <span class="badge badge-sm indicator-item qty-cart"></span>
        </div>
    </button>
</div>

<!-- Mobel Modal -->
<div class="drawer drawer-bottom md:hidden z-30">
    <input id="mobile-cart-modal" type="checkbox" class="drawer-toggle" />
    <div class="drawer-side">
        <label for="mobile-cart-modal" class="drawer-overlay z-20"></label>
        <div class="modal-content">
            <div class="bg-white text-base-content min-h-screen p-4 overflow-y-auto">
                <div class="flex justify-between items-center">
                    <h2 class="text-lg font-medium text-secondary">Food Cart</h2>
                    <button
                        type="button"
                        class="text-gray-500 hover:text-gray-700"
                        onclick="document.getElementById('mobile-cart-modal').checked = false">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="mt-2">
                    <div class="flow-root">
                        <ul role="list" class="divide-y divide-gray-200 cart-list">
                        </ul>
                    </div>
                </div>
                <div class="border-t border-gray-200 px-4 py-6">
                    <div class="flex justify-between text-base font-medium text-secondary">
                        <p>Subtotal</p>
                        <p>Rp. 0</p>
                    </div>
                    <p class="mt-0.5 text-sm text-gray-500">Packaging calculated at checkout.</p>
                    <div class="mt-6">
                        <a href="#" class="disabled flex items-center justify-center rounded-md border border-transparent bg-primary px-6 py-3 text-base font-medium text-white hover:bg-accent mb-2">Checkout</a>
                        <button id="clear-cart-btn-mobile" class="flex items-center justify-center w-full rounded-md border border-transparent bg-primary px-6 py-3 text-base font-medium text-white hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 active:bg-red-700">
                            Clear Cart
                        </button>
                    </div>

                    <div class="mt-6 flex flex-col items-center text-center text-sm text-gray-500">
                        <p>or</p>
                        <button type="button" class="font-medium text-secondary hover:text-accent mt-2" onclick="document.getElementById('mobile-cart-modal').checked = false;">
                            Continue Shopping
                            <span aria-hidden="true"> &rarr;</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- buat modal -->
<style>
    @media (min-width: 768px) {
        .fixed {
            display: none;
        }
    }

    .modal-content {
        position: relative;
        z-index: 40;
    }

    .drawer-side .bg-white {
        max-height: 80vh;
        overflow-y: auto;
    }
</style>



<!-- logic buat cart -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        function updateCartDisplay(cartItems) {
            $('.cart-list').empty();
            if (cartItems.length > 0) {
                cartItems.forEach((item) => {
                    const listItem = document.createElement('li');
                    listItem.className = `flex py-6`;
                    listItem.innerHTML = `
                    <div class="size-24 shrink-0 overflow-hidden rounded-md border border-gray-200">
                        <img src="<?php BASE_URL ?>${item.IMAGE}" alt="${item.NAME}" class="size-full object-cover">
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
                    $('.cart-list').append(listItem);
                });
            } else {
                const emptyMessage = $('<p class="text-center text-gray-500 dark:text-gray-400">Your cart is empty.</p>');
                $('.cart-list').append(emptyMessage);
            }

            $('.qty-cart').text(cartItems.length);

            if (cartItems.length > 0) {
                $('.dropdown.dropdown-end').addClass('md:inline');
            }
        }

        $(document).on('click', '.remove-btn', function() {
            const cart = $(this).data();

            $.ajax({
                url: '<?php echo BASE_URL; ?>/Cart/delete',
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

        $('.add-to-cart').click(function() {
            const menu = $(this).data();
            $.ajax({
                url: '<?php echo BASE_URL; ?>/Cart/add',
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

        function clearCart() {
            $.ajax({
                url: '<?php echo BASE_URL; ?>/Cart/clear',
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
        }

        $('#clear-cart-btn').click(function() {
            clearCart();
        });

        $('#clear-cart-btn-mobile').click(function() {
            clearCart();
        });

        const cart = <?php echo json_encode($data['cart']); ?>;
        updateCartDisplay(cart);
    });
</script>