<?php

require __DIR__ . "/../core/Database.php";

class CoachProfile {
    private $id;
    private $user_id;
    private $description;
    private $experience_years;
    private $certifications;
    private $photo;


    public function __construct($description, $user_id, $experience_years, $certifications, $photo)
    {
        $this->description = $description;
        $this->user_id = $user_id;
        $this->experience_years = $experience_years;
        $this->certifications = $certifications;
        $this->photo = $photo;
    }


    public function save() : bool {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("INSERT INTO coach_profiles (user_id, description, experience_years, certifications, photo) VALUES (?,?,?,?,?)");
        return $stmt->execute([
            $this->description,
            $this->user_id,
            $this->experience_years,
            $this->certifications,
            $this->photo
        ]);
    }


    public function getCoachById(int $user_id) {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM coach_profiles WHERE user_id = ?");
        $stmt->execute([$user_id]);
        return $stmt->fetch();
    }


}