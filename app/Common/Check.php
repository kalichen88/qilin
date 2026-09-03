<?php declare(strict_types=1);
namespace App\Common;

use App\Model\Checklog;

class Check
{
    /**
     * 巡检单项：写 video_checklog。R5 最小实现（后续可扩展为真实 HTTP 可用性检测）。
     */
    public function run(string $name, string $target = ''): void
    {
        // 模拟一次检测
        Checklog::query()->create(['url' => $name . ':' . $target, 'response' => 'ok']);
    }
}
