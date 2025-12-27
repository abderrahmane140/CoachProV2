<?php

require __DIR__ . "/../core/Database.php";

class User{
    protected $id;
    protected $username;
    protected $email;
    protected $password;
    protected string $role;


    public function __construct($username, $email, $hashedPassword, $role)
    {
        $this->username = $username;
        $this->email = $email;
        $this->password = $hashedPassword;
        $this->role = $role;

    }

    public function save() : bool {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password, role ) VALUES (?, ?, ?, ?)");

        return $stmt->execute([
            $this->username,
            $this->email,
            $this->password,
            $this->role
        ]);
    }


    public static function findByEmail($email) {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM users where email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch();
    }


    public static function findById($id) {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ? ");
        $stmt->execute([$id]);
        return $stmt->fetch();

    }
}