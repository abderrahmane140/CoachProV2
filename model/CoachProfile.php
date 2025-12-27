<?php

require_once __DIR__ . "/../core/Database.php";

class CoachProfile {
    private int $id;
    private int $user_id;
    private string $description;
    private int $experience_years;
    private string $certifications;
    private ?string $photo;


    public function __construct(string $description, int $user_id, int $experience_years, string $certifications, string $photo)
    {
        $this->description = $description;
        $this->user_id = $user_id;
        $this->experience_years = $experience_years;
        $this->certifications = $certifications;
        $this->photo = $photo;
    }

    public function setId(int $id) : void {
        $this->id = $id;
    }



    public function save() : bool {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("INSERT INTO coach_profiles (user_id, description, experience_years, certifications, photo) VALUES (?,?,?,?,?)");
        return $stmt->execute([
            $this->user_id,
            $this->description,
            $this->experience_years,
            $this->certifications,
            $this->photo
        ]);
    }

    public function update(): bool {
            $pdo = Database::getConnection();

            if ($this->photo === null) {
                $stmt = $pdo->prepare("
                    UPDATE coach_profiles SET
                        description = ?,
                        experience_years = ?,
                        certifications = ?
                    WHERE user_id = ?
                ");

                return $stmt->execute([
                    $this->description,
                    $this->experience_years,
                    $this->certifications,
                    $this->user_id
                ]);
            }

            $stmt = $pdo->prepare("
                UPDATE coach_profiles SET
                    description = ?,
                    experience_years = ?,
                    certifications = ?,
                    photo = ?
                WHERE user_id = ?
            ");

            return $stmt->execute([
                $this->description,
                $this->experience_years,
                $this->certifications,
                $this->photo,
                $this->user_id
            ]);
        }




    public static function getCoachById(int $user_id) {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM coach_profiles WHERE user_id = ?");
        $stmt->execute([$user_id]);
        return $stmt->fetch();
    }

    public function exists($user_id) {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM coach_profiles WHERE user_id = :user_id LIMIT 1");
        $stmt->execute(['user_id'=> $user_id]);
        return $profile = $stmt->fetch(PDO::FETCH_ASSOC);
    }


    //get all the coachs for the user

    public static function getAllCoaches(){
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("
            SELECT 
                c.id AS coach_profile_id,
                c.user_id,
                u.username,
                c.description,
                c.experience_years,
                c.certifications,
                c.photo,
                GROUP_CONCAT(s.sport_name SEPARATOR ', ') AS sports
            FROM coach_profiles c
            INNER JOIN users u ON c.user_id = u.id
            LEFT JOIN coach_sports cs ON cs.coach_profile_id = c.id
            LEFT JOIN sports s ON s.id = cs.sport_id
            WHERE u.role = 'coach'
            GROUP BY c.id
        ");

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


}