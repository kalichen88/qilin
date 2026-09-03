<?php declare(strict_types=1);
namespace App\Controller\View;

use App\Common\AbstractController;
use App\Common\Response;
use App\Common\ViewCtx;
use App\Middleware\LogMiddleware;
use App\Model\Tousu;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\HttpServer\Annotation\Middleware;

#[Controller]
#[Middleware(LogMiddleware::class)]
class TousuController extends AbstractController
{
    #[PostMapping(path: '/view/tousu/add')]
    public function add(): mixed
    {
        $row = Tousu::query()->create([
            'ip' => ViewCtx::get('ip'),
            'type' => (int) $this->request->input('type', 0),
            'content' => (string) $this->request->input('content', ''),
            'fingerprint' => ViewCtx::get('fingerprint'),
            'openid' => ViewCtx::get('openid'),
        ]);
        return Response::success($this->response, $row);
    }
}
