<?php
declare(strict_types=1);

namespace App\Job;

use Hyperf\AsyncQueue\Job;

class ItemJob extends Job
{
    public function __construct(public array $params = [])
    {
    }

    public function handle(): void
    {
        // R0 占位：异步任务（支付对账/分销结算等 R3+）
    }
}
