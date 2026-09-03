<?php declare(strict_types=1);
namespace App\Payment;

use App\Model\Agent;
use App\Model\History;
use App\Model\Notify;
use App\Model\Order;
use App\Model\PayLog;

class PaymentCallbackService
{
    public function handle(array $params): array
    {
        $orderId = (string) ($params['orderId'] ?? '');
        if ($orderId === '') {
            return ['success' => false, 'msg' => '缺少 orderId'];
        }
        $order = Order::query()->where('orderId', $orderId)->first();
        if (! $order) {
            return ['success' => false, 'msg' => '订单不存在'];
        }

        // 幂等：已支付直接返回成功
        if ((int) $order->status === 1) {
            return ['success' => true, 'idempotent' => true, 'orderId' => $orderId];
        }

        // 模拟验签（Mock 通道） + 回调原始记录
        $channel = new MockChannel();
        $parsed = $channel->parseNotify($params);
        Notify::query()->create(['orderId' => $orderId, 'params' => json_encode($params, JSON_UNESCAPED_UNICODE)]);

        // 置为已支付 + 授权起止时间
        $order->status = 1;
        $order->payType = $order->payType ?: 'mock';
        $order->startTime = time();
        $order->expiredTime = $order->startTime + $this->expireFor((int) $order->type);

        // 分销：上级获得 parentMoney = price * fyfl%
        $parentMoney = 0.0;
        $agent = Agent::find($order->agent);
        if ($agent) {
            $parentMoney = round($order->price * ((float) $agent->fyfl / 100), 2);
            if ($agent->parent) {
                $parent = Agent::find($agent->parent);
                if ($parent) {
                    $parent->money = ((float) $parent->money) + $parentMoney;
                    $parent->save();
                }
            }
        }
        $order->parentMoney = $parentMoney;
        $order->save();

        // 播放授权
        History::query()->create([
            'video' => $order->video, 'fingerprint' => $order->fingerprint,
            'openid' => $order->openid, 'type' => $order->type,
            'startTime' => $order->startTime, 'expireTime' => $order->expiredTime, 'xvzf' => '',
        ]);

        // 支付流水
        PayLog::query()->create([
            'agent' => $order->agent, 'total' => $order->price,
            'info' => '支付成功', 'orderId' => $orderId, 'admin' => 0,
        ]);

        return ['success' => true, 'orderId' => $orderId, 'parentMoney' => $parentMoney];
    }

    private function expireFor(int $type): int
    {
        return match ($type) {
            2 => 86400,          // 按天
            3 => 86400 * 7,      // 按周
            4 => 86400 * 30,     // 按月
            default => 86400,    // 单片
        };
    }
}
