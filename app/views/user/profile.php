<div class="bg-base-100 flex justify-center p-4">
    <div class="font-std w-full max-w-4xl rounded-xl bg-white p-10 shadow-2xl border-2 border-neutral">
        <div class="flex flex-col">
            <!-- Title and Profile Picture -->
            <div class="flex flex-col md:flex-row justify-between mb-8 items-start">
                <h2 class="mb-5 text-4xl font-extrabold text-primary md:mb-0">My Profile</h2>
            </div>

            <!-- Feedback Messages -->
            <?php if (isset($_SESSION['success'])): ?>
                <div class="p-4 mb-6 text-sm text-white bg-accent rounded-lg">
                    <?= $_SESSION['success'];
                    unset($_SESSION['success']); ?>
                </div>
            <?php elseif (isset($_SESSION['error'])): ?>
                <div class="p-4 mb-6 text-sm text-white bg-primary rounded-lg">
                    <?= $_SESSION['error'];
                    unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>

            <!-- Form -->
            <form id="profileForm" class="space-y-6" method="POST" action="<?= BASE_URL ?>/User/profile">
                <div>
                    <label for="name" class="block text-sm font-semibold text-secondary">Name</label>
                    <input type="text" id="name" name="username" class="w-full px-4 py-2 border-2 border-neutral rounded-lg focus:outline-none focus:ring focus:ring-accent"
                        value="<?= htmlspecialchars($data['username']); ?>" readonly>
                </div>
                <div>
                    <label for="birthdate" class="block text-sm font-semibold text-secondary">Birthdate</label>
                    <input type="date" id="birthdate" name="birthdate" class="w-full px-4 py-2 border-2 border-neutral rounded-lg focus:outline-none focus:ring focus:ring-accent"
                        value="<?= htmlspecialchars($data['birthday'] ?? ''); ?>" readonly>
                </div>
                <div>
                    <label for="phone" class="block text-sm font-semibold text-secondary">Phone</label>
                    <input type="tel" id="phone" name="phone_number" class="w-full px-4 py-2 border-2 border-neutral rounded-lg focus:outline-none focus:ring focus:ring-accent"
                        value="<?= htmlspecialchars($data['phone_number'] ?? ''); ?>" readonly>
                </div>
                <div>
                    <label for="email" class="block text-sm font-semibold text-secondary">Email</label>
                    <input type="email" id="email" class="w-full px-4 py-2 border-2 border-neutral rounded-lg bg-gray-100 focus:outline-none" value="<?= htmlspecialchars($data['email']); ?>" readonly>
                </div>
                <div id="editFields" class="hidden">
                <div>
                    <label for="currentPassword" class="block text-sm font-semibold text-secondary">Current Password</label>
                    <input type="password" id="currentPassword" name="currentPassword" class="w-full px-4 py-2 border-2 border-neutral rounded-lg focus:outline-none focus:ring focus:ring-accent"readonly>
                </div>
                    <div>
                        <label for="newPassword" class="block text-sm font-semibold text-secondary">New Password</label>
                        <input type="password" id="newPassword" name="newPassword" class="w-full px-4 py-2 border-2 border-neutral rounded-lg focus:outline-none focus:ring focus:ring-accent"readonly>
                    </div>
                    <div>
                        <label for="confirmNewPassword" class="block text-sm font-semibold text-secondary">Confirm New Password</label>
                        <input type="password" id="confirmNewPassword" name="confirmNewPassword" class="w-full px-4 py-2 border-2 border-neutral rounded-lg focus:outline-none focus:ring focus:ring-accent"readonly>
                    </div>
                </div>
                <div class="flex justify-end space-x-4">
                    <button id="editButton" type="button" class="px-6 py-2 bg-primary text-white font-semibold rounded-lg hover:bg-secondary" onclick="toggleEdit()">Edit Profile</button>
                    <button id="saveButton" type="submit" class="px-6 py-2 bg-primary text-white font-semibold rounded-lg hover:bg-secondary hidden">Save Changes</button>
                    <a href="/home" class="w-full px-6 py-2 bg-gray-300 text-gray-800 font-semibold rounded-lg hover:bg-neutral text-center block">
                        Back To Home
                    </a>
                </div>
            </form>

            <script>
                function toggleEdit() {
                    const inputs = document.querySelectorAll('#profileForm input');
                    const editFields = document.getElementById('editFields');
                    const editButton = document.getElementById('editButton');
                    const saveButton = document.getElementById('saveButton');

                    inputs.forEach(input => {
                        if (input.id !== 'email') { 
                            input.readOnly = !input.readOnly;
                        }
                    });

                    if (editFields.classList.contains('hidden')) {
                        editFields.classList.remove('hidden');
                        saveButton.classList.remove('hidden');
                        editButton.textContent = 'Cancel';
                    } else {
                        editFields.classList.add('hidden');
                        saveButton.classList.add('hidden');
                        editButton.textContent = 'Edit Profile';
                    }
                }
            </script>
        </div>
    </div>
</div>