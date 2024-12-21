<head>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<div class="flex flex-col justify-center items-center min-h-screen space-y-8">
    <div class="text-center text-4xl font-bold text-orange-500 font-serif mb-5">
        <p>Your Orders Are Going To Be Processed!</p>
        <p>But First...</p>
    </div>

    <div class="relative flex justify-center items-center">
        <div class="absolute animate-spin rounded-full h-32 w-32 border-t-4 border-b-4 border-purple-500 z-10"></div>
        <img src="https://www.svgrepo.com/show/509001/avatar-thinking-9.svg" class="rounded-full h-28 w-28 z-0">
    </div>

    <button class="btn" onclick="my_modal_2.showModal()">What Should I do Next?</button>
</div>

<!-- Modal -->
<dialog id="my_modal_2" class="modal">
    <div class="modal-box">
        <!-- Page 1 of the modal -->
        <div id="page1" class="page">
            <h3 class="text-lg font-bold">Go To The Admin!</h3>
            <p class="py-4">First You Need To Go To The Admin To Confirm Your Purchase.</p>
            <button class="btn" onclick="showPage('page2')">Next</button>
        </div>

        <!-- Page 2 of the modal -->
        <div id="page2" class="page hidden">
            <h3 class="text-lg font-bold">Show Them Your Unique Code!</h3>
            <?php
            if (isset($_SESSION['user']['id'])) {
                $userId = $_SESSION['user']['id'];
                echo "<p class='py-4' style='font-size: 2rem; font-family: \"Courier New\", monospace; color: #ff6600; font-weight: bold;'>" . substr($userId, 0, 6) . "</p>";
            } else {
                echo "<p class='py-4'>User ID is not available</p>";
            }
            ?>
            <p class="py-4">This is Your Unique Code Show It To the Admin! </p>
            <button class="btn" onclick="showPage('page3')">Next</button>
            <button class="btn" onclick="showPage('page1')">Back</button>
        </div>

        <!-- Page 3 of the modal -->
        <div id="page3" class="page hidden">
            <h3 class="text-lg font-bold">Pay Up!</h3>
            <p class="py-4">Pay For Your Food To the Admins By Using Cash.</p>
            <button class="btn" onclick="showPage('page4')">Next</button>
            <button class="btn" onclick="showPage('page2')">Back</button>
        </div>

        <!-- Page 4 of the modal -->
        <div id="page4" class="page hidden">
            <h3 class="text-lg font-bold">Wait For Your Food</h3>
            <p class="py-4">The Tenant Will Be preparing Your Food.</p>
            <button class="btn" onclick="closeModal()">Close</button>
            <button class="btn" onclick="showPage('page3')">Back</button>
        </div>
    </div>
    <form method="dialog" class="modal-backdrop">
        <button>Close</button>
    </form>
</dialog>



<script>
    function showPage(pageId) {
        const pages = document.querySelectorAll('.page');
        pages.forEach(page => page.classList.add('hidden'));

        const selectedPage = document.getElementById(pageId);
        selectedPage.classList.remove('hidden');
    }

    function closeModal() {
        const modal = document.getElementById('my_modal_2');
        modal.close();
    }

    function checkTransactionStatus() {
        fetch('/Checkout/checkTransactionStatus')
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success' && data.trx_status === 'Completed') {
                    window.location.href = '/user/order';
                }
            })
            .catch(error => console.error('Error checking transaction status:', error));
    }
    setInterval(checkTransactionStatus, 5000);
</script>