<?php

class AuthController {

    public function register() {


        if ($_SERVER['REQUEST_METHOD'] !== "POST") {
            require __DIR__ . '/../views/auth/login.php';
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

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            header("Location: /CoachProV2/views/auth/register.php");
            exit();
        }

        $user = new User($username, $email, $password, $role);
        $user->save();

        header('Location: /CoachProV2/views/auth/login.php');
        exit();
    }

    public function login() {


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

        header('Location: /CoachProV2/views/coach/index.php');
        exit();
    }

    public function logout()
    {
        session_start();
        session_destroy();
        header('Location: /CoachProV2/public/index.php?action=login');
        exit();
    }
}
