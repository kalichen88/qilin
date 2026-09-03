<?php
declare(strict_types=1);

namespace App\Common;

use Hyperf\Context\Context;
use Psr\Http\Message\ServerRequestInterface;

class ViewCtx
{
    public static function capture(ServerRequestInterface $request): void
    {
        $body = (array) $request->getParsedBody();
        $query = (array) $request->getQueryParams();
        $server = $request->getServerParams();
        Context::set('view_ctx', [
            'fingerprint' => (string) ($body['fingerprint'] ?? $query['fingerprint'] ?? ''),
            'xvzf' => (string) ($body['xvzf'] ?? $query['xvzf'] ?? ''),
            't' => (string) ($body['t'] ?? $query['t'] ?? ''),
            'openid' => (string) ($body['openid'] ?? $query['openid'] ?? ''),
            'ip' => (string) ($server['remote_addr'] ?? ''),
        ]);
    }

    public static function all(): array
    {
        return Context::get('view_ctx', []);
    }

    public static function get(string $key): string
    {
        return (string) (Context::get('view_ctx', [])[$key] ?? '');
    }
}
