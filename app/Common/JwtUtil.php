<?php
declare(strict_types=1);

namespace App\Common;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Hyperf\Context\ApplicationContext;
use Hyperf\Redis\Redis;

class JwtUtil
{
    private static string $secret = '';

    private static function secret(): string
    {
        return self::$secret ?: (string) config('jwt.secret', 'wanli-dev-secret');
    }

    public static function issue(string $scene, int $uid, array $extra = []): string
    {
        $now = time();
        $ttl = (int) config('jwt.ttl', 86400);
        $payload = array_merge($extra, [
            'iss' => 'wanli',
            'iat' => $now,
            'nbf' => $now,
            'exp' => $now + $ttl,
            'scope' => $scene,
            'uid' => $uid,
        ]);
        return JWT::encode($payload, self::secret(), 'HS256');
    }

    public static function verify(string $token): ?array
    {
        try {
            $payload = (array) JWT::decode($token, new Key(self::secret(), 'HS256'));
        } catch (\Throwable $e) {
            return null;
        }

        // 黑名单校验（若 Redis 可用）
        try {
            $redis = ApplicationContext::getContainer()->get(Redis::class);
            if ($redis && $redis->exists('jwt:bl:' . md5($token))) {
                return null;
            }
        } catch (\Throwable $e) {
            // ignore
        }

        return $payload;
    }

    public static function revoke(string $token): void
    {
        try {
            $redis = ApplicationContext::getContainer()->get(Redis::class);
            $payload = self::verify($token);
            $ttl = $payload ? max(0, (int) ($payload['exp'] ?? time()) - time()) : 3600;
            if ($redis) {
                $redis->setex('jwt:bl:' . md5($token), $ttl, '1');
            }
        } catch (\Throwable $e) {
            // ignore
        }
    }
}
