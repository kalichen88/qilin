<?php declare(strict_types=1);
namespace App\Payment;

use App\Model\Order;
use App\Model\Pay;

class MockChannel implements PaymentChannelInterface
{
    public function channel(): string
    {
        return 'mock';
    }

    public function createPayment(Order $order, array $params, Pay $pay): array
    {
        $orderId = $order->orderId;
        $form = '<form id="mockPay" action="' . ($params['notifyUrl'] ?? '/view/pay/notify') . '" method="post">'
            . '<input type="hidden" name="orderId" value="' . $orderId . '"/>'
            . '<input type="hidden" name="mock" value="1"/></form>'
            . '<script>document.getElementById("mockPay").submit();</script>';
        return ['type' => 'form', 'data' => $form, 'status' => 'success'];
    }

    public function verify(array $params, Pay $pay): bool
    {
        // Mock 通道：默认通过
        return ! empty($params['orderId']);
    }

    public function parseNotify(array $params): array
    {
        return [
            'orderId' => (string) ($params['orderId'] ?? ''),
            'tradeNo' => (string) ($params['trade_no'] ?? ($params['tradeNo'] ?? '')),
            'amount' => (float) ($params['total_fee'] ?? ($params['amount'] ?? 0)),
        ];
    }
}
