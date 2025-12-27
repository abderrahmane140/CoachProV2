<?php

require_once __DIR__ . "/../model/Availability.php";
require_once __DIR__ . '/../core/Auth.php';

class AvailabilityController {

    public function saveAvailability() {


        Auth::requireRole('coach');




        $coach_id = $_SESSION['user_id'];
        $id = $_POST['id'] ?? 0;
        $date = $_POST['date'];
        $startTime = $_POST['startTime'];
        $endTime = $_POST['endTime'];
        $status = $_POST['status'];


        var_dump($coach_id,$date,$startTime,$endTime,$status );

        $availability = new Availability(
            $coach_id,
            $id,
            $date,
            $startTime,
            $endTime,
            $status
        );


        if($id > 0){
            $availability->updateAvailability();
        }else{
            $availability->save();
        }

        header("Location: index.php?action=showAvailability");
        exit();

    }

    public function getAllAvailability() {

        
        Auth::requireRole('coach');


        $coach_id = $_SESSION['user_id'];

        $availabilities = Availability::getAllAvailabilityForCoach($coach_id);

        require_once __DIR__ . "/../views/coach/availability.php";
    }



    public function updateAvailability() {

        Auth::requireRole('athlete');


        session_start();
        $coach_id = $_SESSION['user_id'];

        $availability_id = $_POST['id'];
        $data = $_POST['date'];
        $startTime = $_POST['startTime'];
        $endTime = $_POST['endTime'];
        $status = $_POST['status'];

        $availability = new Availability(
            $coach_id,
            $data,
            $startTime,
            $endTime,
            $status
        );

        $availability->setId($availability_id);


        if($availability->updateAvailability()){
            header("Location: Location: index.php?action=showAvailability");
        }else{
            echo "Error updating availability";
        }
    }


    public function getCoachAvailabilityForUser() {

        Auth::requireRole('athlete');

        if (!isset($_GET['coach_id'])) {
            die("Coach ID missing");
        }

        $coach_id = (int) $_GET['coach_id'];

        $availability = Availability::getAllAvailabilityForCoach($coach_id);

        require_once __DIR__ . "/../views/athlete/coach_availability.php";
    } 

}



?>