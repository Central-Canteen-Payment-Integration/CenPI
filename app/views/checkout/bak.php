<div class="container mx-auto py-2 text-sm">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

        <!-- Tampilan Kiri (Profil Pembeli & Pesanan) -->
        <div class="col-span-2 bg-white p-4 rounded-lg shadow sm:ml-5 sm:mr-6">
            <!-- Profil Pembeli -->
            <div class="mb-4">
                <h2 class="text-base font-semibold mb-2">Profil Pembeli</h2>
                <div class="border p-3 rounded-lg">
                    <p class="font-medium">Nama Pembeli</p>
                    <p>Email: email@example.com</p>
                    <p>No Telp: +62 81234567890</p>
                </div>
            </div>

            <!-- Pesanan  -->
            <div>
                <h2 class="text-base font-semibold mb-2">Pesanan Anda</h2>
                <div id="order-list">
                    <!-- Pesanan 1 -->
                    <div class="border p-3 rounded-lg mb-3">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <img src="https://via.placeholder.com/50" alt="Product Image"
                                    class="rounded-lg w-12 h-12">
                                <div class="ml-3">
                                    <p class="font-medium">Nama Makanan 1</p>
                                    <p class="text-xs text-gray-500">Nama Tenant 1</p>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <button class="btn btn-outline btn-xs" onclick="updateQuantity('decrease', 1)">-</button>
                                <input type="text" id="quantity-1" value="1" class="input input-bordered input-xs mx-2 w-12 text-center" readonly>
                                <button class="btn btn-outline btn-xs" onclick="updateQuantity('increase', 1)">+</button>
                            </div>
                            <p class="font-medium ml-4 text-sm">Rp X.XXXX</p>
                        </div>
                        <!-- Pilihan Jenis Pesanan -->
                        <div class="mt-3">
                            <label class="block font-medium text-xs mb-1">Jenis Pesanan</label>
                            <div class="flex gap-2">
                                <button id="type-dinein-1" class="btn btn-outline btn-xs"
                                    onclick="selectOrderType(1, 'Dine In')">Dine In</button>
                                <button id="type-takeaway-1" class="btn btn-outline btn-xs"
                                    onclick="selectOrderType(1, 'Takeaway')">Takeaway</button>
                            </div>
                        </div>
                        <!-- Catatan -->
                        <textarea class="textarea textarea-bordered mt-3 w-full text-xs"
                            placeholder="Tambah catatan untuk pesanan ini"></textarea>
                    </div>

                    <!-- Pesanan 2 -->
                    <div class="border p-3 rounded-lg mb-3">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <img src="https://via.placeholder.com/50" alt="Product Image"
                                    class="rounded-lg w-12 h-12">
                                <div class="ml-3">
                                    <p class="font-medium">Nama Makanan 2</p>
                                    <p class="text-xs text-gray-500">Nama Tenant 2</p>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <button class="btn btn-outline btn-xs"
                                    onclick="updateQuantity('decrease', 2)">-</button>
                                <input type="text" id="quantity-2" value="1"
                                    class="input input-bordered input-xs mx-2 w-12 text-center" readonly>
                                <button class="btn btn-outline btn-xs"
                                    onclick="updateQuantity('increase', 2)">+</button>
                            </div>
                            <p class="font-medium ml-4 text-sm">Rp X.XXXX</p>
                        </div>
                        <!-- Pilihan Jenis Pesanan -->
                        <div class="mt-3">
                            <label class="block font-medium text-xs mb-1">Jenis Pesanan</label>
                            <div class="flex gap-2">
                                <button id="type-dinein-2" class="btn btn-outline btn-xs"
                                    onclick="selectOrderType(2, 'Dine In')">Dine In</button>
                                <button id="type-takeaway-2" class="btn btn-outline btn-xs"
                                    onclick="selectOrderType(2, 'Takeaway')">Takeaway</button>
                            </div>
                        </div>
                        <!-- Catatan -->
                        <textarea class="textarea textarea-bordered mt-3 w-full text-xs"
                            placeholder="Tambah catatan untuk pesanan ini"></textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tampilan Kanan -->
        <!-- Ringkasan Pesanan -->
        <div class="bg-white p-4 rounded-lg shadow h-fit mr-6 sm:ml-5 sm:mr-2">
            <h2 class="text-base font-semibold mb-3">Ringkasan Pesanan</h2>

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

            <!-- Ignoring, masih bingung mau ditaruh setelah klik button atau dari tampilan awal, lets discuss this tonight -->
            <!-- Ini metode pembayaran ditampilan checkout -->
            <div class="mb-2 mt-3">
                <label class="block font-medium mb-2">Metode Pembayaran</label>
                <select class="select select-bordered w-full max-w-xs">
                <option disabled selected>Select Payment</option>
                <option>Cash</option>
                <option>QRIS</option>
            </select>
            </div>

            <!-- Ini Metode Pembayaran menggunakan modal-->
            <button class="btn btn-primary mt-4 w-full bg-red-600 hover:bg-red-700 text-sm"
                onclick="my_modal_3.showModal()">Bayar Sekarang</button>
            <dialog id="my_modal_3" class="modal">
                <div class="modal-box">
                    <form method="dialog">
                        <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                    </form>
                    <h3 class="text-base font-semibold mb-4 text-center">Pilih Metode Pembayaran</h3>
                    <div class="flex justify-between gap-3">
                        <button class="btn btn-outline flex-1 text-sm">Cash</button>
                        <button class="btn btn-outline flex-1 text-sm">QRIS</button>
                    </div>
                </div>
            </dialog>
        </div>
    </div>
</div>

<script>
    // Fungsi Quantity
    function updateQuantity(action, id) {
        const quantityInput = document.getElementById(`quantity-${id}`);
        let quantity = parseInt(quantityInput.value);

        if (action === 'increase') {
            quantity += 1;
        } else if (action === 'decrease' && quantity > 1) {
            quantity -= 1;
        }

        quantityInput.value = quantity;
    }

    // Fungsi Jenis Pesanan
    function selectOrderType(orderId, type) {
        // Boolean
        document.getElementById(`type-dinein-${orderId}`).classList.remove('bg-[#F54D2F]', 'text-white');
        document.getElementById(`type-takeaway-${orderId}`).classList.remove('bg-[#F54D2F]', 'text-white');

        // Highlight buat jenis pilihan
        if (type === 'Dine In') {
            document.getElementById(`type-dinein-${orderId}`).classList.add('bg-[#F54D2F]', 'text-white');
        } else if (type === 'Takeaway') {
            document.getElementById(`type-takeaway-${orderId}`).classList.add('bg-[#F54D2F]', 'text-white');
        }
    }

    function openPaymentModal() {
        document.getElementById('paymentModal').classList.remove('hidden');
    }

    function closePaymentModal() {
        document.getElementById('paymentModal').classList.add('hidden');
    }
</script>