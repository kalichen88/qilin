<?php declare(strict_types=1);
namespace App\Controller\Manager;
use App\Common\Response;
use App\Middleware\AdminAuthMiddleware;
use App\Model\PayLog;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\HttpServer\Annotation\Middleware;

#[Controller]
#[Middleware(AdminAuthMiddleware::class)]
class PayLogController extends BaseCrudController
{
    protected function model(): string { return PayLog::class; }
    protected array $searchable = ['orderId'];
    protected array $fields = ['agent', 'total', 'info', 'orderId'];
    #[GetMapping(path: '/api/payLog/get')] public function get(): mixed { return Response::success($this->response, $this->q_page()); }
    #[PostMapping(path: '/api/payLog/delete')] public function delete(): mixed { return Response::success($this->response, ['deleted' => $this->q_delete((int) $this->request->input('id', 0))]); }
}
