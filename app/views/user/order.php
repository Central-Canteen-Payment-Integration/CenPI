<header>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
</header>

<div class="section max-w-md mx-auto mt-4">
    <h2 class="text-center text-xl font-bold">My Orders</h2>
    <div class="mt-6">
        <div class="grid gap-6">
            <?php if (isset($data['orders']) && count($data['orders']) > 0): ?>
                <?php foreach ($data['orders'] as $order): ?>
                    <?php
                    $statuses = [
                        'Pending' => 0,
                        'Accept' => 0,
                        'Pickup' => 0
                    ];

                    foreach ($order['DETAILS'] as $detail) {
                        if (isset($statuses[$detail['TRANSACTION_DETAIL_STATUS']])) {
                            $statuses[$detail['TRANSACTION_DETAIL_STATUS']]++;
                        }
                    }
                    if (array_sum($statuses) == 0) {
                        $overallStatus = $order['TRX_STATUS'];
                    } else {
                        $overallStatus = array_search(max($statuses), $statuses);
                    }
                    $statusDisplayMap = [
                        'Pending' => 'Pending',
                        'Accept' => 'Cooking',
                        'Pickup' => 'Ready to Pickup',
                        'Completed' => 'Completed',
                        'Cancelled' => 'Cancelled'
                    ];

                    $overallStatusDisplay = $statusDisplayMap[$overallStatus];
                    ?>
                    <div data-id=<?= $order['ID_TRANSACTION'] ?> class="details cursor-pointer bg-white p-6 rounded-lg shadow-md">
                        <div class="flex justify-between items-center">
                            <div>
                                <h2 class="text-xl font-bold location">
                                    <?= htmlspecialchars(implode(', ', array_unique(array_column($order['DETAILS'], 'LOCATION_NAME')))); ?>
                                </h2>
                                <p class="text-gray-500"><?= $order['TRX_DATETIME']; ?></p>
                            </div>
                            <p class="text-gray-500"><?= $overallStatusDisplay; ?></p>
                        </div>
                        <div class="flex mt-6 gap-4 items-start justify-between">
                            <div class="flex gap-4">
                                <?php
                                if (COUNT($order['DETAILS']) > 1) {
                                    for ($i = 0; $i < 2; $i++) {
                                        if (isset($order['DETAILS'][$i])) {
                                ?>
                                            <img src=<?= MENU_URL . $order['DETAILS'][$i]['MENU_IMAGE_PATH'] ?> alt="" class="w-16 h-16 rounded-full">
                                    <?php
                                        }
                                    }
                                } elseif (COUNT($order['DETAILS']) == 1) {
                                    ?>
                                    <img src=<?= MENU_URL . $order['DETAILS'][0]['MENU_IMAGE_PATH'] ?> alt="" class="w-16 h-16 rounded-full">
                                    <div class="">
                                        <h3 class="text-lg font-medium"><?= $order['DETAILS'][0]['MENU_NAME']; ?></h3>
                                    </div>
                                <?php
                                }
                                ?>
                            </div>
                            <div class="flex flex-col justify-start items-end text-right">
                                <p class="text-gray-500"><?= COUNT($order['DETAILS']) ?> Item</p>
                                <p class="font-bold">Rp <?= number_format($order['TRX_PRICE'], 0, ',', '.'); ?></p>
                            </div>
                        </div>
                        <div class="flex justify-end items-end w-full mt-2">
                            <?php
                            switch ($order['TRX_STATUS']) {
                                case 'Pending':
                                    echo '<span class="border rounded-full bg-white text-black font-medium py-2 px-4 flex items-center justify-center">Pending</span>';
                                    break;
                                case 'Unpaid':
                                    echo '<button onclick="window.location.href=\'/Checkout/' . ($order['TRX_METHOD'] == 'qris' ? 'qrisPayment/' . $order['MIDTRANS_TOKEN'] : 'cashPayment/' . $order['ID_TRANSACTION']) . '\'" class="group/button relative inline-flex items-center justify-center overflow-hidden rounded-full bg-red-500 backdrop-blur-lg px-6 py-2 text-base font-semibold text-white transition-all duration-300 ease-in-out hover:scale-110 hover:shadow-xl hover:shadow-red-600/50 border border-white/20">
                                                <span class="text-md">Pay</span>
                                                <div class="absolute inset-0 flex h-full w-full justify-center [transform:skew(-13deg)_translateX(-100%)] group-hover/button:duration-1000 group-hover/button:[transform:skew(-13deg)_translateX(100%)]">
                                                    <div class="relative h-full w-10 bg-white/30"></div>
                                                </div>
                                              </button>';
                                    break;
                                default:
                                    echo '<button data-order-id=' . $order['ID_TRANSACTION'] . ' class="group/button relative inline-flex items-center justify-center overflow-hidden reorder rounded-full bg-[#0B3C33] backdrop-blur-lg px-6 py-2 text-base font-semibold text-white transition-all duration-300 ease-in-out hover:scale-110 hover:shadow-xl hover:shadow-green-600/50 border border-white/20">
                                                <span class="text-md">Reorder</span>
                                                <div
                                                    class="absolute inset-0 flex h-full w-full justify-center [transform:skew(-13deg)_translateX(-100%)] group-hover/button:duration-1000 group-hover/button:[transform:skew(-13deg)_translateX(100%)]">
                                                    <div class="relative h-full w-10 bg-white/30"></div>
                                                </div>
                                              </button>';
                                    break;
                            }
                            ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-center text-lg text-gray-500">No orders.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Modal Component -->
<input type="checkbox" id="orderModal" class="modal-toggle" style="display: none;">
<label for="orderModal" class="modal cursor-pointer">
    <div class="modal-box relative">
        <h2 class="text-xl font-bold">Order Details</h2>
        <div id="modalContent"></div>
        <div class="modal-action">
            <label for="orderModal" class="btn">Close</label>
        </div>
    </div>
</label>



<script>
    $(document).ready(function() {
        $('.reorder').on('click', function() {
            event.stopPropagation();
            const id_transaction = $(this).data('order-id');

            $.ajax({
                url: '/Cart/reorder',
                type: 'POST',
                data: {
                    id_transaction: id_transaction
                },
                dataType: 'json',
                success: function(res) {
                    if (res.status == 'success') {
                        swalert('success', 'Items added to cart successfully!');
                        updateCartDisplay(res.cart);
                    } else {
                        swalert('error', 'Failed to add items to cart.');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    swalert('error', 'An error occurred while adding items to the cart.');
                }
            });
        });

        $('.details').on('click', function(event) {
            event.stopPropagation();
            const orderId = $(this).data('id');
            console.log('Details clicked with ID:', orderId);
            showModal(orderId);
        });
    });

    function showModal(orderId) {
        const orders = <?php echo json_encode($data['orders']); ?>;
        const order = orders[orderId];

        if (!order) {
            console.error('Order not found:', orderId);
            return;
        }

        const modalContent = `
        <div class="w-[400px] bg-white shadow-lg rounded-lg p-4 text-neutral-950">
            <div class="flex items-center mb-4">
                <span class="material-symbols-outlined text-primary-500">
                    ${order.TRX_STATUS === 'Cancelled' ? 'cancel' : 'check_circle'}
                </span>
                <h2 class="ml-2 font-title text-lg font-bold">Order Status: ${order.TRX_STATUS}</h2>
            </div>

            ${order.TRX_STATUS === 'Cancelled' ? 
                `<p class="text-sm text-neutral-500">Cancel Reason: ${order.CANCEL_REASON || 'No paid in time'}</p>` 
                : ''}
            
                <!-- Loop through the order.DETAILS array to group items by location (tenant and booth) -->
                ${order.DETAILS.map((item, index, array) => {
                    const currentTenant = item.TENANT_NAME;
                    const currentBooth = item.LOCATION_BOOTH;
                    const currentLocation = item.LOCATION_NAME;
                    const showLocation = index === 0 || array[index - 1].TENANT_NAME !== currentTenant || array[index - 1].LOCATION_BOOTH !== currentBooth;

                    return `
                        ${showLocation ? `
                            <div class="mt-8 bg-neutral-100 p-6 rounded-lg"> 
                                <h3 class="font-semibold mb-3">${currentLocation}</h3> 
                                <p class="text-sm text-neutral-500 flex items-center">
                                    ${currentTenant}, ${currentBooth}
                                    <span class="material-symbols-outlined text-neutral-400 text-lg ml-auto">info</span>
                                </p>
                            </div>
                        ` : ''}
                        
                        <!-- Item section -->
                        <div class="mt-6 flex border-t border-dashed pt-4"> 
                            <img src="<?= MENU_URL ?>${item.MENU_IMAGE_PATH || 'placeholder.jpg'}" alt="Product" class="rounded-md object-cover" style="width: 120px; height: 120px;" />
                            <div class="ml-6 flex-1">
                                <div class="flex justify-between">
                                    <span class="text-primary-500 text-xs font-bold">${order.TRX_STATUS === 'Completed' ? 'New!' : 'Cancelled'}</span>
                                </div>
                                <h4 class="font-semibold">${item.MENU_NAME}</h4>
                                <p class="text-sm text-neutral-500">${item.NOTES || 'No notes'}</p>
                                <div class="mt-4 flex flex-col"> <!-- Increased margin-top for more space -->
                                    <div class="flex items-center">
                                        <p class="font-semibold">
                                            Rp ${order.TAKEAWAY === 1 ? (item.QTY_PRICE - 1000 * item.QTY) : item.QTY_PRICE}
                                        </p>
                                        <div class="ml-12 text-neutral-500 text-sm font-semibold">x${item.QTY}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                }).join('')}

                <!-- Subtotal and Takeaway fee section -->
                <div class="mt-6 border-t border-dashed pt-4"> 
                    <div class="flex justify-between text-sm">
                        <span>Subtotal</span>
                        <span class="font-semibold">Rp ${order.TRX_PRICE}</span>
                    </div>

                    ${order.TAKEAWAY === 1 ? 
                        `<div class="flex justify-between text-sm">
                            <span>Takeaway Fee</span>
                            <span class="text-red-500 font-semibold">+ Rp ${order.DETAILS.reduce((total, item) => total + (item.QTY * 1000), 0)} </span>
                        </div>` : 
                        `<div class="flex justify-between text-sm">
                            <span>Method</span>
                            <span class="text-primary-500 font-semibold">Dine In</span>
                        </div>`}
                </div>

            <div class="mt-4 pt-2 border-t border-dashed">
                <div class="flex justify-between font-title">
                    <span>Total</span>
                    <span class="font-bold">Rp ${order.TRX_PRICE}</span>
                </div>
            </div>
            
            <div class="mt-6 bg-neutral-50 p-4 rounded-lg">
                <div class="text-sm flex justify-between">
                    <span>Order Number</span>
                    <span>#${order.ID_TRANSACTION.substring(order.ID_TRANSACTION.length - 5)}</span>
                </div>
                <div class="text-sm flex justify-between mt-1">
                    <span>Order Time</span>
                    <span>${order.TRX_DATETIME}</span>
                </div>
                <div class="text-sm flex justify-between mt-1">
                    <span>Order Channel</span>
                    <span>APP</span>
                </div>
                <div class="text-sm flex justify-between mt-1">
                    <span>Payment Method</span>
                    <span>${order.TRX_METHOD}</span>
                </div>
            </div>
        </div>
    `;

        const modalContentElement = document.getElementById('modalContent');
        modalContentElement.innerHTML = modalContent;

        const modalToggle = document.getElementById('orderModal');
        modalToggle.checked = true; 
    }

    function closeModal() {
        const modalToggle = document.getElementById('orderModal');
        modalToggle.checked = false; 
    }
</script>