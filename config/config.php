<?php
declare(strict_types=1);

use Hyperf\Contract\StdoutLoggerInterface;
use Psr\Log\LogLevel;

return [
    'app_name' => env('APP_NAME', 'wanli'),
    'app_env' => env('APP_ENV', 'dev'),
    'app_debug' => env('APP_DEBUG', false),
    'scan_cacheable' => env('SCAN_CACHEABLE', false),
    StdoutLoggerInterface::class => [
        'log_level' => [
            LogLevel::ALERT,
            LogLevel::CRITICAL,
            LogLevel::EMERGENCY,
            LogLevel::ERROR,
            LogLevel::WARNING,
            LogLevel::INFO,
            LogLevel::NOTICE,
        ],
    ],
    'app_secret' => env('JWT_SECRET', ''),
    'jwt' => [
        'secret' => env('JWT_SECRET', 'wanli-dev-secret'),
        'ttl' => (int) env('JWT_TTL', 86400),
    ],
];
