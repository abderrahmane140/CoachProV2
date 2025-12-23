<?php

require __DIR__ . "/../core/Database.php";

class Sprot{
    
    public static function all(){
        $pdo = Database::getConnection();
        $stmt = $pdo->query("SELECT * FROM sports");
        return $stmt->fetchAll();
    }


    public function getSportByName($sportName) : bool{
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM sports WHERE sport_name = ?");
        return $stmt->execute([$sportName]);
    }
}