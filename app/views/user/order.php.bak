<div id="activeOrdersSection" class="section">
    <h2 class="section-title text-center text-xl font-bold">Active Orders</h2>
    <div id="activeOrderContent" class="content mt-6">
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            <!-- Active orders will be dynamically loaded here -->
        </div>
    </div>
</div>

<div id="transactionHistorySection" class="section mt-12">
    <h2 class="section-title text-center text-xl font-bold">Transaction History</h2>
    <div id="historyContent" class="content mt-6">
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            <!-- Transaction history will be dynamically loaded here -->
        </div>
    </div>
    <p id="empty-message" class="text-center text-lg text-gray-500 hidden">No transaction history found.</p>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        loadActiveOrders();
        loadTransactionHistory();
    });

    function loadActiveOrders() {
        fetch('/Order/activeOrders')
            .then(response => response.json())
            .then(data => {
                const activeOrderContent = document.getElementById('activeOrderContent').querySelector('.grid');
                if (data && data.length > 0) {
                    activeOrderContent.innerHTML = ''; 
                    data.forEach(order => {
                        const orderCard = createOrderCard(order);
                        activeOrderContent.appendChild(orderCard);
                    });
                } else {
                    activeOrderContent.innerHTML = `<p class="text-center text-lg text-gray-500">No active orders.</p>`;
                }
            })
            .catch(error => console.error('Error fetching active orders:', error));
    }

    function loadTransactionHistory() {
        fetch('/Order/transactionHistory')
            .then(response => response.json())
            .then(data => {
                const historyContent = document.getElementById('historyContent').querySelector('.grid');
                if (data && data.length > 0) {
                    historyContent.innerHTML = ''; 
                    data.forEach(transaction => {
                        const transactionCard = createTransactionCard(transaction);
                        historyContent.appendChild(transactionCard);
                    });
                    document.getElementById('empty-message').classList.add('hidden'); 
                } else {
                    document.getElementById('empty-message').classList.remove('hidden');
                }
            })
            .catch(error => console.error('Error fetching transaction history:', error));
    }

    function createOrderCard(order) {
        const card = document.createElement('div');
        card.className = 'container px-4 mx-auto';

        card.innerHTML = `
            <div class="mx-auto p-6 pb-1 border bg-white rounded-md shadow-dashboard">
                <div class="flex flex-wrap items-center justify-between mb-1 -m-2">
                    <div class="w-auto p-2">
                        <h2 class="text-lg font-semibold text-coolGray-900">${order.id_transaction}</h2>
                        <a href="#" class="text-sm text-green-500 hover:text-green-600 font-semibold">Total: Rp.${order.trx_price}</a>
                    </div>
                    <div class="w-auto">
                        <p class="text-xs text-coolGray-500">Tanggal: ${order.trx_date}</p>
                        <p class="text-xs text-coolGray-500">Status: ${order.trx_status}</p>
                    </div>
                </div>
                <button class="w-full py-2 text-sm font-medium text-coolGray-900 bg-gray-100 rounded-md hover:bg-gray-200 mb-4" onclick="toggleDropdown('order-${order.real_id}')">Lihat Detail</button>
                <div id="order-${order.real_id}" class="hidden flex flex-wrap">
                    ${order.details && order.details.length > 0 ? order.details.map(detail => `
                        <div class="w-full border-b border-coolGray-100">
                            <div class="flex flex-wrap items-center justify-between py-4 -m-2">
                                <div class="w-auto p-2">
                                    <div class="flex items-center justify-center w-12 h-12 bg-yellow-50 rounded-md">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" height="24" width="24">
                                            <path fill="#F59E0B"
                                                d="M19 4H5C4.20435 4 3.44129 4.31607 2.87868 4.87868C2.31607 5.44129 2 6.20435 2 7V17C2 17.7956 2.31607 18.5587 2.87868 19.1213C3.44129 19.6839 4.20435 20 5 20H19C19.7956 20 20.5587 19.6839 21.1213 19.1213C21.6839 18.5587 22 17.7956 22 17V7C22 6.20435 21.6839 5.44129 21.1213 4.87868C20.5587 4.31607 19.7956 4 19 4ZM5 18C4.73478 18 4.48043 17.8946 4.29289 17.7071C4.10536 17.5196 4 17.2652 4 17V14.58L7.3 11.29C7.48693 11.1068 7.73825 11.0041 8 11.0041C8.26175 11.0041 8.51307 11.1068 8.7 11.29L15.41 18H5ZM20 17C20 17.2652 19.8946 17.5196 19.7071 17.7071C19.5196 17.8946 19.2652 18 19 18H18.23L14.42 14.17L15.3 13.29C15.4869 13.1068 15.7382 13.0041 16 13.0041C16.2618 13.0041 16.5131 13.1068 16.7 13.29L20 16.58V17ZM20 13.76L18.12 11.89C17.5501 11.3424 16.7904 11.0366 16 11.0366C15.2096 11.0366 14.4499 11.3424 13.88 11.89L13 12.77L10.12 9.89C9.55006 9.34243 8.79036 9.03663 8 9.03663C7.20964 9.03663 6.44994 9.34243 5.88 9.89L4 11.76V7C4 6.73478 4.10536 6.48043 4.29289 6.29289C4.48043 6.10536 4.73478 6 5 6H19C19.2652 6 19.5196 6.10536 19.7071 6.29289C19.8946 6.48043 20 6.73478 20 7V13.76Z">
                                            </path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="w-auto p-2">
                                    <h2 class="text-sm font-medium text-coolGray-900">${detail.menu_name}</h2>
                                    <h3 class="text-xs font-medium text-coolGray-400">${detail.tenant_name}</h3>
                                </div>
                                <div class="w-auto p-2">
                                    <p class="text-xs text-coolGray-500 font-medium">${detail.qty} x Rp.${detail.qty_price}</p>
                                </div>
                            </div>
                        </div>
                    `).join('') : 'No details available'}
                </div>
            </div>
        `;

        return card;
    }

    function createTransactionCard(transaction) {
        const card = document.createElement('div');
        card.className = 'container px-4 mx-auto';

        card.innerHTML = `
            <div class="mx-auto p-6 pb-1 border bg-white rounded-md shadow-dashboard">
                <div class="flex flex-wrap items-center justify-between mb-1 -m-2">
                    <div class="w-auto p-2">
                        <h2 class="text-lg font-semibold text-coolGray-900">${transaction.id_transaction}</h2>
                        <a href="#" class="text-sm text-green-500 hover:text-green-600 font-semibold">Total: Rp.${transaction.trx_price}</a>
                    </div>
                    <div class="w-auto">
                        <p class="text-xs text-coolGray-500">Tanggal: ${transaction.trx_date}</p>
                        <p class="text-xs text-coolGray-500">Status: ${transaction.trx_status}</p>
                    </div>
                </div>
                <button class="w-full py-2 text-sm font-medium text-coolGray-900 bg-gray-100 rounded-md hover:bg-gray-200 mb-4" onclick="toggleDropdown('transaction-${transaction.real_id}')">Lihat Detail</button>
                <div id="transaction-${transaction.real_id}" class="hidden flex flex-wrap">
                    ${transaction.details && transaction.details.length > 0 ? transaction.details.map(detail => `
                        <div class="w-full border-b border-coolGray-100">
                            <div class="flex flex-wrap items-center justify-between py-4 -m-2">
                                <div class="w-auto p-2">
                                    <div class="flex items-center justify-center w-12 h-12 bg-yellow-50 rounded-md">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" height="24" width="24">
                                            <path fill="#F59E0B"
                                                d="M19 4H5C4.20435 4 3.44129 4.31607 2.87868 4.87868C2.31607 5.44129 2 6.20435 2 7V17C2 17.7956 2.31607 18.5587 2.87868 19.1213C3.44129 19.6839 4.20435 20 5 20H19C19.7956 20 20.5587 19.6839 21.1213 19.1213C21.6839 18.5587 22 17.7956 22 17V7C22 6.20435 21.6839 5.44129 21.1213 4.87868C20.5587 4.31607 19.7956 4 19 4ZM5 18C4.73478 18 4.48043 17.8946 4.29289 17.7071C4.10536 17.5196 4 17.2652 4 17V14.58L7.3 11.29C7.48693 11.1068 7.73825 11.0041 8 11.0041C8.26175 11.0041 8.51307 11.1068 8.7 11.29L15.41 18H5ZM20 17C20 17.2652 19.8946 17.5196 19.7071 17.7071C19.5196 17.8946 19.2652 18 19 18H18.23L14.42 14.17L15.3 13.29C15.4869 13.1068 15.7382 13.0041 16 13.0041C16.2618 13.0041 16.5131 13.1068 16.7 13.29L20 16.58V17ZM20 13.76L18.12 11.89C17.5501 11.3424 16.7904 11.0366 16 11.0366C15.2096 11.0366 14.4499 11.3424 13.88 11.89L13 12.77L10.12 9.89C9.55006 9.34243 8.79036 9.03663 8 9.03663C7.20964 9.03663 6.44994 9.34243 5.88 9.89L4 11.76V7C4 6.73478 4.10536 6.48043 4.29289 6.29289C4.48043 6.10536 4.73478 6 5 6H19C19.2652 6 19.5196 6.10536 19.7071 6.29289C19.8946 6.48043 20 6.73478 20 7V13.76Z">
                                            </path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="w-auto p-2">
                                    <h2 class="text-sm font-medium text-coolGray-900">${detail.menu_name}</h2>
                                    <h3 class="text-xs font-medium text-coolGray-400">${detail.tenant_name}</h3>
                                </div>
                                <div class="w-auto p-2">
                                    <p class="text-xs text-coolGray-500 font-medium">${detail.qty} x Rp.${detail.qty_price}</p>
                                </div>
                            </div>
                        </div>
                    `).join('') : 'No details available'}
                </div>
            </div>
        `;

        return card;
    }

    function toggleDropdown(dropdownId) {
        const dropdown = document.getElementById(dropdownId);
        console.log('Toggling dropdown: ', dropdownId);
        if (dropdown) {
            dropdown.classList.toggle('hidden');
        } else {
            console.error('Dropdown not found for id:', dropdownId);
        }
    }
</script>
