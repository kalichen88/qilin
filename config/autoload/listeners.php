<?php
declare(strict_types=1);

// R0：移除 DB 初始化监听(避免 worker 启动时连接未就绪的 MySQL)。
return [
    \Hyperf\ExceptionHandler\Listener\ErrorExceptionHandler::class,
];
