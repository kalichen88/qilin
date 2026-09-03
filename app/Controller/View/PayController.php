<?php declare(strict_types=1);
namespace App\Controller\View;

use App\Common\AbstractController;
use App\Common\Response;
use App\Common\ViewCtx;
use App\Middleware\LogMiddleware;
use App\Model\Order;
use App\Model\Pay;
use App\Payment\PaymentCallbackService;
use App\Payment\PaymentService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\View\RenderInterface;

#[Controller]
#[Middleware(LogMiddleware::class)]
class PayController extends AbstractController
{
    #[Inject]
    protected PaymentService $payService;

    #[Inject]
    protected PaymentCallbackService $callback;

    #[Inject]
    protected RenderInterface $view;

    #[PostMapping(path: '/view/pay/checkout')]
    public function checkout(): mixed
    {
        $input = (array) $this->request->all();
        $ctx = ViewCtx::all();
        $input['fingerprint'] = (string) ($input['fingerprint'] ?? ($ctx['fingerprint'] ?? ''));
        $input['xvzf'] = (string) ($input['xvzf'] ?? ($ctx['xvzf'] ?? ''));
        $input['t'] = (string) ($input['t'] ?? ($ctx['t'] ?? ''));
        $input['openid'] = (string) ($input['openid'] ?? ($ctx['openid'] ?? ''));
        $input['ip'] = (string) ($ctx['ip'] ?? '');
        $input['base'] = (string) ($this->request->getHeaderLine('x-forwarded-host') ?: $this->request->getHeaderLine('host') ?: 'http://localhost');
        $result = $this->payService->checkout($input);
        return Response::success($this->response, $result);
    }

    #[PostMapping(path: '/view/pay/getList')]
    public function getList(): mixed
    {
        $list = Pay::query()->where('switch', 1)->orderBy('sort')->get()
            ->map(fn ($p) => ['model' => $p->model, 'name' => $p->name, 'viewName' => $p->viewName, 'icon' => $p->icon, 'extraMoney' => $p->extraMoney]);
        return Response::success($this->response, $list->values()->all());
    }

    #[GetMapping(path: '/view/pay/checkOrder')]
    public function checkOrder(): mixed
    {
        $orderId = (string) $this->request->query('orderId', '');
        $order = Order::query()->where('orderId', $orderId)->first();
        $paid = $order && (int) $order->status === 1;
        return Response::success($this->response, [
            'status' => $paid ? 1 : 0,
            'paid' => $paid,
            'url' => $paid ? '/view/pay/return?orderId=' . $orderId : '',
        ]);
    }

    #[PostMapping(path: '/view/pay/notify')]
    public function notify(): mixed
    {
        $r = $this->callback->handle((array) $this->request->all());
        return $r['success'] ?? false ? Response::success($this->response, $r) : Response::error($this->response, $r['msg'] ?? 'fail', 1000);
    }

    #[GetMapping(path: '/view/pay/notify')] public function notifyGet(): mixed { return $this->notify(); }
    #[PostMapping(path: '/view/pay/wxnotify')] public function wxnotify(): mixed { return $this->notify(); }
    #[GetMapping(path: '/view/pay/wxnotify')] public function wxnotifyGet(): mixed { return $this->notify(); }

    #[GetMapping(path: '/view/pay/return')]
    public function return(): mixed
    {
        $orderId = (string) $this->request->query('orderId', '');
        $order = Order::query()->where('orderId', $orderId)->first();
        return Response::success($this->response, [
            'orderId' => $orderId,
            'paid' => $order ? ((int) $order->status === 1) : false,
        ]);
    }

    // ---- R4 渲染模板星：先返回 JSON 占位 ----
    #[GetMapping(path: '/view/pay/qrcode')] public function qrcode(): mixed { $oid = (string) $this->request->query('orderId', ''); $o = Order::query()->where('orderId', $oid)->first(); $data = ['orderId' => $oid, 'price' => $o->price ?? 0, 'result' => '{}', 'type' => 'qrcode']; try { return $this->view->render('qrcode', ['data' => $data, 'orderId' => $oid, 'config' => ViewCtx::all()]); } catch (\Throwable $e) { return Response::success($this->response, ['page' => 'qrcode', 'orderId' => $oid, 'error' => $e->getMessage()]); } }
    #[GetMapping(path: '/view/pay/h5')] public function h5(): mixed { $oid = (string) $this->request->query('orderId', ''); $o = Order::query()->where('orderId', $oid)->first(); $data = ['orderId' => $oid, 'price' => $o->price ?? 0, 'result' => '{}']; try { return $this->view->render('h5', ['data' => $data, 'orderId' => $oid, 'config' => ViewCtx::all()]); } catch (\Throwable $e) { return Response::success($this->response, ['page' => 'h5', 'orderId' => $oid, 'error' => $e->getMessage()]); } }
    #[GetMapping(path: '/view/pay/wxpay')] public function wxpay(): mixed { $oid = (string) $this->request->query('orderId', ''); $o = Order::query()->where('orderId', $oid)->first(); $payInfo = json_encode(['appId' => '', 'timeStamp' => time(), 'nonceStr' => uniqid(), 'package' => 'prepay_id=mock', 'signType' => 'MD5', 'paySign' => '']); try { return $this->view->render('wxpay', ['data' => ['orderId' => $oid, 'price' => $o->price ?? 0, 'result' => '{}', 'type' => 'wxpay'], 'orderId' => $oid, 'payInfo' => $payInfo, 'config' => ViewCtx::all()]); } catch (\Throwable $e) { return Response::success($this->response, ['page' => 'wxpay', 'orderId' => $oid]); } }

    #[GetMapping(path: '/view/pay/check')]
    public function check(): mixed
    {
        $oid = (string) $this->request->query('orderId', '');
        try {
            return $this->view->render('check', ['orderId' => $oid, 't' => ViewCtx::get('t')]);
        } catch (\Throwable $e) {
            return Response::success($this->response, ['page' => 'check', 'orderId' => $oid]);
        }
    }
    #[PostMapping(path: '/view/pay/wxjsapi')] public function wxjsapi(): mixed { return Response::success($this->response, ['page' => 'wxjsapi', 'orderId' => (string) $this->request->input('orderId', '')]); }
}
