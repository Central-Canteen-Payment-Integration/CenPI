<?php
$buyerName = isset($_SESSION['user']['username']) ? $_SESSION['user']['username'] : '';
$buyerEmail = isset($_SESSION['user']['email']) ? $_SESSION['user']['email'] : '';
$buyerPhone = isset($_SESSION['user']['id']) ? $_SESSION['user']['id'] : '';

$cartItems = isset($data['cart']) ? $data['cart'] : [];
?>

<div class="container min-w-full py-5 text-sm bg-[#F0F3F7]">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <!-- Tampilan Kiri (Profil Pembeli & Pesanan) -->
        <div class="col-span-2 bg-white p-4 rounded-lg shadow sm:ml-5 sm:mr-6">
            <!-- Profil Pembeli -->
            <div class="mb-4">
                <h2 class="text-base font-semibold mb-2">Profil Pembeli</h2>
                <div class="border p-3 rounded-lg">
                    <p class="font-medium"><?= htmlspecialchars($buyerName); ?></p>
                    <p>Email: <?= htmlspecialchars($buyerEmail); ?></p>
                    <p>No Telp: <?= htmlspecialchars($buyerPhone); ?></p>
                </div>
            </div>

            <!-- Pesanan -->
            <div>
                <h2 class="text-base font-semibold mb-2">Pesanan Anda</h2>
                <div id="order-list"></div>
            </div>
        </div>

        <!-- Tampilan Kanan Ringkasan Pesanan -->
        <div class="bg-white p-4 rounded-lg shadow h-fit mr-6 sm:ml-5 sm:mr-2">
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
                <select class="select select-bordered w-full max-w-xs">
                    <option disabled selected>Select Payment</option>
                    <option>Cash</option>
                    <option>QRIS</option>
                </select>
            </div>

            <button class="btn btn-primary mt-4 w-full text-white bg-red-600 hover:bg-red-700 text-sm">Bayar Sekarang</button>
        </div>
    </div>
</div>

<script>
    const cartItems = <?php echo json_encode($cartItems); ?>;

    function generateOrderList() {
        const orderListContainer = document.getElementById('order-list');
        orderListContainer.innerHTML = '';
        let subtotal = 0;
        let takeaway = 0;

        cartItems.forEach((item, index) => {
            const orderItem = document.createElement('div');
            orderItem.classList.add('border', 'p-3', 'rounded-lg', 'mb-3');

            const itemPrice = parseFloat(item.PRICE);
            subtotal += itemPrice;

            orderItem.innerHTML = `
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <img src="<?= MENU_URL . '/'; ?>${item.IMAGE_PATH}" alt="Product Image" class="rounded-lg w-12 h-12">
                        <div class="ml-3">
                            <p class="font-medium">${item.NAME}</p>
                            <p class="text-xs text-gray-500">${item.TENANT_NAME}</p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <button class="btn btn-outline btn-xs" onclick="updateQuantity('decrease', ${index + 1})">-</button>
                        <input type="text" id="quantity-${index + 1}" value="1" class="input input-bordered input-xs mx-2 w-12 text-center" readonly>
                        <button class="btn btn-outline btn-xs" onclick="updateQuantity('increase', ${index + 1})">+</button>
                    </div>
                    <p class="font-medium ml-4 text-sm">Rp ${itemPrice}</p>
                </div>
                <div class="mt-3">
                    <label class="block font-medium text-xs mb-1">Jenis Pesanan</label>
                    <div class="flex gap-2">
                        <button id="type-dinein-${index + 1}" class="btn btn-outline btn-xs" onclick="selectOrderType(${index + 1}, 'Dine In')">Dine In</button>
                        <button id="type-takeaway-${index + 1}" class="btn btn-outline btn-xs" onclick="selectOrderType(${index + 1}, 'Takeaway')">Takeaway</button>
                    </div>
                </div>
                <textarea class="textarea textarea-bordered mt-3 w-full text-xs" placeholder="Tambah catatan untuk pesanan ini"></textarea>
            `;

            orderListContainer.appendChild(orderItem);
        });

        // Update summary
        document.getElementById('subtotal-price').innerText = `Rp ${subtotal.toFixed(2)}`;

        takeaway = cartItems.some(item => item.ORDER_TYPE === 'Takeaway') ? 5000 : 0;
        document.getElementById('takeaway-price').innerText = `Rp ${takeaway.toFixed(2)}`;

        const total = subtotal + takeaway;
        document.getElementById('total-price').innerText = `Rp ${total.toFixed(2)}`;
    }

    // Call the function to populate the order list
    generateOrderList();

    // Functions for quantity update and order type selection
    function updateQuantity(action, id) {
        const quantityInput = document.getElementById(`quantity-${id}`);
        let quantity = parseInt(quantityInput.value);

        if (action === 'increase') {
            quantity += 1;
        } else if (action === 'decrease' && quantity > 1) {
            quantity -= 1;
        }

        quantityInput.value = quantity;

        generateOrderList();
    }

    function selectOrderType(orderId, type) {
        document.getElementById(`type-dinein-${orderId}`).classList.remove('bg-[#F54D2F]', 'text-white');
        document.getElementById(`type-takeaway-${orderId}`).classList.remove('bg-[#F54D2F]', 'text-white');

        if (type === 'Dine In') {
            document.getElementById(`type-dinein-${orderId}`).classList.add('bg-[#F54D2F]', 'text-white');
        } else if (type === 'Takeaway') {
            document.getElementById(`type-takeaway-${orderId}`).classList.add('bg-[#F54D2F]', 'text-white');
        }

        // Update total price after order type selection
        generateOrderList();
    }
</script>
