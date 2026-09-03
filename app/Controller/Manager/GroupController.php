<?php declare(strict_types=1);
namespace App\Controller\Manager;
use App\Common\Response;
use App\Middleware\AdminAuthMiddleware;
use App\Model\Group;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\HttpServer\Annotation\Middleware;

#[Controller]
#[Middleware(AdminAuthMiddleware::class)]
class GroupController extends BaseCrudController
{
    protected function model(): string { return Group::class; }
    protected array $searchable = ['name'];
    protected array $fields = ['name', 'rule'];
    #[GetMapping(path: '/api/group/getall')] public function getall(): mixed { return Response::success($this->response, Group::query()->get()); }
    #[GetMapping(path: '/api/group/get')] public function get(): mixed { return Response::success($this->response, $this->q_page()); }
    #[PostMapping(path: '/api/group/add')] public function add(): mixed { return Response::success($this->response, $this->q_save(null)); }
    #[PostMapping(path: '/api/group/save')] public function save(): mixed { return Response::success($this->response, $this->q_save((int) $this->request->input('id', 0))); }
    #[PostMapping(path: '/api/group/delete')] public function delete(): mixed { return Response::success($this->response, ['deleted' => $this->q_delete((int) $this->request->input('id', 0))]); }
}
