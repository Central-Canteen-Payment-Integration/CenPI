<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>CenPI</title>
		<link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/global.css">
		<link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/style.css">
		<link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/header.css">
	</head>
	<body>
		<header>
			<nav class="bg w-full">
				<div class="px-14 flex flex-wrap items-center justify-between mx-auto py-4  ">
					<a href="<?php echo BASE_URL; ?>" class="flex items-center">
						<img src="<?php echo BASE_URL; ?>/assets/svg/logo.svg" class="h-8" alt="">
					</a>
					<div class="items-center justify-between">
						<ul class="flex flex-row font-medium gap-6">
							<li>
								<a href="<?php echo BASE_URL; ?>" class="block py-2 mx-2 text-white">Home</a>
							</li>
							<li>
								<a href="<?php echo BASE_URL; ?>/products.html" class="block py-2 mx-2 text-white">Products</a>
							</li>
							<li>
								<a href="<?php echo BASE_URL; ?>/about.html" class="block py-2 mx-2 text-white">About Us</a>
							</li>
						</ul>
					</div>
					<div id="login_div">
						<a href="<?php echo BASE_URL; ?>/User/login" class="block py-2 mx-2 text-white">Sign In</a>
					</div>
				</div>
			</nav>
		</header>
		<main></main>
		<footer></footer>
	</body>
</html>
