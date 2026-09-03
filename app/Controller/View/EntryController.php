<?php
declare(strict_types=1);

namespace App\Controller\View;

use App\Common\Response;
use App\Common\ViewAbstractController;
use App\Common\ViewCtx;
use App\Middleware\LogMiddleware;
use App\Model\System;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\HttpServer\Annotation\Middleware;

#[Controller]
#[Middleware(LogMiddleware::class)]
class EntryController extends ViewAbstractController
{
    /**
     * 落地入口：?t=<hash>。R1 占位返回入口信息；R4 渲染 mubanX 模板。
     */
    #[GetMapping(path: '/')]
    public function index(): mixed
    {
        $sys = System::query()->first();
        $config = [
            'siteTitle' => $sys->siteTitle ?? '',
            'siteName' => $sys->siteName ?? '',
            'siteLogo' => $sys->siteLogo ?? '',
            'fingerprint' => ViewCtx::get('fingerprint'),
            'xvzf' => ViewCtx::get('xvzf'),
            't' => ViewCtx::get('t'),
            'pc_switch' => $sys->switch_pc ?? 0,
            'switches' => [],
        ];
        try {
            return $this->view->render('view', ['config' => $config]);
        } catch (\Throwable $e) {
            return Response::success($this->response, ['entry' => 'wanli', 't' => ViewCtx::get('t'), 'error' => $e->getMessage()]);
        }
    }

    #[PostMapping(path: '/url')]
    public function url(): mixed
    {
        return Response::success($this->response, ['parsed' => true]);
    }

    /**
     * 防红落地跳转页（postJump.php）：传落地上下文。
     */
    #[GetMapping(path: '/postJump')]
    public function postJump(): mixed
    {
        try {
            return $this->view->render('postJump', [
                'f' => ViewCtx::get('fingerprint'),
                'hezi' => (string) $this->request->query('box', ''),
                'view_id' => (string) $this->request->query('id', ''),
                'pc_javascript' => '',
                'session' => ViewCtx::get('t'),
                't' => ViewCtx::get('t'),
                'url' => (string) $this->request->query('url', ''),
                'loading' => '正在进入',
            ]);
        } catch (\Throwable $e) {
            return Response::success($this->response, ['page' => 'postJump']);
        }
    }

    #[PostMapping(path: '/shortVideo')]
    public function shortVideo(): mixed
    {
        return Response::success($this->response, ['shortVideo' => true]);
    }

    /**
     * 微信 OAuth 回跳：code → openid。
     * R1 骨架：暂不真请求微信(占位 appid/secret)，先存 openid 占位并回跳首页。
     */
    #[GetMapping(path: '/weixinCodeHandler')]
    public function weixinCode(): mixed
    {
        $code = (string) $this->request->query('code', '');
        // TODO(R4): 用 video_system.appid/secret 调微信 code2session 取 openid
        $openid = '';
        return Response::success($this->response, [
            'code' => $code,
            'openid' => $openid,
            'jump' => '/',
        ]);
    }
}
