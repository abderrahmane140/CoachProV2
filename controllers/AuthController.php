<?php
require_once __DIR__ . '/../core/Auth.php';
class AuthController {

    public function register() {


        Auth::guestOnly();
        if ($_SERVER['REQUEST_METHOD'] !== "POST") {
            require __DIR__ . '/../views/auth/register.php';
            return;
        }


        $errors = [];

        $username = trim($_POST['username']);
        $email = trim($_POST['email']);
        $password = $_POST['password'];
        $role = $_POST['role'];

        if (empty($username) || empty($email) || empty($password) || empty($role)) {
            $errors[] = 'All fields are required!';
        }


        if (!in_array($role, ['athlete', 'coach'])) {
            $errors[] = 'Invalid role';
        }
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;

            header("Location: index.php?action=register");
            exit();
        }
        
     
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $user = new User($username, $email, $hashedPassword, $role);
        $user->save();

        header('Location: index.php?action=login');
        exit();
    }


    public function login() {

        Auth::guestOnly();

        if ($_SERVER['REQUEST_METHOD'] !== "POST") {
            require __DIR__ . '/../views/auth/login.php';
            return;
        }

        $errors = [];

        $email = trim($_POST['email']);
        $password = $_POST['password'];

        if (empty($email) || empty($password)) {
            $errors[] = 'Both fields are required!';
        }

        $user = User::findByEmail($email);

        if (!$user || !password_verify($password, $user['password'])) {
            $errors[] = 'Invalid credentials!';
        }

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;

            exit();
        }

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];

        Auth::redirectAfterLogin();
    }

    public function logout()
    {
        session_start();
        session_destroy();
        header('Location: /CoachProV2/public/index.php?action=login');
        exit();
    }
}
