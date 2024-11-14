<div id="dialog" class="fixed z-50 top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full rounded-md px-8 py-6 space-y-5 drop-shadow-lg">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/global.css">
<link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/style.css">
    <main class="flex justify-center">
        <div class="box">
            <div class="top w-full flex ms-[-1.5rem] mt-7 lg:mb-0 lg:ms-1 lg:mt-[-40px]">
                <button id="close" class="lg:end-2.5 text-gray-300 lg:text-white bg-transparentrounded-lg text-sm w-5 h-5 lg:w-8 lg:h-8 ms-auto inline-flex justify-center items-center">
                    <svg class="w-8 h-8" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <div class="inner-box">
                <div class="forms-wrap">
                <form id="login_form" class="form_sign sign-in-form" method="POST" action="<?php echo BASE_URL; ?>/home/login">
                    <div class="logo">
                        <img src="<?php echo BASE_URL; ?>/assets/svg/logo_blue.png" alt="" />
                    </div>
                    <div class="heading_login">
                        <h2>Welcome Back</h2>
                        <h6>Not registered yet?</h6>
                        <a href="#" class="toggle_login">Sign up</a>
                    </div>
                    <div class="actual-form">
                        <div class="input-wrap">
                            <input type="username" name="username" id="username" class="input-field" autocomplete="off" required />
                            <label>Username</label>
                        </div>
                        <div class="input-wrap">
                            <input type="password" name="password" id="password" class="input-field" autocomplete="off" required />
                            <label>Password</label>
                        </div>
                        <button id="submit" type="submit" class="w-full text-white bg-gray-900 hover:bg-[#37B7C3] font-medium rounded-lg text-sm px-5 py-2.5 text-center mb-4">Sign In</button>
                        <p class="text"> Forgotten your password or your login details? <a href="#">Get help</a> signing in </p>
                    </div>
                </form>
                    <!-- REGISTERR -->
                    <form onsubmit="handleRegister(event)" class="form_sign sign-up-form">
                        <div class="logo">
                            <img src="<?php echo BASE_URL; ?>/assets/svg/logo_blue.png" alt="" />
                        </div>
                        <div class="heading_login">
                            <h2>Get Started</h2>
                            <h6>Already have an account?</h6>
                            <a href="#" class="toggle_login">Sign in</a>
                        </div>
                        <div class="actual-form">
                            <div class="input-wrap">
                                <input type="username" name="username" id="username-register" minlength="4" class="input-field" autocomplete="off" required />
                                <label>Username</label>
                            </div>
                            <div class="input-wrap">
                                <input type="email" id="email-register" class="input-field" autocomplete="off" required />
                                <label>Email</label>
                            </div>
                            <div class="input-wrap">
                                <input type="password" id="password-register" minlength="4" class="input-field" autocomplete="off" required />
                                <label>Password</label>
                            </div>
                            <button id="submit" type="submit" class="w-full text-white bg-gray-900 hover:bg-[#37B7C3] font-medium rounded-lg text-sm px-5 py-2.5 text-center mb-4">Register</button>
                            <p class="text"> By signing up, I agree to the <a href="#">Terms of Services</a> and <a href="#">Privacy Policy</a>
                            </p>
                        </div>
                    </form>
                </div>
                <div class="carousel_login">
                    <div class="images-wrapper">
                        <img src="" class="image img-1 show" alt="" />
                        <img src="" class="image img-2" alt="" />
                        <img src="" class="image img-3" alt="" />
                    </div>
                    <div class="text-slider">
                        <div class="text-wrap">
                            <div class="text-group">
                                <h2>Create your own courses</h2>
                                <h2>Customize as you like</h2>
                                <h2>Invite students to your class</h2>
                            </div>
                        </div>
                        <div class="bullets">
                            <span class="active" data-value="1"></span>
                            <span data-value="2"></span>
                            <span data-value="3"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<script>

    const inputs = document.querySelectorAll(".input-field");
    const toggle_login_btn = document.querySelectorAll(".toggle_login");
    const mainEle = document.querySelector("main");
    const bullets = document.querySelectorAll(".bullets span");
    const images = document.querySelectorAll(".image");
    inputs.forEach((inp) => {
        inp.addEventListener("focus", () => {
            inp.classList.add("active");
        });
        inp.addEventListener("blur", () => {
            if (inp.value != "") return;
            inp.classList.remove("active");
        });
    });
    toggle_login_btn.forEach((btn) => {
        btn.addEventListener("click", () => {
            mainEle.classList.toggle("sign-up-mode");
            inputs.forEach((cb) => {
                cb.value = "";
            });
        });
    });

    function moveSlider() {
        let index = this.dataset.value;
        let currentImage = document.querySelector(`.img-${index}`);
        images.forEach((img) => img.classList.remove("show"));
        currentImage.classList.add("show");
        const textSlider = document.querySelector(".text-group");
        textSlider.style.transform = `translateY(${-(index - 1) * 2.2}rem)`;
        bullets.forEach((bull) => bull.classList.remove("active"));
        this.classList.add("active");
        inputs.forEach((cb) => {
            cb.value = "";
        });
    }
    bullets.forEach((bullet) => {
        bullet.addEventListener("click", moveSlider);
    });
    document.addEventListener("DOMContentLoaded", function() {
        const dropdownUserBtn = document.getElementById("dropdownUserBtn");
        const dropdownUser = document.getElementById("dropdownUser");
        dropdownUserBtn.addEventListener("mouseenter", () => {
            dropdownUser.classList.remove("hidden");
        });
        dropdownUserBtn.addEventListener("mouseleave", () => {
            setTimeout(() => {
                if (!dropdownUser.matches(":hover")) {
                    dropdownUser.classList.add("hidden");
                }
            }, 100);
        });
        dropdownUser.addEventListener("mouseleave", () => {
            dropdownUser.classList.add("hidden");
        });
        dropdownUser.addEventListener("mouseenter", () => {
            dropdownUser.classList.remove("hidden");
        });
    });

    loginDialog();
</script>