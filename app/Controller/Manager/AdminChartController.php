<?php declare(strict_types=1);
namespace App\Controller\Manager;
use App\Common\AbstractController;
use App\Common\Response;
use App\Middleware\AdminAuthMiddleware;
use App\Model\IvLog;
use App\Model\Kllist;
use App\Model\Order;
use App\Model\PayLog;
use App\Model\SearchLog;
use App\Model\Tx;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\Middleware;

#[Controller]
#[Middleware(AdminAuthMiddleware::class)]
class AdminChartController extends AbstractController
{
    private function today(): string { return date('Y-m-d'); }
    #[GetMapping(path: '/api/adminChart/getNowData')]
    public function getNowData(): mixed
    {
        $today = $this->today();
        return Response::success($this->response, [
            'visits' => IvLog::query()->whereDate('created_at', $today)->count(),
            'orders' => Order::query()->whereDate('created_at', $today)->where('status', 1)->count(),
            'amount' => (float) Order::query()->whereDate('created_at', $today)->where('status', 1)->sum('price'),
            'kl' => Kllist::query()->whereDate('created_at', $today)->count(),
            'tx' => Tx::query()->where('status', 1)->count(),
            'paylog' => PayLog::query()->whereDate('created_at', $today)->count(),
            'search' => SearchLog::query()->whereDate('created_at', $today)->count(),
        ]);
    }
    #[GetMapping(path: '/api/adminChart/get')] public function get(): mixed { return $this->getNowData(); }
    #[GetMapping(path: '/api/adminChart/getRow')] public function getRow(): mixed { return $this->getNowData(); }
    #[GetMapping(path: '/api/adminChart/getRateData')] public function getRateData(): mixed { return Response::success($this->response, ['rate' => 0]); }
    #[GetMapping(path: '/api/adminChart/getSalesDay')] public function getSalesDay(): mixed { return Response::success($this->response, ['amount' => (float) Order::query()->whereDate('created_at', $this->today())->where('status', 1)->sum('price')]); }
    #[GetMapping(path: '/api/adminChart/getPayData')] public function getPayData(): mixed { return $this->getNowData(); }
    #[GetMapping(path: '/api/adminChart/getSearch')] public function getSearch(): mixed { return Response::success($this->response, SearchLog::query()->whereDate('created_at', $this->today())->orderByDesc('id')->limit(10)->get()); }
}
