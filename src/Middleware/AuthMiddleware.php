<?php
namespace App\Middleware;

class AuthMiddleware
{
    public static function handle(): void
    {
        if (empty($_SESSION['auth_user_id'])) {
            header('Location: /login');
            exit;
        }
    }
}
