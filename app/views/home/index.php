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
    <button id="orderButton" class="mt-6 py-2 px-6 bg-white text-red-500 font-semibold rounded-lg hover:bg-gray-200 transition">
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
