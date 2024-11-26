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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
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

        $(document).on('click', '.remove-btn', function () {
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

        $('.add-to-cart').click(function () {
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
        const cart = <?php echo json_encode($data['cart']); ?>;
        updateCartDisplay(cart);
    });
</script>