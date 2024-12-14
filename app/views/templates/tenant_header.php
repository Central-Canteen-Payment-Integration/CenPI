<body class="bg-gray-100">
    <div class="flex">
        <aside class="w-64 bg-white h-screen shadow-lg flex flex-col">
            <div class="p-6 border-b">
                <h1 class="text-2xl font-bold text-gray-800 flex items-center space-x-2">
                    <a href="<?= BASE_URL ?>/tenant">
                        <img src="<?= BASE_URL ?>/assets/img/logo.svg" alt="Cenπ Logo" class="h-10">
                    </a>
                    <span>CenPi</span>
                </h1>
                <p class="text-lg text-gray-500 mt-2">Hi, Admin</p>
            </div>
            <!-- Navigasi Sidebar -->
            <nav class="mt-4 flex-1">
                <ul>
                    <!-- Dashboard -->
                    <li class="text-gray-600 font-medium px-6 py-3 flex items-center space-x-3 hover:bg-red-100">
                        <i class="ti ti-home text-gray-500"></i>
                        <a href="<?= BASE_URL; ?>/Tenant/index" class="flex-1">Dashboard</a>
                    </li>

                    <!-- Order List -->
                    <li class="text-gray-600 font-medium px-6 py-3 flex items-center space-x-3 hover:bg-red-100">
                        <i class="ti ti-shopping-cart text-gray-500"></i>
                        <a href="<?= BASE_URL; ?>/Tenant/orderList" class="flex-1">Order List</a>
                    </li>

                    <!-- Menu -->
                    <li class="text-gray-600 font-medium px-6 py-3 flex items-center space-x-3 hover:bg-red-100">
                        <i class="ti ti-list text-gray-500"></i>
                        <a href="<?= BASE_URL; ?>/Tenant/menu" class="flex-1">Menu</a>
                    </li>

                    <!-- History Transaksi -->
                    <li class="text-gray-600 font-medium px-6 py-3 flex items-center space-x-3 hover:bg-red-100">
                        <i class="ti ti-history text-gray-500"></i>
                        <a href="<?= BASE_URL; ?>/Tenant/historytransaction" class="flex-1">History Transaksi</a>
                    </li>

                    <!-- Report -->
                    <li class="text-gray-600 font-medium px-6 py-3 flex items-center space-x-3 hover:bg-red-100">
                        <i class="ti ti-report text-gray-500"></i>
                        <a href="<?= BASE_URL; ?>/Tenant/report" class="flex-1">Report</a>
                    </li>

                    <li class="text-gray-600 font-medium px-6 py-3 flex flex-col space-y-1">
                        <div class="flex items-center space-x-3 cursor-pointer" id="settingsMenu">
                            <i class="ti ti-settings text-gray-500"></i>
                            <span class="flex-1">Settings</span>
                            <svg class="w-4 h-4 ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                        <ul class="hidden flex-col space-y-1 pl-6 pt-2" id="submenu">
                            <li class="hover:bg-red-100 px-4 py-2">
                                <a href="<?= BASE_URL; ?>/Tenant/settings" class="text-sm text-gray-600">Profile</a>
                            </li>
                            <li class="hover:bg-red-100 px-4 py-2">
                                <form action="<?= BASE_URL; ?>/Tenant/logout" method="post">
                                    <button type="submit" class="text-sm text-gray-600 w-full text-left">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </nav>
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <span class="text-gray-800 text-lg font-medium">Tenant Status</span>
                    <div id="tenantToggle"
                        class="relative w-12 h-6 bg-red-500 rounded-full cursor-pointer transition-all duration-300">
                        <div
                            class="absolute top-0.5 left-0.5 w-5 h-5 bg-white rounded-full shadow-md transition-all duration-300">
                        </div>
                    </div>
                </div>
                <p id="statusText" class="text-sm text-red-500 mt-2 font-medium">Status: <span>Closed</span></p>
            </div>
            <script>
                // DOM Elements
                const toggle = document.getElementById('tenantToggle');
                const statusText = document.getElementById('statusText');

                // Load status from localStorage
                const loadStatus = () => {
                    const savedStatus = localStorage.getItem('tenantStatus');
                    if (savedStatus === 'open') {
                        setToggleState(true);
                    } else {
                        setToggleState(false);
                    }
                };

                // Update UI and save to localStorage
                const setToggleState = (isOpen) => {
                    const toggleKnob = toggle.querySelector('div');
                    if (isOpen) {
                        toggle.classList.add('bg-green-500');
                        toggle.classList.remove('bg-red-500');
                        toggleKnob.style.transform = 'translateX(24px)';
                        statusText.classList.replace('text-red-500', 'text-green-500');
                        statusText.querySelector('span').textContent = 'Open';
                        localStorage.setItem('tenantStatus', 'open');
                    } else {
                        toggle.classList.add('bg-red-500');
                        toggle.classList.remove('bg-green-500');
                        toggleKnob.style.transform = 'translateX(0)';
                        statusText.classList.replace('text-green-500', 'text-red-500');
                        statusText.querySelector('span').textContent = 'Closed';
                        localStorage.setItem('tenantStatus', 'closed');
                    }
                };

                // Event listener for toggle click
                toggle.addEventListener('click', () => {
                    const isOpen = toggle.classList.contains('bg-red-500');
                    setToggleState(isOpen); // Invert the current state
                });

                // Initialize the toggle state on page load
                loadStatus();

                const reconnectInterval = 2000;

                const connectWebSocket = () => {
                    const socket = new WebSocket('ws://<?php echo DB_HOST; ?>:8070?tenant_id=<?php echo $_SESSION['tenant']['id']; ?>');

                    socket.addEventListener('open', function (event) {
                        console.log('Connected to the WebSocket server.');
                    });

                    socket.addEventListener('message', function (event) {
                        swallert('info', event.data);
                    });

                    socket.addEventListener('error', function (event) {
                        console.error('WebSocket error: ' + event.message);
                        setTimeout(connectWebSocket, reconnectInterval);
                    });

                    socket.addEventListener('close', function (event) {
                        console.log('Disconnected from the WebSocket server.');
                        setTimeout(connectWebSocket, reconnectInterval);
                    });
                };

                connectWebSocket();
                document.getElementById('settingsMenu').addEventListener('click', function () {
                    const submenu = document.getElementById('submenu');
                    submenu.classList.toggle('hidden');
                });
            </script>
        </aside>

        <div class="flex-1 p-6">