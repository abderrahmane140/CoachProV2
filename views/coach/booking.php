<?php require_once 'inc/header.php'?>

 <!-- Main Content -->
  <div class="flex-1 bg-gray-900 px-6 py-8">
    <h1 class="text-3xl font-bold text-white">Booking</h1>
<div class="overflow-x-auto mt-6">
    <table class="min-w-full border border-gray-700 bg-gray-800 rounded-lg">
        <thead class="bg-gray-700 text-gray-200">
            <tr>
                <th class="px-4 py-3 text-left">#</th>
                <th class="px-4 py-3 text-left">Athlete</th>
                <th class="px-4 py-3 text-left">date</th>
                <th class="px-4 py-3 text-left">start time</th>
                <th class="px-4 py-3 text-left">end time</th>
                <th class="px-4 py-3 text-left">Status</th>
                <th class="px-4 py-3 text-left">Created At</th>
                <th class="px-4 py-3 text-left">Action</th>
            </tr>
        </thead>

        <tbody class="text-gray-300">
            <?php if (!empty($result)) : ?>
                <?php foreach ($result as $index => $booking) : ?>
                    <tr class="border-t border-gray-700 hover:bg-gray-700/50 transition">
                        <td class="px-4 py-3"><?= $index + 1 ?></td>
                        <td class="px-4 py-3"><?= $booking['athlete_name'] ?></td>
                        <td class="px-4 py-3"><?= $booking['date_avb'] ?></td>
                        <td class="px-4 py-3"><?= $booking['start_time'] ?></td>
                        <td class="px-4 py-3"><?= $booking['end_time'] ?></td>


                        <td class="px-4 py-3">
                            <span class="
                                px-2 py-1 rounded text-sm font-semibold
                                <?= $booking['status'] === 'pending' ? 'bg-yellow-500 text-black' : '' ?>
                                <?= $booking['status'] === 'accepted' ? 'bg-green-500 text-white' : '' ?>
                                <?= $booking['status'] === 'rejected' ? 'bg-red-500 text-white' : '' ?>
                                <?= $booking['status'] === 'canceled' ? 'bg-gray-500 text-white' : '' ?>
                            ">
                                <?= ucfirst($booking['status']) ?>
                            </span>
                        </td>

                        <td class="px-4 py-3">
                            <?= date('Y-m-d H:i', strtotime($booking['created_at'])) ?>
                        </td>
                        <td class="px-4 py-3 flex gap-3">

                        <?php if ($booking['status'] === 'pending') : ?>

                            <!-- accept -->
                            <form action="/CoachProV2/public/index.php?action=updateBooking" method="POST">
                                <input type="hidden" name="booking_id" value="<?= $booking['id'] ?>">
                                <input type="hidden" name="status" value="accepted">
                                <button class="text-green-400 hover:text-green-600">
                                    <i class="fa-solid fa-check"></i>
                                </button>
                            </form>

                            <!-- reject -->
                            <form action="/CoachProV2/public/index.php?action=updateBooking" method="POST">
                                <input type="hidden" name="booking_id" value="<?= $booking['id'] ?>">
                                <input type="hidden" name="status" value="rejected">
                                <button class="text-red-400 hover:text-red-600">
                                    <i class="fa-solid fa-xmark"></i>
                                </button>
                            </form>


                        <?php else :?>
                            <span class="text-gray">no action </span>
                        <?php endif;?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="6" class="px-4 py-6 text-center text-gray-400">
                        No bookings found
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

  </div>
<?php require_once 'inc/footer.php' ?>

