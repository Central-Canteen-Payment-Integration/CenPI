<!-- Body Section -->
<div class="flex items-center justify-center min-h-screen">
    <div class="relative w-full max-w-4xl bg-white rounded-3xl shadow-2xl p-10">
        <!-- Profile Image -->
        <div class="absolute -top-14 left-1/2 transform -translate-x-1/2">
            <div class="w-28 h-28 rounded-full p-1">
                <img src="<?= BASE_URL ?>/assets/img/logo.svg" alt="Profile Image"
                    class="w-full h-full fill-cover rounded-full bg-white">
            </div>
        </div>
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
        <?php if (!empty($data['error'])): ?>
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4">
                <?= htmlspecialchars($data['error']); ?>
            </div>
        <?php elseif (!empty($data['success'])): ?>
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4">
                <?= htmlspecialchars($data['success']); ?>
            </div>
        <?php endif; ?>
<form id="changePasswordForm" method="POST" action="/Tenant/settings">
    <!-- Current Password -->
    <div class="mb-4">
        <label for="currentPassword" class="block text-sm font-medium text-gray-700">Current Password</label>
        <input id="currentPassword" name="current_password" type="password" placeholder="Enter Current Password" required
            class="mt-1 p-3 w-full border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
        <p class="text-red-500 text-sm mt-1">
            <?= $data['current_password_error'] ?? '' ?>
        </p>
    </div>
    <!-- New Password -->
    <div class="mb-4">
        <label for="newPassword" class="block text-sm font-medium text-gray-700">New Password</label>
        <input id="newPassword" name="new_password" type="password" placeholder="Enter New Password" required
            class="mt-1 p-3 w-full border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
        <p class="text-red-500 text-sm mt-1">
            <?= $data['new_password_error'] ?? '' ?>
        </p>
    </div>
    <!-- Confirm New Password -->
    <div class="mb-4">
        <label for="confirmPassword" class="block text-sm font-medium text-gray-700">Confirm New Password</label>
        <input id="confirmPassword" name="confirm_password" type="password" placeholder="Confirm New Password" required
            class="mt-1 p-3 w-full border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
        <p class="text-red-500 text-sm mt-1">
            <?= $data['confirm_password_error'] ?? '' ?>
        </p>
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
    <!-- Success Message -->
    <?php if (!empty($data['success_message'])): ?>
        <div class="text-green-500 mt-4 text-sm">
            <?= $data['success_message'] ?>
        </div>
    <?php endif; ?>
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
</script>