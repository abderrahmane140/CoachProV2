<?php

require __DIR__ . "/../core/Database.php";

class Availability {
    private int $id;
    private int $coach_id;
    private string $date;
    private string $startTime;
    private string $endTime;
    private string $status = 'available';



    public function setId($id) {
        $this->id  = $id;
    }
    
    public function __construct($coach_id, $date, $startTime, $endTime, $status)
    {
        $this->coach_id = $coach_id;
        $this->date = $date;
        $this->startTime = $startTime;
        $this->endTime = $endTime;
        $this->status = $status;
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

    public function getAll($coach_id) {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM availabilities WHERE coach_id = ?");
        $stmt->execute();
        return $stmt->execute([$coach_id]);
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