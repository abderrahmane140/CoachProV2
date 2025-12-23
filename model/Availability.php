<?php

require __DIR__ . "/../core/Database.php";

class Availability {
    private int $id;
    private int $caoch_id;
    private string $date;
    private string $startTime;
    private string $endTime;
    private string $status = 'available';


    public function __construct($caoch_id, $date, $startTime, $endTime, $status)
    {
        $this->caoch_id = $caoch_id;
        $this->date = $date;
        $this->startTime = $startTime;
        $this->endTime = $endTime;
        $this->status = $status;
    }

    public function save() : bool {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("INSERT INTO availabilities (coach_id, date_avb, start_time, end_time, status) VALUES (?,?,?,?,?)");
        return $stmt->execute([
            $this->caoch_id,
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
        return $stmt->fetchAll();
    }
}