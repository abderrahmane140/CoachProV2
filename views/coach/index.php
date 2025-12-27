<?php

include 'inc/header.php';

?>

<!-- Main Content -->
<!-- Main Content -->
  <div class="flex-1 bg-gray-900 px-6 py-8">
    <h1 class="text-3xl font-bold text-white">Coach Dashboard</h1>


    <!-- Dashboard Cards or Content Section (Grid layout) -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-8 mb-6">
      <div class="bg-gray-800 rounded-lg p-6">
        <h2 class="text-xl font-bold text-white">Pending Booking</h2>
        <p class="mt-2 text-3xl text-gray-400"><?php echo $pendingCount ?></p>
      </div>

      <div class="bg-gray-800 rounded-lg p-6">
        <h2 class="text-xl font-bold text-white">Today Sessions</h2>
        <p class="mt-2 text-3xl text-gray-400"><?= $todaysession ?></p>
      </div>

      <div class="bg-gray-800 rounded-lg p-6">
        <h2 class="text-xl font-bold text-white">Tomorrow Sessions</h2>
        <p class="mt-2 text-3xl text-gray-400"><?= $tomorowsession  ?></p>
      </div>
    </div>


    
  <?php if ($nextSession): ?>
    <div class="bg-gray-800  p-6 rounded-xl shadow-lg text-white space-y-4 mt-10">
      <!-- Athlete Info -->
      <div>
        <p class="text-lg font-bold"><?= htmlspecialchars($nextSession['athlete_name']) ?></p>
        <p class="text-sm opacity-80"><?= htmlspecialchars($nextSession['athlete_email']) ?></p>
      </div>

      <!-- Date & Time -->
      <div class="flex flex-wrap gap-2 text-sm">
        <span class="px-3 py-1 bg-blue-800 bg-opacity-30 rounded-full">
          <?= $nextSession['date_avb'] ?>
        </span>
        <span class="px-3 py-1 bg-blue-800 bg-opacity-30 rounded-full">
          <?= $nextSession['start_time'] ?> – <?= $nextSession['end_time'] ?>
        </span>
      </div>

      <!-- View Details Button -->
      <a href="/CoachPro/pages/coach/bookings.php"
        class="inline-block mt-2 px-3 py-1 bg-gray-600 text-white font-semibold rounded hover:bg-gray-100 transition">
        View Details →
      </a>
    </div>
  <?php else: ?>
    <div class="bg-gray-800 p-6 rounded-xl shadow-lg text-gray-400 text-center">
      No upcoming sessions
    </div>
  <?php endif; ?>

  </div>




<?php include 'inc/footer.php'; ?>
