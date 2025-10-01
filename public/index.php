<?php
require_once __DIR__ . '/../config/app.php';

use App\Database\Connection;

// Test DB + page Bootstrap
$ok = false;
$error = null;

try {
    $pdo = Connection::make();
    // simple ping
    $pdo->query('SELECT 1');
    $ok = true;
} catch (Throwable $t) {
    $error = $t->getMessage();
}
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Courrier24 — Test environnement</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap 5 CDN (JS natif, pas de jQuery) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <h1 class="mb-4">Courrier24 — Environnement</h1>

    <?php if ($ok): ?>
        <div class="alert alert-success">
            ✅ Connexion MySQL OK — timezone: <strong><?= htmlspecialchars(date_default_timezone_get()) ?></strong>
        </div>
    <?php else: ?>
        <div class="alert alert-danger">
            ❌ Échec connexion DB : <code><?= htmlspecialchars($error) ?></code>
        </div>
    <?php endif; ?>

    <p>Env: <code><?= htmlspecialchars($_ENV['APP_ENV'] ?? 'local') ?></code> —
        Debug: <code><?= htmlspecialchars($_ENV['APP_DEBUG'] ?? '0') ?></code></p>
    <a class="btn btn-primary" href="#">Continuer</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
