<?php declare(strict_types=1);
namespace App\Controller\Manager;
use App\Common\Response;
use App\Middleware\AdminAuthMiddleware;
use App\Model\Tousu;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\HttpServer\Annotation\Middleware;

#[Controller]
#[Middleware(AdminAuthMiddleware::class)]
class TousuController extends BaseCrudController
{
    protected function model(): string { return Tousu::class; }
    protected array $searchable = [];
    protected array $fields = ['type', 'content'];
    #[GetMapping(path: '/api/tousu/get')] public function get(): mixed { return Response::success($this->response, $this->q_page()); }
    #[PostMapping(path: '/api/tousu/save')] public function save(): mixed { return Response::success($this->response, $this->q_save((int) $this->request->input('id', 0))); }
    #[PostMapping(path: '/api/tousu/delete')] public function delete(): mixed { return Response::success($this->response, ['deleted' => $this->q_delete((int) $this->request->input('id', 0))]); }
}
