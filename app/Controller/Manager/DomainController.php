<?php declare(strict_types=1);
namespace App\Controller\Manager;
use App\Common\Response;
use App\Middleware\AdminAuthMiddleware;
use App\Model\Domain;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\HttpServer\Annotation\Middleware;

#[Controller]
#[Middleware(AdminAuthMiddleware::class)]
class DomainController extends BaseCrudController
{
    protected function model(): string { return Domain::class; }
    protected array $searchable = ['host'];
    protected array $fields = ['host', 'wechat', 'qq', 'type', 'agent'];
    #[GetMapping(path: '/api/domain/getall')] public function getall(): mixed { return Response::success($this->response, Domain::query()->orderByDesc('id')->get()); }
    #[GetMapping(path: '/api/domain/get')] public function get(): mixed { return Response::success($this->response, $this->q_page()); }
    #[GetMapping(path: '/api/domain/get/single')] public function single(): mixed { return Response::success($this->response, $this->q_single((int) $this->request->input('id', 0))); }
    #[PostMapping(path: '/api/domain/add')] public function add(): mixed { return Response::success($this->response, $this->q_save(null)); }
    #[PostMapping(path: '/api/domain/save')] public function save(): mixed { return Response::success($this->response, $this->q_save((int) $this->request->input('id', 0))); }
    #[PostMapping(path: '/api/domain/delete')] public function delete(): mixed { return Response::success($this->response, ['deleted' => $this->q_delete((int) $this->request->input('id', 0))]); }
    #[PostMapping(path: '/api/domain/deletes')] public function deletes(): mixed { return Response::success($this->response, ['deleted' => $this->q_deletes()]); }
    #[PostMapping(path: '/api/domain/setSwitch')] public function setSwitch(): mixed {
        $id = (int) $this->request->input('id', 0);
        $domain = Domain::find($id);
        if ($domain) { $domain->wechat = (int) $this->request->input('wechat', $domain->wechat); $domain->qq = (int) $this->request->input('qq', $domain->qq); $domain->save(); }
        return Response::success($this->response, $domain);
    }
    #[GetMapping(path: '/api/domain/getSwitch')] public function getSwitch(): mixed { return Response::success($this->response, Domain::query()->get(['id', 'host', 'wechat', 'qq'])); }
}
