<div class="flex flex-col justify-center translate-y-8">
  <div class="relative sm:max-w-xl sm:mx-auto">
    <div 
      class="absolute inset-0 bg-gradient-to-r from-cyan-400 to-sky-500 shadow-lg transform -skew-y-6 sm:skew-y-0 sm:-rotate-6 sm:rounded-3xl">
    </div>
    <form class="relative px-4 py-10 bg-white shadow-lg sm:rounded-3xl sm:p-20 swap-card" id="login_form" method="POST" action="<?= BASE_URL; ?>/User/login">
      <div class="max-w-md mx-auto">
        <div>
          <h1 class="text-2xl font-semibold sm:text-3xl">Login</h1>
        </div>
        <div class="divide-y divide-gray-200">
          <div class="py-8 text-base leading-6 space-y-4 text-gray-700 sm:text-lg sm:leading-7">
            <div class="relative">
              <input autocomplete="off" id="username" name="username" type="text" class="peer placeholder-transparent h-10 w-full border-b-2 border-gray-300 text-gray-900 focus:outline-none focus:border-rose-600" placeholder="Username" />
              <label for="username" class="absolute left-0 -top-3.5 text-gray-600 text-sm peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-440 peer-placeholder-shown:top-2 transition-all peer-focus:-top-3.5 peer-focus:text-gray-600 peer-focus:text-sm">Username</label>
            </div>
            <div class="relative">
              <input autocomplete="off" id="password" name="password" type="password" class="peer placeholder-transparent h-10 w-full border-b-2 border-gray-300 text-gray-900 focus:outline-none focus:border-rose-600" placeholder="Password" />
              <label for="password" class="absolute left-0 -top-3.5 text-gray-600 text-sm peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-440 peer-placeholder-shown:top-2 transition-all peer-focus:-top-3.5 peer-focus:text-gray-600 peer-focus:text-sm">Password</label>
            </div>
            <div class="cf-turnstile" data-sitekey="0x4AAAAAAA1fPhlo9NVYdMtn" data-callback="onTurnstileComplete"></div>
            <input type="hidden" name="turnstile_response" id="turnstile_response">
            <div class="relative">
              <button class="bg-cyan-500 w-full text-white rounded-md px-2 py-1">Submit</button>
            </div>
          </div>
        </div>
        <p class="text-center mt-4 text-sm text-gray-600">
          Belum punya akun? <a href="#" class="text-cyan-500 font-semibold swap-link">Klik disini</a>
        </p>
      </div>
    </form>

    <!-- Register Form -->
    <form class="relative px-4 py-10 bg-white shadow-lg sm:rounded-3xl sm:p-20 hidden swap-card" id="register_form" method="POST" action="<?= BASE_URL; ?>/User/register">
      <div class="max-w-md mx-auto">
        <div>
          <h1 class="text-2xl font-semibold sm:text-3xl">Register</h1>
        </div>
        <div class="divide-y divide-gray-200">
          <div class="py-8 text-base leading-6 space-y-4 text-gray-700 sm:text-lg sm:leading-7">
            <div class="relative">
              <input autocomplete="off" id="reg_username" name="username" type="text" class="peer placeholder-transparent h-10 w-full border-b-2 border-gray-300 text-gray-900 focus:outline-none focus:border-rose-600" placeholder="Username" />
              <label for="reg_username" class="absolute left-0 -top-3.5 text-gray-600 text-sm peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-440 peer-placeholder-shown:top-2 transition-all peer-focus:-top-3.5 peer-focus:text-gray-600 peer-focus:text-sm">Username</label>
            </div>
            <div class="relative">
              <input autocomplete="off" id="email" name="email" type="email" class="peer placeholder-transparent h-10 w-full border-b-2 border-gray-300 text-gray-900 focus:outline-none focus:border-rose-600" placeholder="Email" />
              <label for="email" class="absolute left-0 -top-3.5 text-gray-600 text-sm peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-440 peer-placeholder-shown:top-2 transition-all peer-focus:-top-3.5 peer-focus:text-gray-600 peer-focus:text-sm">Email</label>
            </div>
            <div class="relative">
              <input autocomplete="off" id="reg_password" name="password" type="password" class="peer placeholder-transparent h-10 w-full border-b-2 border-gray-300 text-gray-900 focus:outline-none focus:border-rose-600" placeholder="Password" />
              <label for="reg_password" class="absolute left-0 -top-3.5 text-gray-600 text-sm peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-440 peer-placeholder-shown:top-2 transition-all peer-focus:-top-3.5 peer-focus:text-gray-600 peer-focus:text-sm">Password</label>
            </div>
            <div class="relative">
              <button class="bg-cyan-500 w-full text-white rounded-md px-2 py-1">Register</button>
            </div>
          </div>
        </div>
        <p class="text-center mt-4 text-sm text-gray-600">
          Sudah punya akun? <a href="#" class="text-cyan-500 font-semibold swap-link">Login disini</a>
        </p>
      </div>
    </form>
  </div>
</div>

<script
    src="https://challenges.cloudflare.com/turnstile/v0/api.js?onload=onloadTurnstileCallback"
    defer
></script>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const swapLinks = document.querySelectorAll('.swap-link');
        const swapCards = document.querySelectorAll('.swap-card');

        swapLinks.forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                swapCards.forEach(card => card.classList.toggle('hidden'));
            });
        });
    });

    document.addEventListener("DOMContentLoaded", () => {
        const loginForm = document.getElementById("login_form");

        function checkTurnstileResponse(form) {
            const turnstileResponse = document.getElementById('turnstile_response').value;
            return turnstileResponse !== "";
        }

        loginForm.addEventListener("submit", (event) => {
            if (!checkTurnstileResponse(loginForm)) {
                event.preventDefault();
                alert("Please complete the captcha verification.");
            }
        });

        const errorMessage = "<?php echo addslashes($data['error']); ?>";

        if (errorMessage) {
            swalert('error', errorMessage);
        }
    });

    function onTurnstileComplete(token) {
        document.getElementById('turnstile_response').value = token;
    }
</script>
