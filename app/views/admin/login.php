<div class="flex justify-center items-center h-screen">
  <div class="xl:w-[700px] px-10 h-[400px] rounded-3xl xl:shadow-xl">
    <h1 class="text-center text-3xl font-bold mt-2 mb-2">Login</h1>
    <hr>
    <div class="flex justify-center mt-10">
      <form action="<?= BASE_URL; ?>/Admin/login" method="POST">
        <!-- Username Input -->
        <input type="text" name="username" id="username" class="py-3 p-5 rounded-md bg-zinc-50 md:w-[500px] w-[300px] outline-indigo-400" placeholder="Enter your username" required>
        <br><br>
        
        <!-- Password Input -->
        <input type="password" name="password" id="password" class="py-3 p-5 rounded-md bg-zinc-50 md:w-[500px] w-[300px] outline-indigo-400" placeholder="Enter your password" required>

        <!-- Invalid Username/Password Error -->
        <?php if (!empty($data['error'])): ?>
            <div class="text-red-500 text-sm mt-2"><?= $data['error']; ?></div>
        <?php endif; ?>

        <!-- Submit Button -->
        <button type="submit" class="py-3 bg-indigo-400 text-white w-full rounded-md font-bold">Login</button>
      </form>
    </div>
  </div>
</div>
