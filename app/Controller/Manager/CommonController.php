<?php
declare(strict_types=1);

namespace App\Controller\Manager;

use App\Common\AbstractController;
use App\Common\JwtUtil;
use App\Common\Response;
use App\Constants\ErrorCode;
use App\Exception\BusinessException;
use App\Model\Admin;
use App\Model\Agent;
use App\Model\System;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\HttpServer\Annotation\GetMapping;

#[Controller]
class CommonController extends AbstractController
{
    #[PostMapping(path: '/common/login')]
    public function login(): mixed
    {
        $user = (string) $this->request->input('user', '');
        $password = (string) $this->request->input('password', '');

        if ($user === '' || $password === '') {
            throw new BusinessException('账号密码不能为空', ErrorCode::PARAM_ERROR);
        }

        // 管理员
        $admin = Admin::query()->where('user', $user)->first();
        if ($admin && $admin->password === $password) {
            if ((int) $admin->flag !== 1) {
                throw new BusinessException('账号无权限', ErrorCode::ACCOUNT_DISABLED);
            }
            $token = JwtUtil::issue('admin', (int) $admin->id, ['name' => $admin->name]);
            return Response::success($this->response, [
                'token' => $token,
                'scope' => 'admin',
                'user' => ['id' => $admin->id, 'user' => $admin->user, 'name' => $admin->name],
            ], '登录成功');
        }

        // 代理
        $agent = Agent::query()->where('user', $user)->first();
        if ($agent && $agent->password === $password) {
            $token = JwtUtil::issue('agent', (int) $agent->id, ['name' => $agent->name]);
            return Response::success($this->response, [
                'token' => $token,
                'scope' => 'agent',
                'user' => ['id' => $agent->id, 'user' => $agent->user, 'name' => $agent->name],
            ], '登录成功');
        }

        throw new BusinessException('账号或密码错误', ErrorCode::LOGIN_FAILED);
    }

    #[PostMapping(path: '/common/logout')]
    public function logout(): mixed
    {
        $token = $this->request->getHeaderLine('Authorization');
        $token = str_replace('Bearer ', '', $token);
        if ($token) {
            JwtUtil::revoke($token);
        }
        return Response::success($this->response, null, '已退出');
    }

    #[GetMapping(path: '/common/auth')]
    public function auth(): mixed
    {
        $payload = JwtUtil::payloadFromRequest($this->request);
        if (! $payload) {
            throw new BusinessException('账号或密码错误', ErrorCode::LOGIN_FAILED);
        }
        return Response::success($this->response, $payload);
    }

    #[GetMapping(path: '/common/basic')]
    public function basic(): mixed
    {
        $sys = System::query()->first();
        return Response::success($this->response, [
            'siteTitle' => $sys->siteTitle ?? '',
            'siteName' => $sys->siteName ?? '',
            'siteInfo' => $sys->siteInfo ?? '',
            'siteLogo' => $sys->siteLogo ?? '',
            'siteBg' => $sys->siteBg ?? '',
            'bindDomain' => $sys->bindDomain ?? '',
        ]);
    }

    #[GetMapping(path: '/common/getCode')]
    public function getCode(): mixed
    {
        // R0: 图形验证码占位，返回一个假 id
        return Response::success($this->response, ['codeId' => uniqid('code_', true)]);
    }
}
