<?php

require_once __DIR__ .  '/../model/CoachProfile.php';
require_once __DIR__ . '/../core/Auth.php';

class CoachController {


    
    public function showProfile(){

        Auth::requireRole('coach');


        $user_id = $_SESSION['user_id'];


        $profileData =  CoachProfile::getCoachById($user_id);

        require_once __DIR__ . "/../views/coach/profile.php";
    }



    public function saveProfile() {

        Auth::requireRole('coach');



        $user_id = (int) $_SESSION['user_id'];

        $description = $_POST['description'];
        $experience_years = $_POST['experience_years'];
        $certifications = $_POST['certifications'];
        $photo = null;

        if (!empty($_FILES['photo']['name'])) {
            $uploadDir = __DIR__ . '/../uploads/';
            $fileName = time() . '_' . basename($_FILES['photo']['name']);
            move_uploaded_file($_FILES['photo']['tmp_name'], $uploadDir . $fileName);
            $photo = $fileName;
        }


        $coachProfile = new CoachProfile(
            $description,
            $user_id,
            $experience_years,
            $certifications,
            $photo
        );

        if($coachProfile->exists($user_id)){
          $coachProfile->update();  
        }else{
            $coachProfile->save();
        }


        header("Location: index.php?action=showProfile");
        exit;   
    }



    //get all the coachs for the user 


     public function getAllCoaches() {

        Auth::requireRole('athlete');
        $coachs = CoachProfile::getAllCoaches();

        require_once __DIR__ . "/../views/athlete/coachs.php";

    }
}
?>