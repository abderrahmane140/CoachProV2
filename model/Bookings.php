    <?php

    require_once __DIR__ . "/../core/Database.php";

    class Bookings {
        private ?int $athleteId = null;
        private ?int $coachId = null;
        private ?int $availabilityId = null;
        private ?string $status = 'pending';


        public function __construct( $athleteId, $coachId,$availabilityId, $status)
        {

            $this->athleteId = $athleteId;
            $this->coachId = $coachId;
            $this->availabilityId = $availabilityId;
            $this->status = $status = 'ppending';
        }

        public static function save($coach_id,$availability_id, $athlete) {
            $pdo = Database::getConnection();
            
            $stmt = $pdo->prepare("SELECT status FROM availabilities WHERE id = :id AND coach_id = :coach_id");
            $stmt->execute([
                ':id' => $availability_id,
                ':coach_id' => $coach_id
            ]);
            $slot = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$slot || $slot['status'] !== 'available') {
                die('This slot is no longer available.');
            }

            try {
            $pdo->beginTransaction();

            $stmt = $pdo->prepare("INSERT INTO bookings (athlete_id, coach_id, availability_id) VALUES (:athlete_id, :coach_id, :availability_id)");
            $stmt->execute([
                ':athlete_id' => $athlete,
                ':coach_id' => $coach_id,
                ':availability_id' => $availability_id 
            ]);

            $stmt = $pdo->prepare("UPDATE availabilities SET status = 'booked' WHERE id = :availability_id");
            $stmt->execute([':availability_id' => $availability_id]);

            $pdo->commit();

            // Refresh availability
            $stmt = $pdo->prepare("SELECT * FROM availabilities WHERE coach_id = :id ORDER BY date_avb, start_time");
            $stmt->execute([':id' => $coach_id]);
            $availability = $stmt->fetchAll(PDO::FETCH_ASSOC);

            } catch (Exception $e) {
                $pdo->rollBack();
                die('Booking failed.');
            }
        }


        public static function getByAthlete($athleteId) {
            $pdo = Database::getConnection();
            $stmt = $pdo->prepare("SELECT * FROM bookings where athlete_id = ? ");
            $stmt->execute([$athleteId]);
            return $stmt->fetchAll();
        }

        public static function getByCoach($coachId) : array {
            $pdo = Database::getConnection();
            $stmt = $pdo->prepare("    
                SELECT 
                u.username AS athlete_name,

                a.date_avb,
                a.start_time,
                a.end_time,

                b.id AS id,
                b.status,
                b.created_at
                FROM bookings b
                JOIN users u ON b.athlete_id = u.id
                JOIN availabilities a ON b.availability_id = a.id
                WHERE b.coach_id = :coachId");
            $stmt->execute([":coachId"=>$coachId]);
            return $stmt->fetchAll();
        }

        public static function updateState($status, $booking_id, $coach_id){
            $pdo = Database::getConnection();
            $stmt = $pdo->prepare("UPDATE bookings SET status = :status WHERE id = :id AND coach_id = :coach_id");
            $stmt->execute([
                ':status' => $status,
                ':id' => $booking_id,
                ':coach_id' => $coach_id
            ]);


            if($status === 'accepted'){
                $stmt = $pdo->prepare("
                UPDATE availabilities 
                SET status = 'booked'
                WHERE id = (
                SELECT availability_id FROM bookings WHERE id = :id
                )
                ");
                $stmt->execute([':id' => $booking_id]);
            }
        }


        //get resevation for a user 

        public static function getUserReservation($user_id) {
            $pdo = Database::getConnection();

            $stmt = $pdo->prepare("
                SELECT 
                    b.id as booking_id, 
                    b.status as booking_status, 
                    b.created_at as booking_created_at,
                    
                    a.id as availability_id,
                    a.date_avb,
                    a.start_time,
                    a.end_time,

                    u.username as coach_name, 
                    cp.photo as coach_photo
                    FROM bookings b
                    JOIN availabilities a ON a.id = b.availability_id
                    JOIN users u ON u.id = b.coach_id
                    LEFT JOIN coach_profiles cp ON cp.user_id = u.id
                    WHERE b.athlete_id = :id
                    ORDER BY b.created_at DESC
            ");

            $stmt->execute([':id'=> $user_id]);
            return $stmt->fetchAll();
        }


        public static function cancelBooking($booking_id) {
                $pdo = Database::getConnection();

                $stmt = $pdo->prepare("
                    UPDATE bookings 
                    SET status = :status 
                    WHERE id = :id
                ");

                return $stmt->execute([
                    ':status' => 'canceled',
                    ':id' => $booking_id,
                ]);
            }


        //coach dashboard

        public static function getPendingBooking($coach_id) {
            $pdo = Database::getConnection();
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM bookings WHERE coach_id = :coach_id AND status ='pending'");
            $stmt->execute([
            ':coach_id' => $coach_id,
            ]);
            return $stmt->fetchColumn();
        }



        public static function getTodaySession ($coach_id){
            $pdo = Database::getConnection();
            $stmt = $pdo->prepare("
                SELECT COUNT(*) 
                FROM bookings b
                JOIN  availabilities a ON  b.availability_id = a.id 
                WHERE b.coach_id = :coach_id
                AND b.status = 'accepted' 
                AND a.date_avb = CURDATE();
            ");

            $stmt->execute([':coach_id'=>$coach_id]);
            return $stmt->fetchColumn();
        }

        public static function getTomorrowSession($coach_id){
            $pdo = Database::getConnection();
            $stmt = $pdo->prepare("
                SELECT COUNT(*) 
                FROM bookings b
                JOIN  availabilities a ON  b.availability_id = a.id 
                WHERE b.coach_id = :coach_id
                AND b.status = 'accepted' 
                AND a.date_avb = CURDATE() + INTERVAL 1 DAY;
            ");

            $stmt->execute([':coach_id'=>$coach_id]);
            return $stmt->fetchColumn();
        }

        public static function nextSession($coach_id){
            $pdo = Database::getConnection();
            $stmt = $pdo->prepare("
                    SELECT 
                        u.username AS athlete_name,
                        u.email AS athlete_email,
                        a.date_avb,
                        a.start_time,
                        a.end_time
                    FROM bookings b
                    JOIN users u ON b.athlete_id = u.id
                    JOIN availabilities a ON b.availability_id = a.id
                    WHERE b.coach_id = :coach_id
                    AND b.status = 'accepted'
                    AND a.date_avb >= CURDATE()
                    ORDER BY a.date_avb ASC, a.start_time ASC
                    LIMIT 1
                ");

                $stmt->execute([':coach_id' => $coach_id]);
                $nextSession = $stmt->fetch(PDO::FETCH_ASSOC);
        }


    }