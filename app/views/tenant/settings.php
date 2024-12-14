<!-- Body Section -->
<div class="flex items-center justify-center min-h-screen">
    <div class="relative w-full max-w-4xl bg-white rounded-3xl shadow-2xl p-10">
        <!-- Profile Image -->
        <div class="absolute -top-14 left-1/2 transform -translate-x-1/2">
            <div class="w-28 h-28 rounded-full bg-red-500 p-1">
                <img src="https://via.placeholder.com/100" alt="Profile Image"
                    class="w-full h-full object-cover rounded-full bg-white">
            </div>
        </div>
        <!-- Profile Title -->
        <h1 class="text-3xl font-extrabold text-gray-800 text-center mt-16">
            <?= htmlspecialchars($data['tenant_name']); ?>
        </h1>
        <p class="text-center text-gray-500 text-sm mt-2">
            Welcome to your dashboard
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
                class="px-6 py-3 bg-blue-500 text-white text-sm font-semibold rounded-lg shadow hover:bg-blue-600 transition">
                Update Profile
            </button>
        </div>
    </div>
</div>

<!-- Modal Section -->
<div id="modal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-white w-full max-w-lg rounded-lg shadow-lg p-8">
        <h2 class="text-2xl font-bold text-gray-700 mb-6">Edit Profile</h2>
        <form id="editProfileForm">
            <!-- Upload Image -->
            <div class="mb-4">
                <label for="profileImage" class="block text-sm font-medium text-gray-700">Profile Image</label>
                <input id="profileImage" type="file" accept="image/*"
                    class="mt-1 w-full border rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <!-- Nama Tenant -->
            <div class="mb-4">
                <label for="tenantName" class="block text-sm font-medium text-gray-700">Nama Tenant</label>
                <input id="tenantName" type="text" placeholder="Masukkan Nama Tenant"
                    class="mt-1 p-3 w-full border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <!-- Current Password -->
            <div class="mb-4">
                <label for="currentPassword" class="block text-sm font-medium text-gray-700">Current Password</label>
                <input id="currentPassword" type="password" placeholder="Masukkan Password Saat Ini"
                    class="mt-1 p-3 w-full border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <!-- New Password -->
            <div class="mb-4">
                <label for="newPassword" class="block text-sm font-medium text-gray-700">New Password</label>
                <input id="newPassword" type="password" placeholder="Masukkan Password Baru"
                    class="mt-1 p-3 w-full border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <!-- Confirm New Password -->
            <div class="mb-6">
                <label for="confirmPassword" class="block text-sm font-medium text-gray-700">Confirm New Password</label>
                <input id="confirmPassword" type="password" placeholder="Konfirmasi Password Baru"
                    class="mt-1 p-3 w-full border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <!-- Buttons -->
            <div class="flex justify-end space-x-4">
                <button type="button" id="closeModalBtn"
                    class="px-4 py-2 bg-gray-300 rounded-lg hover:bg-gray-400 transition">Cancel</button>
                <button type="submit"
                    class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">Save</button>
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

    // Open Modal
    openModalBtn.addEventListener('click', () => {
        modal.classList.remove('hidden');
    });

    // Close Modal
    closeModalBtn.addEventListener('click', () => {
        modal.classList.add('hidden');
    });

    // Handle Form Submit
    editProfileForm.addEventListener('submit', (e) => {
        e.preventDefault();
        const tenantName = document.getElementById('tenantName').value;
        const currentPassword = document.getElementById('currentPassword').value;
        const newPassword = document.getElementById('newPassword').value;
        const confirmPassword = document.getElementById('confirmPassword').value;

        if (newPassword !== confirmPassword) {
            alert("New Password and Confirm New Password do not match!");
            return;
        }

        alert(`Profile Updated!\nNama Tenant: ${tenantName}\nCurrent Password: ${currentPassword}`);
        modal.classList.add('hidden');
    });
</script>
