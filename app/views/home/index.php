<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CenPI</title>
  <link rel="stylesheet" href="<?= BASE_URL; ?>/assets/css/style.css">
  <style>
    .slider-text {
      opacity: 0;
      transform: translateY(-10px);
      transition: opacity 1s ease-in-out, transform 1s ease-in-out;
      position: absolute;
    }

    .slider-text.active {
      opacity: 1;
      transform: translateY(0);
    }
.btn-donate {
  --clr-font-main: hsla(0, 0%, 20%, 1);
  --btn-bg-1: hsla(0, 100%, 50%, 1); /* Merah terang */
  --btn-bg-2: hsla(0, 100%, 40%, 1); /* Warna bg-red-500 */
  --btn-bg-color: hsla(0, 100%, 95%, 1); /* Warna teks */
  --radii: 0.5em;
  cursor: pointer;
  padding: 0.9em 1.4em;
  min-width: 120px;
  min-height: 44px;
  font-size: var(--size, 1rem);
  font-weight: 500;
  transition: 0.8s;
  background-size: 280% auto;
  background-image: linear-gradient(
    325deg,
    var(--btn-bg-2) 0%,
    var(--btn-bg-1) 55%,
    var(--btn-bg-2) 90%
  );
  border: none;
  border-radius: var(--radii);
  color: var(--btn-bg-color);
  box-shadow:
    0px 0px 20px rgba(255, 71, 71, 0.5),
    0px 5px 5px -1px rgba(233, 58, 58, 0.25),
    inset 4px 4px 8px rgba(255, 175, 175, 0.5),
    inset -4px -4px 8px rgba(216, 19, 19, 0.35);
}

.btn-donate:hover {
  background-position: right top;
}

.btn-donate:is(:focus, :focus-visible, :active) {
  outline: none;
  box-shadow:
    0 0 0 3px var(--btn-bg-color),
    0 0 0 6px var(--btn-bg-2);
}

@media (prefers-reduced-motion: reduce) {
  .btn-donate {
    transition: linear;
  }
}


  </style>
</head>

<body class="bg-red-500 flex items-center justify-start pl-12 min-h-screen"> <!-- Menambahkan padding kiri dengan Tailwind -->
  <div class="text-left max-w-lg">
    <h1 class="text-5xl font-bold text-white mb-2">CenPI</h1>
    <div class="slider-container mb-6">
      <p id="slider1" class="slider-text active text-lg text-white">Seamless Canteen Payments at Your Fingertips</p>
      <p id="slider2" class="slider-text text-lg text-white">Bayar dengan Mudah dan Cepat</p>
      <p id="slider3" class="slider-text text-lg text-white">Pesan Makanan Praktis Online</p>
      <p id="slider4" class="slider-text text-lg text-white">Transaksi Kantin Tanpa Tunai</p>
    </div>
    <button id="orderButton" class="btn-donate mt-6 py-2 px-6 bg-white text-red-500 font-semibold rounded-lg hover:bg-gray-200 transition">
      Lets Make an Order
    </button>
  </div>

  <script>
    document.getElementById("orderButton").addEventListener("click", function() {
    window.location.href = "<?= BASE_URL; ?>/menu";
    });
    const texts = document.querySelectorAll(".slider-text");
    let currentIndex = 0;

    function changeText() {
      texts[currentIndex].classList.remove("active");
      currentIndex = (currentIndex + 1) % texts.length;
      texts[currentIndex].classList.add("active");
    }

    setInterval(changeText, 3000);
  </script>
</body>

</html>
