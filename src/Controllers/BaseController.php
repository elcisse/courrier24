<?php
namespace App\Controllers;

class BaseController
{
    protected function render(string $view, array $data = []): void
    {
        extract($data);
        $viewFile = BASE_PATH . '/src/Views/' . $view . '.php';
        $layout = BASE_PATH . '/src/Views/layouts/base.php';
        if (!is_file($viewFile)) { throw new \RuntimeException("Vue non trouvée: $viewFile"); }
        include $layout;
    }
}
