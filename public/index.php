<?php

session_start();
require_once dirname(__DIR__) . '/vendor/autoload.php';
require_once dirname(__DIR__) . '/config/app.php';

define('ROOT', dirname(__DIR__));
$scriptDir = dirname($_SERVER['SCRIPT_NAME']);
$baseDir = ($scriptDir === '/' || $scriptDir === '\\') ? '' : $scriptDir;

define('BASE_URL', rtrim($_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'], '/') . $baseDir . '/');


require_once dirname(__DIR__) . '/routes/web.php';
