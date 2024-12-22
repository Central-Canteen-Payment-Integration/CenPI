<?php
$cartItems = isset($data['cart']) ? $data['cart'] : [];
if (isset($_SESSION['error'])) {
    $errorMessage = $_SESSION['error'];
    unset($_SESSION['error']);
?>
    <script>
        swalert('error', '<?php echo $errorMessage; ?>', { timer: 2500 });
    </script>
<?php
}
?>

<div class="container min-w-full py-5 text-sm bg-[#F0F3F7]">
    <form action="<?= BASE_URL . '/Checkout/initialize'; ?>" method="POST" id="formtest">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Tampilan Kiri (Profil Pembeli & Pesanan) -->
            <div class="col-span-2 bg-white p-4 rounded-lg shadow ml-2 max-md:mr-6">
                <!-- Profil Pembeli -->
                <div class="mb-4">
                    <h2 class="text-base font-semibold mb-2">Tipe Pesanan</h2>
                    <div class="join">
                        <input class="join-item btn" type="radio" name="order-type" value="Dine In" aria-label="Dine In" checked/>
                        <input class="join-item btn" type="radio" name="order-type" value="Takeaway" aria-label="Takeaway" />
                    </div>
                </div>
                <!-- Pesanan -->
                <div>
                    <h2 class="text-base font-semibold mb-2">Pesanan Anda</h2>
                    <div id="order-list"></div>
                </div>
            </div>
            <!-- Tampilan Kanan Ringkasan Pesanan -->
            <div class="bg-white p-4 rounded-lg shadow h-fit mr-2 max-md:ml-2">
                <h2 class="text-base font-semibold mb-3">Ringkasan Pesanan</h2>
                <div class="detail-order">
                    <div class="flex justify-between text-sm mb-3">
                        <p>Subtotal</p>
                        <p id="subtotal-price">Rp X.XXXX</p>
                    </div>
                    <div class="flex justify-between text-sm mb-3">
                        <p>Takeaway</p>
                        <p id="takeaway-price">Rp X.XXX</p>
                    </div>
                    <!-- Total Harga -->
                    <div class="flex justify-between font-semibold text-sm">
                        <p>Total</p>
                        <p id="total-price">Rp X.XXXX</p>
                    </div>
                </div>
                <!-- Metode Pembayaran -->
                <div class="mb-2 mt-3">
                    <label class="block font-medium mb-2">Metode Pembayaran</label>
                    <select class="select select-bordered w-full max-w-xs" name="payment-option">
                        <option disabled selected>Select Payment</option>
                        <option>Cash</option>
                        <option>QRIS</option>
                    </select>
                </div>
                <button id="pay-button" class="btn btn-primary mt-4 w-full text-white bg-red-600 hover:bg-red-700 text-sm">Proses Sekarang!</button>
            </div>
        </div>
    </form>
</div>
<?php if (isset($_SESSION['show_modal']) && $_SESSION['show_modal']): ?>
    <div id="closedTenantsModal" class="modal modal-open">
        <div class="modal-box translate-y-[50%]">
            <h2 class="font-bold text-lg">Info</h2>
            <p class="py-4">The following menus are from menu that not available or tenant closed:</p>
            <div class="grid grid-cols-1 gap-4">
                <?php foreach ($_SESSION['inactive'] as $inactive): ?>
                    <?php foreach ($data['cart'] as $item): ?>
                        <?php if ($item['ID_MENU'] == $inactive['ID_MENU']): ?>
                            <div class="card bg-base-100 shadow-xl">
                                <figure><img src="<?= MENU_URL . $item['IMAGE_PATH'] ?>" alt="<?= $item['NAME'] ?>" class="w-full h-32 object-cover"></figure>
                                <div class="card-body">
                                    <h2 class="card-title"><?= $item['NAME'] ?></h2>
                                    <p><?= $item['TENANT_NAME'] ?></p>
                                    <?php if ($inactive['ACTIVE'] == 0): ?>
                                        <p class="text-red-500">This menu is not available</p>
                                    <?php endif; ?>
                                    <?php if ($inactive['IS_OPEN'] == 0): ?>
                                        <p class="text-red-500">Tenant is closed</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            </div>
            <div class="modal-action">
                <button class="btn" onclick="document.getElementById('closedTenantsModal').style.display='none'">Close</button>
            </div>
        </div>
    </div>
    <?php unset($_SESSION['show_modal']); ?>
    <?php unset($_SESSION['closed_tenants']); ?>
<?php endif; ?>

<script>
    let cartItems = <?php echo json_encode($cartItems); ?>;
    
    function renderOrderList(cartItems) {
        const orderListContainer = document.getElementById('order-list');
        orderListContainer.innerHTML = '';

        cartItems.forEach((item, index) => {
            const orderItem = document.createElement('div');
            orderItem.classList.add('border', 'p-3', 'rounded-lg', 'mb-3');

            const itemPrice = parseFloat(item.PRICE);

            orderItem.innerHTML = `
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <img src="<?= MENU_URL ?>${item.IMAGE_PATH}" alt="Product Image" class="rounded-lg w-12 h-12">
                        <div class="ml-3">
                            <p class="font-medium">${item.NAME}</p>
                            <p class="text-xs text-gray-500">${item.TENANT_NAME}</p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <button type="button" class="btn btn-outline btn-xs" onclick="updateQuantity('decrease', ${index + 1})">-</button>
                        <input type="text" id="quantity-${index + 1}" value="${item.QTY}" class="input input-bordered input-xs mx-2 w-12 text-center" readonly>
                        <button type="button" class="btn btn-outline btn-xs" onclick="updateQuantity('increase', ${index + 1})">+</button>
                    </div>
                    <p class="font-medium ml-4 text-sm">Rp ${itemPrice.toLocaleString('id-ID')}</p>
                </div>
                <textarea class="notes textarea textarea-bordered mt-3 w-full text-xs" data-id="${item.ID_CART}" placeholder="Tambah catatan untuk pesanan ini">${item.NOTES ? item.NOTES : ''}</textarea>
            `;

            orderListContainer.appendChild(orderItem);
        });

        renderOrderDetail(cartItems)
    }

    $(document).on('click', '.notes', function() {
        $('#pay-button').prop('disabled', true);
    });

    $(document).on('blur', '.notes', function() {
        const cart = $(this).data();
        const text = $(this).val();
        $('#pay-button').prop('disabled', false);

        $.ajax({
            url: '/Cart/updateNote',
            method: 'POST',
            data: {
                id_cart: cart.id,
                notes: text
            },
            success: function(response) {
                let res = JSON.parse(response);
                swalert('success', res.message);
            },
            error: function(xhr, status, error) {
                console.error('Error updating note:', error);
            }
        });
    });

    function renderOrderDetail(cartItems) {
        let subtotal = 0;
        let takeaway = 0;
        const orderType = document.querySelector('input[name="order-type"]:checked');
        if (orderType && orderType.value === 'Takeaway') {
            cartItems.forEach((item, index) => {
                subtotal += item.PRICE * item.QTY;
                takeaway += item.PKG_PRICE * item.QTY;
            });
        } else {
            cartItems.forEach((item, index) => {
                subtotal += item.PRICE * item.QTY;
            });
            takeaway = 0;
        }
        document.getElementById('subtotal-price').innerText = `Rp ${subtotal.toLocaleString('id-ID')}`;
        document.getElementById('takeaway-price').innerText = `Rp ${takeaway.toLocaleString('id-ID')}`;
        const total = subtotal + takeaway;
        document.getElementById('total-price').innerText = `Rp ${total.toLocaleString('id-ID')}`;
    }

    function updateQuantity(action, id) {
        const quantityInput = document.getElementById(`quantity-${id}`);

        const increase = (action == 'increase');

        $.ajax({
            url: '/Cart/update',
            type: 'POST',
            data: {
                id_cart: cartItems[id - 1].ID_CART,
                qty: cartItems[id - 1].QTY,
                increase: increase
            },
            dataType: 'json',
            success: function(res) {
                if (res.status === 'success') {
                    if (cartItems[id - 1].QTY == 1 && !increase) {
                        renderOrderList(res.cart);
                    } else {
                        quantityInput.value = res.cart[id - 1].QTY;
                        renderOrderDetail(res.cart);
                    }

                    cartItems = res.cart;
                    swalert('success', 'Cart updated.');
                } else {
                    swalert('error', 'Error updating item: ' + res.message, { timer: 2500 });
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error: ' + error);
                swalert('error', 'An error occurred while updating the item.', { timer: 2500 });
            }
        });
    }

    const orderTypeButtons = document.querySelectorAll('input[name="order-type"]');
    
    orderTypeButtons.forEach(button => {
        button.addEventListener('change', () => {
            renderOrderDetail(cartItems);
        });
    });

    document.getElementById('pay-button').addEventListener('click', function(event) {
        const paymentOption = document.querySelector('select[name="payment-option"]');
        
        if (paymentOption.value === "Select Payment") {
            event.preventDefault();
            swalert("error" ,"Please select a payment option.", { timer: 2500 });
        }
    });

    renderOrderList(cartItems);
</script>
