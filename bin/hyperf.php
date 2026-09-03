#!/usr/bin/env php
<?php
declare(strict_types=1);

use Hyperf\Contract\ApplicationInterface;

ini_set('display_errors', 'on');
ini_set('display_startup_errors', 'on');
error_reporting(E_ALL);
date_default_timezone_set('Asia/Shanghai');

if (!defined('BASE_PATH')) {
    define('BASE_PATH', dirname(__DIR__));
}

require BASE_PATH . '/vendor/autoload.php';

\Hyperf\Di\ClassLoader::init();

$container = require BASE_PATH . '/config/container.php';

$application = $container->get(ApplicationInterface::class);
$application->run();
