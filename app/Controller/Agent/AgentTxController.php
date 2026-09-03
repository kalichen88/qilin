<?php declare(strict_types=1);
namespace App\Controller\Agent;

use App\Common\AbstractController;
use App\Common\Response;
use App\Middleware\AgentAuthMiddleware;
use App\Middleware\AgentLogMiddleware;
use App\Model\Agent;
use App\Model\Tx;
use Hyperf\Context\Context;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\HttpServer\Annotation\Middleware;

#[Controller]
#[Middleware(AgentAuthMiddleware::class)]
#[Middleware(AgentLogMiddleware::class)]
class AgentTxController extends AbstractController
{
    private function agentId(): int
    {
        return (int) (Context::get('agent_user')['uid'] ?? 0);
    }

    #[GetMapping(path: '/api/agentTx/get')]
    public function get(): mixed
    {
        return Response::success($this->response, Tx::query()->where('agent', $this->agentId())->orderByDesc('id')->paginate(20));
    }

    #[GetMapping(path: '/api/agentTx/getTotal')]
    public function getTotal(): mixed
    {
        $agent = Agent::find($this->agentId());
        return Response::success($this->response, [
            'money' => $agent->money ?? 0,
            'wait' => Tx::query()->where('agent', $this->agentId())->where('status', 0)->count(),
            'success' => Tx::query()->where('agent', $this->agentId())->where('status', 1)->count(),
        ]);
    }

    #[GetMapping(path: '/api/agentTx/getinfo')]
    public function getinfo(): mixed
    {
        $agent = Agent::find($this->agentId());
        return Response::success($this->response, $agent);
    }

    #[PostMapping(path: '/api/agentTx/add')]
    public function add(): mixed
    {
        $agent = Agent::find($this->agentId());
        $price = (float) $this->request->input('price', 0);
        if (! $agent || $price <= 0) {
            return Response::error($this->response, '参数错误', 1000);
        }
        if ($agent->money < $price) {
            return Response::error($this->response, '余额不足', 1001);
        }
        $tx = Tx::query()->create([
            'agent' => $agent->id, 'price' => $price,
            'payImage' => (string) $this->request->input('payImage', ''),
            'type' => (int) $this->request->input('type', 0),
            'account' => (string) $this->request->input('account', ''),
            'remark' => (string) $this->request->input('remark', ''),
            'status' => 0, 'rejectContent' => '',
        ]);
        // 冻结余额
        $agent->money = max(0, $agent->money - $price);
        $agent->save();
        return Response::success($this->response, $tx, '已提交提现');
    }

    #[PostMapping(path: '/api/agentTx/delete')] public function delete(): mixed { return Response::success($this->response, ['deleted' => (bool) Tx::destroy((int) $this->request->input('id', 0))]); }
    #[PostMapping(path: '/api/agentTx/deletes')] public function deletes(): mixed { $ids = array_map('intval', (array) $this->request->input('ids', [])); return Response::success($this->response, ['deleted' => Tx::whereIn('id', $ids)->delete()]); }
}
