<?php declare(strict_types=1);
namespace App\Payment;

use App\Model\Order;

class PaymentReconcileService
{
    public function __construct(protected PaymentCallbackService $callback)
    {
    }

    /**
     * 对账：将超过 X 分钟仍未支付(模拟环境下)的待付订单，按当前通道确认。
     * R6：Mock 驱动下“超时视为已支付”以演示对账；真实驱动需接入通道查单。
     */
    public function run(): array
    {
        $orders = Order::query()
            ->where('status', 0)
            ->where('fingerprint', '!=', '')                                  // 仅真实用户会话单
            ->where('created_at', '<', date('Y-m-d H:i:s', time() - 300))     // 超 5 分钟未付
            ->where('created_at', '>', date('Y-m-d H:i:s', time() - 86400))   // 近 24h，避免结算历史单
            ->get();
        $settled = 0;
        $pending = [];
        foreach ($orders as $order) {
            if (env('PAY_DRIVER', 'test') === 'real') {
                $pending[] = $order->orderId;   // 真实通道：接入网关查单
                continue;
            }
            // Mock：确认支付
            $this->callback->handle(['orderId' => $order->orderId, 'mock_reconcile' => 1]);
            ++$settled;
        }
        return ['settled' => $settled, 'pending' => $pending];
    }
}
