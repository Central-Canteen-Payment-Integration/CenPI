<!DOCTYPE html>
<html data-theme="def" lang="en" class="scroll-smooth">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>CenPI - PNJ</title>
	<link rel="stylesheet" href="<?php BASE_URL ?>/assets/css/style.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css" />
</head>

<body>
	<header class="mb-10">
		<div class="navbar px-6 gap-3">
			<div class="navbar-start">
				<a href="<?php BASE_URL ?>"><button class="btn btn-glass text-xl">Cenπ</button></a>
			</div>
			<div class="navbar-end gap-3">
				<div class="dropdown dropdown-end hidden md:inline">
					<?php if (isset($_SESSION['user_id'])): ?>
						<!-- button cart cuma muncul kalo login -->
						<div class="drawer drawer-end hidden md:block">
							<input id="my-drawer-4" type="checkbox" class="drawer-toggle" />
							<div class="drawer-content">
								<label for="my-drawer-4" class="drawer-button btn btn-ghost btn-circle">
									<div class="indicator">
										<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
										</svg>
										<span class="badge badge-sm indicator-item qty-cart"></span>
									</div>
								</label>
							</div>
							<div class="drawer-side z-50">
								<label for="my-drawer-4" class="drawer-overlay"></label>
								<div class="bg-white text-base-content min-h-full w-3/12 p-4 pr-6">
									<div class="flex justify-between items-center">
										<h2 class="text-lg font-medium text-secondary">Food Cart</h2>
										<button type="button" class="text-gray-500 hover:text-gray-700" onclick="document.getElementById('my-drawer-4').checked = false;">
											<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
												<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
											</svg>
										</button>
									</div>
									<div class="mt-2">
										<div class="flow-root">
											<ul role="list" class="divide-y divide-gray-200 cart-list">
											</ul>
										</div>
									</div>
									<div class="border-t border-gray-200 px-4 py-6 cart-btn">
									</div>
								</div>
							</div>
						</div>
					<?php endif; ?>
				</div>

			</div>
			<?php
			if (!isset($_SESSION['user_id'])) {
			?>
				<a href="<?php BASE_URL ?>/User/login"><button class="btn btn-active btn-neutral">Login</button></a>
				<a href="<?php BASE_URL ?>/User/register" class="hidden md:inline"><button class="btn btn-active btn-primary">Register</button></a>
			<?php
			} else {
			?>
				<button class="btn btn-ghost btn-circle">
					<div class="indicator">
						<svg
							xmlns="http://www.w3.org/2000/svg"
							class="h-5 w-5"
							fill="none"
							viewBox="0 0 24 24"
							stroke="currentColor">
							<path
								stroke-linecap="round"
								stroke-linejoin="round"
								stroke-width="2"
								d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
						</svg>
						<span class="badge badge-xs badge-primary indicator-item"></span>
					</div>
				</button>
				<div class="dropdown dropdown-end">
					<div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">
						<?php if (isset($_SESSION['user_image'])) { ?>
							<div class="w-10 rounded-full flex items-center justify-center">
								<img src="<?php echo $_SESSION['user_image']; ?>" alt="User  Image" class="rounded-full w-full h-full object-cover">
							</div>
						<?php } else { ?>
							<svg xmlns="http://www.w3.org/2000/svg"
								width="24" height="24"
								viewBox="0 0 24 24"
								stroke-width="1.5"
								fill="none"
								stroke="currentColor"
								class="object-cover">
								<path stroke="none" d="M0 0h24v24H0z" fill="none" />
								<path d="M12 2a5 5 0 1 1 -5 5l.005 -.217a5 5 0 0 1 4.995 -4.783z" />
								<path d="M14 14a5 5 0 0 1 5 5v1a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-1a5 5 0 0 1 5 -5h4z" />
							</svg>
						<?php } ?>
					</div>
					<ul tabindex="0" class="menu menu-sm dropdown-content bg-base-100 rounded-box z-[1] mt-3 w-52 p-2 shadow">
						<li><a href="<?php echo BASE_URL ?>/User/profile">Profile</a></li>
						<li><a>My Orders</a></li>
						<li><a>Settings</a></li>
						<li><a href="<?php BASE_URL ?>/User/logout">Logout</a></li>
					</ul>
				</div>
			<?php } ?>
		</div>
		</div>
	</header>