<?php
declare(strict_types=1);

namespace App\Controller;

use App\Common\AbstractController;
use App\Common\Response;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;

#[Controller]
class HealthController extends AbstractController
{
    #[GetMapping(path: '/health')]
    public function index(): mixed
    {
        return Response::success($this->response, [
            'app' => config('app_name'),
            'time' => date('Y-m-d H:i:s'),
            'status' => 'ok',
        ]);
    }

    #[GetMapping(path: '/health/ping')]
    public function ping(): mixed
    {
        return Response::success($this->response, ['pong' => true]);
    }
}
