<div class="min-h-screen bg-gray-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8 px-6">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <img class="mx-auto h-16 w-auto" src="<?= BASE_URL; ?>/assets/img/logo.svg" alt="logo cenpi">
        <h2 id="form-title" class="mt-6 text-center text-3xl leading-9 font-extrabold text-gray-900">
            Sign in to your account
        </h2>
        <p class="mt-2 text-center text-sm leading-5 text-red-500 max-w">
            Or
            <a href="#" id="toggle-register"
                class="font-medium text-red-500 hover:text-red-700 focus:outline-none focus:underline transition ease-in-out duration-150">
                Register your Tenant
            </a>
        </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
            <!-- Login Form -->
            <form id="login-form" method="POST" action="<?= BASE_URL; ?>/Tenant/login">
                <div>
                    <label for="username" class="block text-sm font-medium leading-5 text-gray-700">Username</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <input id="username" name="username" type="username" required=""
                            class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5">
                    </div>
                </div>

                <div class="mt-6">
                    <label for="password" class="block text-sm font-medium leading-5 text-gray-700">Password</label>
                    <div class="mt-1 rounded-md shadow-sm">
                        <input id="password" name="password" type="password" required=""
                            class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5">
                    </div>
                </div>

                <div class="mt-6 flex items-center justify-between">
                    <div class="text-sm leading-5">
                        <a href="#"
                            class="font-medium text-red-500 hover:text-red-700 focus:outline-none focus:underline transition ease-in-out duration-150">Forgot
                            your password?</a>
                    </div>
                </div>

                <div class="mt-6">
                    <span class="block w-full rounded-md shadow-sm">
                        <button type="submit"
                            class="w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-red-500 hover:bg-red-700 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-red-700 transition duration-150 ease-in-out">
                            Sign in
                        </button>
                    </span>
                </div>
            </form>

            <!-- Register Form -->
            <form id="register-form" class="hidden" method="POST" action="<?= BASE_URL; ?>/Tenant/register">
                <div class="flex flex-wrap -mx-2">
                    <!-- Username -->
                    <div class="w-full md:w-1/2 px-2">
                        <label for="username" class="block text-sm font-medium leading-5 text-gray-700">Username</label>
                        <div class="mt-1 rounded-md shadow-sm">
                            <input id="username" name="username" type="text" required=""
                                class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5">
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="w-full md:w-1/2 px-2 mt-4 md:mt-0">
                        <label for="email-register"
                            class="block text-sm font-medium leading-5 text-gray-700">Email</label>
                        <div class="mt-1 rounded-md shadow-sm">
                            <input id="email-register" name="email" type="email" required=""
                                class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5">
                        </div>
                    </div>
                </div>

                <div class="flex flex-wrap -mx-2 mt-4">
                    <!-- Password -->
                    <div class="w-full md:w-1/2 px-2">
                        <label for="password-register"
                            class="block text-sm font-medium leading-5 text-gray-700">Password</label>
                        <div class="mt-1 rounded-md shadow-sm">
                            <input id="password-register" name="password" type="password" required=""
                                class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5">
                        </div>
                    </div>

                    <!-- Nama Tenant -->
                    <div class="w-full md:w-1/2 px-2 mt-4 md:mt-0">
                        <label for="tenant-name" class="block text-sm font-medium leading-5 text-gray-700">Nama
                            Tenant</label>
                        <div class="mt-1 rounded-md shadow-sm">
                            <input id="tenant-name" name="tenant_name" type="text" required=""
                                class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5">
                        </div>
                    </div>
                </div>

                <div class="flex flex-wrap -mx-2 mt-4">
                    <!-- Location Tenant -->
                    <div class="w-full md:w-1/2 px-2">
                        <label for="tenant-location" class="block text-sm font-medium leading-5 text-gray-700">Location
                            Tenant</label>
                        <div class="mt-1 rounded-md shadow-sm">
                            <select id="tenant-location" name="tenant_location" required=""
                                class="block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5">
                                <option value="" disabled selected>Pilih Lokasi</option>
                                <option value="Kantin Bawah">Kantin Bawah</option>
                                <option value="Kantin Teknik">Kantin Teknik</option>
                            </select>
                        </div>
                    </div>

                    <!-- No Tenant -->
                    <div class="w-full md:w-1/2 px-2 mt-4 md:mt-0">
                        <label for="tenant-number" class="block text-sm font-medium leading-5 text-gray-700">No
                            Tenant</label>
                        <div class="mt-1 rounded-md shadow-sm">
                            <input id="tenant-number" name="tenant_number" type="number" required=""
                                class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5">
                        </div>
                    </div>
                </div>

                <div class="mt-6">
                    <span class="block w-full rounded-md shadow-sm">
                        <button type="submit"
                            class="w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-red-500 hover:bg-red-700 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-red-700 transition duration-150 ease-in-out">
                            Register
                        </button>
                    </span>
                </div>
            </form>


        </div>
    </div>
</div>

<script>
    const toggleRegister = document.getElementById('toggle-register');
    const loginForm = document.getElementById('login-form');
    const registerForm = document.getElementById('register-form');
    const formTitle = document.getElementById('form-title');

    toggleRegister.addEventListener('click', (e) => {
        e.preventDefault();
        if (registerForm.classList.contains('hidden')) {
            loginForm.classList.add('hidden');  
            registerForm.classList.remove('hidden');
            formTitle.textContent = "Register your tenant";
            toggleRegister.textContent = "Sign in to your account";
        } else {
            registerForm.classList.add('hidden');
            loginForm.classList.remove('hidden');
            formTitle.textContent = "Sign in to your account";
            toggleRegister.textContent = "Register your Tenant";
        }
    });

    document.addEventListener("DOMContentLoaded", () => {
        const errorMessage = "<?php echo addslashes($data['error']); ?>";

        console.log(errorMessage);

        if (errorMessage) {
            swalert('error', errorMessage);
            window.history.replaceState(null, null, '<?php echo BASE_URL; ?>/Tenant/login');
        }
    });
</script>