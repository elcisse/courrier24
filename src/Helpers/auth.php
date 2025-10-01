<?php
function auth_user_id(): ?int { return $_SESSION['auth_user_id'] ?? null; }
function auth_check(): bool { return !empty($_SESSION['auth_user_id']); }
function auth_login(int $userId): void { $_SESSION['auth_user_id'] = $userId; }
function auth_logout(): void { unset($_SESSION['auth_user_id']); session_regenerate_id(true); }
function has_role(string $role): bool {
    // à implémenter plus tard (requête DB ou session). Pour le squelette:
    return $_SESSION['auth_role'] ?? null === $role;
}
