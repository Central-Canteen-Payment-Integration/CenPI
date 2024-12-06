<body class="bg-gray-100">
    <div class="flex">
        <aside class="w-64 bg-white h-screen shadow-lg">
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
            <nav class="mt-4">
                <ul>
                    <!-- Dashboard -->
                    <li class="text-gray-600 font-medium px-6 py-3 flex items-center space-x-3 hover:bg-gray-100">
                        <i class="ti ti-home text-gray-500"></i>
                        <a href="<?= BASE_URL; ?>/Tenant/dashboard" class="flex-1">Dashboard</a>
                    </li>

                    <!-- Order List -->
                    <li class="text-gray-600 font-medium px-6 py-3 flex items-center space-x-3 hover:bg-gray-100">
                        <i class="ti ti-shopping-cart text-gray-500"></i>
                        <a href="<?= BASE_URL; ?>/Tenant/orderList" class="flex-1">Order List</a>
                    </li>

                    <!-- Menu -->
                    <li class="text-gray-600 font-medium px-6 py-3 flex items-center space-x-3 hover:bg-gray-100">
                        <i class="ti ti-list text-gray-500"></i>
                        <a href="<?= BASE_URL; ?>/Tenant/menu" class="flex-1">Menu</a>
                    </li>

                    <!-- History Transaksi -->
                    <li class="text-gray-600 font-medium px-6 py-3 flex items-center space-x-3 hover:bg-gray-100">
                        <i class="ti ti-history text-gray-500"></i>
                        <a href="<?= BASE_URL; ?>/Tenant/historytransaction" class="flex-1">History Transaksi</a>
                    </li>

                    <!-- Report -->
                    <li class="text-gray-600 font-medium px-6 py-3 flex items-center space-x-3 hover:bg-gray-100">
                        <i class="ti ti-report text-gray-500"></i>
                        <a href="<?= BASE_URL; ?>/Tenant/report" class="flex-1">Report</a>
                    </li>

                    <!-- Settings -->
                    <li class="text-gray-600 font-medium px-6 py-3 flex items-center space-x-3 hover:bg-gray-100">
                        <i class="ti ti-settings text-gray-500"></i>
                        <a href="<?= BASE_URL; ?>/Tenant/settings" class="flex-1">Settings</a>
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
            </script>
        </aside>

        <div class="flex-1 p-6">