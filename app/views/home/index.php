<div class="flex flex-wrap gap-5 justify-center">
    <div class="flex flex-wrap justify-center gap-5">
        <?php if (!empty($data['menus'])): ?>
            <?php foreach ($data['menus'] as $menu): ?>
                <div class="card card-compact bg-base-100 w-64 shadow-xl">
                    <figure>
                        <img
                        src="https://img.daisyui.com/images/stock/photo-1606107557195-0e29a4b5b4aa.webp"
                        alt="FnBImages" />
                    </figure>
                    <div class="card-body">
                        <h2 class="card-title"><?php echo htmlspecialchars($menu['NAMA_MENU']); ?></h2>
                        <div class="flex justify-between items-center">
                            <div class="text-lg font-bold">
                                $<?php echo number_format($menu['HARGA'], 2); ?>
                            </div>
                             <button class="btn btn-primary add-to-cart"
                                    data-id="<?php echo $menu['ID_MENU']; ?>" 
                                    data-name="<?php echo htmlspecialchars($menu['NAMA_MENU']); ?>" 
                                    data-price="<?php echo $menu['HARGA']; ?>">
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
    <ul id="cart-list">
        <?php if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) { 
            foreach ($_SESSION['cart'] as $item) {
                echo '<li>';
                echo '<strong>' . htmlspecialchars($item['name']) . '</strong> - ';
                echo '$' . number_format($item['price'], 2);
                echo ' (ID: ' . htmlspecialchars($item['id']) . ')';
                echo '</li>';
            }
        } ?>
    </ul>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        function updateCartDisplay() {
            $('.cart-list').empty();
            const cartItems = JSON.parse(localStorage.getItem('cart')) || [];

            cartItems.forEach((item, index) => {
                const listItem = document.createElement('li');
                listItem.className = `flex py-6 cart-list-${index}`;
                listItem.innerHTML = `
                    <div class="size-24 shrink-0 overflow-hidden rounded-md border border-gray-200">
                        <img src="${item.image || 'placeholder.jpg'}" alt="${item.name}" class="size-full object-cover">
                    </div>
                    <div class="ml-4 flex flex-1 flex-col">
                        <div>
                            <div class="flex justify-between text-base font-medium text-gray-900">
                                <h3>
                                    <a href="#">${item.name}</a>
                                </h3>
                                <p class="ml-4">$${item.price.toFixed(2)}</p>
                            </div>
                        </div>
                        <div class="flex flex-1 items-end justify-between text-sm">
                            <p class="text-gray-500">Qty ${item.qty}</p>
                            <div class="flex">
                                <button type="button" class="font-medium text-primary hover:text-indigo-500 remove-btn" data-index="${index}">Remove</button>
                            </div>
                        </div>
                    </div>
                `;
                $('.cart-list').append(listItem);
            });

            $('.qty-cart').text(cartItems.length);

            if (cartItems.length > 0) {
                $('.dropdown.dropdown-end').addClass('md:inline');
            }
        }

        function updateCartItem(cartItems, menu) {
            cartItems.push({
                id: menu.id,
                name: menu.name,
                price: menu.price,
                qty: 1,
            });
        }

        $(document).on('click', '.remove-btn', function () {
            const index = $(this).data('index');
            const cartItems = JSON.parse(localStorage.getItem('cart')) || [];
            cartItems.splice(index, 1);
            localStorage.setItem('cart', JSON.stringify(cartItems));
            updateCartDisplay();
        });

        $('.add-to-cart').click(function () {
            const menu = $(this).data();
            const cartItems = JSON.parse(localStorage.getItem('cart')) || [];

            updateCartItem(cartItems, menu);
            localStorage.setItem('cart', JSON.stringify(cartItems));
            updateCartDisplay();
        });

        updateCartDisplay();
    });
</script>