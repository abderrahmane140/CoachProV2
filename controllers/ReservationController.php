<?php

require_once __DIR__ .  '/../model/Bookings.php';
require_once __DIR__ . '/../core/Auth.php';


class ReservationController{

    public function getAllReservation() {

        Auth::requireRole('coach');

        
        $coach_id = $_SESSION['user_id'];


        $result  = Bookings::getByCoach($coach_id);


        require_once __DIR__ . "/../views/coach/booking.php";

    }

    public function updateStatus(){

        Auth::requireRole('coach');


        $coach_id = $_SESSION['user_id'];

        $booking_id = $_POST['booking_id'];
        $status = $_POST['status'];



        Bookings::updateState($status, $booking_id,$coach_id);

        header("Location: index.php?action=showBooking");
        exit();
    }

    public function BookACoach() {


        Auth::requireRole('athlete');

        if (!isset($_SESSION['user_id'])) {
                die("Unauthorized");
        }

        if (!isset($_POST['coach_id'], $_POST['availability_id'])) {
            die("Invalid request");
        }
        $athlete =(int) $_SESSION['user_id'];
        $coach_id =(int) $_POST['coach_id'];
        $availability_id =(int) $_POST['availability_id'];

        Bookings::save($coach_id, $availability_id,$athlete );

        header("Location: index.php?action=mybookings");
        exit();
    }


    public function getUserReservation() {

        Auth::requireRole('athlete');

        $user_id = $_SESSION['user_id'];

        $bookings = Bookings::getUserReservation($user_id);

        require_once __DIR__ . "/../views/athlete/bookings.php";

    }



    //dashboard 

    public function statisticsForDashboard (){

        Auth::requireRole('coach');


        $coach_id = $_SESSION['user_id'];

        $pendingCount = Bookings::getPendingBooking($coach_id);

        $todaysession = Bookings::getTodaySession($coach_id);

        $tomorowsession = Bookings::getTomorrowSession($coach_id);

        $nextSession = Bookings::nextSession($coach_id);


        require_once __DIR__ . "/../views/coach/index.php";

    }


    public function cancelBooking() {

        Auth::requireRole('athlete');

        if (!isset($_POST['booking_id'])) {
            die("Booking ID missing");
        }

        $booking_id = (int) $_POST['booking_id'];

        $result = Bookings::cancelBooking($booking_id);

        if ($result) {
            header("Location: index.php?action=myBookings");
            exit;
        } else {
            echo "Error cancelling booking";
        }
    }




}