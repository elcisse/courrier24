<?php
use App\Core\Router;
use App\Middleware\AuthMiddleware;
use App\Middleware\CsrfMiddleware;
use App\Controllers\HomeController;
use App\Controllers\CourrierController;
use App\Controllers\ServiceController;
use App\Controllers\UtilisateurController;
use App\Controllers\AuthController;

/** @var Router $router */

// Publique (login)
$router->get('/login', AuthController::class.'@login');
$router->post('/login', AuthController::class.'@doLogin', [
    ['class' => CsrfMiddleware::class, 'method' => 'handle'],
]);

// Protégées (auth requise)
$auth = [ ['class' => AuthMiddleware::class, 'method' => 'handle'] ];

$router->get('/', HomeController::class.'@index', $auth);
$router->get('/courriers', CourrierController::class.'@index', $auth);
$router->get('/services', ServiceController::class.'@index', $auth);
$router->get('/utilisateurs', UtilisateurController::class.'@index', $auth);

// Déconnexion (POST + CSRF)
$router->post('/logout', AuthController::class.'@logout', array_merge($auth, [
    ['class' => CsrfMiddleware::class, 'method' => 'handle'],
]));
