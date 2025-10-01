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

$router->get('/login', AuthController::class.'@login');
$router->post('/login', AuthController::class.'@doLogin', [
    ['class' => CsrfMiddleware::class, 'method' => 'handle'],
]);

// Guards (closures) basés sur les rôles
$guardAdmin = role_guard(['ADMIN']);
$guardStaff = role_guard(['ADMIN','SECRETAIRE','CHEF_SERVICE','AGENT','LECTEUR']);

// Tableau de bord (tout utilisateur authentifié)
$router->get('/', HomeController::class.'@index', [ $guardStaff ]);

// Services — réservé ADMIN
$router->get('/services', ServiceController::class.'@index', [ $guardAdmin ]);
$router->get('/services/create', ServiceController::class.'@create', [ $guardAdmin ]);
$router->post('/services/store', ServiceController::class.'@store', [ $guardAdmin, ['class'=>CsrfMiddleware::class,'method'=>'handle'] ]);
$router->get('/services/edit', ServiceController::class.'@edit', [ $guardAdmin ]);
$router->post('/services/update', ServiceController::class.'@update', [ $guardAdmin, ['class'=>CsrfMiddleware::class,'method'=>'handle'] ]);
$router->post('/services/delete', ServiceController::class.'@destroy', [ $guardAdmin, ['class'=>CsrfMiddleware::class,'method'=>'handle'] ]);

// Courriers — staff
$router->get('/courriers', CourrierController::class.'@index', [ $guardStaff ]);
$router->get('/courriers/create', CourrierController::class.'@create', [ $guardStaff ]);
$router->post('/courriers/store', CourrierController::class.'@store', [ $guardStaff, ['class'=>CsrfMiddleware::class,'method'=>'handle'] ]);
