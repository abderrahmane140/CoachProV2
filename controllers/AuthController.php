<?php

class AuthController {

    public function register(){

        if($_SERVER['REQUEST_METHOD'] !== "POST"){
            require "../views/auth/register.php";
            return;
        }

            $errors = [];
        
            $username = trim($_POST['username']);
            $email = trim($_POST['email']);
            $password = $_POST['password'];
            $role = $_POST['role'];

            if(empty($username) || empty($email) || empty($password)  || empty($role)){
                    $errors[] = 'All fields are required!';
            }

            $hashedPassowrd = password_hash($password, PASSWORD_BCRYPT);

            $user = new User($username, $email, $hashedPassowrd, $role);
            $user->save();

            if(!empty($errors)){
                $_SESSION['errors'] = $errors;
                header("Location: /CoachProV2/view/auth/register.php");
                exit();
            }

            header('Location: /CoachProV2/view/auth/login.php');
    }

        public function login() {
            if($_SERVER['REQUEST_METHOD'] !== "POST"){
                require "../views/auth/login.php";
                return;
            }

            $errors = [];

            $email = $_POST['email'];
            $password = $_POST['password'];

            if(empty($email) || empty($password)){
                $errors[] = 'Both feild are required!';
            }


            $user = User::findByEmail($email);

            if(!$user || password_verify($password, $user['password'])){
                $errors[] = 'invalide credentials!';

            }


            if (!empty($errors)){
                $_SESSION['errors'] = $errors;
                header('Location: /CoachProV2/view/auth/login.php');
                exit();
            }


            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];

            header('Location: /CoachProV2/view/coach/dashboard.php');

        }
}

?>