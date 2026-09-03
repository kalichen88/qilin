<?php
declare(strict_types=1);

namespace App\Middleware;

use App\Common\JwtUtil;
use App\Constants\ErrorCode;
use App\Exception\BusinessException;
use Hyperf\Context\Context;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class AdminAuthMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $token = $request->getHeaderLine('Authorization');
        $token = str_replace('Bearer ', '', $token);
        $payload = $token ? JwtUtil::verify($token) : null;

        if (! $payload || ($payload['scope'] ?? '') !== 'admin') {
            throw new BusinessException('未授权', ErrorCode::UNAUTHORIZED);
        }

        Context::set('admin_user', $payload);
        return $handler->handle($request);
    }
}
