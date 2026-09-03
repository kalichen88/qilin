<?php
declare(strict_types=1);

// R6：恢复后台进程（需 Redis 运行）
return [
    \Hyperf\Crontab\Process\CrontabDispatcherProcess::class,
    \Hyperf\AsyncQueue\Process\ConsumerProcess::class,
];
