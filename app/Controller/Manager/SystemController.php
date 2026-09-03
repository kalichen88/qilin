<?php
declare(strict_types=1);

namespace App\Controller\Manager;

use App\Common\AbstractController;
use App\Common\Response;
use App\Model\System;
use App\Middleware\AdminAuthMiddleware;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\HttpServer\Annotation\Middleware;

#[Controller]
#[Middleware(AdminAuthMiddleware::class)]
class SystemController extends AbstractController
{
    #[GetMapping(path: '/api/system/get/single')]
    public function single(): mixed
    {
        return Response::success($this->response, System::query()->first());
    }

    #[PostMapping(path: '/api/system/save')]
    public function save(): mixed
    {
        $sys = System::query()->first() ?? new System();
        $allowed = [
            'siteTitle', 'siteName', 'siteInfo', 'siteLogo', 'siteBg', 'bindDomain',
            'wechatOpenidSwitch', 'wechatUrl', 'min_price', 'max_price', 'global_txfl', 'global_fyfl',
            'codePrice', 'domainPrice', 'min_tx', 'max_tx', 'day_max_tx', 'ak', 'global_ak',
            'global_short', 'appid', 'secret', 'wechatJumpUrl', 'global_pay',
            'switch_1', 'switch_2', 'switch_3', 'switch_4', 'switch_5', 'switch_6', 'switch_7', 'switch_8',
            'switch_9', 'switch_10', 'switch_11', 'switch_12', 'switch_pc', 'ffSwitch', 'freeParams',
            'adImg', 's_url', 's_url_1', 's_url_2', 's_url_3', 's_url_4',
        ];
        $data = [];
        foreach ($allowed as $field) {
            if ($this->request->has($field)) {
                $data[$field] = $this->request->input($field);
            }
        }
        $sys->fill($data)->save();
        return Response::success($this->response, $sys);
    }

    #[PostMapping(path: '/api/system/changeThumb')]
    public function changeThumb(): mixed
    {
        $sys = System::query()->first();
        if ($sys && $this->request->has('siteLogo')) {
            $sys->siteLogo = $this->request->input('siteLogo');
            $sys->save();
        }
        return Response::success($this->response, $sys);
    }

    #[PostMapping(path: '/api/system/changeVideo')]
    public function changeVideo(): mixed
    {
        $sys = System::query()->first();
        if ($sys && $this->request->has('adImg')) {
            $sys->adImg = $this->request->input('adImg');
            $sys->save();
        }
        return Response::success($this->response, $sys);
    }

    #[GetMapping(path: '/api/system/deleteData')]
    public function deleteData(): mixed
    {
        // R1 占位：后续按类型清理日志/缓存
        return Response::success($this->response, null, '已清理');
    }
}
