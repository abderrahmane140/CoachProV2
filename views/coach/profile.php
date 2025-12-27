<?php
include 'inc/header.php';

?>
<div class="flex-1 bg-gray-900 px-6 py-8 text-white">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-white">Profile</h1>
    </div>

    
    <!-- Form Centered with Better Spacing -->
    
    <div class="flex items-center justify-center">

        <form action="/CoachProV2/public/index.php?action=saveProfile" method="POST" class="space-y-6 w-full max-w-2xl p-8 bg-gray-800 rounded-lg shadow-lg" enctype="multipart/form-data">

        <div class="flex item-center justify-center">
            <img 
                 src="<?= '/CoachProV2/uploads/' . ($profileData['photo'] ?? 'https://thumbs.dreamstime.com/b/default-avatar-profile-flat-icon-social-media-user-vector-portrait-unknown-human-image-default-avatar-profile-flat-icon-184330869.jpg') ?>" 
                alt="Profile Photo" 
                class="rounded-full w-20 h-20"
    >
        </div>

            

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-medium">Description</label>
                <div class="mt-2">
                    <textarea
                        id="description"
                        name="description"
                        rows="4"
                        class="block w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-gray-500 text-black focus:ring-1 focus:ring-gray-500"
                        placeholder="Enter a brief description about yourself"
                    ><?= htmlspecialchars($profileData['description'] ?? "") ?>
                </textarea>
                </div>
            </div>

            <!-- Experience Years -->
            <div>
                <label for="experience_years" class="block text-sm font-medium">Experience Years</label>
                <div class="mt-2">
                    <input
                        id="experience_years"
                        type="number"
                        name="experience_years"
                        required
                        min="1"
                        class="block w-full rounded-md border border-gray-300 px-3 py-2 text-black  text-sm focus:border-gray-500 focus:ring-1 focus:ring-gray-500"
                        value=<?= htmlspecialchars($profileData['experience_years'] ?? "") ?>
                        />
                </div>
            </div>

            <!-- Certifications -->
            <div>
                <label for="certifications" class="block text-sm font-medium">Certifications</label>
                <div class="mt-2">
                    <input
                        id="certifications"
                        type="text"
                        name="certifications"
                        class="block w-full rounded-md text-black  border border-gray-300 px-3 py-2 text-sm focus:border-gray-500 focus:ring-1 focus:ring-gray-500"
                        placeholder="Enter any certifications you have"
                        value="<?= htmlspecialchars($profileData['certifications'] ?? "") ?>"
                    />
                </div>
            </div>

            <!-- Photo Upload -->

            <div>
                <label for="photo" class="block text-sm font-medium">Upload Photo</label>
                <div class="mt-2">
                    <input
                        id="photo"
                        type="file"
                        name="photo"
                        class="block w-full rounded-md border border-gray-300 text-sm focus:border-gray-500 focus:ring-1 focus:ring-gray-500"
                    />
                </div>
            </div>


            <!-- Submit Button -->
            <div>
                <button
                    type="submit"
                    name="login"
                    class="flex w-full justify-center rounded-md bg-blue-600 px-4 py-2 text-white font-semibold"
                >
                    Create Profile
                </button>
            </div>
        </form>
    </div>
</div>

<?php include 'inc/footer.php'; ?>