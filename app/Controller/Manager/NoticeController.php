<?php declare(strict_types=1);
namespace App\Controller\Manager;
use App\Common\Response;
use App\Middleware\AdminAuthMiddleware;
use App\Model\Notice;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\HttpServer\Annotation\Middleware;

#[Controller]
#[Middleware(AdminAuthMiddleware::class)]
class NoticeController extends BaseCrudController
{
    protected function model(): string { return Notice::class; }
    protected array $searchable = ['title'];
    protected array $fields = ['title', 'content'];
    #[GetMapping(path: '/api/notice/get')] public function get(): mixed { return Response::success($this->response, $this->q_page()); }
    #[GetMapping(path: '/api/notice/get/single')] public function single(): mixed { return Response::success($this->response, $this->q_single((int) $this->request->input('id', 0))); }
    #[PostMapping(path: '/api/notice/add')] public function add(): mixed { return Response::success($this->response, $this->q_save(null)); }
    #[PostMapping(path: '/api/notice/save')] public function save(): mixed { return Response::success($this->response, $this->q_save((int) $this->request->input('id', 0))); }
    #[PostMapping(path: '/api/notice/delete')] public function delete(): mixed { return Response::success($this->response, ['deleted' => $this->q_delete((int) $this->request->input('id', 0))]); }
    #[PostMapping(path: '/api/notice/deletes')] public function deletes(): mixed { return Response::success($this->response, ['deleted' => $this->q_deletes()]); }
}
