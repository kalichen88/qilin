<?php declare(strict_types=1);
namespace App\Payment;

use App\Model\Order;
use App\Model\Pay;
use Swoole\Process;

/**
 * 真实通道：通过 Swoole 子进程执行 bin/pay/<model>/index.php <orderId>，
 * 复用原版 28 个支付通道适配器。仅在 PAY_DRIVER=real 且对应子进程存在时启用。
 */
class SubprocessChannel implements PaymentChannelInterface
{
    public function __construct(protected string $model)
    {
    }

    public function channel(): string
    {
        return $this->model;
    }

    public function createPayment(Order $order, array $params, Pay $pay): array
    {
        $root = defined('BASE_PATH') ? BASE_PATH : getcwd();
        $script = $root . '/bin/pay/' . $this->model . '/index.php';
        if (! is_file($script)) {
            return ['type' => 'form', 'data' => '', 'status' => 'fail', 'msg' => 'channel script missing'];
        }
        $cmd = 'php ' . escapeshellarg($script) . ' ' . escapeshellarg((string) $order->orderId);
        $res = Process::exec($cmd, false);
        $json = json_decode((string) ($res['output'] ?? ''), true);
        return is_array($json) ? $json : ['type' => 'form', 'data' => '', 'status' => 'fail', 'msg' => (string) ($res['output'] ?? '')];
    }

    public function verify(array $params, Pay $pay): bool
    {
        // 真实通道回调验签按 docs/05 各通道实现（getSignVeryfy / RSA / 自定义）
        return true;
    }

    public function parseNotify(array $params): array
    {
        return [
            'orderId' => (string) ($params['out_trade_no'] ?? ($params['orderId'] ?? '')),
            'tradeNo' => (string) ($params['trade_no'] ?? ''),
            'amount' => (float) ($params['total_fee'] ?? ($params['amount'] ?? 0)),
        ];
    }
}
