<link rel="stylesheet" href="<?= BASE_URL; ?>/assets/css/global.css">
<link rel="stylesheet" href="<?= BASE_URL; ?>/assets/css/style.css">
<div class="min-h-screen bg-gray-100 py-6 flex flex-col justify-center sm:py-12">
  <div class="relative py-3 sm:max-w-xl sm:mx-auto">
    <div
      class="absolute inset-0 bg-gradient-to-r from-cyan-400 to-sky-500 shadow-lg transform -skew-y-6 sm:skew-y-0 sm:-rotate-6 sm:rounded-3xl">
    </div>
    <form class="relative px-4 py-10 bg-white shadow-lg sm:rounded-3xl sm:p-20" id="login_form" method="POST" action="<?= BASE_URL; ?>/User/login">
      <div class="max-w-md mx-auto">
        <div>
            <h1 class="text-2xl font-semibold">Login</h1>
        </div>
        <div class="divide-y divide-gray-200">
          <div class="py-8 text-base leading-6 space-y-4 text-gray-700 sm:text-lg sm:leading-7">
            <div class="relative">
              <input autocomplete="off" id="username" name="username" type="text" class="peer placeholder-transparent h-10 w-full border-b-2 border-gray-300 text-gray-900 focus:outline-none focus:borer-rose-600" placeholder="Username" />
              <label for="username" class="absolute left-0 -top-3.5 text-gray-600 text-sm peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-440 peer-placeholder-shown:top-2 transition-all peer-focus:-top-3.5 peer-focus:text-gray-600 peer-focus:text-sm">Username</label>
            </div>
            <div class="relative">
              <input autocomplete="off" id="password" name="password" type="password" class="peer placeholder-transparent h-10 w-full border-b-2 border-gray-300 text-gray-900 focus:outline-none focus:borer-rose-600" placeholder="Password" />
              <label for="password" class="absolute left-0 -top-3.5 text-gray-600 text-sm peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-440 peer-placeholder-shown:top-2 transition-all peer-focus:-top-3.5 peer-focus:text-gray-600 peer-focus:text-sm">Password</label>
            </div>
            <div class="cf-turnstile" data-sitekey="0x4AAAAAAA1fPhlo9NVYdMtn" data-callback="onTurnstileComplete"></div>
            <input type="hidden" name="turnstile_response" id="turnstile_response">
            <div class="relative">
              <button class="bg-cyan-500  w-full text-white rounded-md px-2 py-1">Submit</button>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>

<script
    src="https://challenges.cloudflare.com/turnstile/v0/api.js?onload=onloadTurnstileCallback"
    defer
></script>

<script>
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
    });

    function onTurnstileComplete(token) {
        document.getElementById('turnstile_response').value = token;
    }
</script>