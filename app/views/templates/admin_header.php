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
                        <a href="<?= BASE_URL; ?>/Admin/index" class="flex-1">List Tenant</a>
                    </li>

                    <!-- Cash Management -->
                    <li class="text-gray-600 font-medium px-6 py-3 flex items-center space-x-3 hover:bg-red-100">
                        <i class="ti ti-list text-gray-500"></i>
                        <a href="<?= BASE_URL; ?>/Admin/cash" class="flex-1">Cash Management</a>
                    </li>

                    <li class="text-gray-600 font-medium px-6 py-3 flex flex-col space-y-1">
                        <div class="flex items-center space-x-3 cursor-pointer">
                            <i class="ti ti-settings text-gray-500"></i>
                            <a class="flex-1" href="<?= BASE_URL; ?>/Admin/logout">Logout</a>
                            <svg class="w-4 h-4 ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </li>
                </ul>
            </nav>
        </aside>

        <div class="flex-1 p-6"></div>