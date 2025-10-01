<?php
use App\Database\Connection;

function auth_user_id(): ?int { return $_SESSION['auth_user_id'] ?? null; }
function auth_check(): bool { return !empty($_SESSION['auth_user_id']); }

function auth_login(int $userId, string $role, ?int $serviceId, string $prenomNom): void {
    $_SESSION['auth_user_id'] = $userId;
    $_SESSION['auth_role'] = $role;
    $_SESSION['auth_service_id'] = $serviceId;
    $_SESSION['auth_prenom_nom'] = $prenomNom;
    session_regenerate_id(true);
}
function auth_logout(): void {
    unset($_SESSION['auth_user_id'], $_SESSION['auth_role'], $_SESSION['auth_service_id'], $_SESSION['auth_prenom_nom']);
    session_regenerate_id(true);
}
function has_role(string $role): bool { return ($_SESSION['auth_role'] ?? '') === $role; }
function in_roles(array $roles): bool { return in_array($_SESSION['auth_role'] ?? '', $roles, true); }

/** Middleware callable pour le routeur */
function role_guard(array $roles): callable {
    return function() use ($roles) {
        if (!auth_check()) {
            header('Location: ' . url('/login')); exit;
        }
        if (!in_roles($roles)) {
            http_response_code(403);
            include BASE_PATH . '/src/Views/errors/403.php'; exit;
        }
    };
}
