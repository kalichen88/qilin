<?php declare(strict_types=1);
namespace App\Controller\Manager;

use App\Common\AbstractController;
use App\Common\Response;
use App\Middleware\AdminAuthMiddleware;
use App\Model\Agent;
use App\Model\Tx;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\HttpServer\Annotation\Middleware;

#[Controller]
#[Middleware(AdminAuthMiddleware::class)]
class TxController extends AbstractController
{
    #[GetMapping(path: '/api/tixian/get')]
    public function get(): mixed
    {
        $status = (int) $this->request->query('status', -1);
        $query = Tx::query()->orderByDesc('id');
        if ($status >= 0) {
            $query->where('status', $status);
        }
        return Response::success($this->response, $query->paginate(20));
    }

    #[GetMapping(path: '/api/tixian/getTotal')]
    public function getTotal(): mixed
    {
        return Response::success($this->response, [
            'wait' => Tx::query()->where('status', 0)->count(),
            'pass' => Tx::query()->where('status', 1)->count(),
            'reject' => Tx::query()->where('status', 2)->count(),
        ]);
    }

    #[GetMapping(path: '/api/tixian/pass')]
    public function pass(): mixed
    {
        $tx = Tx::find((int) $this->request->query('id', 0));
        if ($tx) {
            $tx->status = 1;
            $tx->save();
        }
        return Response::success($this->response, $tx);
    }

    #[PostMapping(path: '/api/tixian/reject')]
    public function reject(): mixed
    {
        $tx = Tx::find((int) $this->request->input('id', 0));
        if ($tx) {
            $tx->status = 2;
            $tx->rejectContent = (string) $this->request->input('rejectContent', '');
            $tx->save();
            // 驳回退款
            $agent = Agent::find($tx->agent);
            if ($agent) {
                $agent->money = ((float) $agent->money) + (float) $tx->price;
                $agent->save();
            }
        }
        return Response::success($this->response, $tx);
    }

    #[PostMapping(path: '/api/tixian/save')]
    public function save(): mixed
    {
        $tx = Tx::find((int) $this->request->input('id', 0));
        if ($tx) {
            $tx->remark = (string) $this->request->input('remark', $tx->remark);
            $tx->save();
        }
        return Response::success($this->response, $tx);
    }

    #[PostMapping(path: '/api/tixian/delete')] public function delete(): mixed { return Response::success($this->response, ['deleted' => (bool) Tx::destroy((int) $this->request->input('id', 0))]); }
    #[PostMapping(path: '/api/tixian/deletes')] public function deletes(): mixed { $ids = array_map('intval', (array) $this->request->input('ids', [])); return Response::success($this->response, ['deleted' => Tx::whereIn('id', $ids)->delete()]); }
}
