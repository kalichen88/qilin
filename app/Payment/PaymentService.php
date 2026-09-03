<?php declare(strict_types=1);
namespace App\Payment;

use App\Common\Utils;
use App\Model\Agent;
use App\Model\Order;
use App\Model\Pay;
use App\Model\PayRequest;
use App\Model\System;

class PaymentService
{
    public function checkout(array $input): array
    {
        $videoId = (int) ($input['videoId'] ?? ($input['video'] ?? 0));
        $type = (int) ($input['type'] ?? 1);
        $price = (float) ($input['price'] ?? (float) (System::query()->first()->min_price ?? 1));
        $fingerprint = (string) ($input['fingerprint'] ?? '');
        $xvzf = (string) ($input['xvzf'] ?? '');
        $t = (string) ($input['t'] ?? '');
        $openid = (string) ($input['openid'] ?? '');
        $base = rtrim((string) ($input['base'] ?? 'http://localhost'), '/');
        $agent = $this->agentByXvzf($xvzf);

        $orderId = Utils::genOrderId();
        $pay = Pay::query()->where('switch', 1)->orderBy('sort')->first();
        $model = $pay->model ?? 'mock';

        $order = Order::query()->create([
            'orderId' => $orderId, 'video' => $videoId, 'status' => 0, 'agentPrice' => $price,
            'extraMoney' => 0, 'type' => $type, 'price' => $price, 'agent' => $agent->id ?? 0,
            'link' => 0, 'startTime' => 0, 'expiredTime' => 0, 'ip' => (string) ($input['ip'] ?? ''),
            'payType' => 'h5', 'isKl' => 0, 'raisePrice' => 0, 'openid' => $openid,
            'fingerprint' => $fingerprint, 'useTemplate' => (string) ($input['useTemplate'] ?? ''),
            'usePayTemplate' => (string) ($input['usePayTemplate'] ?? ''), 'payModel' => $model, 'parentMoney' => 0,
        ]);

        $params = [
            'orderId' => $orderId,
            'notifyUrl' => $base . '/view/pay/notify',
            'returnUrl' => $base . '/view/pay/return',
            'price' => $price,
        ];
        PayRequest::query()->create([
            'orderId' => $orderId, 'params' => json_encode($params, JSON_UNESCAPED_UNICODE),
            'status' => 0, 'model' => $model, 'extra' => '',
        ]);

        $channel = $this->channel($pay);
        $result = $channel->createPayment($order, $params, $pay);

        return [
            'orderId' => $orderId,
            'payModel' => $model,
            'type' => $result['type'] ?? 'form',
            'data' => $result['data'] ?? '',
            'status' => $result['status'] ?? 'success',
        ];
    }

    private function channel(?Pay $pay): PaymentChannelInterface
    {
        $model = $pay->model ?? 'mock';
        $root = defined('BASE_PATH') ? BASE_PATH : getcwd();
        if (env('PAY_DRIVER', 'test') === 'real' && $model && is_file($root . '/bin/pay/' . $model . '/index.php')) {
            return new SubprocessChannel($model);
        }
        // 默认 Mock 通道（无需真实商户）；接真实通道设 PAY_DRIVER=real
        return new MockChannel();
    }

    private function agentByXvzf(string $xvzf): ?Agent
    {
        if ($xvzf === '') {
            return null;
        }
        return Agent::query()->where('hash', $xvzf)->first();
    }
}
