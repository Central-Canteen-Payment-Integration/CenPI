</head>
<body class="<?php echo (strpos($_SERVER['REQUEST_URI'], 'login') !== false) ? 'overflow-hidden' : ''; ?>">
	<header class="mb-4 md:mb-10 shadow">
		<div class="navbar px-4 py-2 mt-1">
			<div class="navbar-start">
				<a href="<?= BASE_URL ?>/Home/menu">
					<img src="<?= BASE_URL ?>/assets/img/logo.svg" alt="Cenπ Logo" class="max-md:h-12 h-16">
				</a>
			</div>
			<div class="navbar-end gap-2">
				<?php if (!isset($_SESSION['user'])) { ?>
					<a class="max-md:hidden <?php echo (strpos($_SERVER['REQUEST_URI'], 'login') !== false) || (strpos($_SERVER['REQUEST_URI'], 'register') !== false) ? 'hidden' : ''; ?>" href="<?= BASE_URL ?>/User/login" onclick="handleRedirect(event, '<?= BASE_URL ?>/User/login')">
						<button
							class="group/button relative inline-flex items-center justify-center overflow-hidden rounded-md bg-red-500 backdrop-blur-lg px-6 py-2 text-base font-semibold text-white transition-all duration-300 ease-in-out hover:scale-110 hover:shadow-xl hover:shadow-red-600/50 border border-white/20">
							<span class="text-md">Login</span>
							<div
								class="absolute inset-0 flex h-full w-full justify-center [transform:skew(-13deg)_translateX(-100%)] group-hover/button:duration-1000 group-hover/button:[transform:skew(-13deg)_translateX(100%)]">
								<div class="relative h-full w-10 bg-white/30"></div>
							</div>
						</button>
					</a>
					<?php /*
					<!-- Tombol Register -->
					<a href="<?= BASE_URL ?>/User/register" class="<?php echo (strpos($_SERVER['REQUEST_URI'], 'login') !== false) || (strpos($_SERVER['REQUEST_URI'], 'register') !== false) ? 'hidden' : ''; ?>"
						onclick="handleRedirect(event, '<?= BASE_URL ?>/User/register')">
						<button
							class="group/button relative inline-flex items-center justify-center overflow-hidden rounded-md bg-[#0B3C33] backdrop-blur-lg px-6 py-2 text-base font-semibold text-white transition-all duration-300 ease-in-out hover:scale-110 hover:shadow-xl hover:shadow-green-600/50 border border-white/20">
							<span class="text-md">Register</span>
							<div
								class="absolute inset-0 flex h-full w-full justify-center [transform:skew(-13deg)_translateX(-100%)] group-hover/button:duration-1000 group-hover/button:[transform:skew(-13deg)_translateX(100%)]">
								<div class="relative h-full w-10 bg-white/30"></div>
							</div>
						</button>
					</a>
					*/ ?>

					<!-- Overlay dan Animasi Loading -->
					<div id="overlay"
						class="hidden fixed inset-0 bg-gray-500 bg-opacity-50 flex items-center justify-center z-50">
						<div id="loading-animation" class="flex flex-row gap-2">
							<div class="w-4 h-4 rounded-full bg-red-500 animate-bounce"></div>
							<div class="w-4 h-4 rounded-full bg-red-500 animate-bounce [animation-delay:-.3s]"></div>
							<div class="w-4 h-4 rounded-full bg-red-500 animate-bounce [animation-delay:-.5s]"></div>
						</div>
					</div>

				<?php } else { ?>
					<div class="dropdown dropdown-end">
						<div class="drawer drawer-end">
							<input id="cart-drawer" type="checkbox" class="drawer-toggle" />
							<div class="drawer-content">
								<label for="cart-drawer" class="drawer-button btn btn-ghost btn-circle">
									<div class="indicator">
										<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
										</svg>
										<span class="badge badge-sm badge-secondary !text-white indicator-item qty-cart"></span>
									</div>
								</label>
							</div>

							<div class="drawer-side z-50">
								<label for="cart-drawer" class="drawer-overlay"></label>
								<div class="bg-white text-base-content min-h-full w-2/3 md:w-3/12 p-4 pr-6">
									<div class="flex justify-between items-center">
										<h2 class="text-lg font-medium text-secondary">Food Cart</h2>
										<button type="button" class="text-gray-500 hover:text-gray-700"
											onclick="document.getElementById('cart-drawer').checked = false;">
											<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
												viewBox="0 0 24 24" stroke="currentColor">
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
					<div class="dropdown dropdown-end max-md:hidden">
						<div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">
							<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
								stroke-width="1.5" fill="none" stroke="currentColor" class="object-cover">
								<path stroke="none" d="M0 0h24v24H0z" fill="none" />
								<path d="M12 2a5 5 0 1 1 -5 5l.005 -.217a5 5 0 0 1 4.995 -4.783z" />
								<path d="M14 14a5 5 0 0 1 5 5v1a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-1a5 5 0 0 1 5 -5h4z" />
							</svg>
						</div>
						<ul tabindex="0"
							class="menu menu-sm dropdown-content bg-base-100 rounded-box z-[1] mt-3 w-52 p-2 shadow">
							<li><a href="<?= BASE_URL ?>/User/profile">Profile</a></li>
							<li><a href="<?= BASE_URL ?>/User/order">Order</a></li>
							<li><a href="<?= BASE_URL ?>/User/logout">Logout</a></li>
						</ul>
					</div>
				<?php } ?>
			</div>
		</div>
		<div class="btm-nav z-10 md:hidden">
			<button onclick="window.location.href='/Home/menu'" class="<?php echo (strpos($_SERVER['REQUEST_URI'], 'menu') !== false) ? 'text-primary active' : 'text-secondary'; ?>">
			<svg  xmlns="http://www.w3.org/2000/svg"  class="h-5 w-5"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-tools-kitchen-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M19 3v12h-5c-.023 -3.681 .184 -7.406 5 -12zm0 12v6h-1v-3m-10 -14v17m-3 -17v3a3 3 0 1 0 6 0v-3" /></svg>
				<span class="btm-nav-label">Menu</span>
			</button>
			<button onclick="window.location.href='/User/order'" class="<?php echo (strpos($_SERVER['REQUEST_URI'], 'order') !== false) ? 'text-primary active' : 'text-secondary'; ?>">
			<svg  xmlns="http://www.w3.org/2000/svg"  class="h-5 w-5"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-shopping-cart-check"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 19a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M11.5 17h-5.5v-14h-2" /><path d="M6 5l14 1l-1 7h-13" /><path d="M15 19l2 2l4 -4" /></svg>
				<span class="btm-nav-label">Order</span>
			</button>
			<?php
				$currentUri = $_SERVER['REQUEST_URI'];
				$buttonClass = 'text-secondary';

				if (strpos($currentUri, 'profile') !== false) {
					$buttonClass = 'text-primary active';
				} elseif (strpos($currentUri, 'login') !== false) {
					$buttonClass = 'text-primary active';
				} elseif (strpos($currentUri, 'register') !== false) {
					$buttonClass = 'text-primary active';
				}
			?>
			<button onclick="window.location.href='/User/profile'" class="<?php echo $buttonClass; ?>">
				<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24"
								stroke-width="2" fill="none" stroke="currentColor">
								<path stroke="none" d="M0 0h24v24H0z" fill="none" />
								<path d="M12 2a5 5 0 1 1 -5 5l.005 -.217a5 5 0 0 1 4.995 -4.783z" />
								<path d="M14 14a5 5 0 0 1 5 5v1a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-1a5 5 0 0 1 5 -5h4z" />
							</svg>
				<span class="btm-nav-label">Profile</span>
			</button>
		</div>
	</header>
	<script>
		function handleRedirect(event, url) {
			event.preventDefault();
			const overlay = document.getElementById('overlay');

			document.querySelectorAll('button').forEach(button => {
				button.style.display = 'none';
			});

			overlay.classList.remove('hidden');

			setTimeout(() => {
				window.location.href = url;
			}, 1000);
		}

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
                        <a href="<?= BASE_URL; ?>/Checkout" onclick="document.getElementById('cart-drawer').checked = false;" class="flex items-center justify-center rounded-md border border-transparent bg-primary px-6 py-3 text-base font-medium text-white hover:bg-red-600 mb-2">Checkout</a>
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
                        <button type="button" onclick="document.getElementById('cart-drawer').checked = false" class="w-full flex items-center justify-center rounded-md border border-red-500 bg-white px-6 py-3 text-base font-medium text-red-600 hover:bg-red-100">
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
                url: '/Cart/delete',
                type: 'POST',
                data: {
                    id_cart: cart.id
                },
                dataType: 'json',
                success: function(res) {
                    if (res.status === 'success') {
                        updateCartDisplay(res.cart);
                        swalert('success', 'Item removed from cart.');
                    } else {
                        swalert('error', 'Error removing item: ' + res.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error: ' + error);
                    swalert('error', 'An error occurred while removing the item.');
                }
            });
        });

        $(document).on('click', '#clear-cart-btn', function() {
            $.ajax({
                url: '/Cart/clear',
                type: 'POST',
                dataType: 'json',
                success: function(res) {
                    if (res.status === 'success') {
                        updateCartDisplay(res.cart);
                        swalert('success', 'Cart cleared successfully.');
                    } else {
                        swalert('error', 'Error clearing cart: ' + res.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error: ' + error);
                    swalert('error', 'An error occurred while clearing the cart.');
                }
            });
        });

        const cart = <?= json_encode($data['cart']); ?>;
        updateCartDisplay(cart);
	</script>