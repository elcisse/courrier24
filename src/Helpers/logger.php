<?php
use Monolog\Level;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

function logger(): Logger {
    static $log = null;
    if ($log) return $log;
    $log = new Logger('app');
    $log->pushHandler(new StreamHandler(__DIR__ . '/../../storage/logs/app.log', Level::Info));
    return $log;
}
