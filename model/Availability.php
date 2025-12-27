<?php

require_once __DIR__ . "/../core/Database.php";

class Availability {
    private ?int $id = null;
    private int $coach_id;
    private ?string $date = null;
    private ?string $startTime = null;
    private ?string $endTime = null;
    private string $status = 'available';




    public function __construct(
        int $coach_id,
        ?int $id= null,
        ?string $date = null,
        ?string $startTime = null,
        ?string $endTime = null,
        ?string $status = 'available'
    ) {
        $this->id = $id;
        $this->coach_id = $coach_id;
        $this->date = $date;
        $this->startTime = $startTime;
        $this->endTime = $endTime;
        $this->status = $status ?? 'available';
    }
    public function setId($id) {
        $this->id  = $id;
    }
    

    public function save() : bool {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("INSERT INTO availabilities (coach_id, date_avb, start_time, end_time, status) VALUES (?,?,?,?,?)");
        return $stmt->execute([
            $this->coach_id,
            $this->date,
            $this->startTime,
            $this->endTime,
            $this->status

        ]);
    }

    public static function markAsBooked($id) : bool{
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("UPDATE availabilities SET status = 'booked' WHERE id = ?");
        return $stmt->execute([$id]);
    }


    public static function availabilitySession() : array {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM availabilities WHERE status = 'available'");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function getAllAvailabilityForCoach($coach_id) {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM availabilities WHERE coach_id = ?");
        $stmt->execute([$coach_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC); 
    }

    public function updateAvailability() : bool {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("UPDATE availabilities 
                               SET date_avb = :date_avb, start_time = :start_time, end_time = :end_time, status = :status
                               WHERE id = :id AND coach_id = :coach_id");
        
        return $stmt->execute([
            ':date_avb' => $this->date,
            ':start_time' => $this->startTime,
            ':end_time'=> $this->endTime,
            ':status' => $this->status,
            ':id' => $this->id,
            ':coach_id' => $this->coach_id
        ]);
    }
}