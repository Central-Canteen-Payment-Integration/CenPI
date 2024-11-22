<div class="flex flex-wrap gap-5 justify-center">
    <div class="flex flex-wrap justify-center gap-5">
        <?php if (!empty($data['menus'])): ?>
            <?php foreach ($data['menus'] as $menu): ?>
                <div class="card card-compact bg-base-100 w-64 shadow-xl">
                    <figure>
                        <img
                        src="https://img.daisyui.com/images/stock/photo-1606107557195-0e29a4b5b4aa.webp"
                        alt="FnBImages" />
                    </figure>
                    <div class="card-body">
                        <h2 class="card-title"><?php echo htmlspecialchars($menu['NAMA_MENU']); ?></h2>
                        <div class="flex justify-between items-center">
                            <div class="text-lg font-bold">
                                $<?php echo number_format($menu['HARGA'], 2); ?>
                            </div>
                            <button class="btn btn-primary">Buy Now</button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-center text-gray-500 dark:text-gray-400">No items available.</p>
        <?php endif; ?>
    </div>
</div>