<?php declare(strict_types=1);
namespace App\Controller\Agent;
use App\Common\AbstractController;
use App\Common\Response;
use App\Middleware\AgentAuthMiddleware;
use App\Middleware\AgentLogMiddleware;
use App\Model\Agent;
use App\Model\Domain;
use App\Model\System;
use Hyperf\Context\Context;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\Middleware;

#[Controller]
#[Middleware(AgentAuthMiddleware::class)]
#[Middleware(AgentLogMiddleware::class)]
class AgentDomainSingleController extends AbstractController
{
    private function agentId(): int { return (int) (Context::get('agent_user')['uid'] ?? 0); }
    #[GetMapping(path: '/api/agentDomainSingle/getMyDomain')] public function getMyDomain(): mixed { return Response::success($this->response, Domain::query()->where('agent', $this->agentId())->get()); }
    #[GetMapping(path: '/api/agentDomainSingle/getPay')] public function getPay(): mixed { $sys = System::query()->first(); return Response::success($this->response, ['price' => $sys->domainPrice ?? 0]); }
    #[GetMapping(path: '/api/agentDomainSingle/pay')] public function pay(): mixed {
        $id = (int) $this->request->query('id', 0);
        $sys = System::query()->first();
        $price = (float) ($sys->domainPrice ?? 0);
        $agent = Agent::find($this->agentId());
        if (! $agent || $agent->money < $price) { return Response::error($this->response, '余额不足', 1001); }
        $domain = Domain::find($id);
        if ($domain && $price > 0) { $domain->agent = $agent->id; $domain->save(); $agent->money = max(0, $agent->money - $price); $agent->save(); }
        return Response::success($this->response, ['domain' => $domain, 'money' => $agent->money]);
    }
}
