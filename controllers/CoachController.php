<?php

require_once __DIR__ .  '/../model/CoachProfile.php';

class CoachController {


    
    public function showProfile(){
        session_start();
        
        $user_id = $_SESSION['user_id'];

        $coachProfile = new CoachProfile(null,$user_id, 0, null, null);
        $profileData =  $coachProfile->getCoachById($user_id);

        require_once __DIR__ . "/../views/coach/profile.php";
    }


    public function createProfile() {

        session_start();
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

        $coachProfile->save();

        header("Location: index.php?action=showProfile");
        exit;   
    }

    public function updateProfile(){
        session_start();
        $coach_id = $_SESSION['user_id'];


        $description = $_POST['description'];
        $experience_years = $_POST['experience_years'];
        $certifications = $_POST['certifications'];
        $photo =  null;

        if (!empty($_FILES['photo']['name'])) {
            $uploadDir = __DIR__ . '/../uploads/';
            $fileName = time() . '_' . basename($_FILES['photo']['name']);
            move_uploaded_file($_FILES['photo']['tmp_name'], $uploadDir . $fileName);
            $photo = $fileName;
        }


        $coach = new CoachProfile(
            $description,
            $coach_id,
            $experience_years,
            $certifications,
            $photo
        );

        if($coach->update()){
            header("Location: index.php?action=showProfile");
        }else{
            echo "Error updating coach";
        }


    }

}
?>