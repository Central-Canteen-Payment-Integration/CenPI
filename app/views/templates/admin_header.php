<!DOCTYPE html>
<html data-theme="def" lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="<?= BASE_URL; ?>/assets/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css" />
</head>

<body class="bg-gray-100">
    <div class="flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-white h-screen shadow-lg">
            <div class="p-6 border-b">
                <h1 class="text-2xl font-bold text-gray-800 flex items-center space-x-2">
                    <span><i class="ti ti-layout-dashboard"></i></span>
                    <span>CenPi</span>
                </h1>
                <p class="text-sm text-gray-500">Admin Dashboard</p>
            </div>

            <!-- Navigasi Sidebar -->
            <nav class="mt-6">
                <ul>
                    <!-- Dashboard -->
                    <li class="text-gray-600 font-medium px-6 py-3 flex items-center space-x-3 hover:bg-gray-100">
                        <i class="ti ti-home text-gray-500"></i>
                        <a href="<?= BASE_URL; ?>/Admin/dashboard" class="flex-1">Dashboard</a>
                    </li>

                    <!-- Order List -->
                    <li class="text-gray-600 font-medium px-6 py-3 flex items-center space-x-3 hover:bg-gray-100">
                        <i class="ti ti-shopping-cart text-gray-500"></i>
                        <a href="<?= BASE_URL; ?>/Admin/orderList" class="flex-1">Order List</a>
                    </li>

                    <!-- Menu -->
                    <li class="text-gray-600 font-medium px-6 py-3 flex items-center space-x-3 hover:bg-gray-100">
                        <i class="ti ti-list text-gray-500"></i>
                        <a href="<?= BASE_URL; ?>/Admin/menu" class="flex-1">Menu</a>
                    </li>

                    <!-- History Transaksi -->
                    <li class="text-gray-600 font-medium px-6 py-3 flex items-center space-x-3 hover:bg-gray-100">
                        <i class="ti ti-history text-gray-500"></i>
                        <a href="<?= BASE_URL; ?>/Admin/transactionHistory" class="flex-1">History Transaksi</a>
                    </li>

                    <!-- Report -->
                    <li class="text-gray-600 font-medium px-6 py-3 flex items-center space-x-3 hover:bg-gray-100">
                        <i class="ti ti-report text-gray-500"></i>
                        <a href="<?= BASE_URL; ?>/Admin/report" class="flex-1">Report</a>
                    </li>

                    <!-- Settings -->
                    <li class="text-gray-600 font-medium px-6 py-3 flex items-center space-x-3 hover:bg-gray-100">
                        <i class="ti ti-settings text-gray-500"></i>
                        <a href="<?= BASE_URL; ?>/Admin/settings" class="flex-1">Settings</a>
                    </li>
                </ul>
            </nav>
        </aside>

        <div class="flex-1 p-6">
            <!-- Header -->
            <header class="flex items-center justify-between border-b pb-4 mb-4">
                <h2 class="text-2xl font-semibold text-gray-800 flex items-center space-x-2 mb-4">
                    <span></span>
                </h2>
                <div class="flex items-center space-x-4">
                    <button class="p-2 rounded-full bg-gray-200 text-gray-600 hover:bg-gray-300">
                        <i class="ti ti-bell"></i>
                    </button>
                    <div class="w-10 h-10 rounded-full bg-gray-300 flex items-center justify-center text-gray-600">
                        <i class="ti ti-user"></i>
                    </div>
                    <div class="text-xl font-semibold text-gray-800 flex items-center space-x-2">Hi, Admin</div>
                </div>
            </header>