<?php declare(strict_types=1);
namespace App\Payment;

use App\Model\Order;
use App\Model\Pay;

interface PaymentChannelInterface
{
    public function channel(): string;

    /**
     * 拉起支付：返回 ['type'=>'form'|'url','data'=>..., 'status'=>'success'|'fail']。
     */
    public function createPayment(Order $order, array $params, Pay $pay): array;

    public function verify(array $params, Pay $pay): bool;

    /**
     * 归一化回调参数：['orderId','tradeNo','amount']。
     */
    public function parseNotify(array $params): array;
}
