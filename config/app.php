<?php
// Charger l'autoload Composer
require_once __DIR__ . '/../vendor/autoload.php';

// .env
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->safeLoad();

// Timezone (fallback Africa/Dakar)
date_default_timezone_set($_ENV['APP_TIMEZONE'] ?? 'Africa/Dakar');

// Errors en dev
if (($_ENV['APP_ENV'] ?? 'local') === 'local' && (int)($_ENV['APP_DEBUG'] ?? 0) === 1) {
    ini_set('display_errors', '1');
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', '0');
}
