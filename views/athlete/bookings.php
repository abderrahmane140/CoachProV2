<?php include 'inc/header.php' ?>


<main class="bg-gray-100 p-6 h-screen mb-20">
    <div class="max-w-7xl mx-auto">
        <h1 class="text-3xl font-semibold text-center text-gray-800 mb-6">Your Bookings</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($bookings as $booking): ?>
                <div class="bg-white p-6 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300">

                    <!-- Status Badge -->
                    <div class="text-center mb-4">
                        <?php if ($booking['booking_status'] === 'accepted'): ?>
                            <span class="inline-block px-4 py-2 text-sm font-semibold text-green-700 bg-green-100 rounded-full">Accepted</span>
                        <?php elseif ($booking['booking_status'] === 'rejected'): ?>
                            <span class="inline-block px-4 py-2 text-sm font-semibold text-red-700 bg-red-100 rounded-full">Rejected</span>
                        <?php elseif ($booking['booking_status'] === 'pending'): ?>
                            <span class="inline-block px-4 py-2 text-sm font-semibold text-yellow-700 bg-yellow-100 rounded-full">Pending</span>
                        <?php else: ?>
                            <span class="inline-block px-4 py-2 text-sm font-semibold text-gray-700 bg-gray-200 rounded-full">Cannceled</span>
                        <?php endif; ?>
                    </div>

                    <!-- Booking Info -->
                    <h3 class="text-lg font-semibold text-gray-800 mb-1">
                        Booking #<?= (int)$booking['booking_id']; ?>
                    </h3>

                    <!-- Coach Ticket Style -->
                    <div class="flex items-center gap-3 mt-4 border-t pt-4">
                        <img 
                            src="<?= !empty($booking['coach_photo']) 
                                ? '../../uploads/' . htmlspecialchars($booking['coach_photo']) 
                                : 'https://thumbs.dreamstime.com/b/default-avatar-profile-flat-icon-social-media-user-vector-portrait-unknown-human-image-default-avatar-profile-flat-icon-184330869.jpg' ?>"
                            class="w-10 h-10 rounded-full object-cover border"
                            alt="Coach photo"
                        >
                        <div>
                            <p class="text-sm font-semibold text-gray-800">
                                <?= htmlspecialchars($booking['coach_name']); ?>
                            </p>
                            <p class="text-xs text-gray-500">
                                Coach
                            </p>
                        </div>
                    </div>

                    <!-- Date & Time -->
                    <div class="mt-4 text-sm text-gray-600">
                        <p>
                            📅 <strong>Date:</strong> 
                            <?= htmlspecialchars($booking['date_avb']); ?>
                        </p>
                        <p>
                            ⏰ <strong>Time:</strong> 
                            <?= htmlspecialchars($booking['start_time']); ?> – <?= htmlspecialchars($booking['end_time']); ?>
                        </p>
                    </div>

                    <!-- Created At -->
                    <p class="text-xs text-gray-400 mt-4">
                        Created at: <?= date('F j, Y, g:i a', strtotime($booking['booking_created_at'])); ?>
                    </p>
                    <?php if($booking['booking_status'] !== 'rejected') : ?>
                    <form action="/CoachProV2/public/index.php?action=cancel_booking" method="POST">
                        <input type="hidden" name="booking_id" value="<?=  $booking['booking_id'] ?>">
                        <button class="w-full text bg-gray-300 p-2 font-bold mt-3 text-gray-500 rounded-md">Cancel</button>
                    </form>
                    <?php endif; ?>

                </div>
            <?php endforeach; ?>
        </div>
    </div>
</main>


<?php include 'inc/footer.php' ?>