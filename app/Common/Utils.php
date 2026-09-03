<?php
declare(strict_types=1);

namespace App\Common;

class Utils
{
    public static function clientIp(): string
    {
        $request = \Hyperf\Context\Context::get(\Psr\Http\Message\ServerRequestInterface::class);
        if ($request) {
            $server = $request->getServerParams();
            return $server['remote_addr'] ?? ($server['http_x_forwarded_for'] ?? '');
        }
        return '';
    }

    public static function genOrderId(): string
    {
        return date('YmdHis') . mt_rand(1000, 9999) . mt_rand(100000, 999999);
    }

    /**
     * 生成短推广 hash（base62，8 位），对应 promotion.hash / ?t=<hash>。
     */
    public static function promoHash(): string
    {
        $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $hash = '';
        $len = strlen($chars);
        for ($i = 0; $i < 8; ++$i) {
            $hash .= $chars[random_int(0, $len - 1)];
        }
        return $hash;
    }
}
