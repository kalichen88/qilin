<?php
declare(strict_types=1);

namespace App\Exception\Handler;

use App\Constants\ErrorCode;
use App\Exception\BusinessException;
use Hyperf\Contract\StdoutLoggerInterface;
use Hyperf\ExceptionHandler\ExceptionHandler;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Psr\Http\Message\ResponseInterface;
use Throwable;

class AppExceptionHandler extends ExceptionHandler
{
    public function __construct(protected StdoutLoggerInterface $logger)
    {
    }

    public function handle(Throwable $throwable, ResponseInterface $response): ResponseInterface
    {
        $this->stopPropagation();

        $code = $throwable instanceof BusinessException ? $throwable->getCode() : ErrorCode::SERVER_ERROR;
        $msg = $throwable instanceof BusinessException ? $throwable->getMessage() : '服务器开小差了';

        if (! $throwable instanceof BusinessException) {
            $this->logger->error('uncaught exception: ' . $throwable->getMessage(), ['trace' => $throwable->getTraceAsString()]);
        }

        $body = json_encode([
            'code' => (int) $code,
            'msg' => $msg,
            'data' => null,
        ], JSON_UNESCAPED_UNICODE);

        return $response
            ->withHeader('Content-Type', 'application/json;charset=utf-8')
            ->withStatus(200)
            ->withBody(new SwooleStream($body));
    }

    public function isValid(Throwable $throwable): bool
    {
        return true;
    }
}
