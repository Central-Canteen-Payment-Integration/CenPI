document.addEventListener('DOMContentLoaded', function () {
    const dropdownButton = document.getElementById('dropdownButton');
    const dropdownMenu = document.getElementById('dropdownMenu');

    // Toggle dropdown saat tombol diklik
    dropdownButton.addEventListener('click', function () {
        dropdownMenu.classList.toggle('hidden');
    });

    // Menutup dropdown jika klik di luar elemen
    document.addEventListener('click', function (e) {
        if (!dropdownButton.contains(e.target) && !dropdownMenu.contains(e.target)) {
            dropdownMenu.classList.add('hidden');
        }
    });
});