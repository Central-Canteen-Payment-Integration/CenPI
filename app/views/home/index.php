<div class="flex flex-wrap gap-5 justify-center">
    <div class="flex flex-wrap justify-center gap-5">
        <?php if (!empty($data['menus'])): ?>
            <?php foreach ($data['menus'] as $menu): ?>
                <div class="w-full max-w-xs bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 mt-5">
                    <a href="#">
                        <img class="p-8 rounded-t-lg" src="<?php echo BASE_URL; ?>/assets/img/images.png">
                    </a>
                    <div class="px-5 pb-5">
                        <a href="#">
                            <h5 class="text-xl font-semibold tracking-tight text-gray-900 dark:text-white">
                                <?php echo htmlspecialchars($menu['NAMA_MENU']); ?>
                            </h5>
                        </a>
                        <div class="flex items-center mt-2.5 mb-5">
                            <p class="text-sm text-gray-600 dark:text-gray-400"><?php echo htmlspecialchars($menu['NAMA_MENU']); ?></p>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-3xl font-bold text-gray-900 dark:text-white">
                                $<?php echo number_format($menu['HARGA'], 2); ?>
                            </span>
                            <a href="#" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                Add to cart
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-center text-gray-500 dark:text-gray-400">No items available.</p>
        <?php endif; ?>
    </div>
</div>






