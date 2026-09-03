<?php declare(strict_types=1);
namespace App\Controller\Agent;
use App\Common\AbstractController;
use App\Common\Response;
use App\Middleware\AgentAuthMiddleware;
use App\Middleware\AgentLogMiddleware;
use App\Model\Order;
use Hyperf\Context\Context;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\Middleware;

#[Controller]
#[Middleware(AgentAuthMiddleware::class)]
#[Middleware(AgentLogMiddleware::class)]
class AgentOrderController extends AbstractController
{
    private function agentId(): int { return (int) (Context::get('agent_user')['uid'] ?? 0); }
    #[GetMapping(path: '/api/agentOrder/get')] public function get(): mixed { return Response::success($this->response, Order::query()->where('agent', $this->agentId())->orderByDesc('id')->paginate(20)); }
    #[GetMapping(path: '/api/agentOrder/getTotal')] public function getTotal(): mixed { return Response::success($this->response, ['total' => Order::query()->where('agent', $this->agentId())->count()]); }
}
