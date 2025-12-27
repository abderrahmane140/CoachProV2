<?php
session_start();
require_once __DIR__ . '/../model/User.php';
require_once __DIR__ . '/../controllers/AuthController.php';
require_once __DIR__ . '/../controllers/CoachController.php';
require_once __DIR__ . '/../controllers/AvailabilityController.php';
require_once __DIR__ . '/../controllers/ReservationController.php';
require_once __DIR__ . '/../controllers/HomeController.php';

if (!isset($_GET['action'])) {
    if (!isset($_SESSION['user_id'])) {
        header("Location: index.php?action=login");
        exit;
    }

    if ($_SESSION['role'] === 'coach') {
        header("Location: index.php?action=dashboard");
    } else {
        header("Location: index.php?action=home");
    }
    exit;
}





$authController = new AuthController();
$coachController = new CoachController();
$avaailability= new AvailabilityController();
$bookings = new ReservationController();
$homeController = new HomeController();


$action = $_GET['action'] ?? null;

switch($action) {
    case 'login':
    case 'register':
    case 'logout':
        if(method_exists($authController, $action)){
            $authController->$action();
        }
        break;

    

    case 'showProfile':
        $coachController->showProfile();
        break;

    case 'saveProfile' :
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $coachController->saveProfile();
        }else{
            echo "invalide a request method";
        }

        break;
    case 'showAvailability' :
        $avaailability->getAllAvailability();
        break;
    case 'createAvailability' :
        $avaailability->saveAvailability();
        break;
    case 'updateAvailability' : 
        $avaailability->updateAvailability();
        break;

    case 'showBooking':
        $bookings->getAllReservation();
        break;
    
    case 'updateBooking':
        $bookings->updateStatus();
        break;
    case 'dashboard' :
        $bookings->statisticsForDashboard();
        break;
    case 'myBookings' :
        $bookings->getUserReservation();
        break;
    case 'cancel_booking' :
        $bookings->cancelBooking();
        break;
    case 'coachs' :
        $coachController->getAllCoaches();
        break;
    case 'coachAvailability':
        $avaailability->getCoachAvailabilityForUser();
        break;
    case 'book' :
        $bookings->BookACoach();
        break;
    case 'home' :
        $homeController->home();
        break;
    case 'logout' :
        $authController->logout();
        break;

}


?>