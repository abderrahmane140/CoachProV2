<?php include 'inc/header.php' ?>

<main class="p-6">
    <h1 class="text-3xl font-bold text-center mb-8">Disponible Coachs</h1>

 
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
        <?php foreach ($coachs as $coach): ?>
            <div class="bg-white shadow-lg rounded-lg p-6 max-w-md mx-auto">
      
                <div class="flex justify-center mb-4">
                    <img src="../../uploads/<?php echo htmlspecialchars($coach['photo']); ?>" alt="Coach Photo" class="w-32 h-32 rounded-full object-cover">
                </div>

                <h3 class="text-center font-bold mt-4"><?php echo $coach['username']?></h3>

 
                <div class="text-start">
                    <p class="text-xl font-semibold mb-2">Sports:</p>
                    <p class="text-gray-700 mb-4">
                        <?= $coach['sports'] ? htmlspecialchars($coach['sports']) : 'No sport specified'; ?>
                    </p>
                    <p class="text-xl font-semibold mb-2">Description:</p>
                    <p class="text-gray-700 mb-4"><?php echo htmlspecialchars($coach['description']); ?></p>
                    <p class="text-xl font-semibold mb-2">Experience:</p>
                    <p class="text-gray-700 mb-4"><?php echo htmlspecialchars($coach['experience_years']); ?> years</p>
                    <p class="text-xl font-semibold mb-2">Certifications:</p>
                    <p class="text-gray-700"><?php echo htmlspecialchars($coach['certifications']); ?></p>
                    <a href="index.php?action=coachAvailability&coach_id=<?= $coach['user_id'] ?>"><button class="w-full bg-gray-200 p-2 rounded-md mt-2">Book</button></a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</main>


<?php include 'inc/footer.php' ?>