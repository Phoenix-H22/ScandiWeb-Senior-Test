<?php

session_start();
require_once dirname(__DIR__) . '/vendor/autoload.php';
require_once dirname(__DIR__) . '/config/app.php';

define('ROOT', dirname(__DIR__));
$scriptDir = dirname($_SERVER['SCRIPT_NAME']);
$baseDir = ($scriptDir === '/' || $scriptDir === '\\') ? '' : $scriptDir;
$scheme = $_SERVER['REQUEST_SCHEME'] ?? ($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? $_SERVER['HTTPS'] == "on" ? 'https' : "http"); // Default to 'http' if neither exists
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
$scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
$baseDir = ($scriptDir === '/' || $scriptDir === '\\') ? '' : $scriptDir;

define('BASE_URL', rtrim($scheme . '://' . $host, '/') . $baseDir . '/');

require_once dirname(__DIR__) . '/routes/web.php';
