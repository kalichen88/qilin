<?php
declare(strict_types=1);

namespace App\Controller\View;

use App\Common\AbstractController;
use App\Common\Response;
use App\Model\Domain;
use App\Middleware\LogMiddleware;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\Middleware;

#[Controller]
#[Middleware(LogMiddleware::class)]
class ApiController extends AbstractController
{
    /**
     * gzh.html 调用：/api/public/getPublic?type=2，期望 data[0].host。
     */
    #[GetMapping(path: '/api/public/getPublic')]
    public function getPublic(): mixed
    {
        $type = (int) $this->request->query('type', 0);
        $query = Domain::query();
        if ($type > 0) {
            $query->where('type', $type);
        }
        $domains = $query->get()->map(fn ($d) => ['host' => $d->host, 'type' => $d->type]);
        return Response::success($this->response, $domains->values()->all());
    }

    #[GetMapping(path: '/api/public/get')]
    public function get(): mixed
    {
        return $this->getPublic();
    }
}
