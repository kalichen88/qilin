<?php declare(strict_types=1);
namespace App\Controller\Agent;
use App\Common\AbstractController;
use App\Common\Response;
use App\Middleware\AgentAuthMiddleware;
use App\Middleware\AgentLogMiddleware;
use App\Model\Agent;
use App\Model\IvLog;
use App\Model\Order;
use Hyperf\Context\Context;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\Middleware;

#[Controller]
#[Middleware(AgentAuthMiddleware::class)]
#[Middleware(AgentLogMiddleware::class)]
class AgentChartController extends AbstractController
{
    private function agentId(): int { return (int) (Context::get('agent_user')['uid'] ?? 0); }
    #[GetMapping(path: '/api/agentChart/getNowData')]
    public function getNowData(): mixed
    {
        $agent = Agent::find($this->agentId());
        $today = date('Y-m-d');
        return Response::success($this->response, [
            'visits' => IvLog::query()->where('xvzf', $agent->hash ?? '')->whereDate('created_at', $today)->count(),
            'orders' => Order::query()->where('agent', $this->agentId())->whereDate('created_at', $today)->where('status', 1)->count(),
            'amount' => (float) Order::query()->where('agent', $this->agentId())->whereDate('created_at', $today)->where('status', 1)->sum('price'),
            'parentMoney' => (float) Order::query()->where('agent', $this->agentId())->where('status', 1)->sum('parentMoney'),
        ]);
    }
    #[GetMapping(path: '/api/agentChart/getRow')] public function getRow(): mixed { return $this->getNowData(); }
    #[GetMapping(path: '/api/agentChart/getRateData')] public function getRateData(): mixed { return Response::success($this->response, ['rate' => 0]); }
}
