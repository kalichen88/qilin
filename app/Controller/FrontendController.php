<?php declare(strict_types=1);
namespace App\Controller;

use App\Common\ViewAbstractController;
use App\Common\ViewCtx;
use App\Model\System;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Psr\Http\Message\ResponseInterface;

#[Controller]
class FrontendController extends ViewAbstractController
{
    private function managerIndex(): ResponseInterface
    {
        $html = @file_get_contents(BASE_PATH . '/runtime/manager/index.html');
        if ($html === false) {
            $html = '<h1>manager</h1>';
        }
        return $this->response->withHeader('Content-Type', 'text/html; charset=utf-8')->withBody(new SwooleStream($html));
    }

    #[GetMapping(path: '/manager')]
    public function manager(): ResponseInterface
    {
        return $this->managerIndex();
    }

    #[GetMapping(path: '/manager/')]
    public function managerSlash(): ResponseInterface
    {
        return $this->managerIndex();
    }

    #[GetMapping(path: '/manager/{path:.+}')]
    public function managerPath(): ResponseInterface
    {
        // SPA fallback：非静态资源回退到 index.html；实际文件由静态处理器先命中
        return $this->managerIndex();
    }

    // C 端 Vue 路由直连（/h5 /payVideo /qrcode /tousu）→ 渲染 view.php
    #[GetMapping(path: '/h5')] public function h5(): mixed { return $this->vue(); }
    #[GetMapping(path: '/payVideo')] public function payVideo(): mixed { return $this->vue(); }
    #[GetMapping(path: '/qrcode')] public function qrcode(): mixed { return $this->vue(); }
    #[GetMapping(path: '/tousu')] public function tousu(): mixed { return $this->vue(); }

    private function vue(): mixed
    {
        $sys = System::query()->first();
        $config = [
            'siteTitle' => $sys->siteTitle ?? '',
            'siteName' => $sys->siteName ?? '',
            'siteLogo' => $sys->siteLogo ?? '',
            'pc_switch' => $sys->switch_pc ?? 0,
            'fingerprint' => ViewCtx::get('fingerprint'),
            'xvzf' => ViewCtx::get('xvzf'),
            't' => ViewCtx::get('t'),
        ];
        try {
            return $this->view->render('view', ['config' => $config]);
        } catch (\Throwable $e) {
            return $this->response->withHeader('Content-Type', 'text/html; charset=utf-8')->withBody(new SwooleStream('<h1>wanli vue</h1>'));
        }
    }
}
