<?php
namespace App\Middleware;

class CsrfMiddleware
{
    public static function handle(): void
    {
        if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
            $token = $_POST['_token'] ?? '';
            if (!hash_equals($_SESSION['csrf_token'] ?? '', $token)) {
                http_response_code(419); // Page Expired
                echo "CSRF token invalide.";
                exit;
            }
        }
    }
}
