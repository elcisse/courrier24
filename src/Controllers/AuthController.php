<?php
namespace App\Controllers;

use App\Database\Connection;
use Respect\Validation\Validator as v;

class AuthController extends BaseController
{
    public function login(): void
    {
        if (auth_check()) { redirect(url('/')); }
        $title = 'Connexion';
        $contentView = 'auth/login';
        $this->render($contentView, compact('title'));
    }

    public function doLogin(): void
    {
        // CSRF déjà vérifié par middleware
        $login = trim($_POST['login'] ?? '');
        $password = $_POST['password'] ?? '';

        // Validation rapide
        if (!v::alnum('_-.')->noWhitespace()->length(3, 80)->validate($login)) {
            $_SESSION['flash_error'] = "Login invalide.";
            redirect(url('/login'));
        }

        $pdo = Connection::make();
        $stmt = $pdo->prepare("SELECT u.id, u.prenom_nom, u.login, u.mdp_hash, u.role, u.service_id
                               FROM utilisateurs u
                               WHERE u.login = :login AND u.actif = 1
                               LIMIT 1");
        $stmt->execute([':login' => $login]);
        $user = $stmt->fetch();

        if (!$user || !password_verify($password, $user['mdp_hash'])) {
            $_SESSION['flash_error'] = "Identifiants incorrects.";
            redirect(url('/login'));
        }

        auth_login((int)$user['id'], $user['role'], $user['service_id'] ? (int)$user['service_id'] : null, $user['prenom_nom']);

        redirect(url('/'));
    }

    public function logout(): void
    {
        auth_logout();
        redirect(url('/login'));
    }
}
