<?php
declare(strict_types=1);

namespace App\Common;

use Hyperf\Redis\Redis;

class RedisDao
{
    public function __construct(protected Redis $redis)
    {
    }

    public function get(string $key): mixed
    {
        return $this->redis->get($key);
    }

    public function set(string $key, mixed $value, ?int $ttl = null): bool
    {
        if ($ttl) {
            return $this->redis->setex($key, $ttl, $value);
        }
        return $this->redis->set($key, $value);
    }

    public function del(string ...$keys): int
    {
        return $this->redis->del(...$keys);
    }
}
