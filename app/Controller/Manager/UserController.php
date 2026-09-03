<?php declare(strict_types=1);
namespace App\Controller\Manager;
use App\Common\AbstractController;
use App\Common\Response;
use App\Middleware\AdminAuthMiddleware;
use App\Model\Order;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\Middleware;

#[Controller]
#[Middleware(AdminAuthMiddleware::class)]
class UserController extends AbstractController
{
    // 会员：以 order 的指纹/用户聚合为“用户视图”
    #[GetMapping(path: '/api/user/get')]
    public function get(): mixed
    {
        $page = max(1, (int) $this->request->query('page', 1));
        $users = Order::query()->select('fingerprint', 'openid', \Hyperf\DbConnection\Db::raw('COUNT(*) as cnt, MAX(id) as id'))->where('fingerprint', '!=', '')->groupBy('fingerprint')->orderByDesc('id')->forPage($page, 20)->get();
        return Response::success($this->response, ['total' => $users->count(), 'list' => $users]);
    }
}
