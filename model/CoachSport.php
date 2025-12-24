<?php


require __DIR__ . "/../core/Database.php";

class CoachSport{


    public static function attach ($coachProfilId, $sportId)  {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("INSERT INTO (coach_profile_id, sport_id) VALUE (?, ?)");
        return $stmt->execute([
            $coachProfilId,$sportId
        ]);
    }


    public static function getCoachSports ($coachProfilId){
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("
        SELECT s.* FROM sports s
        JOIN coach_sports cs ON cs.sport_id = s.id
        WHERE cs.coach_profile_id = ?
        ");
        $stmt->execute([$coachProfilId]);
        return $stmt->fetchAll();
    }
}