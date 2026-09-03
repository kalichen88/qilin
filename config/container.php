<?php
declare(strict_types=1);

use Hyperf\Di\Container;
use Hyperf\Di\Definition\DefinitionSourceFactory;
use Hyperf\Context\ApplicationContext;

if (!defined('BASE_PATH')) {
    define('BASE_PATH', dirname(__DIR__));
}

$container = new Container((new DefinitionSourceFactory())());

if (!ApplicationContext::hasContainer()) {
    ApplicationContext::setContainer($container);
}

return $container;
