<?php
declare(strict_types=1);

namespace App\Common;

use Hyperf\HttpServer\Contract\ResponseInterface;

class Response
{
    public static function success(ResponseInterface $response, mixed $data = null, string $msg = 'ok'): mixed
    {
        return $response->json([
            'code' => 0,
            'msg' => $msg,
            'data' => $data,
        ]);
    }

    public static function error(ResponseInterface $response, string $msg = 'error', int $code = 1000, mixed $data = null): mixed
    {
        return $response->json([
            'code' => $code,
            'msg' => $msg,
            'data' => $data,
        ]);
    }
}
