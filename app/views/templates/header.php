<!DOCTYPE html>
<html data-theme="autumn" lang="en" class="scroll-smooth">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>CenPI - PNJ</title>
	<link rel="stylesheet" href="<?php BASE_URL ?>/assets/css/style.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css" />
</head>

<body>
	<header class="mb-10">
		<div class="navbar bg-base-100 px-6">
			<div class="navbar-start">
				<a href="<?php BASE_URL ?>"><button class="btn btn-glass text-xl"">Cenπ</button></a>
			</div>
			<div class="navbar-end gap-3">
				<div class="dropdown dropdown-end hidden md:inline">
					<div tabindex="0" role="button" class="btn btn-ghost btn-circle">
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
								d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
							</svg>
							<span class="badge badge-sm indicator-item">0</span>
						</div>
					</div>
					<div
						tabindex="0"
						class="card card-compact dropdown-content bg-base-100 z-[1] mt-3 w-52 shadow">
						<div class="card-body">
							<span class="text-lg font-bold">0 Items</span>
							<span class="text-info">Subtotal: Rp. 0</span>
							<div class="card-actions">
								<button class="btn btn-primary btn-block">View cart</button>
							</div>
						</div>
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
						<li><a>Profile</a></li>
						<li><a>My Orders</a></li>
						<li><a>Settings</a></li>
						<li><a href="<?php BASE_URL ?>/User/logout">Logout</a></li>
					</ul>
				</div>
				<?php } ?>
			</div>
		</div>
	</header>