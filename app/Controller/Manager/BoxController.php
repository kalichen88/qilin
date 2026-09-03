<?php declare(strict_types=1);
namespace App\Controller\Manager;
use App\Common\Response;
use App\Middleware\AdminAuthMiddleware;
use App\Model\Box;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\HttpServer\Annotation\Middleware;

#[Controller]
#[Middleware(AdminAuthMiddleware::class)]
class BoxController extends BaseCrudController
{
    protected function model(): string { return Box::class; }
    protected array $searchable = ['title'];
    protected array $fields = ['video', 'title', 'thumb'];
    #[GetMapping(path: '/api/box/get')] public function get(): mixed { return Response::success($this->response, $this->q_page()); }
    #[GetMapping(path: '/api/box/get/single')] public function single(): mixed { return Response::success($this->response, $this->q_single((int) $this->request->input('id', 0))); }
    #[PostMapping(path: '/api/box/add')] public function add(): mixed { return Response::success($this->response, $this->q_save(null)); }
    #[PostMapping(path: '/api/box/save')] public function save(): mixed { return Response::success($this->response, $this->q_save((int) $this->request->input('id', 0))); }
    #[PostMapping(path: '/api/box/delete')] public function delete(): mixed { return Response::success($this->response, ['deleted' => $this->q_delete((int) $this->request->input('id', 0))]); }
    #[PostMapping(path: '/api/box/deletes')] public function deletes(): mixed { return Response::success($this->response, ['deleted' => $this->q_deletes()]); }
    #[PostMapping(path: '/api/box/adds')] public function adds(): mixed {
        $rows = (array) $this->request->input('rows', []);
        $n = 0;
        foreach ($rows as $r) { if (! empty($r['title'])) { (new Box())->fill(array_intersect_key((array) $r, array_flip($this->fields)))->save(); ++$n; } }
        return Response::success($this->response, ['added' => $n]);
    }
}
