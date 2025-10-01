<?php
namespace App\Core;

class Router
{
    private array $routes = [];

    public function get(string $path, $handler, array $middlewares = []): void {
        $this->map('GET', $path, $handler, $middlewares);
    }
    public function post(string $path, $handler, array $middlewares = []): void {
        $this->map('POST', $path, $handler, $middlewares);
    }

    private function map(string $method, string $path, $handler, array $middlewares): void {
        $this->routes[$method][$this->normalize($path)] = ['handler' => $handler, 'mw' => $middlewares];
    }

    private function normalize(string $path): string {
        $base = rtrim($_ENV['BASE_URI'] ?? '', '/'); // optionnel (si app pas à la racine)
        $path = '/' . trim($path, '/');
        return $base . ($path === '/' ? '' : $path);
    }

    public function dispatch(string $method, string $uri): void {
        $base = rtrim($_ENV['BASE_URI'] ?? '', '/');
        $path = '/' . trim(str_replace($base, '', $uri), '/');
        if ($path === '//') $path = '/';

        $route = $this->routes[$method][$path] ?? null;

        if (!$route) {
            http_response_code(404);
            include BASE_PATH . '/src/Views/errors/404.php';
            return;
        }

        // Middlewares
        foreach ($route['mw'] as $mw) {
            // $mw: ['class' => FQCN, 'method' => 'handle']  ou  une callable
            if (is_callable($mw)) { $mw(); continue; }
            if (is_array($mw) && isset($mw['class'], $mw['method'])) {
                $cls = $mw['class']; $m = $mw['method']; $cls::$m();
            }
        }

        // Handler "Controller@method" ou callable
        $h = $route['handler'];
        if (is_string($h) && str_contains($h, '@')) {
            [$class, $methodName] = explode('@', $h, 2);
            $controller = new $class();
            $controller->$methodName();
        } elseif (is_callable($h)) {
            $h();
        } else {
            throw new \RuntimeException('Handler de route invalide');
        }
    }
}
