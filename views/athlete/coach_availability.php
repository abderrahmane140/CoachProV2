<?php include "inc/header.php" ?>



<div class="min-h-screen bg-gray-100 py-10">
    <div class="max-w-6xl mx-auto px-4">

        <h2 class="text-2xl font-bold mb-6">Coach Availability</h2>

        <?php if (empty($availability)): ?>
            <div class="bg-white p-6 rounded-lg shadow text-center text-gray-500">
                No availability found.
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($availability as $slot): ?>
                    <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition">

                        <!-- Date -->
                        <p class="text-sm text-gray-500 mb-2">
                            <?= date('F d, Y', strtotime($slot['date_avb'])); ?>
                        </p>

                        <!-- Time -->
                        <div class="text-lg font-semibold mb-4">
                            <?= substr($slot['start_time'], 0, 5); ?>
                            -
                            <?= substr($slot['end_time'], 0, 5); ?>
                        </div>

                        <!-- Status -->
                        <span class="inline-block mb-4 px-3 py-1 rounded-full text-sm font-medium
                            <?= $slot['status'] === 'available'
                                ? 'bg-green-100 text-green-700'
                                : 'bg-red-100 text-red-700'; ?>">
                            <?= ucfirst($slot['status']); ?>
                        </span>

                        <!-- Action -->
                        <?php if ($slot['status'] === 'available'): ?>
                            <form action="/CoachProV2/public/index.php?action=book" method="POST">
                                <input type="hidden" name="availability_id" value="<?= $slot['id'] ?>">
                                <input type="hidden" name="coach_id" value="<?= $slot['coach_id'] ?>">
                                <button class="block  w-full text-center mt-4 bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition">Book Now</button>
                            </form>
                        <?php else: ?>
                            <button disabled 
                                class="block w-full mt-4 bg-gray-300 text-gray-600 py-2 rounded-lg cursor-not-allowed">
                                Already Booked
                            </button>
                        <?php endif; ?>

                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    </div>
</div>


<?php include "inc/footer.php"?>