<?php

require_once __DIR__ . "/../model/Availability.php";

class AvailabilityController {

    public function crateaAvailability() {
        session_start();
        $coach_id = $_SESSION['user_id'];
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

        $availability->save();



        header("Location: index.php?action=showAvailability");

    }

    public function getAllAvailability() {
        session_start();
        $coach_id = $_SESSION['user_id'];

        $availability = new Availability($coach_id, null,null,null,null);

        $reault = $availability->getAll($coach_id);


        require_once __DIR__ . "/../views/coach/index.php";

        
    }

    public function updateAvailability() {
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
}



?>