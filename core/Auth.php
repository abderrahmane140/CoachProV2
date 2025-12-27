<?php

class Auth
{
    public static function check()
    {
        return isset($_SESSION['user_id']);
    }

    public static function role()
    {
        return $_SESSION['role'] ?? null;
    }


    public static function requireLogin()
    {
        if (!self::check()) {
            header("Location: index.php?action=login");
            exit;
        }
    }


    public static function requireRole(string $role)
    {
        if (!self::check()) {
            header("Location: index.php?action=login");
            exit;
        }

        if (self::role() !== $role) {
            self::redirectAfterLogin();
        }
    }


    public static function guestOnly()
    {
        if (self::check()) {
            self::redirectAfterLogin();
        }
    }


    public static function redirectAfterLogin()
    {
        if (self::role() === 'coach') {
            header("Location: index.php?action=dashboard");
        } else {
            header("Location: index.php?action=home");
        }
        exit;
    }
}
