<?php declare(strict_types=1);
namespace App\Controller\Manager;
use App\Common\Response;
use App\Middleware\AdminAuthMiddleware;
use App\Model\Agent;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\HttpServer\Annotation\Middleware;

#[Controller]
#[Middleware(AdminAuthMiddleware::class)]
class AgentController extends BaseCrudController
{
    protected function model(): string { return Agent::class; }
    protected array $searchable = ['name', 'user'];
    protected array $fields = ['user', 'password', 'name', 'group', 'parent', 'money', 'txfl', 'fyfl', 'ff', 'pay', 'short', 'wechat', 'qq', 'hash', 'tx_password', 'video_day_switch', 'video_day_price', 'video_week_switch', 'video_week_price', 'video_mouth_switch', 'video_mouth_price', 'priceType', 'priceOnce', 'priceMin', 'priceMax'];

    #[GetMapping(path: '/api/agent/get')] public function get(): mixed { return Response::success($this->response, $this->q_page()); }
    #[GetMapping(path: '/api/agent/getall')] public function getall(): mixed { return Response::success($this->response, Agent::query()->get(['id', 'user', 'name'])); }
    #[GetMapping(path: '/api/agent/get/single')] public function single(): mixed { return Response::success($this->response, $this->q_single((int) $this->request->input('id', 0))); }
    #[GetMapping(path: '/api/agent/getTotal')] public function getTotal(): mixed { return Response::success($this->response, ['total' => Agent::query()->count()]); }
    #[PostMapping(path: '/api/agent/add')] public function add(): mixed { return Response::success($this->response, $this->q_save(null)); }
    #[PostMapping(path: '/api/agent/save')] public function save(): mixed { return Response::success($this->response, $this->q_save((int) $this->request->input('id', 0))); }
    #[PostMapping(path: '/api/agent/delete')] public function delete(): mixed { return Response::success($this->response, ['deleted' => $this->q_delete((int) $this->request->input('id', 0))]); }
    #[PostMapping(path: '/api/agent/deletes')] public function deletes(): mixed { return Response::success($this->response, ['deleted' => $this->q_deletes()]); }
    #[PostMapping(path: '/api/agent/pay')] public function pay(): mixed { $a = Agent::find((int) $this->request->input('id', 0)); if ($a) { $a->pay = $this->request->input('pay', $a->pay); $a->save(); } return Response::success($this->response, $a); }
    #[PostMapping(path: '/api/agent/ff')] public function ff(): mixed { $a = Agent::find((int) $this->request->input('id', 0)); if ($a) { $a->ff = $this->request->input('flag', $a->ff); $a->save(); } return Response::success($this->response, $a); }
    #[PostMapping(path: '/api/agent/short')] public function short(): mixed { $a = Agent::find((int) $this->request->input('id', 0)); if ($a) { $a->short = $this->request->input('short', $a->short); $a->save(); } return Response::success($this->response, $a); }
    #[PostMapping(path: '/api/agent/password')] public function password(): mixed { $a = Agent::find((int) $this->request->input('id', 0)); if ($a) { $pw = (string) $this->request->input('password', ''); if ($pw !== '') { $a->password = $pw; $a->save(); } } return Response::success($this->response, $a); }
}
