<?php
declare(strict_types=1);

namespace App\Middleware;

use App\Common\ViewCtx;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class LogMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        // 捕获 C 端上下文（fingerprint/xvzf/t/openid/ip）
        ViewCtx::capture($request);
        return $handler->handle($request);
    }
}
