<?php
    echo '<pre>' . var_export($data, true) . '</pre>';
?>
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
                                    <img src=<?= MENU_URL . $order['DETAILS'][$i]['MENU_IMAGE_PATH']?> alt="" class="w-16 h-16 rounded-full">
                                <?php
                                            }
                                        }
                                    } elseif (COUNT($order['DETAILS']) == 1) {
                                ?>
                                    <img src=<?= MENU_URL . $order['DETAILS'][0]['MENU_IMAGE_PATH']?> alt="" class="w-16 h-16 rounded-full">
                                    <div class="">
                                        <h3 class="text-lg font-medium"><?= $order['DETAILS'][0]['MENU_NAME']; ?></h3>
                                    </div>
                                <?php
                                    }
                                ?>
                            </div>
                            <div class="flex flex-col justify-start items-end text-right">
                                <p class="text-gray-500"><?= COUNT($order['DETAILS'])?> Item</p>
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

<script>
    $(document).ready(function() {
        $('.reorder').on('click', function() {
            event.stopPropagation();
            const id_transaction = $(this).data('order-id');

            $.ajax({
                url: '/Cart/reorder',
                type: 'POST',
                data: {
                    id_transaction: id_transaction,
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

        $('.details a').on('click', function(event) {
            event.stopPropagation();
        });

        $('.details').on('click', function() {
            const id_transaction = $(this).data('id');

            console.log('Details clicked with ID:', id_transaction);
        });
    });
</script>