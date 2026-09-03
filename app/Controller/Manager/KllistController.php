<?php declare(strict_types=1);
namespace App\Controller\Manager;
use App\Common\Response;
use App\Middleware\AdminAuthMiddleware;
use App\Model\Kllist;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\HttpServer\Annotation\Middleware;

#[Controller]
#[Middleware(AdminAuthMiddleware::class)]
class KllistController extends BaseCrudController
{
    protected function model(): string { return Kllist::class; }
    protected array $searchable = ['orderId'];
    protected array $fields = ['orderId', 'video', 'price', 'agent'];
    #[GetMapping(path: '/api/kllist/get')] public function get(): mixed { return Response::success($this->response, $this->q_page()); }
    #[GetMapping(path: '/api/kllist/getTotal')] public function getTotal(): mixed { return Response::success($this->response, ['total' => Kllist::query()->count()]); }
    #[PostMapping(path: '/api/kllist/delete')] public function delete(): mixed { return Response::success($this->response, ['deleted' => $this->q_delete((int) $this->request->input('id', 0))]); }
    #[PostMapping(path: '/api/kllist/deletes')] public function deletes(): mixed { return Response::success($this->response, ['deleted' => $this->q_deletes()]); }
}
