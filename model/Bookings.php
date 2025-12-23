<?php

require __DIR__ . "/../core/Database.php";

class Bookings {
    private int $athleteId;
    private int $coachId;
    private int $availabilityId;
    private string $status = 'pending';


    public function __construct( $athleteId, $coachId,$availabilityId, $status)
    {
        $this->athleteId = $athleteId;
        $this->coachId = $coachId;
        $this->availabilityId = $availabilityId;
        $this->status = $status;
    }

    public function save() : bool {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("INSERT INTO bookings (athlete_id, coach_id, availability_id , status ) VALUES (?,?,?,?)");
        return $stmt->execute([
            $this->athleteId,
            $this->coachId,
            $this->availabilityId,
            $this->status
        ]);
    }

    public static function getByAthlete($athleteId) {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM bookings where athelete_id = ? ");
        $stmt->execute([$athleteId]);
        return $stmt->fetchAll();
    }

    public static function getByCoach($coachId) {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM bookings where coach_id = ? ");
        $stmt->execute([$coachId]);
        return $stmt->fetchAll();
    }

}