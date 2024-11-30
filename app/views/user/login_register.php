<div class="fixed z-50 top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full rounded-md px-8 py-6 space-y-5 drop-shadow-lg">
    <link rel="stylesheet" href="<?= BASE_URL; ?>/assets/css/global.css">
    <link rel="stylesheet" href="<?= BASE_URL; ?>/assets/css/style.css">
    <main class="flex justify-center <?= ($data['page'] === 'register') ? 'sign-up-mode' : ''; ?>">
        <div class="box">
            <div class="inner-box">
                <div class="forms-wrap">
                    <form id="login_form" class="form_sign sign-in-form" method="POST" action="<?= BASE_URL; ?>/User/login">
                        <div class="logo">
                            <img src="<?= BASE_URL; ?>/assets/svg/logo_blue.png" alt="" />
                        </div>
                        <div class="heading_login">
                            <h2>Welcome Back</h2>
                            <h6>Not registered yet?</h6>
                            <a href="#" class="toggle_login">Sign up</a>
                        </div>
                        <div class="actual-form">
                            <div class="input-wrap">
                                <input type="text" name="username" class="input-field" autocomplete="off" required />
                                <label>Username</label>
                            </div>
                            <div class="input-wrap">
                                <input type="password" name="password" class="input-field" autocomplete="off" required />
                                <label>Password</label>
                            </div>
                            <button type="submit" class="w-full text-white bg-gray-900 hover:bg-[#37B7C3] font-medium rounded-lg text-sm px-5 py-2.5 text-center mb-4">
                                Sign In
                            </button>
                            <p>Forgotten your password? <a href="#">Get help</a></p>
                        </div>
                    </form>
                    <!-- REGISTER -->
                    <form id="register_form" class="form_sign sign-up-form" method="POST" action="<?= BASE_URL; ?>/User/register">
                        <div class="logo">
                            <img src="<?= BASE_URL; ?>/assets/svg/logo_blue.png" alt="" />
                        </div>
                        <div class="heading_login">
                            <h2>Get Started</h2>
                            <h6>Already have an account?</h6>
                            <a href="#" class="toggle_login">Sign in</a>
                        </div>
                        <div class="actual-form">
                            <div class="input-wrap">
                                <input type="text" name="username" class="input-field" autocomplete="off" required />
                                <label>Username</label>
                            </div>
                            <div class="input-wrap">
                                <input type="email" name="email" class="input-field" autocomplete="off" required />
                                <label>Email</label>
                            </div>
                            <div class="input-wrap">
                                <input type="password" name="password" class="input-field" autocomplete="off" required />
                                <label>Password</label>
                            </div>
                            <button type="submit" class="w-full text-white bg-gray-900 hover:bg-[#37B7C3] font-medium rounded-lg text-sm px-5 py-2.5 text-center mb-4">
                                Register
                            </button>
                            <p>By signing up, you agree to our <a href="#">Terms</a> and <a href="#">Privacy Policy</a>.</p>
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
                                <h2>Bayar dengan Mudah dan Cepat</h2>
                                <h2>Pesan Makanan Praktis Online</h2>
                                <h2>Transaksi Kantin Tanpa Tunai</h2>
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

    document.addEventListener("DOMContentLoaded", () => {
        const mainEle = document.querySelector("main");
        const toggleLoginBtns = document.querySelectorAll(".toggle_login");

        toggleLoginBtns.forEach((btn) => {
            btn.addEventListener("click", (event) => {
                event.preventDefault();
                const currentURL = window.location.href;
                const isRegisterMode = mainEle.classList.contains("sign-up-mode");

                if (isRegisterMode) {
                    mainEle.classList.remove("sign-up-mode");
                    const newURL = currentURL.replace(/\/register/, "/login");
                    history.pushState(null, null, newURL);
                } else {
                    mainEle.classList.add("sign-up-mode");
                    const newURL = currentURL.replace(/\/login/, "/register");
                    history.pushState(null, null, newURL);
                }
            });
        });
    });
</script>