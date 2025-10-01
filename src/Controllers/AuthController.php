<?php
namespace App\Controllers;

class AuthController extends BaseController
{
    public function login(): void
    {
        $title = 'Connexion';
        $contentView = 'auth/login';
        $this->render($contentView, compact('title'));
    }

    public function doLogin(): void
    {
        // Squelette : à compléter (vérifier login/mdp en DB)
        // Pour l’instant on simule une connexion
        auth_login(1);
        $_SESSION['auth_role'] = 'ADMIN';
        redirect(url('/'));
    }

    public function logout(): void
    {
        auth_logout();
        redirect(url('/login'));
    }
}
