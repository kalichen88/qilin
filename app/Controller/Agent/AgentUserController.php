<?php declare(strict_types=1);
namespace App\Controller\Agent;
use App\Common\AbstractController;
use App\Common\Response;
use App\Middleware\AgentAuthMiddleware;
use App\Middleware\AgentLogMiddleware;
use App\Model\Agent;
use Hyperf\Context\Context;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\HttpServer\Annotation\Middleware;

#[Controller]
#[Middleware(AgentAuthMiddleware::class)]
#[Middleware(AgentLogMiddleware::class)]
class AgentUserController extends AbstractController
{
    private function agentId(): int { return (int) (Context::get('agent_user')['uid'] ?? 0); }
    #[GetMapping(path: '/api/agentUser/get')] public function get(): mixed { return Response::success($this->response, Agent::find($this->agentId())); }
    #[GetMapping(path: '/api/agentUser/get/single')] public function single(): mixed { return $this->get(); }
    #[PostMapping(path: '/api/agentUser/save')] public function save(): mixed {
        $a = Agent::find($this->agentId());
        if ($a) { foreach (['name', 'avatar', 'wechat', 'qq'] as $f) { if ($this->request->has($f)) { $a->{$f} = $this->request->input($f); } } $a->save(); }
        return Response::success($this->response, $a);
    }
    #[PostMapping(path: '/api/agentUser/changePassword')] public function changePassword(): mixed {
        $a = Agent::find($this->agentId());
        if ($a) { $old = (string) $this->request->input('original', ''); $new = (string) $this->request->input('newPassword', ''); if ($a->password === $old && $new !== '') { $a->password = $new; $a->save(); return Response::success($this->response, $a); } return Response::error($this->response, '原密码错误', 1001); }
        return Response::error($this->response, '代理不存在', 1000);
    }
    #[PostMapping(path: '/api/agentUser/updateTxpassword')] public function updateTxpassword(): mixed { $a = Agent::find($this->agentId()); if ($a) { $a->tx_password = (string) $this->request->input('tx_password', $a->tx_password); $a->save(); } return Response::success($this->response, $a); }
    #[PostMapping(path: '/api/agentUser/initTxPassword')] public function initTxPassword(): mixed { $a = Agent::find($this->agentId()); if ($a) { $a->tx_password = (string) $this->request->input('tx_password', ''); $a->save(); } return Response::success($this->response, $a); }
    #[GetMapping(path: '/api/agentUser/getTxPassword')] public function getTxPassword(): mixed { $a = Agent::find($this->agentId()); return Response::success($this->response, ['tx_password' => $a->tx_password ?? '']); }
}
