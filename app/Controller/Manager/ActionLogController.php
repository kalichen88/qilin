<?php declare(strict_types=1);
namespace App\Controller\Manager;
use App\Common\Response;
use App\Middleware\AdminAuthMiddleware;
use App\Model\ActionLog;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\HttpServer\Annotation\Middleware;

#[Controller]
#[Middleware(AdminAuthMiddleware::class)]
class ActionLogController extends BaseCrudController
{
    protected function model(): string { return ActionLog::class; }
    protected array $searchable = [];
    protected array $fields = ['url', 'content', 'ip'];
    #[GetMapping(path: '/api/actionLog/get')] public function get(): mixed { return Response::success($this->response, $this->q_page()); }
    #[PostMapping(path: '/api/actionLog/delete')] public function delete(): mixed { return Response::success($this->response, ['deleted' => $this->q_delete((int) $this->request->input('id', 0))]); }
    #[PostMapping(path: '/api/actionLog/deleteAll')] public function deleteAll(): mixed { return Response::success($this->response, ['deleted' => ActionLog::query()->delete()]); }
}
