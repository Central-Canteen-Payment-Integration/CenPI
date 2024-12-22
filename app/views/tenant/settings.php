<!-- Body Section -->
<div class="flex items-center justify-center min-h-screen">
    <div class="relative w-full max-w-4xl bg-white rounded-3xl shadow-2xl p-10">
        <!-- Profile Title -->
        <h1 class="text-3xl font-extrabold text-gray-800 text-center mt-16">
            <?= htmlspecialchars($data['tenant_name']); ?>
        </h1>
        <p class="text-center text-gray-500 text-sm mt-2">
            Welcome to your profile
        </p>
        <!-- Profile Details -->
        <div class="mt-10 grid grid-cols-2 gap-6">
            <div class="bg-gray-100 p-6 rounded-lg shadow-sm">
                <p class="font-medium text-gray-500">Username</p>
                <p class="text-gray-900 text-lg font-semibold">
                    <?= htmlspecialchars($data['username']); ?>
                </p>
            </div>
            <div class="bg-gray-100 p-6 rounded-lg shadow-sm">
                <p class="font-medium text-gray-500">Email</p>
                <p class="text-gray-900 text-lg font-semibold">
                    <?= htmlspecialchars($data['email']); ?>
                </p>
            </div>
            <div class="bg-gray-100 p-6 rounded-lg shadow-sm">
                <p class="font-medium text-gray-500">Location Name</p>
                <p class="text-gray-900 text-lg font-semibold">
                    <?= htmlspecialchars($data['location_name']); ?>
                </p>
            </div>
            <div class="bg-gray-100 p-6 rounded-lg shadow-sm">
                <p class="font-medium text-gray-500">Location Booth</p>
                <p class="text-gray-900 text-lg font-semibold">
                    <?= htmlspecialchars($data['location_booth']); ?>
                </p>
            </div>
        </div>
        <!-- Update Button -->
        <div class="mt-8 text-center">
            <button id="openModalBtn"
                class="px-6 py-3 bg-red-500 text-white text-sm font-semibold rounded-lg shadow hover:bg-red-600 transition">
                Changes Password
            </button>
        </div>
    </div>
</div>

<!-- Modal Section -->
<div id="modal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-white w-full max-w-lg rounded-lg shadow-lg p-8">
        <h2 class="text-2xl font-bold text-gray-700 mb-6">Edit Profile</h2>
<form id="changePasswordForm" method="POST" action="/Tenant/settings">
    <!-- Current Password -->
    <div class="mb-4">
        <label for="currentPassword" class="block text-sm font-medium text-gray-700">Current Password</label>
        <input id="currentPassword" name="current_password" type="password" placeholder="Enter Current Password" required
            class="mt-1 p-3 w-full border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
    </div>
    <!-- New Password -->
    <div class="mb-4">
        <label for="newPassword" class="block text-sm font-medium text-gray-700">New Password</label>
        <input id="newPassword" name="new_password" type="password" placeholder="Enter New Password" required
            class="mt-1 p-3 w-full border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
    </div>
    <!-- Confirm New Password -->
    <div class="mb-4">
        <label for="confirmPassword" class="block text-sm font-medium text-gray-700">Confirm New Password</label>
        <input id="confirmPassword" name="confirm_password" type="password" placeholder="Confirm New Password" required
            class="mt-1 p-3 w-full border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
    </div>
    <!-- Submit Button -->
    <div class="flex justify-end space-x-4">
        <button type="button" id="closeModalBtn"
            class="px-6 py-3 bg-gray-500 text-white text-sm font-semibold rounded-lg shadow hover:bg-gray-600 transition">
            Cancel
        </button>
        <button type="submit"
            class="px-6 py-3 bg-blue-500 text-white text-sm font-semibold rounded-lg shadow hover:bg-blue-600 transition">
            Save Changes
        </button>
    </div>
</form>


    </div>
</div>


<!-- JavaScript -->
<script>
    const modal = document.getElementById('modal');
    const openModalBtn = document.getElementById('openModalBtn');
    const closeModalBtn = document.getElementById('closeModalBtn');
    const editProfileForm = document.getElementById('editProfileForm');

    openModalBtn.addEventListener('click', () => {
        modal.classList.remove('hidden');
    });

    closeModalBtn.addEventListener('click', () => {
        modal.classList.add('hidden');
    });

    document.addEventListener("DOMContentLoaded", () => {
        const errorMessage = "<?php echo isset($data['error']) ? addslashes($data['error']) : ''; ?>";
        const message = "<?php echo isset($data['message']) ? addslashes($data['message']) : ''; ?>";

        if (errorMessage) {
            swalert('error', errorMessage, {timer: 2500});
        } else if (message) {
            swalert('info', message, {timer: 2500});
        }
    });
</script>