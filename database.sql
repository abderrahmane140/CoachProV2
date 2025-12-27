USE coachprov2;

CREATE TABLE users (
    id int AUTO_INCREMENT PRIMARY key,
    username varchar(50) not null,
    email varchar(60) not null UNIQUE,
    password varchar(255) not null,
    role ENUM('athlete','coach') not null,
    created_at datetime DEFAULT CURRENT_TIMESTAMP,
    updated_at datetime DEFAULT CURRENT_TIMESTAMP on UPDATE CURRENT_TIMESTAMP
);

create TABLE coach_profiles (
    id int AUTO_INCREMENT PRIMARY KEY,
    user_id int not null,
    description text, 
    experience_years int not null,
    certifications varchar(255) DEFAULT null,
    photo text NOT null,
    created_at datetime DEFAULT CURRENT_TIMESTAMP,
    FOREIGN key(user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE sports (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sport_name VARCHAR(50) NOT NULL
);

CREATE table coach_sports(
    coach_profile_id int not null,
    sport_id int not null,
    FOREIGN key(coach_profile_id) REFERENCES coach_profiles(id),
    FOREIGN key(sport_id) REFERENCES sports(id)
);

CREATE TABLE availabilities (
    id int AUTO_INCREMENT PRIMARY KEY,
    coach_id int not null,
    date_avb date not null,
    start_time time not null,
    end_time time not null,
    status ENUM('available','booked') DEFAULT 'available',
    FOREIGN key(coach_id) REFERENCES users(id) on DELETE CASCADE
);

CREATE TABLE bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    athlete_id INT NOT NULL,
    coach_id INT NOT NULL,
    availability_id INT NOT NULL,
    status ENUM('pending','accepted','rejected','canceled') DEFAULT 'pending',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(athlete_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY(coach_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY(availability_id) REFERENCES availabilities(id) ON DELETE CASCADE
);





INSERT INTO users (username, email, password, role) VALUES
('coach_john', 'john@coach.com', 'password', 'coach'),
('coach_sara', 'sara@coach.com', 'password', 'coach'),
('coach_mike', 'mike@coach.com', 'password', 'coach'),

('athlete_ali', 'ali@athlete.com', 'password', 'athlete'),
('athlete_nora', 'nora@athlete.com', 'password', 'athlete'),
('athlete_yassine', 'yassine@athlete.com', 'password', 'athlete');



INSERT INTO coach_profiles (user_id, description, experience_years, certifications, photo) VALUES
(10, 'Fitness and strength training coach', 5, 'NASM CPT', 'john.jpg'),
(11, 'Yoga and wellness coach', 7, 'Yoga Alliance RYT-500', 'sara.jpg'),
(12, 'Football conditioning coach', 10, 'UEFA C License', 'mike.jpg');



INSERT INTO sports (sport_name) VALUES
('Fitness'),
('Yoga'),
('Football'),
('CrossFit'),
('Pilates');


INSERT INTO coach_sports (coach_profile_id, sport_id) VALUES
(5, 1), -- John → Fitness
(5, 4), -- John → CrossFit
(6, 2), -- Sara → Yoga
(6, 5), -- Sara → Pilates
(7, 3); -- Mike → Football



INSERT INTO availabilities (coach_id, date_avb, start_time, end_time, status) VALUES
(10, '2025-01-05', '09:00:00', '10:00:00', 'available'),
(10, '2025-01-05', '10:00:00', '11:00:00', 'booked'),

(11, '2025-01-06', '14:00:00', '15:30:00', 'available'),
(11, '2025-01-06', '16:00:00', '17:00:00', 'available'),

(12, '2025-01-07', '18:00:00', '19:30:00', 'available');





INSERT INTO bookings (athlete_id, coach_id, availability_id, status) VALUES
(13, 10, 6, 'accepted'),   -- Ali booked John
(14, 11, 10, 'pending'),    -- Nora booked Sara
(15, 12, 8, 'rejected');   -- Yassine booked Mike

