<header>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
</header>

<div class="container mx-auto">
  <!-- Header Section -->
  <div class="mb-4 flex justify-between items-center">
    <div>
      <h1 class="text-2xl font-semibold">Transaction History</h1>
      <p class="text-sm text-gray-500">A detailed list of your past transactions</p>
    </div>
    <div class="flex space-x-4">
      <div id="date-range-picker" date-rangepicker class="flex items-center">
        <div class="relative">
          <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
            <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
              <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
            </svg>
          </div>
          <input id="startDate" name="start" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5" placeholder="Select date start">
        </div>
        <span class="mx-4 text-gray-500">to</span>
        <div class="relative">
          <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
            <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
              <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
            </svg>
          </div>
          <input id="endDate" name="end" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5" placeholder="Select date end">
        </div>
        <button id="applyButton" class="bg-primary text-white font-semibold ml-4 p-2 rounded-lg border">Apply</button>
      </div>
    </div>
  </div>

  <!-- Table Section -->
  <div class="bg-white shadow-md rounded-lg overflow-hidden p-10">
    <table id="export-table">
      <thead>
        <tr>
          <th>
            <span class="flex items-center">
              Order ID
              <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4" />
              </svg>
            </span>
          </th>
          <th data-type="date" data-format="DD/MM/YYYY">
            <span class="flex items-center">
              Date
              <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4" />
              </svg>
            </span>
          </th>
          <th>
            <span class="flex items-center">
              Amount
              <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4" />
              </svg>
            </span>
          </th>
          <th>
            <span class="flex items-center">
              Payment
              <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4" />
              </svg>
            </span>
          </th>
          <th>
            <span class="flex items-center">
              Status
              <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4" />
              </svg>
            </span>
          </th>
          <th>
            <span class="flex items-center">
              Details
              <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4" />
              </svg>
            </span>
          </th>
        </tr>
      </thead>
      <tbody>
        <tr class="hover:bg-gray-50 cursor-pointer">
          <td> </td>
          <td> </td>
          <td> </td>
          <td> </td>
          <td> </td>
          <td> </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>

<!-- Modal Structure -->
<div id="modalOverlay" class="modal hidden">
  <div class="modal-box">
    <h2 class="text-lg font-bold">Order History</h2>
    <div id="modalContent" class="mt-4"></div>
    <div class="modal-action">
      <button id="closeModalButton" class="btn btn-sm">Close</button>
    </div>
  </div>
</div>



<script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@9.0.3"></script>
<script>
  let allTransactions = []; 

  const table = new simpleDatatables.DataTable("#export-table", {
    template: (options, dom) => "<div class='" + options.classes.top + "'>" +
      "<div class='flex flex-col sm:flex-row sm:items-center space-y-4 sm:space-y-0 sm:space-x-3 rtl:space-x-reverse w-full sm:w-auto'>" +
      (options.paging && options.perPageSelect ?
        "<div class='" + options.classes.dropdown + "'>" +
        "<label>" +
        "<select class='" + options.classes.selector + "'></select> " + options.labels.perPage +
        "</label>" +
        "</div>" : ""
      ) + "</div>" +
      "</div>" +
      "<div class='" + options.classes.container + "'" + (options.scrollY.length ? " style='height: " + options.scrollY + "; overflow-Y: auto;'" : "") + "></div>" +
      "<div class='" + options.classes.bottom + "'>" +
      (options.paging ?
        "<div class='" + options.classes.info + "'></div>" : ""
      ) +
      "<nav class='" + options.classes.pagination + "'></nav>" +
      "</div>"
  });

  $('#applyButton').on('click', function() {
    const startDateInput = $('#startDate').val();
    const endDateInput = $('#endDate').val();

    const formatDate = (date) => {
      const d = new Date(date);
      const month = String(d.getDate()).padStart(2, '0');
      const day = String(d.getMonth() + 1).padStart(2, '0');
      const year = d.getFullYear();
      return `${day}/${month}/${year}`;
    };

    const startDate = formatDate(startDateInput);
    const endDate = formatDate(endDateInput);

    fetchTransactions(startDate, endDate);
  });

  const fetchTransactions = (startDate, endDate) => {
    $.ajax({
      url: `/Tenant/order/history`,
      method: 'POST',
      data: {
        startDate: startDate,
        endDate: endDate
      },
      dataType: 'json',
      success: function(data) {
        allTransactions = data;

        const transactionsBody = document.getElementsByTagName('tbody');
        transactionsBody[0].innerHTML = ''; 

        data.forEach(transaction => {
          let id = transaction.ID_TRANSACTION;
          let id_transaction = '#' + id.substring(31);
          const row = `
            <tr class="hover:bg-gray-50 cursor-pointer">
              <td class="font-medium text-gray-900 whitespace-nowrap">${id_transaction}</td>
              <td>${transaction.TRX_DATETIME}</td>
              <td>${transaction.TRX_PRICE}</td>
              <td>${transaction.TRX_METHOD}</td>
              <td>${transaction.TRX_STATUS}</td>
              <td>  
                <button 
                  class="bg-green-500 rounded-lg text-white details-button ml-4 p-2 border" 
                  data-transaction-id="${transaction.ID_TRANSACTION}">View Details</button>
              </td>
            </tr>
          `;
          transactionsBody[0].innerHTML += row;
        });

        table.refresh();

        const detailButtons = document.querySelectorAll('.details-button');
        detailButtons.forEach(button => {
          button.addEventListener('click', function() {
            const transactionId = this.getAttribute('data-transaction-id');
            fetchTransactionDetails(transactionId); 
          });
        });
      },
      error: function(xhr, status, error) {
        console.error('Error fetching data:', error);
      }
    });
  };


  fetchTransactions('', '');

  const fetchTransactionDetails = (transactionId) => {
  const transactionDetails = allTransactions.find(transaction => transaction.ID_TRANSACTION === transactionId);

  if (transactionDetails) {
    renderOrderModal(transactionDetails);
  } else {
    console.error('Transaction not found');
  }
};

const renderOrderModal = (order) => {
    if (!order) {
      console.error('Order not found!');
      return;
    }

    const modalContent = `
  <div class="w-full bg-white shadow-lg rounded-lg p-4 text-neutral-950">
    <div class="flex items-center mb-4">
      <span class="material-symbols-outlined text-primary-500">
        ${order.TRX_STATUS === 'Cancelled' ? 'cancel' : 'check_circle'}
      </span>
      <h2 class="ml-2 font-title text-lg font-bold">Order Status: ${order.TRX_STATUS}</h2>
    </div>

    ${order.TRX_STATUS === 'Cancelled' ? 
      `<p class="text-sm text-neutral-500">Cancel Reason: ${order.CANCEL_REASON || 'No paid in time'}</p>` 
      : ''}

    ${order.details.map(item => {
      const currentMenuName = item.NAME;
      const currentMenuPrice = item.PRICE;
      const currentQuantity = item.QTY;
      const currentMenuImagePath = item.IMAGE_PATH || 'placeholder.jpg';

      return `
        <div class="mt-6 flex border-t border-dashed pt-4"> 
          <img src="<?= MENU_URL ?>${currentMenuImagePath}" alt="Product: ${currentMenuName}" class="rounded-md object-cover" style="width: 120px; height: 120px;" />
          <div class="ml-6 flex-1">
            <h4 class="font-semibold">${currentMenuName}</h4>
            <p class="text-sm text-neutral-500">${item.NOTES || 'No notes'}</p>
            <div class="mt-4 flex flex-col">
              <div class="flex items-center">
                <p class="font-semibold">Rp ${order.TAKEAWAY === 1 ? (currentMenuPrice - 1000 * currentQuantity) : currentMenuPrice}</p>
                <div class="ml-12 text-neutral-500 text-sm font-semibold">x${currentQuantity}</div>
              </div>
            </div>
          </div>
        </div>
      `;
    }).join('')}

    <div class="mt-6 border-t border-dashed pt-4"> 
      <div class="flex justify-between text-sm">
        <span>Subtotal</span>
        <span class="font-semibold">Rp ${order.TRX_PRICE}</span>
      </div>

      ${order.TAKEAWAY === 1 ? 
        `<div class="flex justify-between text-sm">
          <span>Takeaway Fee</span>
          <span class="text-red-500 font-semibold">+ Rp ${order.details.reduce((total, item) => total + (item.QTY * 1000), 0)} </span>
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

    const modal = document.getElementById('modalOverlay');
    modal.classList.remove('hidden'); 
    modal.classList.add('modal-open');

    document.getElementById('closeModalButton').addEventListener('click', () => {
      modal.classList.add('hidden');
      modal.classList.remove('modal-open'); 
    });
};
</script>