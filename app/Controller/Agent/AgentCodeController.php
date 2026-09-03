<?php declare(strict_types=1);
namespace App\Controller\Agent;
use App\Common\AbstractController;
use App\Common\Response;
use App\Common\Utils;
use App\Middleware\AgentAuthMiddleware;
use App\Middleware\AgentLogMiddleware;
use App\Model\Code;
use Hyperf\Context\Context;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\HttpServer\Annotation\Middleware;

#[Controller]
#[Middleware(AgentAuthMiddleware::class)]
#[Middleware(AgentLogMiddleware::class)]
class AgentCodeController extends AbstractController
{
    private function agentId(): int { return (int) (Context::get('agent_user')['uid'] ?? 0); }
    #[GetMapping(path: '/api/agentCode/get')] public function get(): mixed { return Response::success($this->response, Code::query()->where('agent', $this->agentId())->orderByDesc('id')->paginate(20)); }
    #[GetMapping(path: '/api/agentCode/getPrice')] public function getPrice(): mixed { return Response::success($this->response, ['price' => 1]); }
    #[PostMapping(path: '/api/agentCode/add')] public function add(): mixed {
        $n = max(1, (int) $this->request->input('num', 1));
        $ids = [];
        for ($i = 0; $i < $n; ++$i) {
            $c = Code::query()->create(['content' => Utils::promoHash(), 'agent' => $this->agentId(), 'status' => 0, 'active' => 0]);
            $ids[] = $c->id;
        }
        return Response::success($this->response, ['created' => count($ids), 'ids' => $ids]);
    }
}
