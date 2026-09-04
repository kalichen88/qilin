<?php declare(strict_types=1);
namespace App\Controller\Agent;
use App\Common\AbstractController;
use App\Common\Response;
use App\Middleware\AgentAuthMiddleware;
use App\Middleware\AgentLogMiddleware;
use App\Model\Notice;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\Middleware;

#[Controller]
#[Middleware(AgentAuthMiddleware::class)]
#[Middleware(AgentLogMiddleware::class)]
class AgentNoticeController extends AbstractController
{
    #[GetMapping(path: '/api/agentNotice/get')] public function get(): mixed { return Response::success($this->response, Notice::query()->orderByDesc('id')->get(['id', 'title', 'content'])); }
    #[GetMapping(path: '/api/agentNotice/getList')] public function getList(): mixed { return $this->get(); }
}
