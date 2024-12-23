<div class="container mx-auto">
  <!-- Header Section -->
  <div class="mb-4 flex justify-between items-center">
    <div>
      <h1 class="text-2xl font-semibold">Your Orders</h1>
    </div>
  </div>

  <!-- Order Cards -->
  <div id="order-list" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <?php foreach ($data['transactions'] as $transaction): ?>
      <?php
        $overallStatus = 'Completed';
        foreach ($transaction['details'] as $detail) {
          if ($detail['STATUS'] === 'Pending') {
            $overallStatus = 'Pending';
            break;
          } elseif ($detail['STATUS'] === 'Accept') {
            $overallStatus = 'Cooking';
          } elseif ($detail['STATUS'] === 'Pickup') {
            $overallStatus = 'Ready to Pickup';
          }
        }
      ?>
      <div class="order-card flex flex-col justify-between relative bg-white border-4 border-<?= $overallStatus === 'Pending' ? 'red' : ($overallStatus === 'Cooking' ? 'yellow' : ($overallStatus === 'Ready to Pickup' ? 'blue' : 'green')) ?>-500 rounded-lg shadow-lg p-6" data-id="<?=$transaction['ID_TRANSACTION'] ?>" data-id-menu="<?=$data['tenant']['id'] ?>">
        <div class="flex items-center justify-between mb-4">
          <h2 class="text-lg font-bold text-gray-800">Order #<?= substr($transaction['ID_TRANSACTION'], 31) ?></h2>
          <span class="text-sm text-gray-500"><?= $transaction['TRX_DATETIME'] ?></span>
        </div>
        <div class="flex flex-col flex-grow">
          <h3 class="text-md font-semibold text-gray-800">Menu Details:</h3>
          <ul class="list-disc list-inside">
            <?php foreach ($transaction['details'] as $detail): ?>
              <li class="text-gray-700 text-sm">
                <?= $detail['NAME'] ?> - <?= $detail['QTY'] ?>
                <?php if (!empty($detail['NOTES'])): ?>
                  <p class="text-gray-500 text-xs italic"><strong>Notes:</strong> <?= $detail['NOTES'] ?></p>
                <?php endif; ?>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
        <div class="flex flex-col items-end">
          <span class="text-sm text-<?= $overallStatus === 'Pending' ? 'red' : ($overallStatus === 'Cooking' ? 'yellow' : ($overallStatus === 'Ready to Pickup' ? 'blue' : 'green')) ?>-500 status">Status: <?= $overallStatus === 'Pending' ? 'Pending' : ($overallStatus === 'Cooking' ? 'Cooking' : ($overallStatus === 'Ready to Pickup' ? 'Ready to Pickup' : 'Completed')) ?></span>
          <?php if ($overallStatus === 'Pending'): ?>
            <button class="status bg-red-500 text-white text-sm px-4 py-2 rounded-lg hover:bg-red-600 shadow-md" onclick="acceptOrder(this)">
              Accept Order
            </button>
          <?php elseif ($overallStatus === 'Cooking'): ?>
            <button class="status bg-yellow-500 text-white text-sm px-4 py-2 rounded-lg hover:bg-yellow-600 shadow-md" onclick="readyToPickupOrder(this)">
              Ready to Pickup
            </button>
          <?php elseif ($overallStatus === 'Ready to Pickup'): ?>
            <button class="status bg-blue-500 text-white text-sm px-4 py-2 rounded-lg hover:bg-blue-600 shadow-md" onclick="completeOrder(this)">
              Complete Order
            </button>
          <?php endif; ?>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>

<script>
  function acceptOrder(button) {
    const card = button.closest('.order-card');
    const statusElement = card.querySelector('.status');
    const idTransaction = card.getAttribute('data-id');
    const idMenu = card.getAttribute('data-id-menu');

    // SweetAlert confirmation
    Swal.fire({
      title: 'Accept Order?',
      text: 'This order will now be processed for delivery.',
      icon: 'success',
      confirmButtonColor: '#f59e0b',
      confirmButtonText: 'Accept',
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: '/Tenant/order/accept',
          type: 'POST',
          data: { id_transaction: idTransaction, id_menu: idMenu },
          success: function(response) {
            const data = JSON.parse(response);  
            if (data.status === 'success') {
              statusElement.textContent = 'Status: Accept';
              statusElement.classList.remove('text-red-500');
              statusElement.classList.add('text-yellow-500');
              card.classList.remove('border-red-500');
              card.classList.add('border-yellow-500');

              button.textContent = 'Ready to Pickup';
              button.classList.remove('bg-red-500', 'hover:bg-red-600');
              button.classList.add('bg-yellow-500', 'hover:bg-yellow-600');
              button.setAttribute('onclick', 'readyToPickupOrder(this)');
            } else {
              Swal.fire('Error', data.message, 'error');
            }
          },
          error: function(xhr, status, error) {
            Swal.fire('Error', 'Failed to update order status.', 'error');
          }
        });
      }
    });
  }

  function readyToPickupOrder(button) {
    const card = button.closest('.order-card');
    const statusElement = card.querySelector('.status');
    const idTransaction = card.getAttribute('data-id');
    const idMenu = card.getAttribute('data-id-menu');

    Swal.fire({
      title: 'Ready to Pickup?',
      text: 'This order is now ready for pickup.',
      icon: 'info',
      confirmButtonText: 'Ready',
      confirmButtonColor: '#1e90ff',
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: '/Tenant/order/pickup',
          type: 'POST',
          data: { id_transaction: idTransaction, id_menu: idMenu },
          success: function(response) {
            const data = JSON.parse(response);
            if (data.status === 'success') {
              statusElement.textContent = 'Status: Ready to Pickup';
              statusElement.classList.remove('text-yellow-500');
              statusElement.classList.add('text-blue-500');
              card.classList.remove('border-yellow-500');
              card.classList.add('border-blue-500');

              button.textContent = 'Complete Order';
              button.classList.remove('bg-yellow-500', 'hover:bg-yellow-600');
              button.classList.add('bg-blue-500', 'hover:bg-blue-600');
              button.setAttribute('onclick', 'completeOrder(this)');
            } else {
              Swal.fire('Error', data.message, 'error');
            }
          },
          error: function(xhr, status, error) {
            Swal.fire('Error', 'Failed to update order status.', 'error');
          }
        });
      }
    });
  }

  function completeOrder(button) {
    const card = button.closest('.order-card');
    const statusElement = card.querySelector('.status');
    const idTransaction = card.getAttribute('data-id');
    const idMenu = card.getAttribute('data-id-menu');

    Swal.fire({
      title: 'Complete Order?',
      text: 'Are you sure this order has been completed?',
      icon: 'question',
      confirmButtonText: 'Complete',
      confirmButtonColor: '#38a169',
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: '/Tenant/order/complete',
          type: 'POST',
          data: { id_transaction: idTransaction, id_menu: idMenu },
          success: function(response) {
            const data = JSON.parse(response);
            if (data.status === 'success') {
              statusElement.textContent = 'Status: Completed';
              statusElement.classList.remove('text-yellow-500');
              statusElement.classList.add('text-green-500');
              card.classList.remove('border-yellow-500');
              card.classList.add('border-green-500');

              card.remove();
              Swal.fire('Order Completed', 'This order has been completed.', 'success');
            } else {
              Swal.fire('Error', data.message, 'error');
            }
          },
          error: function(xhr, status, error) {
            Swal.fire('Error', 'Failed to update order status.', 'error');
          }
        });
      }
    });
  }
</script>