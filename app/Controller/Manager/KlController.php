<?php declare(strict_types=1);
namespace App\Controller\Manager;
use App\Common\Response;
use App\Middleware\AdminAuthMiddleware;
use App\Model\Kl;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\HttpServer\Annotation\Middleware;

#[Controller]
#[Middleware(AdminAuthMiddleware::class)]
class KlController extends BaseCrudController
{
    protected function model(): string { return Kl::class; }
    protected array $searchable = [];
    protected array $fields = ['agent', 'kl', 'init'];
    #[GetMapping(path: '/api/kl/get')] public function get(): mixed { return Response::success($this->response, $this->q_page()); }
    #[GetMapping(path: '/api/kl/get/single')] public function single(): mixed { return Response::success($this->response, $this->q_single((int) $this->request->input('id', 0))); }
    #[GetMapping(path: '/api/kl/getInit')] public function getInit(): mixed { return Response::success($this->response, Kl::query()->get()); }
    #[PostMapping(path: '/api/kl/add')] public function add(): mixed { return Response::success($this->response, $this->q_save(null)); }
    #[PostMapping(path: '/api/kl/save')] public function save(): mixed { return Response::success($this->response, $this->q_save((int) $this->request->input('id', 0))); }
    #[PostMapping(path: '/api/kl/delete')] public function delete(): mixed { return Response::success($this->response, ['deleted' => $this->q_delete((int) $this->request->input('id', 0))]); }
    #[PostMapping(path: '/api/kl/deletes')] public function deletes(): mixed { return Response::success($this->response, ['deleted' => $this->q_deletes()]); }
}
