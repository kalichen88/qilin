<?php declare(strict_types=1);
namespace App\Task;

use App\Common\Check;
use App\Common\RedisDao;
use App\Model\Task;
use Hyperf\Di\Annotation\Inject;
use Hyperf\Crontab\Annotation\Crontab;

#[Crontab(name: 'Check', rule: '*/5 * * * * *', callback: [CheckTask::class, 'execute'], memo: '巡检任务', enable: true)]
class CheckTask
{
    #[Inject]
    protected RedisDao $redisDao;

    #[Inject]
    protected Check $check;

    /**
     * 读取 video_task(id=1).config 中 switch=true 的 key，逐项巡检并写 video_checklog。
     */
    public function execute(): void
    {
        $task = Task::query()->find(1);
        if (! $task) {
            return;
        }
        $config = json_decode((string) $task->config, true) ?: [];
        foreach ($config as $key => $item) {
            if (! empty($item['switch'])) {
                $this->check->run((string) $key, (string) ($item['token'] ?? ''));
            }
        }
    }
}
