<?php declare(strict_types=1);
namespace App\Service;

use Swoole\Process;

class ShortService
{
    /**
     * 生成短链：优先走 bin/short/<model>/index.php <url> <key>（复用原版短链服务），否则 mock。
     */
    public function shorten(string $url, string $model = '', string $key = ''): string
    {
        $root = defined('BASE_PATH') ? BASE_PATH : getcwd();
        $script = $root . '/bin/short/' . $model . '/index.php';
        if ($model !== '' && $model !== 'mock' && is_file($script)) {
            $cmd = 'php ' . escapeshellarg($script) . ' ' . escapeshellarg($url) . ' ' . escapeshellarg($key);
            $res = Process::exec($cmd, false);
            $out = trim((string) ($res['output'] ?? ''));
            return $out !== '' ? $out : $url;
        }
        // mock
        return 'http://s.wl/' . substr(md5($url . microtime(true)), 0, 8);
    }
}
